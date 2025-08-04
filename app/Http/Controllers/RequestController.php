<?php

namespace App\Http\Controllers;

use App\DataTables\{
    PropertiesDataTable,
    PropertiesForApprovalDataTable,
    ApprovedAdsDataTable,
    FeedbacksDataTable,
    GeneralFeedbackDataTable,
};
use App\Enums\FeedbackStatus;
use App\Models\Property;
use App\Models\PropertyMedia;
use App\Models\PropertyAmenity;
use App\Models\User;
use App\Models\Ad;
use App\Models\Feedback;
use App\Models\UserFeedback;
use App\Notifications\CancellationNotification;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    //new function of properties added by Yousaf starts from here
    public function properties(PropertiesDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.properties');
    }
    //new code added by Yousaf ends here

    public function list(PropertiesForApprovalDataTable $dataTable)
    {

        return $dataTable->render('admin.pages.requests');
    }

    public function details($id = null)
    {
        $property = Property::with('media', 'amenities')->where('id' , $id)->first();
     
        $user = null;

        if ($property) {
            $media = PropertyMedia::where('property_id' , $property->id)->get();
            $propertyAmenities = null;
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
            $user = User::where('id' , $property->user_id)->first();
        }
        return view('admin.pages.details' , [
            'property'  =>  $property,
            'media'     =>  $media,
            'amenities' => $propertyAmenities,
            'user'      =>  $user
        ]);
    }

    // By Asfia
    public function adDetails($id = null)
    {
        $ad = Ad::with('user')->where('id', $id)->first();

        return view('admin.pages.adDetails', [
            'ad' => $ad,
        ]);
    }

    // By Asfia
    public function ads(ApprovedAdsDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.adRequests');
    }

    public function requestApproval(Request $request)
    {
        if ($request->has('property_id')) {
            $property = Property::where('id', $request->property_id)->first();

            if ($property) {
                if ($request->has('approve')) {
                    $property->publish_status = 'Approved';
                } elseif ($request->has('cancel')) {
                    $property->publish_status = 'Cancel';
                    $property->cancel_reason = $request->cancel_reason;
                }

                $property->publish_status_changed_by = auth()->id();
                $property->publish_status_changed_at = now();
                $property->save();

                if ($request->has('approve')) {
                    notifyUserAboutApproval($ad = null, $property);
                }elseif ($request->has('cancel')) {
                    $property->user->notify(new CancellationNotification($ad = null,$property, $property->cancel_reason));
                    // notifyUserAboutCancel($ad = null, $property);
                }
                $message = 'Property Status has been changed!';
                return redirect()->route('admin.requests.list')->with('status', $message);
            } else {
                return redirect()->back()->with('approval_error', 'Sorry! Property does not exist, kindly refresh the page.');
            }
        }

        return redirect()->back()->with('approval_error', 'No valid property was provided.');
    }

    // By Asfia
    public function feedbacks(FeedbacksDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.feedbacks');
    }

    // By Asfia
    public function generalFeedbacks(GeneralFeedbackDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.general-feedback');
    }

    // By Asfia
    public function toggleStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:feedbacks,id',
            'status' => 'required|string',
        ]);

        $feedback = Feedback::find($request->id);
        $feedback->status = ($feedback->status->value === 'Pending') ? 'Approved' : 'Pending';
        $feedback->save();

        return response()->json([
            'success' => true,
            'new_status' => $feedback->status->value,
        ]);
    }

    // By Asfia
    public function generalFeedbacksToggleStatus(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'id' => 'required|exists:user_feedback,id',
            'status' => 'required|string',
        ]);

        // Retrieve the feedback by ID
        $generalFeedback = UserFeedback::find($request->id);

        // Check if the feedback exists
        if (!$generalFeedback) {
            return response()->json(['success' => false, 'message' => 'Feedback not found'], 404);
        }

        // Toggle the status
        $newStatus = ($generalFeedback->status === 'Draft') ? 'Published' : 'Draft';

        // Update the status
        $generalFeedback->update(['status' => $newStatus]);

        // Return a JSON response
        return response()->json([
            'success' => true,
            'new_status' => $newStatus,
        ]);
    }



}
