<?php

namespace App\Jobs;

use App\Enums\EnvironmentTypeEnum;
use App\Http\Controllers\PaymentController;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ChargeSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $users = User::inRandomOrder()
                     ->where('subscription_expires_at', '<=', Carbon::now())
                     ->where('charge_attempts', '<', 10)
                     ->where('auto_subscription', '=', 1)
                     ->limit(50)
                     ->get();

       foreach ($users as $user) {

            if($user &&  App::environment(EnvironmentTypeEnum::notProductEnv())){
                Log::info('Subscription charging job... ');
                Log::info('User: ' . $user->email . ' ' . $user->id);
            }
            
            $order = $user->orders()
                ->whereNotNull('rebill_id')
                ->orderBy('updated_at', 'desc')
                ->first();

            !$order
                ? Log::info('No order for charging subscription. Check orders for user id:' . $user->id)
                : (new PaymentController())->charge($order->id);
        }

    }
}
