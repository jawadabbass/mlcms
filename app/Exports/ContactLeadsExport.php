<?php

namespace App\Exports;

use App\Models\Back\ContactUs;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ContactLeadsExport implements FromView
{
    private $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $ids = ContactUs::where('is_exported', 0)->pluck('id')->toArray();
        $contact_leads = ContactUs::whereIn('id', $ids)->orderBy('dated', 'desc')->get();
        ContactUs::whereIn('id', $ids)->update(['is_exported'=>1]);
        return view('back.contactus.exports.contact_leads', [
            'contact_leads' => $contact_leads,
        ]);
    }
}
