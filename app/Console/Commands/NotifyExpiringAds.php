<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ad;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdExpiryNotification;
use Illuminate\Support\Facades\DB;

class NotifyExpiringAds extends Command
{
   /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:notify-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users when their ads are expiring in 10 days.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    { 
        
        $adsExpiringSoon = Ad::where(DB::raw("DATEDIFF(CURDATE() , expiry_date)") , "<=" , 10)->get();

        foreach ($adsExpiringSoon as $ad) {
            $daysRemaining = now()->diff(Carbon::parse($ad->expiry_date))->format('%a');
            $user = $ad->user; 
            Notification::send($user, new AdExpiryNotification($ad,$daysRemaining));
        }

        $this->info('Users notified for expiring ads.');
        return 0;
    }
}
