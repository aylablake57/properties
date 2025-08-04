<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralEmail;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;

class OtpVerificationController extends Controller
{
    public function view($type = null)
    {
        $user = Auth::user();
        if ($user->is_otp_verified == 0 && $type == null) {
            $user->update(['otp_session' => false, 'otp_expired_at' => null, 'otp_code' => null, 'email_otp_code' => null, 'otp_verified_via' => null]);
            return view('auth.verify');
        } else if ($type == 'email') {
            return $this->view_email();
        } else if ($type == 'sms') {
            return $this->viewSms();
        } else {
            return redirect('dashboard');
        }
    }

    public function viewSms()
    {
        $user = Auth::user();

        // Check if OTP verification is needed
        if ($user->is_otp_verified == 0) {
            $now = now();
            $twoMinutesInSeconds = 120;

            // Check if otp_expired_at is null or if the OTP has expired also check if otp_session is false
            if (is_null($user->otp_expired_at) || $now->greaterThanOrEqualTo($user->otp_expired_at) && !$user->otp_session) {
                $this->send();
                // set otp_session to true
                $user->update(['otp_session' => true, 'otp_verified_via' => 'sms']);
            }
            $remaining_time = $user->otp_expired_at ? $now->diffInSeconds($user->otp_expired_at) : 0;
            $display_time = min(max($remaining_time, 0), $twoMinutesInSeconds);
            session(['remaining_time' => $display_time]);

            return view('auth.verify-otp', ['remaining_time' => $display_time, 'otp_session' => $user->otp_session, 'type' => 'sms']);
        }

        // Redirect to the dashboard if the OTP is already verified
        return redirect('dashboard');
    }


    public function view_email()
    {
        $user = Auth::user();
        if ($user->google_id || $user->facebook_id) {
            return redirect('otp-verification');
        }

        if ($user->is_otp_verified == 0) {
            $now = now();
            $tenMinutesInSeconds = 600;

            // Check if otp_expired_at is null or if the OTP has expired also check if otp_session is false
            if (is_null($user->otp_expired_at) || $now->greaterThanOrEqualTo($user->otp_expired_at) && !$user->otp_session) {
                $this->send_email();
                // set otp_session to true
                $user->update(['otp_session' => true, 'otp_verified_via' => 'email']);
            }
            $remaining_time = $user->otp_expired_at ? $now->diffInSeconds($user->otp_expired_at) : 0;
            $display_time = min(max($remaining_time, 0), $tenMinutesInSeconds);
            session(['remaining_time' => $display_time]);
            return view('auth.verify-otp', ['remaining_time' => $display_time, 'otp_session' => $user->otp_session, 'type' => 'email']);
        } else {
            return redirect('dashboard');
        }
    }

    // resend otp
    public function sendOtp(Request $request)
    {
        $user = Auth::user();
        if ($user->is_otp_verified == 0) {
            $type = $request->type;
            if ($type == 'sms') {
                $this->send();
                return response()->json([
                    'msg' => 'OTP has been sent !!',
                ], 200);
            } else {
                $this->send_email();
                return response()->json([
                    'msg' => 'OTP has been sent !!',
                ], 200);
            }
        }
    }

