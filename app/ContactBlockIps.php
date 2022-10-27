<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactBlockIps extends Model
{
    protected $table = 'contact_block_ips';
    protected $primaryKey = 'ID';
    public $timestamps = false;
}
