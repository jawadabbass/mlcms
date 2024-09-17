<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Sorted;
class ModuleDataImage extends Model
{
    use Sorted;
    protected $table = 'cms_module_data_images';
    public $timestamps = false;
    protected $primaryKey = 'id';
}