    public function check(Request $request)
    {

        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
        ]);

        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;

        $user = Auth::user();

        if ($user->otp_expired_at && now()->gt($user->otp_expired_at)) {
            // remove otp_session from user and otp_expired_at from user and otp_code from user and email_otp_code from user
            $user->update(['otp_session' => true]);
            return redirect()->back()->with('opt_status', '<div class="alert alert-danger">OTP has expired. Please request a new one.</div>');
        }

        if (RateLimiter::tooManyAttempts('verify-otp:' . $user->id, 3)) {
            $seconds = RateLimiter::availableIn('verify-otp:' . $user->id);
            $seconds = 120; // 2 minutes
            RateLimiter::hit('verify-otp:' . $user->id, $seconds);

            // we update the otp_session to false
            $user->update(['otp_session' => false,'too_many_attempt' => true]);
            
            return redirect()->back()->with([
                'opt_status' => '<div class="alert alert-danger">Too many attempts! Please wait for 2 minutes.</div>',
                'rate_limit_seconds' => $seconds,
                'rate_limit_type' => $user->too_many_attempt

            ]);
        }

        // Increment the attempt counter
        RateLimiter::hit('verify-otp:' . $user->id);

        if ($request->type == 'sms') {
            $otp_code = $user->otp_code;
        } else {
            $otp_code = $user->email_otp_code;
        }
        if ($otp_code == $otp) {
            $update_user =  $user->update([
                'otp_code' => NULL,
                'email_otp_code' => NULL,
                'otp_verified_via' => $request->type,
                'is_otp_verified' => 1,
                'otp_expired_at' => NULL,
                'otp_session' => false,
                'too_many_attempt' => false,
            ]);
            if ($update_user) {
                RateLimiter::clear('verify-otp:' . $user->id);
                return redirect('dashboard');
            } else {
                return redirect()->back()->with('opt_status', '<div class="alert alert-danger">Failed to update user information. Please try again.</div>');
            }
        } else {
            return redirect()->back()->with('opt_status', '<div class="alert alert-danger">Invalid OTP. Please try again.</div>');
        }
    }

    public function send()
    {
        $user = Auth::user();
        if (empty($user->phone)) {
            return response()->json(['msg' => 'Phone Number is required !!'], 400);
        }
        if ($user->is_otp_verified == 0) {

            $otp_code = random_int(1000, 9999);
            // Added by Asfia
            $otp_expired_at = now()->addMinutes(2);
            $message = "One Time Password (OTP) {$otp_code} is generated. Do not share this with anyone.";
            //$message = '1234';
            // URL-encode the message
            $encodedMessage = urlencode($message);
            $phone = SmsCellPhoneNumber($user->phone);

            $url = "https://opencodes.pk/api/medver.php/sendsms/url?id=code1082dhai&pass=defence1&mask=DHAI&to={$phone}&lang=English&msg={$encodedMessage}&type=xml";
            //$url = "https://sym.notify92.com/api/quick/message?user=dhai_pakistan&password=oZmK9YpBS)3&mask=8016&to={$phone}&message={$encodedMessage}";
            //$response = file_get_contents($url);

            $response = Http::get($url);

            if ($response->status() == 200) {
                $user->update(['otp_code' => $otp_code, 'otp_expired_at' => $otp_expired_at, 'otp_session' => true,'too_many_attempt'=>false]);

                return response()->json(['msg' => 'OTP has been sent !!'], 200);
            } else {
                return response()->json(['msg' => 'Something went wrong while sending OTP. Try again !!'], 400);
            }
        } else {
            return response()->json([
                'msg' => 'Already verified, please refresh the page !!',
            ], 400);
        }

        // return response()->json([
        //     'msg' => 'Something went wrong while sending OTP. Try again !!',
        // ], 200);
    }

    public function SendSMS($url)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $guzzle = $client->request('GET', $url);

            if ($guzzle->getStatusCode() != 200) {
                return response()->json([
                    'message' => $guzzle->getReasonPhrase(),
                ], $guzzle->getStatusCode());
            }

            return  $guzzle->getBody();
        } catch (Exception $ex) {
            return 0;
        }
    }

    public function send_email()
    {
        $user = Auth::user();
        if ($user->google_id || $user->facebook_id) {
            return redirect('otp-verification');
        }

        if ($user->is_otp_verified == 0) {

            $otp_code = random_int(1000, 9999);
            // Added by Asfia
            $otp_expired_at = now()->addMinutes(10);

            $user->update([
                'email_otp_code' => $otp_code,
                'otp_expired_at' => $otp_expired_at,
                'otp_session' => true,
                'otp_verified_via' => 'email',
                'too_many_attempt'=>false
            ]);

            $mailData = [
                'otp_code' => $otp_code,
            ];

            // Added by Asfia
            $view = 'templates.email-verification';
            $subject = "Verify Email Address | Properties DHA 360";

            try {
                Mail::to($user->email)->send(new GeneralEmail($subject, $view, $mailData));
                return response()->json([
                    'msg' => 'OTP has been sent !!',
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'msg' => 'Something went wrong while sending OTP. Try again !!',
                ], 400);
            }
        } else {
            return response()->json([
                'msg' => 'Something went wrong while sending OTP. Try again !!',
            ], 400);
        }
    }

    public function check_email(Request $request)
    {
        $request->validate([
            'otp1' => 'required|numeric',
            'otp2' => 'required|numeric',
            'otp3' => 'required|numeric',
            'otp4' => 'required|numeric',
        ]);

        $otp = $request->otp1 . $request->otp2 . $request->otp3 . $request->otp4;

        $user = Auth::user();
        if (RateLimiter::tooManyAttempts('send-email:' . $user->id, 2)) {
            $expiryTime = now()->addMinutes(10);
            session(['otp_expiry_time' => $expiryTime, 'otp_type' => 'email']);

            return redirect()->back()->with([
                'opt_status' => '<div class="alert alert-danger">Too many attempts! Please wait for 10 minutes.</div>',
                'retry_after' => $expiryTime->timestamp
            ]);
        }

        RateLimiter::hit('send-email:' . $user->id);

        if ($user->email_otp_code == $otp) {
            $update_user = User::findOrFail($user->id)->update([
                'otp_code' => NULL,
                'email_otp_code' => NULL,
                'otp_verified_via' => 'email',
                'is_otp_verified' => 1,
            ]);

            if ($update_user) {

                RateLimiter::clear('send-email:' . $user->id);
                return redirect('dashboard');
            } else {
                return redirect()->back()->with('opt_status', '<div class="alert alert-danger">Invalid OTP, Please try again !!</div>');
            }
        } else {
            return redirect()->back()->with('opt_status', '<div class="alert alert-danger">Invalid OTP, Please try again !!</div>');
        }
    }

    public function edit_mobile(Request $request)
    {
        $request->validate([
            'mobile_number' => 'required|numeric',
        ]);

        $user = Auth::user();
        if ($user->is_otp_verified == 0) {
            $update_user = User::findOrFail($user->id)->update([
                'phone' => $request->mobile_number,
            ]);

            if ($update_user) {
                return redirect()->back()->with('opt_status', '<div class="alert alert-success ">Mobile Number updated successfully</div>');
            } else {
                return redirect()->back()->with('opt_status', '<div class="alert alert-danger">Something went wrong while updating mobile number, Please try again !!</div>');
            }
        } else {
            return redirect()->back()->with('opt_status', '<div class="alert alert-danger ">Mobile number already verified</div>');
        }
    }


    public function tooManyOTPAttempts()
    {
        $user = Auth::user();
        return response()->json([
            'too_many_attempts' => $user->too_many_attempt, 
        ]);
    }
}
