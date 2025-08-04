<?php

namespace App\Http\Controllers;

use App\DataTables\AdsDataTable;
use App\Http\Requests\AdRequest;
use App\Models\Ad;
use App\Models\User;
use App\Notifications\AdminApprovalNotification;
use App\Notifications\CancellationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class AdController extends Controller
{
    public function index()
    {
        $listings = Ad::where('user_id', auth()->id())
            ->get();

        return view('ad.list', compact('listings'));
    }

    public function form($id = null)
    {
        // Check user ads limit on create
        if (!$id && auth()->user()->total_ads >= auth()->user()->user_type->adsLimit()) {
            return redirect()->route('ad.list')->with('ads_error', 'Sorry! you have exceeded your allowed ads limit.');
        }

        //Edit form
        $ad = null;
        if ($id) {
            $ad = Ad::where(['id' => $id, 'user_id' => auth()->id()])->first();
        }

        return view('ad.form', [
            'ad' => $ad
        ]);
    }

    public function store(AdRequest $request)
    {
        $existinAdID = $request->has('ad_id') ? $request->ad_id : null;

        if ($existinAdID) {
            //for updating existing record
            $ad = Ad::find($existinAdID);
            $ad->status = 'pending';
        } else {
            //for creating record
            $ad = new Ad();
        }

        $this->save($ad, $request);

        notifySuperadminAboutNewApprovalNotification($ad, null);

        $message = 'Ad has been created and sent for approval. Approval may take upto 1 business day!';
        if ($existinAdID) {
            $message = 'Ad has been updated!';
        }

        return redirect()->route('ad.list')->with('status', $message);
    }

    private function save(Ad $ad, Request $request)
    {
        $ad->user_id = auth()->id();
        if ($request->has('ad_image')) {
            if ($ad->file_name) {
                if (Storage::disk('ftp')->exists($ad->file_name)) {
                    Storage::disk('ftp')->delete($ad->file_name);
                }
            }
            $uploadedFilePath = Storage::disk('ftp')->putFile('ads', $request->file('ad_image'));
            $ad->file_name = $uploadedFilePath;
        }

        $ad->save();
    }

    public function delete(Request $request)
    {
        if ($request->has('ad_id')) {
            $ad = Ad::find($request->ad_id);
            if ($ad) {
                if (Storage::disk('ftp')->exists($ad->file_name)) {
                    Storage::disk('ftp')->delete($ad->file_name);
                }
                $ad->delete();
            }
            $message = "Ad has been deleted successfully!";
        } else {
            $message = "Something went wrong while deletion, please try again!";
        }

        return redirect()->route('ad.list')->with('status', $message);
    }

    //for super admin dashboard
    public function newAdsList(AdsDataTable $dataTable)
    {
        return $dataTable->render('admin.pages.ads');
    }

    public function requestApproval(Request $request)
    {
        if ($request->has('ad_id')) {
            $ad = Ad::where('id', $request->ad_id)->first();

            if ($ad) {
                if ($request->status === 'pending') {
                    // Approving the ad
                    $ad->is_approved = 1;
                    $ad->approved_by = auth()->id();
                    $ad->approved_at = now();
                    $ad->expiry_date = Carbon::today()->addMonth();
                    $ad->status = 'approved';
                    $ad->save();

                    // Notify user about the approval
                    notifyUserAboutApproval($ad, null);

                    return redirect()->route('admin.ads.list')->with('status', 'Ad has been approved!');
                }

                if ($request->status === 'cancel') {
                    // Cancelling the ad
                    $cancellationReason = $request->input('cancel_reason');
                    $ad->is_approved = 0;
                    $ad->status = 'cancel';
                    $ad->cancel_reason = $cancellationReason;
                    $ad->cancelled_by = auth()->id();
                    $ad->cancelled_at = now();
                    $ad->save();

                    // Notify user about the cancellation
                    $ad->user->notify(new CancellationNotification($ad, null, $cancellationReason));

                    return redirect()->route('admin.ads.list')->with('status', 'Ad has been canceled. Reason: ' . $cancellationReason);
                }
            }
            return redirect()->back()->with('approval_error', 'Sorry! Ad does not exist, kindly refresh the page.');
        }
    }
}
