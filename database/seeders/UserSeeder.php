<?php

namespace Database\Seeders;

use App\Enums\EnvironmentTypeEnum;
use App\Models\Bank;
use App\Models\CreditCard;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Database\Factories\BankFactory;
use Database\Factories\CreditCardFactory;
use Database\Factories\OrderFactory;
use Database\Factories\OrderPassengerFactory;
use Database\Factories\PromocodeFactory;
use Database\Factories\UserProfileFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    const ADMIN_PASSWORD = 'admin@admin';
    const ADMIN_EMAIL    = 'admin@admin';

    const USER_PASSWORD = 'testtest';
    const USER_EMAIL    = 'test@test.ru';

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
                'email'    => self::ADMIN_EMAIL,
            ]
        );
        $userAdmin->assignRole(Role::ROLE_ADMIN);

        $user = User::factory()->create(
            [
                'password' => Hash::make(self::USER_PASSWORD),
                'email'    => self::USER_EMAIL,
            ],
        );
        $user->assignRole(Role::ROLE_USER);

        $user->userProfile()->create((new UserProfileFactory())->definition());

        $user->passenger()->createMany($this->createPassengersArr());

        $order = Order::create((new OrderFactory())->definition());
        $order->user()->associate($user);
        $order->save();
        $order->orderPassenger()->createMany([
                                                 (new OrderPassengerFactory())->definition(),
                                                 (new OrderPassengerFactory())->definition(),
                                                 (new OrderPassengerFactory())->definition(),
                                             ]

        );

        $orderPayedArr                 = (new OrderFactory())->definition();
        $orderPayedArr['order_status'] = Order::PAYED;
        $order                         = Order::create($orderPayedArr);
        $order->user()->associate($user);
        $order->save();

        $order->orderPassenger()->createMany([
                                                 (new OrderPassengerFactory())->definition(),
                                                 (new OrderPassengerFactory())->definition(),
                                                 (new OrderPassengerFactory())->definition(),
                                             ]

        );

        $user->banks()->create((new BankFactory())->definition());
        $user->creditCards()->create((new CreditCardFactory())->definition());

        $idTakeout = $user->banks()->first()->id;
        $user->takeouts()->create([
                                      'amount'           => 1000 * 100,
                                      'amount_left'      => 3000 * 100,
                                      'takeoutable_id'   => $idTakeout,
                                      'takeoutable_type' => Bank::class
                                  ]);

        $idTakeout = $user->creditCards()->first()->id;
        $user->takeouts()->create([
                                      'amount'           => 2000 * 100,
                                      'amount_left'      => 3000 * 100,
                                      'takeoutable_id'   => $idTakeout,
                                      'takeoutable_type' => CreditCard::class
                                  ]);


        $user->promoCodes()->createMany([
                                            (new PromocodeFactory())->definition(),
                                            (new PromocodeFactory())->definition(),
                                            (new PromocodeFactory())->definition(),
                                        ]);

        $promoCodeModel = $user->promoCodes()->first();

        $order->promocode()->associate($promoCodeModel);
        $order->save();
    }

    private function createPassengersArr(): array
    {
        $passengersArr = [];
        for ($i = 0; $i < 35; $i++) {
            $passengersArr[] = (new OrderPassengerFactory())->definition();
        }
        return $passengersArr;
    }
}
