<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Services\AuthProviderService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthProviderTest extends TestCase
{
    const TEST_EMAIL = 'test@email.ru';

    public function test_auth_with_provider_route_redirects()
    {
        $response = $this->get(route('provider.redirect', 'google'));
        $response->assertStatus(302);
    }

    public function test_auth_with_provider_route_validation()
    {
        $response = $this->getJson(route('provider.redirect', 'googlessss'));
        $response->assertStatus(422);
    }

    public function test_google_provider_creating_user()
    {
        $googleFakeResp = $this->google_response();
        $result         = (new AuthProviderService())->authenticate($googleFakeResp, 'google');

        $url = $result->getTargetUrl();
        $this->assertStringContainsString('?bearer_token=', $url);

        $user = User::whereEmail(self::TEST_EMAIL)->first();

        $this->assertEquals(self::TEST_EMAIL, $user->email);
        $this->assertEquals('ru', $user->language);
        $this->assertNotEmpty($user->email_verified_at);

        //clear tables
        $this->clearUserModels();
        DB::table('personal_access_tokens')->where(['tokenable_id' => $user->id])->delete();
    }

    private function google_response()
    {
        $obj               = new \Laravel\Socialite\Two\User;
        $obj->token        = "ya29.a0AfH6SMA-GCK1ORCfW7fwlk6ZDwEPaAxSbGxZykQliwn3ly1kmfIlGyCrqpHPXn5lqXxTBJyLpDKE4bAnsEswM-SX5ND5SUvAX0w90pzIh2PEbNH8O4A4xOzFbx8eEYul3T00I028qtnHpu9zRqVOi5TpI";
        $obj->refreshToken = null;
        $obj->expiresIn    = 3599;
        $obj->id           = "105094488911965676793";
        $obj->nickname     = null;
        $obj->name         = "Boris Wild";
        $obj->email        = self::TEST_EMAIL;
        $obj->avatar       = "https://lh3.googleusercontent.com/a-/AOh14GjdXFxdUOoKbqz0yhutpgTNeTh7pUUMjGx8gXqWqQ=s96-c";
        $obj->user         = [
            "sub"            => "105094488911965676793",
            "name"           => "Boris Wild",
            "given_name"     => "Boris",
            "family_name"    => "Wild",
            "picture"        => "https://lh3.googleusercontent.com/a-/AOh14GjdXFxdUOoKbqz0yhutpgTNeTh7pUUMjGx8gXqWqQ=s96-c",
            "email"          => self::TEST_EMAIL,
            "email_verified" => true,
            "locale"         => "ru",
            "id"             => "105094488911965676793",
            "verified_email" => true,
            "link"           => null,
        ];
        return $obj;
    }

    private function clearUserModels()
    {
        $user = User::whereEmail(self::TEST_EMAIL);
        $user->forceDelete();
        $this->assertCount(0, $user->get());
    }

    public function test_user_created_only_once()
    {
        $googleFakeResp = $this->google_response();
        (new AuthProviderService())->authenticate($googleFakeResp, 'google');
        (new AuthProviderService())->authenticate($googleFakeResp, 'google');

        $user = User::whereEmail(self::TEST_EMAIL);
        $this->assertCount(1, $user->get());

        $user = $user->first();

        $tokensCount = DB::table('personal_access_tokens')->where(['tokenable_id' => $user->id])->count();
        $this->assertSame(2, $tokensCount);

        //clear tables
        $this->clearUserModels();
        DB::table('personal_access_tokens')->where(['tokenable_id' => $user->id])->delete();
    }
}
