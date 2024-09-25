<?php

namespace App\Http\Controllers\Back;

use Carbon\Carbon;
use App\Models\Back\Client;
use Illuminate\Http\Request;
use App\Mail\AssessmentEmail;
use App\Models\Back\ContactUs;
use App\Models\Back\AdminAlert;
use Spatie\GoogleCalendar\Event;
use App\Models\Back\CmsModuleData;
use App\Models\Back\EmailTemplate;
use App\Exports\ContactLeadsExport;
use App\Models\Back\ClientPackages;
use App\Models\Back\ClientsHistory;
use App\Http\Controllers\Controller;
use App\Models\Back\MessageTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Back\ContactUsRequest;
use App\Models\Back\AssessmentAnswers;
use App\Models\Back\ContactLeadHistory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $read_lead = $request->input('read_lead', 2);
        $sendResult = array('name' => '', 'email' => '', 'dates' => '');
        if (isset($_GET['name']) || isset($_GET['email']) || isset($_GET['dates'])) {
            $searchArr = array();
            $serachLink = '';
            foreach ($sendResult as $key => $value) {
                if (isset($_GET[$key])) {
                    $sendResult[$key] = trim($_GET[$key]);
                    $serachLink .= $key . '=' . trim($_GET[$key]) . '&';
                } else {
                    $serachLink .= $key . '=' . $value . '&';
                }
            }
            $searchArr = $sendResult;
            foreach ($searchArr as $key => $value) {
                if ($value == '' || $value == '0') {
                    unset($searchArr[$key]);
                }
            }
            $specialistQuery = ContactUs::with('user')->with('assessment.assessment_question')->orderBy('dated', 'DESC');
            if ($read_lead != 2) {
                $specialistQuery->where('read_lead', $read_lead);
            }
            if (isset($_GET['name']) && !empty($_GET['name'])) {
                $specialistQuery->where('name', 'like', '%' . $_GET['name'] . '%')->orWhere('email', 'like', '%' . $_GET['name'] . '%')->where('email', 'like', '%' . $_GET['name'] . '%')->orWhere('name', 'like', '%' . $_GET['name'] . '%');
            }
            if (isset($_GET['dates']) && !empty($_GET['dates'])) {
                $date = $_GET['dates'];
                $value = preg_split("#-#", $date);
                $from = date("Y-m-d", strtotime($value[0]));
                $to = date("Y-m-d", strtotime($value[1]));
                $specialistQuery->where('dated', '>=', $from)
                    ->where('dated', '<=', $to);
            }
            $specialistQuery->orderBy('dated', 'desc');
            $result = $specialistQuery->paginate(15);
            $serachLink = rtrim($serachLink, '&');
            $result->setPath('?' . $serachLink);
        } else {
            $result = ContactUs::with('user')->with('assessment.assessment_question')->orderBy('dated', 'DESC')->paginate(15);
        }
        $adminAlert = AdminAlert::where('keyy', 'contact_request')->first();
        if (null !== $adminAlert) {
            $adminAlert->check_dated = date('Y-m-d H:i:s');
            $adminAlert->total = 0;
            $adminAlert->save();
        }
        $contact_data = ContactUs::where('read_lead', 0)->get();
        $contact = count($contact_data);
        $data = array();
        $data['msg'] = '';
        $title = config("Constants.SITE_NAME") . ': Contact Us Page';
        $clientArr = array();
        $get_all_packages = getModuleData(33);
        $sms_template = MessageTemplate::all();
        return view('back.contactus.index_view', compact('result', 'title', 'data', 'clientArr', 'contact', 'get_all_packages', 'sms_template'));
    }
    public function index1()
    {
        $adminAlert = AdminAlert::where('keyy', 'contact_request')->first();
        if (null !== $adminAlert) {
            $adminAlert->check_dated = date('Y-m-d H:i:s');
            $adminAlert->total = 0;
            $adminAlert->save();
        }
        $result = ContactUs::orderBy('id', 'DESC')->get();
        return response()->json($result, 200);
    }
    public function getdata($id)
    {
        return response()->json($id);
    }
    public function savedata(Request $request)
    {
        return response()->json(['message' => 'data has been saved Successfully']);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array();
        $data['msg'] = '';
        $title = config("Constants.SITE_NAME") . ': Add | Contact Lead';
        return view('back.contactus.add', compact('title', 'data'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $contact = new ContactUsRequest;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comments = $request->comments;
        $contact->city = '';
        $contact->country = '';
        $contact->ip = $request->ip();
        $contact->dated = $request->dated;
        $contact->added_by = Auth::user()->id;
        $contact->save();
        session(['message' => 'Added Successfully', 'type' => 'success']);
        return redirect(route('contact_request.index'));
    }
    public function convert_client($id)
    {
        $contact = ContactUs::find($id);
        $abcEmail = Client::where('email', $contact->email)->get();
        if (count($abcEmail) > 0) {
            return json_encode(array("status" => 'error'));
        } else {
            $clientObj = new Client;
            $clientObj->name = $contact->name;
            $clientObj->email = $contact->email;
            $clientObj->phone = $contact->phone;
            $clientObj->comments = $contact->comments;
            $clientObj->city = '';
            $clientObj->country = '';
            $clientObj->ip = $contact->ip;
            $clientObj->dated = $contact->dated;
            $clientObj->address = $contact->address;
            $clientObj->price = $contact->price;
            $clientObj->subject = $contact->subject;
            $clientObj->status = 'Active';
            $clientObj->lead_id = $id;
            $clientObj->assesment_status = $contact->assesment_status;
            $clientObj->assesment_code = $contact->assesment_code;
            $clientObj->added_by = Auth::user()->id;
            $clientObj->save();
            AssessmentAnswers::where('lead_id', $id)->update(['type' => 'client', 'lead_id' => ' ', 'client_id' => $clientObj->id]);
            if (!$contact->package_id == null) {
                $package = new ClientPackages();
                $package->package_id = $contact->package_id;
                $package->client_id = $contact->client_id;
                $package->save();
            }
            $history_c = new ClientsHistory();
            $history_c->client_id = $clientObj->id;
            $history_c->msg = '"Added From Contact Us Lead"';
            $history_c->u_type = Auth::user()->id;
            $history_c->add_by_user_id = Auth::user()->id;
            $history_c->history_id = '';
            $history_c->ref = 2;
            $history_c->email = Auth::user()->email;
            $history_c->save();
            $prehistory = ContactLeadHistory::where('contact_id', $id)->get();
            if (count($prehistory) > 0) {
                foreach ($prehistory as $pre) {
                    $history = new ClientsHistory();
                    $history->client_id = $clientObj->id;
                    $history->msg = $pre->msg;
                    $history->u_type = $pre->user_id;
                    $history->ref = $pre->ref;
                    $history->add_by_user_id = $pre->user_id;
                    $history->history_id = '';
                    $history->email = $pre->email;
                    $history->save();
                }
            }
            $contact->delete();
            session(['message' => 'Deleted Successfully', 'type' => 'success']);
            return json_encode(array("status" => 'done'));
        }
    }

    public function loadDataToGoogleCalendarModal($id)
    {
        $contact = ContactUs::find($id);
        echo '
        <form name="frm_process" id="addLeadToGoogleCalendarForm" class="contact-form">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <input type="hidden" name="lead_id" id="lead_id" value="' . $id . '">
            <div class="col-sm-12">
                <label>Name</label>
                <input type="text" name="name" id="name" class="form-control" value="' . $contact->name . '"/>
            </div>
            <div class="col-sm-12">
                <label>Date</label>
                <input type="date" name="dated" id="dated" class="form-control" value="' . $contact->dated . '"/>
            </div>
            <div class="col-sm-12">
                <label>Address</label>
                <input type="text" name="address" id="address" class="form-control" value="' . $contact->address . '"/>
            </div>
            <div class="col-sm-12">
                <label>City</label>
                <input type="text" name="city" id="city" class="form-control" value="' . $contact->city . '"/>
            </div>
            <div class="col-sm-12">
                <label>Country</label>
                <input type="text" name="country" id="country" class="form-control" value="' . $contact->country . '"/>
            </div>
            <div class="col-sm-12">
                <label>Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" value="' . $contact->subject . '"/>
            </div>
            <div class="col-sm-12">
                <label>Assesment Status</label>
                <input type="text" name="assesment_status" id="assesment_status" class="form-control" value="' . $contact->assesment_status . '"/>
            </div>
            <div class="col-sm-12">
                <label>Assesment Code</label>
                <input type="text" name="assesment_code" id="assesment_code" class="form-control" value="' . $contact->assesment_code . '"/>
            </div>
        </form>';
    }

    public function save_to_google_calendar(Request $request)
    {
        $contact = ContactUs::find($request->lead_id);
        $dated = Carbon::createFromFormat('Y-m-d', $request->dated, "America/New_York");
        $description = '<table>
  <tr><td>Dated</td><td>' . $dated . '</td></tr>
  <tr><td>Address</td><td>' . $request->address . '</td></tr>
  <tr><td>Price</td><td>' . $request->price . '</td></tr>
  <tr><td>Subject</td><td>' . $request->subject . '</td></tr>
  <tr><td>Assesment status</td><td>' . $request->assesment_status . '</td></tr>
  <tr><td>Assesment code</td><td>' . $request->assesment_code . '</td></tr>
  </table>';
        $event = new Event();
        $event->name = $request->name;
        $event->startDate = $dated;
        $event->endDate = $dated;
        $event->setLocation($request->address . ' ' . $request->city . ' ' . $request->country);
        $event->setDescription($description);
        $event->colorId = 11;
        $event->status = 'confirmed';
        $event->transparency = 'transparent';
        $event->save();
        $contact->added_to_google_calendar = 1;
        $contact->save();
        session(['message' => 'Added Successfully', 'type' => 'success']);
        return json_encode(array("status" => 'done'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = config("Constants.SITE_NAME") . ': Contact Us Page';
        $result = ContactUs::find($id);
        $pre = ContactUs::where('id', '<', $id)->orderBy('id', 'DESC')->first();
        $next = ContactUs::where('id', '>', $id)->orderBy('id', 'ASC')->first();
        $history = ContactLeadHistory::where('contact_id', $id)->with(['admin'])->paginate(10);
        return view('back.contactus.history', compact('result', 'title', 'history', 'pre', 'next'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ContactUs::destroy($id);
        return json_encode(array("status" => true));
    }
    public function CommentContactLeads(Request $request)
    {
        $history = new ContactLeadHistory();
        $history->contact_id = $request->contact_id;
        $history->msg = '"Comment Added"' . " " . $request->message;
        $history->user_id = Auth::user()->id;
        $history->save();
        return json_encode(array("status" => true));
    }
    public function contactUsReadData($id)
    {
        $contact = ContactUs::find($id);
        $read_data = $contact->read_lead;
        if ($read_data == 0) {
            $contact->read_lead = 1;
        }
        $contact->save();
        return json_encode(array("status" => true));
    }
    public function PriceContactLeads(Request $request)
    {
        $history = new ContactLeadHistory();
        $history->contact_id = $request->contact_id;
        $history->msg = '"Price Added"' . " " . "$" . $request->price;
        $history->user_id = Auth::user()->id;
        $history->save();
        $contact = ContactUs::find($request->contact_id);
        $contact->price = $request->price;
        $contact->save();
        return json_encode(array("status" => true));
    }
    public function packageChangeLeads(Request $request)
    {
        $contact = ContactUs::find($request->id);
        $contact->package_id = $request->package_id;
        $contact->save();
        return 'done';
    }
    public function send_assesments_email(Request $request)
    {
        $name = '';
        $subject = 'Assessment Questions';
        $digits = 10;
        $code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $link = url('assessment-view/' . $request->status . '/' . $request->id . '/' . $code);
        $email = '';
        if ($request->status == 'lead') {
            $contact = ContactUs::find($request->id);
            $name = $contact->name;
            $email = $contact->email;
            $contact->assesment_code = $code;
            $contact->assesment_status = 'sent';
            $contact->save();
        } else {
            $client = Client::find($request->id);
            $name = $client->name . ' ' . $client->last_name;
            $email = $client->email;
            $client->assesment_code = $code;
            $client->assesment_status = 'sent';
            $client->save();
        }
        $mail = Mail::to($email);
        $mail->send(new AssessmentEmail($name, $link, $subject));
        return json_encode(array("status" => true));
    }
    public function getContactRequestToEdit($id, Request $request)
    {
        $contatUsRequestObj = ContactUs::find($id);
        return response()->json($contatUsRequestObj);
    }
    public function updateContactRequest(Request $request)
    {
        $contatUsRequestObj = ContactUs::find($request->id);
        $contatUsRequestObj->name = $request->name;
        $contatUsRequestObj->email = $request->email;
        $contatUsRequestObj->phone = $request->phone;
        $contatUsRequestObj->address = $request->address;
        $contatUsRequestObj->price = $request->price;
        $contatUsRequestObj->subject = $request->subject;
        $contatUsRequestObj->comments = $request->comments;
        $contatUsRequestObj->dated = $request->dated;
        $contatUsRequestObj->added_by = Auth::user()->id;
        $contatUsRequestObj->update();
        return response()->json(['message' => 'Contact request updated successfully!', 'contatUsRequestObj' => $contatUsRequestObj]);
    }
    public function contactUsBulkActions(Request $request)
    {
        if ($request->bulk_action === 'delete') {
            ContactUs::whereIn('id', $request->contact_request_check)->delete();
            session(['message' => 'Deleted Successfully', 'type' => 'success']);
        }
        if ($request->bulk_action === 'read') {
            ContactUs::whereIn('id', $request->contact_request_check)->update(['read_lead' => 1]);
            session(['message' => 'Marked read successfully', 'type' => 'success']);
        }
        return redirect(route('contact_request.index'));
    }
    public function exportLeads(Request $request, $exportType)
    {
        if ('excel' === $exportType) {
            return Excel::download(new ContactLeadsExport($request), 'Contact-Leads.csv', \Maatwebsite\Excel\Excel::CSV);
        }
    }
}
