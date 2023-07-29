<?php

namespace App\Models;

use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmailNotification;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasLocalePreference, FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'language',
        'is_partner',
        'partner_takeout',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'deleted_at'        => 'datetime',
        'password'          => 'hashed',
        'is_partner'        => 'boolean',
    ];

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function passenger(): HasMany
    {
        return $this->hasMany(Passenger::class);
    }

    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function partnerMessage(): HasOne
    {
        return $this->hasOne(PartnerMessage::class);
    }

    public function banks(): HasMany
    {
        return $this->hasMany(Bank::class);
    }

    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function takeouts(): HasMany
    {
        return $this->hasMany(TakeOut::class);
    }

    public function promoCodes(): HasMany
    {
        return $this->hasMany(Promocode::class);
    }

    public function preferredLocale()
    {
        return $this->language;
    }

    public function sendEmailVerification(): void
    {
        $this->notify(new VerifyEmailNotification);
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function canAccessFilament(): bool
    {
        return $this->hasRole([Role::ROLE_ADMIN, Role::ROLE_MANAGER]);
    }

    public function getFilamentName(): string
    {
        return "{$this->email}";
    }
}
