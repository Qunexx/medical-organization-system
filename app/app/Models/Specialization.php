<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Screen\AsSource;

class Specialization extends Model
{
    use AsSource;
    protected $table = 'specializations';
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'name'         => Like::class,
        'description'       => Like::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
    ];

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(
            Doctor::class,
            'doctor_specialization',
            'specialization_id',
            'doctor_id'
        )->withTimestamps();
    }

}
