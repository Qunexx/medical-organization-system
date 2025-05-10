<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

class Doctor extends Model
{
    use AsSource;
    protected $table = 'doctors';
    protected $fillable = [
        'user_id',
        'years_of_experience',
        'description',
    ];

    protected $casts = [
        'pivot' => 'array',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id'         => Where::class,
        'fio'       => Like::class,
        'email'      => Like::class,
        'subject' => Like::class,
        'text' => Like::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
    ];

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(
            Specialization::class,
            'doctor_specialization',
            'doctor_id',
            'specialization_id'
        )->withTimestamps();
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(
            Service::class,
            'doctor_service',
            'doctor_id',
            'service_id'
        )->withTimestamps();
    }

}
