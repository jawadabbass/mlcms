<?php

namespace App\Models\Back;

use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    use Active;
    use Sorted;

    protected $table = 'careers';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id', 'title', 'description', 'apply_by_date_time', 'location', 'type', 'image', 'image_title', 'image_alt', 'status', 'sort_order', 'created_at', 'updated_at', 'deleted_at',
    ];

    /**
     * Get all of the benefits for the Career
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function benefits(): HasMany
    {
        return $this->hasMany(CareerBenefit::class, 'career_id', 'id');
    }
}
