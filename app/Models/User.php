<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'facebook_id',
        'password',
        'phone',
        'user_type',
        'cnic_number',
        'landline',
        'address',
        'city_id',
        'profile_image',
        'otp_code',
        'email_otp_code',
        'otp_verified_via',
        'is_otp_verified',
        'otp_expired_at',
        'instagram',
        'linkedin',
        'youtube',
        'about',
        'otp_session',
        'too_many_attempt',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'user_type' => UserType::class,
            'otp_expired_at' => 'datetime',

        ];
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total_properties' , 'total_ads'];

    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }


    /**
     * Count comments of posts
    */
    protected function totalProperties(): Attribute
    {
        return new Attribute(
            get: fn () => $this->properties()->count()
        );
    }

    protected function totalAds(): Attribute
    {
        return new Attribute(
            get: fn () => $this->ads()->count()
        );
    }

    // By Asfia
    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedback::class);
    }

    // By Asfia
    public function userFeedbacks(): HasMany
    {
        return $this->hasMany(UserFeedback::class);
    }

    public function agreement(): HasOne
    {
        return $this->hasOne(Agreement::class);
    }

    public function hasAcceptedAgreement(): bool
    {
        return $this->agreement()->exists();
    }
}
