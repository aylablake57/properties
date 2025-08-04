<?php

namespace App\Http\Controllers;

use App\Enums\AreaUnit;
use App\Http\Requests\PropertyRequest;
use App\Http\Requests\ContactRequest;
use App\Models\Amenity;
use App\Models\City;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyAmenity;
use App\Models\PropertyMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\GeneralEmail;
use App\Models\PropertyType as ModelsPropertyType;
use App\Models\Rating;
use App\Models\Review;
use App\Models\Subtype;
use App\Notifications\NewAdOrPropertyNotification;
use Intervention\Image\Facades\Image;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

// use Image;

use function Illuminate\Foundation\Configuration\respond;

class PropertyController extends Controller
{
    const SELL = 'sell';
    const RENT = 'rent';

    public function index()
    {
        $listings = Property::where('user_id', auth()->id())->orderBy('created_at', 'desc')
            // ->where('is_sold', false)  // code added by Yousaf to Exclude sold properties
            ->get();

        return view('property.index', compact('listings'));
    }

    public function form($id = null)
    {
        // Check user ads limit on create
        if (!$id && auth()->user()->total_properties >= auth()->user()->user_type->propertyLimit()) {
            return redirect()->route('property.list')->with('ads_error', 'Sorry! you have exceeded your allowed limit.');
        }

        $propertyTypes = ModelsPropertyType::select('id', 'name')->get();
        $propertyAreaUnits = AreaUnit::cases();
        $cities = City::all();

        /* $amenities = Amenity::all();
        $amenitiesArray = [];
        foreach ($amenities as $key => $amenity) {
            $amenitiesArray[$amenity->key][$key]['id'] = $amenity->id;
            $amenitiesArray[$amenity->key][$key]['value'] = $amenity->value;
        } */

        $property = $id ? Property::where(['id' => $id, 'user_id' => auth()->id()])->first() : null;

        return view('property.form', [
            'types' => $propertyTypes,
            'areaUnits' => $propertyAreaUnits,
            'cities' => $cities,
            'property' => $property
        ]);
    }

    public function store(PropertyRequest $request)
    {
        // dd($request->all());
        $existinPropertyID = $request->input('property_id', null);
        $property = $existinPropertyID ? Property::find($existinPropertyID) : new Property;

        $rules = [
            'featured_image' => $existinPropertyID ? 'nullable|image|mimes:jpg,jpeg,png|max:1024|dimensions:min_width=110,min_height=68' : 'required|image|mimes:jpg,jpeg,png|max:1024|dimensions:min_width=110,min_height=68',
            'media.*' => 'nullable|image|mimes:jpg,jpeg,png|max:1024|dimensions:min_width=110,min_height=68',
        ];

        $request->validate($rules);
        // try{
            $this->save($property, $request);

            if ($request->has('featured_image')) {

                if ($existinPropertyID) {
                    //check from property table and delete existing image
                    if ($property->featured_image && Storage::disk('ftp')->exists($property->featured_image)) {
                        Storage::disk('ftp')->delete($property->featured_image);
                    }

                    //check and delete existing image from media table
                    $featured_images = $property->media()->where('type', 'featured_image')->first();

                    if ($featured_images && Storage::disk('ftp')->exists($featured_images->file_path)) {
                        Storage::disk('ftp')->delete($featured_images->file_path);
                        $featured_images->delete();
                    }
                }

                // Get the uploaded file
                $uploadedFile = $request->file('featured_image');

                $uploadedFilePath = 'properties/' . uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $img = Image::make($uploadedFile->getRealPath());
                $watermarkPath = public_path('assets/images/watermark.png');
                $watermark = Image::make($watermarkPath);
                $watermark->opacity(80);
                $img->insert($watermark, 'center');

                try {
                    Storage::disk('ftp')->put($uploadedFilePath, (string) $img->encode());
                    Storage::disk('ftp')->setVisibility($uploadedFilePath, 'public');
                } catch (\Exception $exception) {
                    Log::error('error: ' . $exception->getMessage());
                }

                //upload and link the new image
                $property->media()->create([
                    'type' => 'featured_image',
                    'file_name' => $request->file('featured_image')->getClientOriginalName(),
                    'file_path' => $uploadedFilePath
                ]);

                $property->featured_image = $uploadedFilePath;
                $property->save();
            }

            if ($request->has('media')) {
                $mediaFiles = $request->file('media');
                $mediaArray = [];
                foreach ($mediaFiles as $key => $file) {
                    $fileType = $file->getClientMimeType();
                    $fileExtension = $file->getClientOriginalExtension();
                    $filePath = 'properties/' . uniqid() . '.' . $fileExtension;

                    if (str_starts_with($fileType, 'image/')) {
                        $img = Image::make($file->getRealPath());
                        $watermarkPath = public_path('assets/images/watermark.png');
                        $watermark = Image::make($watermarkPath);
                        $watermark->opacity(80);
                        $img->insert($watermark, 'center');
                        try {
                            Storage::disk('ftp')->put($filePath, (string) $img->encode());
                            Storage::disk('ftp')->setVisibility($filePath, 'public');
                        } catch (\Exception $exception) {
                            Log::error('error: ' . $exception->getMessage());
                        }

                    } else {
                        // Handle non-image files (e.g., videos)

                        try {
                            Storage::disk('ftp')->putFile('properties', $file);
                            Storage::disk('ftp')->setVisibility($filePath, 'public');
                        } catch (\Exception $exception) {
                            Log::error('error: ' . $exception->getMessage());
                        }
                    }
                    $mediaArray[$key]['file_path'] = $filePath;
                    $mediaArray[$key]['file_name'] = $file->getClientOriginalName();
                    $mediaArray[$key]['type'] = $file->getClientMimeType() == "video/mp4" ? 'video' : 'image';
                }

                $property->media()->createMany($mediaArray);
            }

            if ($request->has('amenities')) {
                // dd($request->amenities);
                $amenities = [];
                foreach ($request->amenities as $key => $value) {
                    if ($value != null) {
                        $amenities[] = [
                            'amenity_id'        => $key,
                            'amenity_value'     => $value
                        ];
                    }
                }

                if ($existinPropertyID) {
                    $property->amenities()->detach(); // Use detach to remove existing relationships
                }
                //link the new amenities
                $property->amenities()->attach($amenities); // Use attach to link new amenities
            }

            $message = 'Property has been created and sent for approval. Approval may take upto 1 business day!';
            if ($existinPropertyID) {
                    $message = 'Property listing has been updated!';
                }

            notifySuperadminAboutNewApprovalNotification(null, $property);
            return redirect()->route('property.list')->with('status', $message);
        // } catch (\Exception $exception) {
        //     Log::error('error: ' . $exception->getMessage());
        //     return redirect()->back()->with('error', 'Something went wrong while saving the property. Try again in few minutes !!');
        // }
    }

