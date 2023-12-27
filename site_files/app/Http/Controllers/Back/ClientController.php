<?php

namespace App\Http\Controllers\Back;

use App\Models\Back\City;
use App\Models\Back\State;
use App\Models\Back\Client;
use Illuminate\Support\Str;
use App\Mail\ConditionEmail;
use Illuminate\Http\Request;
use App\Models\Back\Condition;
use App\Models\Back\ContactUs;
use App\Models\Back\CmsModuleData;
use App\Models\Back\EmailTemplate;
use Vonage\Client as VonageClient;
use App\Models\Back\ClientPackages;
use App\Models\Back\ClientsHistory;
use App\Http\Controllers\Controller;
use App\Mail\ConditionEmailSchedule;
use App\Models\Back\MessageTemplate;
use App\Models\Back\PackageQuestion;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\Back\ContentCondition;
use Illuminate\Support\Facades\Session;
use Vonage\SMS\Message\SMS as VonageSMS;
use Illuminate\Support\Facades\Validator;
use App\Models\Back\ClientPackagesQuestions;
use Vonage\Client\Credentials\Basic as VonageBasic;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sendResult = array('name' => '', 'email' => '',);
        if (isset($_GET['name']) || isset($_GET['email']) || isset($_GET['previous']) || isset($_GET['package'])) {
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
            $specialistQuery = Client::with('user')->with('client_assessment.assessment_question')->with('clientPackage')->orderBy('dated', 'DESC');
            if (isset($_GET['name']) && !empty($_GET['name'])) {
                $specialistQuery->where('name', 'like', '%' . $_GET['name'] . '%')->orWhere('email', 'like', '%' . $_GET['name'] . '%')->where('email', 'like', '%' . $_GET['name'] . '%')->orWhere('name', 'like', '%' . $_GET['name'] . '%');
            }
            if (isset($_GET['dates']) && !empty($_GET['dates'])) {
                $date = $_GET['dates'];
                $value = preg_split("#-#", $date);
                $from = date("Y-m-d", strtotime($value[0]));
                $to = date("Y-m-d", strtotime($value[1]));
                $specialistQuery->whereBetween('dated', [$from, $to]);
            }
            $specialistQuery->orderBy('dated', 'DESC');
            $result = $specialistQuery->get();
            $result2 = [];
            if (isset($_GET['package']) && !empty($_GET['package'])) {
                foreach ($result as $res) {
                    if (!$res->clientPackage->isEmpty()) {
                        foreach ($res->clientPackage as $compare) {
                            if ($compare['package_id'] == $_GET['package']) {
                                $result2[] = $res;
                            }
                        }
                    }
                }
                $result = $result2;
            }
        } else {
            $result = Client::with('user')->with('client_assessment.assessment_question')->orderBy('dated', 'DESC')->paginate(10);
        }
        $data = array();
        $data['msg'] = '';
        $title = 'Clients | ' . config("Constants.SITE_NAME");
        $email_template = EmailTemplate::where('email_type', 'status')->orderBy('ID', 'ASC')->get();
        $sms_template = MessageTemplate::all();
        $get_all_packages = getModuleData(37);
        $content_condition = ContentCondition::select('id', 'title')->whereNotNull('title')->get();
        return view('back.clients.index_view', compact('result', 'title', 'data', 'email_template', 'sms_template', 'get_all_packages', 'content_condition'));
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
        $title = config("Constants.SITE_NAME") . ': Add | Client';
        $states = State::active()->sorted()->get();
        $conditions = getModuleData(38);
        return view('back.clients.add', compact('title', 'data', 'states', 'conditions'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        //Create seller
        $client  = new Client();
        $client->name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->state_id = $request->state_id;
        $client->city_id = $request->city_id;
        $client->email = $request->email;
        $client->zip = $request->zip;
        $client->dob = $request->dob;
        $client->added_by = auth()->user()->id;
        $client->dated = date('Y-m-d');
        $client->password = Hash::make($request->password);
        if (isset($request->conditions)) {
            $client->conditions = json_encode($request->conditions);
        }
        $client->save();
        return redirect()->route('manage_clients.index')->with('success', 'New Client Added Successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::with(['user', 'state'])->find($id);
        $title = config('Constants.SITE_NAME') . ': Clients | Edit';
        $all_leads =Client::orderBy('id')->get();
        
        $pre = Client::where('id', '<', $id)->orderBy('id', 'DESC')->first();
        $next = Client::where('id', '>', $id)->orderBy('id', 'ASC')->first();
        
        $history = ClientsHistory::where('client_id', $id)->with(['user'])->paginate(10);
        $conditions = getModuleData(38);
        return view('back.clients.show', compact('client', 'title', 'history', 'conditions','pre', 'next'));
    }
    public function status(Request $request)
    {
        $clientObj = Client::find($request->idds);
        $history = new ClientsHistory();
        if ($clientObj) {
            $clientObj->status = $request->sts;
            $clientObj->save();
            $history->client_id = $request->idds;
            $history->msg = '"Status updated"' . " " . $request->sts;
            $history->u_type = Auth::user()->id;
            $history->ref = 4;
            $history->add_by_user_id = Auth::user()->id;
            $history->history_id = '';
            $history->email = Auth::user()->email;
            $history->save();
            $response['success'] = 'done';
            $response['errormsg'] = 'DONE';
            $response['status'] = $request->sts;
            $response['id'] = $request->idds;
            echo json_encode($response);
        } else {
            echo json_encode(array(
                'success' => 'error',
                'errormsg' => 'Record not found to delete.'
            ));
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = array();
        $data['msg'] = '';
        $clientObj = Client::find($id);
        $title = config("Constants.SITE_NAME") . ': Edit | Client';
        $states = State::active()->sorted()->get();
        $conditions = getModuleData(38);
        return view('back.clients.edit', compact('title', 'data', 'clientObj', 'states', 'conditions'));
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
        $this->updatevalidator($request->all())->validate();
        $client  = Client::find($id);
        $client->name = $request->first_name;
        $client->last_name = $request->last_name;
        $client->address = $request->address;
        $client->phone = $request->phone;
        $client->state_id = $request->state_id;
        $client->dob = $request->dob;
        $client->city_id = $request->city_id;
        $client->email = $request->email;
        if (isset($request->conditions)) {
            $client->conditions = json_encode($request->conditions);
        }
        if (!$request->password == null) {
            Validator::make($request->all(), [
                'password' => 'required|min:6|confirmed',
            ], [
                'password.required' => 'Password is Required.',
            ]);
            $client->password = Hash::make($request->password);
        }
        $client->zip = $request->zip;
        $client->save();
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect(route('manage_clients.index'));
    }
    protected function updatevalidator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:500',
            'phone' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zip' => 'required|min:5|max:5',
            'dob' => 'required',
        ], [
            'first_name.required' => 'First Name is required.',
            'last_name.required' => 'Last Name is required.',
            'phone.required' => ' Phone is required.',
            'state_id.required' => ' State is required.',
            'city_id.required' => ' City is required.',
            'zip.required' => ' Zip Code is required.',
            'dob.required' => ' Date of Birth is required.',
            'address.required' => 'Address is required.',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Client::destroy($id);
        return json_encode(array("status" => true));
    }
    public function CommentContactClients(Request $request)
    {
        $client = Client::find($request->contact_id);
        $history = new ClientsHistory();
        $history->client_id = $request->contact_id;
        $history->msg = '"Comment Added"' . " " . $request->message;
        $history->u_type = Auth::user()->id;
        $history->add_by_user_id = Auth::user()->id;
        $history->history_id = '';
        $history->ref = 2;
        $history->email = Auth::user()->email;
        $history->save();
        return json_encode(array("status" => true));
    }
    protected function validator(array $data)
    {
        $validated = Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:500',
            'phone' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'zip' => 'required|min:5|max:5',
            'dob' => 'required',
            'email' => 'required|email|max:255|unique:clients',
            'password' => 'required|min:6|confirmed',
        ], [
            'first_name.required' => 'First Name is required.',
            'last_name.required' => 'Last Name is required.',
            'phone.required' => ' Phone is required.',
            'state_id.required' => ' State is required.',
            'city_id.required' => ' City is required.',
            'zip.required' => ' Zip Code is required.',
            'dob.required' => ' Date of Birth is required.',
            'address.required' => 'Address is required.',
            'password.required' => 'Password is Required.',
            'email.required' => 'Email is Required.',
        ]);

        return $validated;
    }
    public function ManageClientPackages($id)
    {
        $data = array();
        $data['msg'] = '';
        $client = Client::find($id);
        $result = ClientPackages::where('client_id', $id)->with('clientPackage')->with('clientPackageQuestions.question')->paginate(20);
        $title = config("Constants.SITE_NAME") . ': Package | Client';
        return view('back.clients.client_packages_index', compact('title', 'data', 'result', 'client'));
    }
    public function changePackageStatus(Request $request)
    {
        $data = ClientPackages::find($request->id);
        $data->sts = $request->status;
        $data->save();
        return 'done';
    }
    public function clientAddPackageView($id)
    {
        $data = array();
        $data['msg'] = '';
        $client = Client::find($id);
        $previous_package_active = ClientPackages::where('client_id', $id)->pluck('package_id')->toarray();
        $title = config("Constants.SITE_NAME") . ': Package | Add Client New Package';
        $get_all_packages = CmsModuleData::where('sts', 'active')
            ->where('cms_module_id', 37)
            ->whereNotIn('id', $previous_package_active)
            ->orderBy('item_order', 'ASC')
            ->get();
        if (!$get_all_packages == null) {
            return view('back.clients.client_packages_add', compact('title', 'data', 'client', 'get_all_packages'));
        } else {
            return back()->with('error', 'No More Package For This Client Is Remaining');
        }
    }
    public function getPackagePrequalifiedQuestions($package_id)
    {
        $package_questions = PackageQuestion::where('package_id', $package_id)->get();
        return view('back.clients.package_question_div', compact('package_questions'));
    }
    public function clientPackageStore(Request $request)
    {
        $new_page = new ClientPackages();
        $new_page->client_id = $request->client_id;
        $new_page->package_id = $request->package_id;
        $new_page->save();
        if (isset($request->answer)) {
            foreach ($request->answer as $key => $do) {
                $client_p_questions = new ClientPackagesQuestions();
                if (is_array($do)) {
                    $client_p_questions->answer = json_encode($do);
                } else {
                    $client_p_questions->answer = $do;
                }
                $client_p_questions->client_package_id = $new_page->id;
                $client_p_questions->question_id = $key;
                $client_p_questions->save();
            }
        }
        return redirect()->route('manage_client_packages', $request->client_id)->with('success', 'Package Added Successfully');
    }
    public function ClientEmailTemplate($id)
    {
        $email_template = EmailTemplate::where('ID', $id)->first();
        echo json_encode($email_template);
    }
    public function sendEmailClient(Request $request)
    {
        if (isset($request->send_to_client)) {
            if (!isset($request->client_package)) {
                return json_encode(array("val_error" => true));
            }
        }
        if (isset($request->new_temp)) {
            $email_template = EmailTemplate::find($request->template_id);
            $email_template->Subject = $request->subject;
            $email_template->user_body = $request->user_body;
            $email_template->save();
        }
        if ($request->value_send == 'combine') {
            if (isset($request->send_to_client) || isset($request->send_to_leads)) {
                if (isset($request->send_to_client)) {
                    $clients = Client::all();
                    if (isset($request->client_package)) {
                        if (!$clients == null) {
                            foreach ($clients as $client) {
                                foreach ($request->client_package as $key => $con_p) {
                                    $package = ClientPackages::where('client_id', $client->id)->whereIn('package_id', $key)->first();
                                    if (!$package == null) {
                                        $email = $client->email;
                                        $name = $client->name . ' ' . $client->last_name;
                                        $history = new ClientsHistory();
                                        $history->client_id = $client->id;
                                        $history->msg = '"Email Sent"';
                                        $history->u_type = Auth::user()->id;
                                        $history->add_by_user_id = Auth::user()->id;
                                        $history->history_id = '';
                                        $history->email = Auth::user()->email;
                                        //$history->template_id = $request->template_id;
                                        $history->ref = 3;
                                        $history->save();
                                        $admin = Auth::user()->name;
                                        $com_email = Auth::user()->email;
                                        $data = $request->all();
                                        $to = $email;
                                        $subject = $request->subject;
                                        $title = $request->subject;
                                        $from = $com_email;
                                        $text = view('mail.template', compact('data', 'name', 'admin', 'com_email', 'title'))->render();
                                        //$headers = "From: $from";
                                        $headers = 'From:' . $from . "\r\n" .
                                            'Reply-To:' . $from . "\r\n" .
                                            'Bcc:' . $from . "\r\n" .
                                            'X-Mailer: PHP/' . phpversion();
                                        $headers .= "MIME-Version: 1.0\r\n";
                                        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                        mail($to, $subject, $text, $headers);
                                    }
                                }
                            }
                        }
                    }
                }
                //second condition
                if (isset($request->send_to_leads)) {
                    $leads = ContactUs::all();
                    if (!$leads == null) {
                        foreach ($leads as $lead) {
                            $email = $lead->email;
                            $name = $lead->name;
                            $history = new ClientsHistory();
                            $history->contact_id = $lead->id;
                            $history->msg = '"Email Sent"';
                            $history->user_id = Auth::user()->id;
                            //$history->ref = 3;
                            $history->save();
                            $admin = Auth::user()->name;
                            $com_email = Auth::user()->email;
                            $data = $request->all();
                            $to = $email;
                            $subject = $request->subject;
                            $title = $request->subject;
                            $from = $com_email;
                            $text = view('mail.template', compact('data', 'name', 'admin', 'com_email', 'title'))->render();
                            //$headers = "From: $from";
                            $headers = 'From:' . $from . "\r\n" .
                                'Reply-To:' . $from . "\r\n" .
                                'Bcc:' . $from . "\r\n" .
                                'X-Mailer: PHP/' . phpversion();
                            $headers .= "MIME-Version: 1.0\r\n";
                            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                            mail($to, $subject, $text, $headers);
                        }
                    }
                }
                return json_encode(array("status" => true));
            } else {
                return json_encode(array("error" => 'Please Check Clients Or Leads Option'));
            }
        } else {
            if ($request->receiver_type == 'client') {
                $client = Client::find($request->receiver_user_id);
                $email = $client->email;
                $name = $client->name . ' ' . $client->last_name;
                $history = new ClientsHistory();
                $history->client_id = $client->id;
                $history->msg = '"Email Sent"';
                $history->u_type = Auth::user()->id;
                $history->add_by_user_id = Auth::user()->id;
                $history->history_id = '';
                $history->email = Auth::user()->email;
                //$history->template_id = $request->template_id;
                $history->ref = 3;
                $history->save();
                $admin = Auth::user()->name;
                $com_email = Auth::user()->email;
                $data = $request->all();
                $to = $email;
                $subject = $request->subject;
                $title = $request->subject;
                $from = $com_email;
                $text = view('mail.template', compact('data', 'name', 'admin', 'com_email', 'title'))->render();
                //$headers = "From: $from";
                $headers = 'From:' . $from . "\r\n" .
                    'Reply-To:' . $from . "\r\n" .
                    'Bcc:' . $from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                mail($to, $subject, $text, $headers);
                return json_encode(array("status" => true));
            } else {
                $lead = ContactUs::find($request->receiver_user_id);
                $email = $lead->email;
                $name = $lead->name;
                $history = new ClientsHistory();
                $history->contact_id = $lead->id;
                $history->msg = '"Email Sent"';
                $history->user_id = Auth::user()->id;
                //$history->ref = 3;
                $history->save();
                $admin = Auth::user()->name;
                $com_email = Auth::user()->email;
                $data = $request->all();
                $to = $email;
                $subject = $request->subject;
                $title = $request->subject;
                $from = $com_email;
                $text = view('mail.template', compact('data', 'name', 'admin', 'com_email', 'title'))->render();
                //$headers = "From: $from";
                $headers = 'From:' . $from . "\r\n" .
                    'Reply-To:' . $from . "\r\n" .
                    'Bcc:' . $from . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                mail($to, $subject, $text, $headers);
                return json_encode(array("status" => true));
            }
        }
    }
    public function ClientSMSTemplate($id)
    {
        $sms_template = MessageTemplate::where('id', $id)->first();
        echo json_encode($sms_template);
    }
    public function sendSMSClient(Request $request)
    {
        $sms_template = MessageTemplate::find($request->sms_template_id);
        if (isset($request->new_temp)) {
            $sms_template->title = $request->sms_subject;
            $sms_template->body = $request->sms_user_body;
            $sms_template->update();
        }

        $sms_body = $sms_template->body;

        $basic  = new VonageBasic(config('vonage.VONAGE_API_KEY'), config('vonage.VONAGE_API_SECRET'));
        $vonageClient = new VonageClient($basic);

        $smsToArray = [];
        if ($request->sms_value_send == 'combine') {
            if (isset($request->sms_send_to_client) || isset($request->sms_send_to_leads)) {
                if (isset($request->sms_send_to_client)) {
                    $clients = Client::all();
                    if (isset($request->sms_client_package)) {
                        if (!$clients == null) {
                            foreach ($clients as $client) {
                                foreach ($request->sms_client_package as $key => $con_p) {
                                    $package = ClientPackages::where('client_id', $client->id)->where('package_id', $key)->first();
                                    if (!$package == null) {
                                        $smsToArray[] = $client->phone;
                                        $history = new ClientsHistory();
                                        $history->client_id = $client->id;
                                        $history->msg = '"SMS Sent"' . $sms_body;
                                        $history->u_type = Auth::user()->id;
                                        $history->add_by_user_id = Auth::user()->id;
                                        $history->history_id = '';
                                        $history->email = Auth::user()->email;
                                        $history->ref = 3;
                                        $history->save();
                                    }
                                }
                            }
                        }
                    }
                }
                //second condition
                if (isset($request->sms_send_to_leads)) {
                    $leads = ContactUs::all();
                    if (!$leads == null) {
                        foreach ($leads as $lead) {
                            $smsToArray[] = $lead->phone;
                            $history = new ClientsHistory();
                            $history->contact_id = $lead->id;
                            $history->msg = '"SMS Sent"' . $sms_body;
                            $history->user_id = Auth::user()->id;
                            $history->save();
                        }
                    }
                }
            }
        } else {
            if ($request->sms_receiver_type == 'client') {
                $client = Client::find($request->sms_receiver_user_id);
                $smsToArray[] = $client->phone;
                $history = new ClientsHistory();
                $history->client_id = $client->id;
                $history->msg = '"SMS Sent"' . $sms_body;
                $history->u_type = Auth::user()->id;
                $history->add_by_user_id = Auth::user()->id;
                $history->history_id = '';
                $history->email = Auth::user()->email;
                //$history->template_id = $request->template_id;
                $history->ref = 3;
                $history->save();
            } else {
                $lead = ContactUs::find($request->sms_receiver_user_id);
                $smsToArray[] = $lead->phone;
                $history = new ClientsHistory();
                $history->contact_id = $lead->id;
                $history->msg = '"SMS Sent"' . $sms_body;
                $history->user_id = Auth::user()->id;
                $history->save();
            }
        }

        $returnMsg = 'The message has been sent successfully!';
        $returnStatus = '200';

        $newSmsToArray = [];
        foreach ($smsToArray as $phone) {
            $phone = str_replace(['+', '-'], [''], $phone);
            if (Str::length($phone) == 10) {
                $phone = '1' . $phone;
            }
            $newSmsToArray = $phone;
        }

        $newSmsToArray = array_unique($newSmsToArray);
        foreach ($newSmsToArray as $phoneNumber) {
            $response = $vonageClient->sms()->send(
                new VonageSMS($phoneNumber, config('vonage.FROM_NUMBER'), $sms_body)
            );
            $message = $response->current();
            if ($message->getStatus() != 0) {
                $returnMsg = "The message failed with status: " . $message->getStatus();
                $returnStatus = '400';
                break;
            }
        }
        return json_encode(array('status' => $returnStatus, "message" => $returnMsg));
    }
    public function update_condition(Request $request)
    {
        $client = Client::find($request->id);
        if ($client->conditions != NULL) {
            $cl_conditions = json_decode($client->conditions);
            if (is_array($cl_conditions)) {
                if (in_array($request->val, $cl_conditions)) {
                    foreach (array_keys($cl_conditions, $request->val) as $key) {
                        unset($cl_conditions[$key]);
                    }
                    $content_conditions = json_encode($cl_conditions);
                    $client->conditions = $content_conditions;
                    $client->save();
                } else {
                    array_push($cl_conditions, $request->val);
                    $content_conditions = json_encode($cl_conditions);
                    $client->conditions = $content_conditions;
                    $client->save();
                }
            } else {
                $cl_conditions = array();
                if ($request->val != "") {
                    array_push($cl_conditions, $request->val);
                    $content_conditions = json_encode($cl_conditions);
                    $client->conditions = $content_conditions;
                    $client->save();
                }
            }
        } else {
            $cla_conditions = array();
            array_push($cla_conditions, $request->val);
            $client->conditions = json_encode($cla_conditions);
            $client->save();
        }
        $client_upd = Client::find($request->id);
        $client_condition = json_decode($client_upd->conditions);
        foreach ($client_condition as $c_condition) {
            $contents = Condition::where('condition_content', 'like', "%$c_condition%")->where('schedule_type', "once")->get();
            foreach ($contents as $content) {
                if ($content->type == "email") {
                    Mail::to($client->email)->send(new ConditionEmail($client_upd->name, $content->description, $content->title));
                } elseif ($content->type == "text") {
                } elseif ($content->type == "web_page") {
                    $pin = rand(10, 100000);
                    $client_upd->web_page_pin = $pin;
                    $client_upd->save();
                    Mail::to($client_upd->email)->send(new ConditionEmailSchedule($client_upd->id, $client_upd->name, $content->id, $pin, $content->title));
                }
            }
        }
    }

    public function clientDelete(Request $request)
    {
        Client::whereIn('id', $request->client_check)->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
        return redirect(route('manage_clients.index'));
    }
}
