<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class GeneralEmailTemplate extends Model
{
    protected $table = 'general_email_templates';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id', 'dynamic_values', 'template_name', 'from_name', 'from_email', 'reply_to_name', 'reply_to_email', 'subject', 'email_template',
    ];
}
