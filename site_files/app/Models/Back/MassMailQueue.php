<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class MassMailQueue extends Model
{
    protected $table = 'mass_mail_queue';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id', 'template_id', 'professional_id', 'contact_id', 'date', 'time', 'is_sent'
    ];
}
