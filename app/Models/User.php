<?php

namespace App\Models;

use App\Enums\SubscriptionTypeEnum;
use App\Notifications\PasswordResetNotification;
use App\Notifications\VerifyEmailNotification;
use App\Traits\ApiTokensWithDevice;
use App\Traits\SheduleLessons;
use Carbon\Carbon;
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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasLocalePreference, FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids, SoftDeletes, HasRoles, ApiTokensWithDevice, SheduleLessons;

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
        'subscription_expires_at',
        'subscription_created_at',
        'subscription_type',
        'is_blocked',
        'last_video_added_at',
        '',
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
    ];

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function quiz_results(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->BelongsToMany(Lesson::class);
    }

    public function lesson_rating(): hasMany
    {
        return $this->hasMany(LessonRating::class);
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

    public function subscriptionAvailable()
    {
        if (is_null($this->subscription_expires_at)) {
            return false;
        }

        return Carbon::now() < Carbon::parse($this->subscription_expires_at);
    }

    public function setSubscriptionTypeAttribute($value)
    {
        if (!in_array($value, SubscriptionTypeEnum::allValues())) {
            throw new \InvalidArgumentException('Invalid subscription type. Avaliable: ' . print_r(SubscriptionTypeEnum::allValues(), true));
        }

        $this->attributes['subscription_type'] = $value;
    }
}