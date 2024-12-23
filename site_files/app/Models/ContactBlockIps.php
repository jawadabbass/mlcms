<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactBlockIps extends Model
{
    protected $table = 'contact_block_ips';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
