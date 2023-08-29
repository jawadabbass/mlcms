<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public $timestamps = false;
    protected $table = 'inv_invoices';
    function paymet_method()
    {
        return $this->hasMany('App\Models\Back\InvoicePayment', 'fk_invoice_id', 'id');
    }
}
