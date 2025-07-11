<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Metrics\Chartable;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{

    use Chartable;
    const AVATAR_PATH = 'avatars';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'address_id',
        'phone',
        'birthday',
        'chat_id',
        'email',
        'password',
        'access_email_notify',
        'access_telegram_notify',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
           'id'         => Where::class,
           'name'       => Like::class,
           'email'      => Like::class,
           'updated_at' => WhereDateStartEnd::class,
           'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];


    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ADMIN;
    }

    public function isDoctor(): bool
    {
        return $this->role === RoleEnum::DOCTOR;
    }

    public function isUser(): bool
    {
        return $this->role === RoleEnum::USER;
    }

    public function isSupport(): bool
    {
        return $this->role === RoleEnum::SUPPORT;
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

    public function getRoleAttribute(): ?RoleEnum
    {
        $role = $this->roles->first();

        return $role ? RoleEnum::from($role->id) : null;
    }

    public function hasRole(RoleEnum $role): bool
    {
        return $this->roles()->where('id', $role->value)->exists();
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim("{$this->last_name} {$this->first_name} {$this->middle_name}");
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
