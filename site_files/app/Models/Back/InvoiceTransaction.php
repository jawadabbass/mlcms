<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class InvoiceTransaction extends Model
{
    public $timestamps = false;
    protected $table = 'inv_invoices_transactions';
}
