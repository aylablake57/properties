<x-guest-layout>
   <style>
     .line-or {
            display: flex;
            flex-direction: row;
        }
        
        .line-or:before,
        .line-or:after {
            content: "";
            flex: 1 1;
            border-bottom: 1px solid #b6b5b5;
            margin: auto;
        }
   </style>
    <div class="box-wrapper p-0 pb-5" style="height: auto;">
        @if (session('opt_status'))
            {!! session('opt_status') !!}
        @endif
        
        <div class="login-form mt-3">
            <div>
                <div class="text-center mt-3 w-100">
                <a href="{{ route('otp.verification',['type' => 'sms']) }}" class="btnLogin btn w-md-auto">Verify with number</a>
                </div>
                <div class="text-center mt-3 w-100">
                    <p class="line-or">or</p>
                </div>
                <div class="text-center mt-3 w-100">
                    <a href="{{ route('otp.verification',['type' => 'email']) }}" class="btnLogin btn w-md-auto">Verify with email</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>