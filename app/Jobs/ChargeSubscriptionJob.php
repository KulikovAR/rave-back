<?php

namespace App\Jobs;

use App\Http\Controllers\PaymentController;
use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
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
        Log::info('Subscription charging job...');

        $users = User::inRandomOrder()
                     ->where('subscription_expires_at', '<=', Carbon::now())
                     ->limit(50)
                     ->get();

        Log::info(print_r($users, true));

        foreach ($users as $user) {
            $order = $user->orders()->where(['order_status' => Order::PAYED])->first();

            !$order ?: (new PaymentController())->charge($order);
        }

    }
}
