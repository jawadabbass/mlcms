<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Back\CmsModuleData;
use App\Models\Back\EmailTemplate;

class Email_templatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $settingArr = array(
        'mainTitle' => 'Email Templates',
        'mainPageTitle' => 'Email Templates',
        'contr_name' => 'email_templates',
        'view_add' => 'add_ajax',
        'view_edit' => 'edit_ajax',
        'view_main' => 'index_view',
        'dbName' => 'email_templates',
        'dbId' => 'ID',
        'baseImg' => '',
        'db_order_title' => 'Subject',
        'db_order_key' => 'orderr',
        'add_func' => false,
        'edit_func' => true,
        'delete_func' => true,
        'order_func' => false,
        'listing_func' => true,
        'search_func' => false,
        'detail_func' => true

    );


    public $arrFAdd = array( //index view page


        //'keyy'=>array('Key','',''),
        //'variables'=>array('Variables','textarea','op'),
        'Body' => array('History Message', 'textarea', ''),
        'SenderName' => array('From Name', '', ''),
        'Sender' => array('From Email', '', ''),
        //'icon'=>array('Icon Class','',''),
        //'icon_class'=>array('Icon Color','',''),
        'Status' => array('Status', 'slide_flag__Send Email__Stop Email', ''),

    );
    public $arrFEdit = array( //index view page
        'Title' => array('Title', '', ''),
        'Subject' => array('Subject', '', ''),
        //'keyy'=>array('Key','',''),
        //'variables'=>array('Variables','textarea','op'),
        'Body' => array('History Message', 'textarea', ''),
        'SenderName' => array('From Name', '', ''),
        'Sender' => array('From Email', '', ''),
        //'icon'=>array('Icon Class','',''),
        //'icon_class'=>array('Icon Color','',''),
        'Status' => array('Status', 'slide_flag__Send Email__Stop Email', ''),
    );
    public $arrFList = array( //index view page
        //    'keyy'=>array('Key','dbId',''),
        'ID' => array('ID', 'dbId', ''),
        'Title' => array('Title', '', ''),
        'Subject' => array('Subject', '', ''),
        // 'Template Of Status'=>array('Template Of Status','',''),

        // 'Subject'=>array('Subject','',''),
        //'SenderName'=>array('From Name','',''),
        'Status' => array('Send Email', 'slide_flag__Send Email__Stop Email', ''),
        // 'user_status'=>array('User','slide_flag__Send Email__Stop Email',''),


    );
    public $arrSearch = array( //index view page
        'ID' => array('ID', 'dbId', ''),
        'Title' => array('Title', '', ''),
        'Subject' => array('Subject', '', ''),
        'keyy' => array('Key', '', ''),



    );
    public $arrFView = array( //index view page
        'ID' => array('ID', 'dbId', ''),
        //'keyy'=>array('Key','',''),

        'Status' => array('Status', 'slide_flag__Send Email__Stop Email', ''),


    );


    public $arrOrder = array(
        'Title' => array('Title', '', ''),
        'orderr' => array('Order', '', '')
    );


    public function index()
    {
        // checkAccess(Auth::user(),1);


        $title = FindInsettingArr('business_name') . ': ' . $this->settingArr['mainPageTitle'];
        $msg = '';
        $result = EmailTemplate::orderBy('ID', 'DESC')->paginate(20);

        $settingArr = $this->settingArr;
        $arrSearch = $this->arrSearch;
        $dataArr = $this->arrFList;
        $idf = $this->settingArr['dbId'];

        $status = getModuleData(52);
        return view('back.email_templates.index', compact('title', 'msg', 'result', 'settingArr', 'arrSearch', 'dataArr', 'idf', 'status'));
    }
    public function set_order()
    {
        $title = FindInsettingArr('business_name') . ': ' . $this->settingArr['mainPageTitle'];
        $msg = '';
        $result = EmailTemplate::orderBy($this->settingArr['db_order_key'], 'asc')->get();

        $settingArr = $this->settingArr;
        $arrSearch = $this->arrSearch;
        $dataArr = $this->arrOrder;
        $idf = $this->settingArr['dbId'];

        return view('back.email_templates.order', compact('title', 'msg', 'result', 'settingArr', 'arrSearch', 'dataArr', 'idf'));
    }

    public function update_order(Request $request)
    {
        if ($this->settingArr['order_func'] == false) {
            echo 'ERROR';
            exit;
        }
        //echo '<pre>';print_r($_POST);echo '</pre>';exit;
        $action = $request->action;
        $updateRecordsArray = $request->recordsArray;
        if ($action == "updateRecordsListings") {
            $listingCounter = 1;
            foreach ($updateRecordsArray as $recordIDValue) {
                $oderf = $this->settingArr['db_order_key'];
                $dbObj = EmailTemplate::find($recordIDValue);
                $dbObj->$oderf = $listingCounter;
                $dbObj->save();




                $listingCounter = $listingCounter + 1;
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $bcArr = array();
        $status = getModuleData(52);
        $settingArr = $this->settingArr;
        $title = 'Edit | ' . $settingArr['mainTitle'];


        $dataArr = $this->arrFAdd;

        $title = FindInsettingArr('business_name') . ': Admin Users Management | Add new';

        $settingArr = $this->settingArr;
        return view('back.email_templates.create', compact('title', 'settingArr', 'bcArr', 'dataArr', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dbObj = new EmailTemplate();
        $dbObj->Title = $request->title;
        $dbObj->Subject = $request->Subject;
        $dbObj->template_off = $request->status;

        $dbObj->icon_sign_email = $request->icon_sign_email;
        $dbObj->user_body = $request->user_body;
        $dbObj->save();
        session(['message' => 'Added Successfully', 'type' => 'success']);
        return redirect()->route('email_templates.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $title = $this->settingArr['mainTitle'] . ' Detail | ' . FindInsettingArr('business_name');
        $msg = '';
        $row = EmailTemplate::find($id);
        $arrFields = $this->arrFView;

        $settingArr = $this->settingArr;
        return view('back.email_templates.detail', compact('title', 'msg', 'row', 'settingArr', 'arrFields'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $settingArr = $this->settingArr;
        $title = 'Edit | ' . $settingArr['mainTitle'];
        $row = EmailTemplate::find($id);

        // $level=checkAccessArr(Auth::user(),[1]);

        $dataArr = $this->arrFEdit;
        $idf = $this->settingArr['dbId'];
        $bcArr = array();

        $bcArr = array('email_templates' => 'Templates');
        $status = getModuleData(52);

        return view('back.email_templates.edit', compact('title', 'settingArr', 'dataArr', 'row', 'idf', 'id', 'bcArr', 'status'));
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



        $dbObj = EmailTemplate::find($id);

        $dbObj->template_off = $request->status;
        $dbObj->Subject = $request->Subject;
        $dbObj->Title = $request->title;
        $dbObj->icon_sign_email = $request->icon_sign_email;
        $dbObj->user_body = $request->user_body;
        $dbObj->save();
        session(['message' => 'Updated Successfully', 'type' => 'success']);
        return redirect()->route('email_templates.index');

        $dbObj->save();
        echo json_encode(array('success' => 'done'));
        exit;
    }

    public function update_status(Request $request)
    {


        $dbObj = EmailTemplate::find($request->idds);
        if ($dbObj->Status == 'Yes') {
            $dbObj->Status = 'No';
        } else {
            $dbObj->Status = 'Yes';
        }

        $dbObj->save();
        echo json_encode(array('success' => 'done'));
        exit;
    }

    public function add_status(Request $request)
    {

        if ($request->status != '') {
            $statusObj = new EmailTemplate;
            $statusObj->Title = $request->status;


            $statusObj->Subject = $request->status;
            $statusObj->keyy = $request->status;
            $statusObj->variables = '{CLIENT_NAME},{CLIENT_EMAIL},{CLIENT_PHONE}';
            $statusObj->Body = '"{STATUS}" status has been updated by {User}.';
            $statusObj->SenderName = 'Admin';
            $statusObj->Sender = 'admin' . config('Constants.SITE_EMAIL');
            $statusObj->icon = 'fas fa-sort';
            $statusObj->icon_class = 'text-warning';
            $statusObj->user_body = '';
            $statusObj->user_status = 'No';
            $statusObj->user_email_active = 'No';
            $statusObj->user_subject = '';
            $statusObj->email_type = 'status';
            $statusObj->save();

            $statusObj->keyy = 'status_' . $statusObj->ID;
            $statusObj->save();

            return redirect()->to('adminmedia/email_templates/' . $statusObj->ID . '/edit');
            exit;
        }
    }
    public function update_feature(Request $request)
    {
        // $validationArr=Mod_convert_validation_arr($this->arrFEdit);
        $validatord = Validator::make(
            $request->all(),
            [
                'sts' => 'required|in:Yes,No',
                'idd' => 'required|integer'
            ]

        );
        if ($validatord->fails()) {
            echo json_encode($validatord->errors());
            exit;
        }

        $featuref = $this->settingArr['dbFeature'];
        $dbObj = EmailTemplate::find($request->idd);
        $dbObj->$featuref = $request->sts;
        $dbObj->save();
        echo json_encode(array('success' => 'done'));
        exit;
    }


    public function edit_ajax(Request $request, $id)
    {

        $title = $this->settingArr['mainTitle'] . ' Detail | ' . FindInsettingArr('business_name');

        $msg = '';
        $row = EmailTemplate::find($id);
        $arrFields = $this->arrFEdit;
        $settingArr = $this->settingArr;
        return view('email_templates.detail', compact('title', 'msg', 'row', 'settingArr', 'arrFields'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        EmailTemplate::destroy($request->idds);
        return json_encode(array("status" => true));
    }

    public function update_email_r()
    {
        if (Auth::user()->type == 'super-admin') {
            User::where('id', '<>', '0')->update(['on_notification_email' => 'No']);
            if (isset($_POST['recp']) && is_array($_POST['recp']))
                foreach ($_POST['recp'] as $key => $value) {

                    User::where('id', $value)->update(['on_notification_email' => 'Yes']);
                }
        }

        echo json_encode(['success' => 'done']);
        exit;
    }

    public function pop()
    {
        $type = '';
        if (isset($_GET['typ']) && $_GET['typ'] != '') {
            $type = $_GET['typ'];
            $allowedpops = array('email_r');
            if ($this->settingArr['add_func'] == true) {
                $allowedpops[] = 'add';
            }



            if (in_array($type, $allowedpops)) {
                $dataArr = $this->arrFAdd;
                $settingArr = $this->settingArr;

                if ($type == 'email_r') {
                    $adminusers = User::where('type', '<>', 'user')->get();
                }
                return view('back.email_templates.' . $type, compact('dataArr', 'settingArr', 'adminusers'));
            } else {
                echo 'ERROR NOT ALLOWED';
                exit;
            }
        } else {
            echo 'ERROR';
            exit;
        }
    }
}