    private function save($property, Request $request)
    {


        // dd($request->all(), $property);
        $property->user_id = auth()->id();
        $property->title = $request->title;
        $property->description = $request->description;
        $property->price = $request->price;
        $property->type = $request->type;
        $property->sub_type = $request->subtype;
        $property->city_id = $request->city;
        $property->location_id = $request->location;
        $property->address = $request->address;
        $property->lat = $request->latitude ?? null;
        $property->lng = $request->longitude ?? null;
        if ($request->has('google_street')) {
            $property->angle = $request->google_street;
        }


        $property->area_size = $request->area_size;
        $property->area_unit = $request->area_unit;
        $property->area_size_value = 0;
        $property->purpose = SELF::SELL;
        $property->number = $request->number;
        $property->ready_for_possession = $request->ready_for_possession ? true : false;
        $property->installments_available = $request->installments_available ? true : false;
        if ($request->installments_available == true) {
            $property->advance_amount = $request->advance_amount;
            $property->monthly_installment = $request->monthly_installment;
            $property->no_of_installments = $request->no_of_installments;
        }

        $property->email = $request->email;
        $property->phone = SmsCellPhoneNumber($request->phone);
        $property->landline = $request->landline;
        // Code added by Asfia Aiman
        if ($request->video_link) {
            $property->video_link = $request->video_link;
        } else {
            $property->video_link = null;
        }
        $property->publish_status = 'Pending';
        $property->save();



    }

    //New Code Added By Yousaf
    public function hasBeenSold(Request $request)
    {
        if ($request->has('id')) {

            $property = Property::findOrFail($request->id);

            $property->is_sold = $request->input('is_sold') ? 1 : 0;

            if ($property->is_sold) {
                $property->sold_on = now();
            } else {
                $property->sold_on = null;
            }

            if ($property->save()) {
                return response()->json(1);
            }
        }

        return response()->json(0);
    }

    public function getSubTypes(Request $request)
    {

        $subTypes = Subtype::where('type_id' , $request->property_type_id)->get();
        return response()->json($subTypes);
    }

