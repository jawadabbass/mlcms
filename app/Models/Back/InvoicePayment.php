<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    protected $table = 'inv_invoice_payment_options';
    function payment_name()
    {
        return $this->hasOne('App\Models\Back\PaymentOption', 'id', 'fk_payment_option_id');
    }
}
