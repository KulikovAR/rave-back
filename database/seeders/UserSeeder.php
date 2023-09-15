<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Enums\SubscriptionTypeEnum;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserAppNotification;
use App\Services\NotificationService;
use Carbon\Carbon;
use Database\Factories\UserProfileFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    const ADMIN_PASSWORD = 'admin@admin';
    const ADMIN_EMAIL = 'admin@admin';

    const USER_PASSWORD = 'test@test.ru';
    const USER_EMAIL = 'test@test.ru';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (App::environment(EnvironmentTypeEnum::productEnv())) {
            return;
        }

        $userAdmin = User::factory()->create(
            [
                'password' => Hash::make(self::ADMIN_PASSWORD),
                'email' => self::ADMIN_EMAIL,
            ]
        );
        $userAdmin->assignRole(Role::ROLE_ADMIN);

        $message = "Новый тест на проверку";
        NotificationService::notifyAdmin($message);

        $user = User::factory()->create(
            [
                'password' => Hash::make(self::USER_PASSWORD),
                'email' => self::USER_EMAIL,
                'subscription_expires_at' => Carbon::now()->addMonths(2),
                'subscription_created_at' => Carbon::now()->subMonth(),
                'subscription_type' => SubscriptionTypeEnum::THREE_MOTHS->value
            ],
        );
        $user->assignRole(Role::ROLE_USER);

        $user->userProfile()->create((new UserProfileFactory())->definition());

        $user->notify(new UserAppNotification(__('notifications.qiuz_verifed')));
    }
}