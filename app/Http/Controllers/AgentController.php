<?php

namespace App\Http\Controllers;

use App\Enums\ {
    UserType
};
use App\Models\ {
    City,
    User,
    Property,
    Ad,
    Feedback,
    Vendor
};
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\GeneralEmail;
use Exception;

class AgentController extends Controller
{
    public function index(Request $request)
    {
        $cities = City::all();
        $users = User::whereIn('user_type' , ['agent' , 'agency']);

        $dhaAgents = Vendor::where('firm_category' , 'PROPERTY DEALER')
                                ->where('vendor_status' , 'Active');

        if ($request->has('agent_name') || $request->has('city')) {
            //search by property type
            if ($request->filled('agent_name')) {
                $users = $users->where('name' , 'like' , '%' . $request->agent_name . '%');

                $dhaAgents = $dhaAgents->where(function($query) use($request) {
                                        $query->where('name_of_firm' , 'like' , '%' . $request->agent_name . '%')
                                        ->orwhere('name_of_person' , 'like' , '%' . $request->agent_name . '%');
                });
            }

            //search by city
            if ($request->filled('city')) {
                $users = $users->where('city_id', $request->city);
                $dhaAgents = $dhaAgents->where('city_id' , $request->city);
            }

        }

        $users = $users->orderBy('created_at' , 'DESC');
        $dhaAgents = $dhaAgents->orderBy('name_of_firm')->paginate(10, ['*'], 'dhaAgents');

        /* if ($users) {
            $users = $users->map(function ($user) {
                $user->propertiesForSale = $user->properties->where('purpose', Property::SELL)->count();
                //$user->propertiesForRent = $user->properties->where('purpose', Property::RENT)->count();
                return $user;
            });
        } */

        $users = $users->with(['properties' => function ($query) {
                    $query->where('purpose', Property::SELL)
                        ->where('publish_status', 'Approved')
                        ->where('is_sold', 0);
                }])
                ->has('properties')
                ->paginate(10, ['*'], 'users')
                ->through(function($user) {

                    $user->propertiesForSale = $user->properties->count();

                    $user->propertiesSold = $user->properties()
                        ->where('purpose', Property::SELL)
                        ->where('publish_status', 'Approved')
                        ->where('is_sold', 1)
                        ->count();

                    return $user;
                });

        $propertiesByCities = City::select('id', 'name')
                                    ->withCount(['properties as properties_count' => function ($query) {
                                        $query->where('publish_status' , 'Approved')
                                            ->where('is_sold' , 0);
                                    }])->get();

        return view('guest.pages.agents.index', [
            'cities' =>  $cities,
            'users' =>  $users,
            'dhaAgents' => $dhaAgents,
            'pageTitle' => 'Agent', //$userType == UserType::Agent->value ? UserType::Agent->name : UserType::Agency->name,
            'route' => 'agent', //$userType == UserType::Agent->value ? 'authorizees.agents' : 'authorizees.agencies',
            'propertiesByCities' => $propertiesByCities,
            'search' => $request->query()
        ]);
    }

    public function details(Request $request)
    {
        //dd($request->id);
        $user = User::find($request->id);

        $properties = Property::where('publish_status' , 'Approved')
                                ->where('user_id' , $user->id)
                                ->where('is_sold' , 0)
                                ->get();

        $propertiesForSale = $properties->where('purpose', Property::SELL)->count();

        $newProjects = Property::where('publish_status' , 'Approved')->take(10)
                        ->orderByDesc('created_at')
                        ->get();

        $soldProperties = Property::where('publish_status' , 'Approved')
                        ->where('user_id' , $user->id)
                        ->where('is_sold' , 1)
                        ->get();

        $propertiesForRent = $properties->where('purpose', Property::RENT)->count();

        $ads = Ad::where('is_approved' , 1)->where('user_id' , $user->id)->get();
        $totalads= $ads->count();
        return view('guest.pages.agents.profile' , [
            'user'             =>  $user,
            'properties'        =>  $properties,
            'propertiesForSale' =>  $propertiesForSale,
            'propertiesForRent' =>  $propertiesForRent,
            'newProjects'       => $newProjects,
            'soldProperties'    =>  $soldProperties,
            'pageTitle' => $user->user_type->value == UserType::Agent->value ? UserType::Agent->name : UserType::Agency->name,
            'ads'   => $ads,
            'totalads' => $totalads
        ]);
    }

    //new code added by Yousaf
    public function agentdetails(Request $request)
    {
        $user = User::find(1);

        $users = [];

        $properties = Property::where('publish_status' , 'Approved')
                                ->where('user_id' , $user->id)
                                ->where('is_sold' , 0)
                                ->get();

        $soldProperties = Property::where('publish_status' , 'Approved')
                                ->where('user_id' , $user->id)
                                ->where('is_sold' , 1)
                                ->get();

        $propertiesForSale = $properties->where('purpose', Property::SELL)->count();

        $dhaAgents = Vendor::query(); // Initialize the query builder for vendors
        if ($request->has('type') || $request->has('city')) {
            //search by property type
            if ($request->filled('type')) {
                $users = User::whereRelation('properties' , 'type' , $request->type);
                $dhaAgents = Vendor::paginate(10);
            }

            //search by city
            if ($request->filled('city')) {
                $users = User::where('city_id', $request->city);
                $dhaAgents = Vendor::where('city_id' , $request->city)->paginate(10);
            }

        } else {
            $users = User::whereIn('user_type' , ['agent' , 'agency'])
                             ->orderBy('created_at' , 'DESC');

            $dhaAgents = Vendor::paginate(10);
        }

        $users = $users->with('properties')
                        ->paginate(10)
                        ->through(function($user){
                            $user->propertiesForSale = $user->properties->where('purpose', Property::SELL)->count();
                            return $user;
                        });

        $newProjects = Property::where('publish_status' , 'Approved')->take(10)
                                ->orderByDesc('created_at')
                                ->get();

        $propertiesForRent = $properties->where('purpose', Property::RENT)->count();

        return view('guest.pages.agents.newprofile' , [
            'user'              =>  $user,
            'users'             =>  $users,
            'properties'        =>  $properties,
            'soldProperties'    =>  $soldProperties,
            'dhaAgents' => $dhaAgents,
            'pageTitle' => $user->user_type->value == UserType::Agent->value ? UserType::Agent->name : UserType::Agency->name
        ]);
    }

    public function contact(ContactRequest $request) {
        if (substr($request->mobile, 0, 1) === '0') {
            $request->mobile = substr($request->mobile, 1);
        }
        $mailData = [
            'agent_email' => $request->agent_email,
            'name'        => $request->name,
            'mobile'      => "+92".$request->mobile,
            'email'       => $request->email,
            'message'     => $request->message,
            'role'        => $request->rdType,
        ];

        $subject = "Message from the client via Properties DHA 360";
        $view = "templates.contact-agent";

        try {
            // Added by Asfia
            Mail::to($request->agent_email)->send(new GeneralEmail($subject,$view,$mailData));
            $message = "Your message has been sent successfully";
            return redirect()->back()->with('check_contact_agent', $message);
        } catch (Exception $e) {
            $message = "Something went wrong while contacting. Try again in few minutes !!";
            return redirect()->back()->with('check_contact_agent', $message);
        }
    }

    public function submitfeedback(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $rating = new Feedback();
        $rating->user_id = $request->user_id;
        $rating->rating = $request->rating;
        $rating->comment = $request->review;  // Storing the comment in the model
        $rating->save();

        return response()->json(['success' => true, 'message' => 'Rating and comment submitted successfully.']);
    }
}
