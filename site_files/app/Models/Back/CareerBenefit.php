<?php

namespace App\Models\Back;

use App\Traits\Active;
use App\Traits\Sorted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerBenefit extends Model
{
    use Active;
    use Sorted;

    protected $table = 'career_benefits';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id', 'career_id', 'title',
    ];

    /**
     * Get the career that owns the CareerBenefit
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id', 'id');
    }
}
