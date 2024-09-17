<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\Client;
use Illuminate\Http\Request;
use App\Models\Back\ContactUs;
use App\Models\Back\Subscribers;
use App\Models\Back\MassMailQueue;
use App\Http\Controllers\Controller;
use App\Models\Back\GeneralEmailTemplate;
use App\Traits\GeneralEmailTemplateTrait;

class MassMailController extends Controller
{
    use GeneralEmailTemplateTrait;
    public function index(Request $request)
    {
        $packages = getModuleData(37);
        $clients = $request->input('clients', 'No');
        $leads = $request->input('leads', 'No');
        $subscribers = $request->input('subscribers', 'No');
        $client_id = $request->input('client_id', 0);
        $lead_id = $request->input('lead_id', 0);
        $clientObj = Client::find($client_id);
        $leadObj = ContactUs::find($lead_id);

        return view('back.mass_email.index', compact(
            'packages',
            'clients',
            'leads',
            'subscribers',
            'client_id',
            'lead_id',
            'clientObj',
            'leadObj',
        ));
    }
    public function massMailQueued(Request $request)
    {
        return view('back.mass_email.queued');
    }
    public function getMailTemplateView(Request $request)
    {
        $id = $request->input('id', 0);
        if ($id == 0) {
            $generalEmailTemplateObj = new GeneralEmailTemplate();
            $generalEmailTemplateObj->dynamic_values = '{NAME},{EMAIL},{PHONE}';
        } else {
            $generalEmailTemplateObj = GeneralEmailTemplate::find($id);
        }
        echo view('back.general_email_templates.form')->with('generalEmailTemplateObj', $generalEmailTemplateObj)->render();
    }
    public function SendMassMail(Request $request)
    {
        $save_update_template_or_just_send_mail = $request->save_update_template_or_just_send_mail;
        if ($save_update_template_or_just_send_mail == 'save_new_template') {
            $generalEmailTemplateObj = new GeneralEmailTemplate();
            $generalEmailTemplateObj = $this->setGeneralEmailTemplateValues($request, $generalEmailTemplateObj);
            $generalEmailTemplateObj->save();
        } elseif ($save_update_template_or_just_send_mail == 'update_selected_template') {
            $generalEmailTemplateObj = GeneralEmailTemplate::find($request->template_id);
            $generalEmailTemplateObj = $this->setGeneralEmailTemplateValues($request, $generalEmailTemplateObj);
            $generalEmailTemplateObj->update();
        } elseif ($save_update_template_or_just_send_mail == 'do_not_update_selected_template') {
            $generalEmailTemplateObj = new GeneralEmailTemplate();
            $generalEmailTemplateObj = $this->setGeneralEmailTemplateValues($request, $generalEmailTemplateObj);
            $generalEmailTemplateObj->is_temporary = 1;
            $generalEmailTemplateObj->save();
        }
        /************************* */
        /************************* */
        $template_id = $generalEmailTemplateObj->id;
        $date = $request->input('date');
        $dateArray = explode('-', $date);
        $date = $dateArray[2] . '-' . $dateArray[0] . '-' . $dateArray[1];
        $time = date('H:i:s', strtotime($request->input('time')));
        /************************* */
        /************************* */
        $lead_date_from = $request->input('lead_date_from', date('m-d-Y'));
        $dateArray = explode('-', $lead_date_from);
        $lead_date_from = $dateArray[2] . '-' . $dateArray[0] . '-' . $dateArray[1];
        /************************* */
        /************************* */
        $lead_date_to = $request->input('lead_date_to', date('m-d-Y'));
        $dateArray = explode('-', $lead_date_to);
        $lead_date_to = $dateArray[2] . '-' . $dateArray[0] . '-' . $dateArray[1];
        /************************* */
        /************************* */
        $packages = $request->input('packages[]', []);
        $is_clients_check = $request->input('clients', 'No');
        $is_leads_check = $request->input('leads', 'No');
        $is_subscribers_check = $request->input('subscribers', 'No');
        $client_id = $request->input('client_id', 0);
        $lead_id = $request->input('lead_id', 0);
        $clientObj = Client::find($client_id);
        $leadObj = ContactUs::find($lead_id);
        /************************* */
        /************************* */
        $clients = Client::where('id', '0')->get();
        $leads = ContactUs::where('id', '0')->get();
        $subscribers = Subscribers::where('id', '0')->get();
        /************************* */
        if ($is_clients_check == 'Yes') {
            $clientQuery = Client::select('*');
            $clientQuery->where(function ($q) use ($packages) {
                if (count($packages) > 0) {
                    foreach ($packages as $key => $package_id) {
                        $q->orWhere('package_id', $package_id);
                    }
                }
            });
            $clients = $clientQuery->get();
        }
        if(null !== $clientObj){
            $clients->push($clientObj);
        }
        /************************* */
        /************************* */
        if ($is_leads_check == 'Yes') {
            $leadQuery = ContactUs::select('*')
                ->where('dated', '>=', $lead_date_from)
                ->where('dated', '<=', $lead_date_to);
            $leads = $leadQuery->get();
        }
        if(null !== $leadObj){
            $leads->push($leadObj);
        }
        /************************* */
        /************************* */
        if ($is_subscribers_check == 'Yes') {
            $subscribers = Subscribers::select('*')->get();
        }
        /************************* */
        /************************* */
        foreach ($clients as $clientObj) {
            $massMailQueueObj = new MassMailQueue();
            $massMailQueueObj->template_id = $template_id;
            $massMailQueueObj->client_id = $clientObj->id;
            $massMailQueueObj->contact_id = 0;
            $massMailQueueObj->subscriber_id = 0;
            $massMailQueueObj->date = $date;
            $massMailQueueObj->time = $time;
            $massMailQueueObj->save();
        }
        /************************* */
        /************************* */
        foreach ($leads as $leadObj) {
            $massMailQueueObj = new MassMailQueue();
            $massMailQueueObj->template_id = $template_id;
            $massMailQueueObj->client_id = 0;
            $massMailQueueObj->contact_id = $leadObj->id;
            $massMailQueueObj->subscriber_id = 0;
            $massMailQueueObj->date = $date;
            $massMailQueueObj->time = $time;
            $massMailQueueObj->save();
        }
        /************************* */
        /************************* */
        foreach ($subscribers as $subscriberObj) {
            $massMailQueueObj = new MassMailQueue();
            $massMailQueueObj->template_id = $template_id;
            $massMailQueueObj->client_id = 0;
            $massMailQueueObj->contact_id = 0;
            $massMailQueueObj->subscriber_id = $subscriberObj->id;
            $massMailQueueObj->date = $date;
            $massMailQueueObj->time = $time;
            $massMailQueueObj->save();
        }
        return redirect('/adminmedia/mass-mail-queued');
    }
}
