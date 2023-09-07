<?php


namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\PersonalAccessToken as PersonalAccessTokenAlias;

/**
 * App\Models\PersonalAccessToken
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property array|null $abilities
 * @property object|null $mobile_app_details
 * @property string|null $country_name
 * @property Carbon|null $last_used_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|\Eloquent $tokenable
 * @method static Builder|PersonalAccessToken newModelQuery()
 * @method static Builder|PersonalAccessToken newQuery()
 * @method static Builder|PersonalAccessToken query()
 * @method static Builder|PersonalAccessToken whereAbilities($value)
 * @method static Builder|PersonalAccessToken whereCreatedAt($value)
 * @method static Builder|PersonalAccessToken whereId($value)
 * @method static Builder|PersonalAccessToken whereLastUsedAt($value)
 * @method static Builder|PersonalAccessToken whereMobileAppDetails($value)
 * @method static Builder|PersonalAccessToken whereName($value)
 * @method static Builder|PersonalAccessToken whereToken($value)
 * @method static Builder|PersonalAccessToken whereTokenableId($value)
 * @method static Builder|PersonalAccessToken whereTokenableType($value)
 * @method static Builder|PersonalAccessToken whereUpdatedAt($value)
 * @mixin Eloquent
 * @noinspection PhpFullyQualifiedNameUsageInspection
 * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
 */
class PersonalAccessTokens extends PersonalAccessTokenAlias
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'device_name',
        'temp'
    ];

    protected $casts = [
        'abilities'    => 'json',
        'last_used_at' => 'datetime',
        'device_name'  => 'string'
    ];

}