    public function getAmenities(Request $request)
    {

        $amenities = Amenity::where('sub_type_id' , 'like' , '%' . $request->subTypeId . '%')->get();
        $selectedAmenities = PropertyAmenity::where('property_id' , $request->property_id)->select('amenity_id' , 'amenity_value')->get();
        if ($amenities->count() > 0) {
            $propertyAmenities = [];
            foreach ($amenities as $key => $amenity) {
                $propertyAmenities[$amenity->key][$key]['id'] = $amenity->id;
                $propertyAmenities[$amenity->key][$key]['value'] = $amenity->value;
            }

            $html_data = '<hr>
                            <div class="section-title">Amenities</div>
                            <div class="section-content">';
            foreach ($propertyAmenities as $title => $amenity) {
                if ($key === array_key_first($propertyAmenities)) {
                    $html_data .= '<hr>';
                }

                $html_data .= '<div class="row mt-3">
                                    <div class="col-sm-4 mb-3">
                                        <label for="title">' . $title . '</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="row">';
                foreach ($amenity as $key => $data) {
                    if ($title === 'Features') {
                        $html_data .= '<div class="col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="' . $key. '-' . $data['id'] . '" name="amenities[' . $data['id'] . ']" value="true"';
                        $amn = $selectedAmenities->where('amenity_id' , $data['id'])->first();
                        if ($request->has('property_id') && $amn) {
                            $html_data .= ' checked ';
                        }
                        $html_data .= '>
                                            <label class="form-check-label" for="' . $key. '-' . $data['id'] . '">' . $data['value'] . '</label>
                                        </div>
                                    </div>';
                    } else {
                        $html_data .= '<div class="col-sm-3">
                                        <label class="form-check-label" for="' . $key. '-' . $data['id'] . '">' . $data['value'] . '</label>
                                    </div>
                                    <div class="col-sm-3">
                                        <input class="form-control" type="text" id="' . $key. '-' . $data['id'] . '" name="amenities[' . $data['id'] . ']" ';
                        $amn = $selectedAmenities->where('amenity_id' , $data['id'])->first();
                        if ($request->has('property_id') && $amn) {
                            $html_data .= ' value="' . $amn['amenity_value'] . '"';
                        }
                        $html_data .= '>
                                    </div>';
                    }
                }
                $html_data .= '</div></div></div>';
            }
        } else {
            $html_data = '';
        }

        return response()->json($html_data);
    }

    public function getCityLocations(Request $request)
    {
        $locations = Location::where('city_id', $request->id)->get();
        return response()->json($locations);
    }

    public function details(Request $request)
    {
        $property = Property::with('media', 'amenities')->find($request->id);

        if ($property->amenities->isNotEmpty()) {
            $propertyAmenities = $property->amenities->groupBy('key')->map(function ($amenitiesGroup) {
                return $amenitiesGroup->map(function ($amenity) {
                    return [
                        'id' => $amenity->id,
                        'value' => $amenity->value,
                        'amenity_value' => $amenity->pivot->amenity_value,
                    ];
                });
            })->toArray();
        } else {
            $propertyAmenities = [];
        }
        // Dynamic data by Asfia Aiman Starts

        $properties = $property->user->properties()->get();

        // counting total properties
        $total_properties = $properties->count();

        // counting active properties
        $active_properties = $properties
                            ->where('publish_status', 'Approved')
                            ->where('is_sold', 0)
                            ->count();

        // counting sold properties
        $sold_properties = $properties
                            ->where('publish_status', 'Approved')
                            ->where('is_sold', 1)
                            ->count();

        // counting inactive properties
        $inactive_properties = $properties->whereIn('publish_status', ['Pending', 'Cancel'])->count();
        $markSeen = markPropertyAsSeen($property->id);

        return view('guest.pages.property-details' , [
            'property' =>  $property,
            'amenities' => $propertyAmenities,
            'sold_properties' => $sold_properties,
            'total_properties' => $total_properties,
            'active_properties' => $active_properties,
            'inactive_properties' => $inactive_properties,
            // Dynamic data by Asfia Aiman Ends
        ]);
    }

    public function contact(ContactRequest $request) {
        $mailData = [
            'property_id' => $request->property_id,
            'name'        => $request->name,
            'mobile'      => "+92".$request->mobile,
            'email'       => $request->email,
            'message'     => $request->message,
            'role'        => $request->rdType,
        ];

        $propertyTitle = Property::where('id', $request->property_id)->pluck('title')->first();

        $property_user = User::findOrFail($request->id);
        $view = "templates.contact-property";
        $subject = "New Message From Customer Regarding $propertyTitle | Properties DHA 360";

        try {
            // Added by Asfia
            Mail::to($property_user->email)->send(new GeneralEmail($subject, $view,$mailData));
            $message = 'Your message has been sent successfully';
            return redirect()->back()->with('check_contact', $message);
        } catch (Exception $e) {
            $message = 'Something went wrong while contacting. Try again in few minutes !!';
            return redirect()->back()->with('check_contact', $message);
        }
    }

    public function removeImage(Request $request)
    {
        if ($request->has('id')) {
            $media = PropertyMedia::findOrFail($request->id);
            if (Storage::disk('ftp')->delete($media->file_path)) {
                $media->delete();
            }
            return response()->json(1);
        }
        return response()->json(0);
    }
}
