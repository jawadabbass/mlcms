<?php
namespace App\Http\Controllers\Back;
use App\Mail\Notification;
use Illuminate\Http\Request;
use App\Models\Back\Location;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Back\GeneralEmailTemplate;
use App\Models\Back\MassMailQueue;
use Illuminate\Support\Facades\Mail;
use App\Traits\GeneralEmailTemplateTrait;
class MassMailController extends Controller
{
    use GeneralEmailTemplateTrait;
    public function index(Request $request)
    {
        return view('back.mass_email.index');
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
        $search_locations = $request->input('locations[]', []);
        $is_professionals_check = $request->input('professionals', 'No');
        $is_contacts_check = $request->input('contact', 'No');
        /************************* */
        /************************* */
        $special = DB::table('wp_specialist')->where('id', '0')->get();
        $contact = DB::table('contact_us_requests')->where('id', '0')->get();
        if ($is_professionals_check == 'Yes') {
            $specialQuery = DB::table('wp_specialist');
            $specialQuery->where(function ($q) use ($search_locations) {
                if (count($search_locations) > 0) {
                    foreach ($search_locations as $location) {
                        $q->orWhere('select_location', 'like', '%' . $location . '%');
                    }
                }
            });
            $special = $specialQuery->get();
        }
        /************************* */
        /************************* */
        if ($is_contacts_check == 'Yes') {
            $contactQuery = DB::table('contact_us_requests')
                ->where('dated', '>=', $lead_date_from)
                ->where('dated', '<=', $lead_date_to);
            $contactQuery->where(function ($q) use ($search_locations) {
                if (count($search_locations) > 0) {
                    foreach ($search_locations as $location) {
                        $q->orWhere('location', 'like', '%' . $location . '%');
                    }
                }
            });
            $contact = $contactQuery->get();
        }
        /************************* */
        /************************* */
        foreach ($special as $professionalObj) {
            $massMailQueueObj = new MassMailQueue();
            $massMailQueueObj->template_id = $template_id;
            $massMailQueueObj->professional_id = $professionalObj->id;
            $massMailQueueObj->contact_id = 0;
            $massMailQueueObj->date = $date;
            $massMailQueueObj->time = $time;
            $massMailQueueObj->save();
        }
        /************************* */
        /************************* */
        foreach ($contact as $leadObj) {
            $massMailQueueObj = new MassMailQueue();
            $massMailQueueObj->template_id = $template_id;
            $massMailQueueObj->professional_id = 0;
            $massMailQueueObj->contact_id = $leadObj->id;
            $massMailQueueObj->date = $date;
            $massMailQueueObj->time = $time;
            $massMailQueueObj->save();
        }
        return redirect('/adminmedia/mass-mail-queued');
    }
}
