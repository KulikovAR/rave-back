<?php

namespace Tests\Feature;

use App\Models\TakeOut;
use Database\Factories\BankFactory;
use Database\Factories\CreditCardFactory;
use Tests\TestCase;

class PartnerMessagesTest extends TestCase
{
    public function test_partner_message_created(): void
    {
        $user = $this->getTestUser();
        $user->partnerMessage()->delete();

        $requestData = [
                'partner_url_location' => $this->faker->sentence,
                'take_out_type'        => TakeOut::TAKEOUT_BANK,
            ]
            + (new BankFactory())->definition()
            + (new CreditCardFactory())->definition();

        $response = $this->actingAs($user)
                         ->json('post', route('partner-message.store'), $requestData);

        $response->assertStatus(200);

        $this->assertSame(__('partners.message_sent'), $response->json('message'));
        $this->assertSame(1, $user->partnerMessage->count());
        $this->assertSame(TakeOut::TAKEOUT_BANK, $user->partner_takeout);

    }

    public function test_partner_bank_created(): void
    {
        $user = $this->getTestUser();
        $user->banks()->delete();

        $requestData = [
                'partner_url_location' => $this->faker->sentence,
                'take_out_type'        => TakeOut::TAKEOUT_BANK,
            ]
            + (new BankFactory())->definition();

        $response = $this->actingAs($user)
                         ->json('post', route('partner-message.store'), $requestData);

        $response->assertStatus(200);

        $this->assertSame(__('partners.message_sent'), $response->json('message'));
        $this->assertSame(1, $user->banks->count());
    }

    public function test_partner_credit_card_created(): void
    {
        $user = $this->getTestUser();
        $user->creditCards()->delete();

        $requestData = [
                'partner_url_location' => $this->faker->sentence,
                'take_out_type'        => TakeOut::TAKEOUT_CARD,
            ]
            + (new CreditCardFactory())->definition();

        $response = $this->actingAs($user)
                         ->json('post', route('partner-message.store'), $requestData);

        $response->assertStatus(200);

        $this->assertSame(__('partners.message_sent'), $response->json('message'));
        $this->assertSame(1, $user->creditCards->count());
    }
}
