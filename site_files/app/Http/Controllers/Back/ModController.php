<?php

namespace App\Http\Controllers\Back;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Back\Mod;
use App\Models\Back\ModTemplate; //Laravel
use App\Models\Back\ModActions; //status,price,qty *ab_gen_fields_actions_dd
use App\Models\Back\ModMainActions; //add,edit,delete,order etc *ab_gen_action_list
use App\Models\Back\ModTemplateActions; //*ab_gen_actions
use App\Models\Back\ModTableFields; //ab_gen_table_fields
class ModController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $settingArr = array(
        'mainTitle' => 'Module',
        'mainPageTitle' => 'Modules',
        'contr_name' => 'mod',
        'view_add' => 'add_ajax',
        'view_edit' => 'edit_ajax',
        'view_main' => 'index_view',
        'dbName' => 'ab_gen_table_info',
        'dbId' => 't_id',
        'baseImg' => '',
        'db_order_title' => '',
        'db_order_key' => '',
        'add_func' => true,
        'edit_func' => true,
        'delete_func' => true,
        'order_func' => true,
        'listing_func' => true,
        'search_func' => true,
        'detail_func' => true,
    );
    public $arrFAdd = array( //index view page
        'table_name' => array('Table Name', '', ''),
        'mod_name' => array('Module Name', '', ''),
        'mod_url' => array('Module URL', '', ''),
        'page_size' => array('Page size', '', ''),
        'img_url' => array('Image Path', 'base_url', ''),
        'templ_type' => array('Templ Type', '', ''),
        'action_allowed' => array('Action allowed', '', ''),
    );
    public $arrFEdit = array( //index view page
        'table_name' => array('Table Name', '', ''),
        'mod_name' => array('Module Name', '', ''),
        'mod_url' => array('Module URL', '', ''),
        'page_size' => array('Page size', '', ''),
        'img_url' => array('Image Path', 'base_url', ''),
        'templ_type' => array('Templ Type', '', ''),
        'action_allowed' => array('Action allowed', '', ''),
    );
    public $arrFList = array( //index view page
        't_id' => array('id', 'dbId', ''),
        'table_name' => array('Table Name', '', ''),
        'mod_name' => array('Module Name', '', ''),
        'mod_url' => array('Module URL', '', ''),
        // 'page_size'=>array('Page size','',''),
        // 'img_url'=>array('Image Path','base_url',''),
        'templ_type' => array('Templ Type', '', ''),
        'action_allowed' => array('Action allowed', '', ''),
        //
    );
    public $arrSearch = array( //index view page
        't_id' => array('id', 'dbId', ''),
        'table_name' => array('Table Name', '', ''),
        'mod_name' => array('Module Name', '', ''),
        'mod_url' => array('Module URL', '', ''),
        'page_size' => array('Page size', '', ''),
        'img_url' => array('Image Path', 'base_url', ''),
        'templ_type' => array('Templ Type', '', ''),
        'action_allowed' => array('Action allowed', '', ''),
    );
    public $arrFView = array( //index view page
        't_id' => array('id', 'dbId', ''),
        'table_name' => array('Table Name', '', ''),
        'mod_name' => array('Module Name', '', ''),
        'mod_url' => array('Module URL', '', ''),
        'page_size' => array('Page size', '', ''),
        'img_url' => array('Image Path', 'base_url', ''),
        'templ_type' => array('Templ Type', '', ''),
        'action_allowed' => array('Action allowed', '', ''),
    );
    public $arrOrder = array('name' => array('Name', '', ''));
    public function index()
    {
        $title = FindInsettingArr('business_name') . ': ' . $this->settingArr['mainPageTitle'];
        $msg = '';
        $queryObj = Mod::where($this->settingArr['dbId'], '<>', '0');
        $searchDataArr = [];
        if (isset($_GET['sr']) && $_GET['sr'] == 'y') {
            $searchDataArr = filter_search_param($_GET, $this->arrSearch);
            if (sizeof($searchDataArr) > 0) {
                foreach ($searchDataArr as $key => $value) {
                    if ($this->settingArr['dbId'] == $key) {
                        $queryObj->where($key, $value);
                    } else {
                        $queryObj->where($key, 'like', '%' . $value . '%');
                    }
                }
            }
        }
        $queryObj->orderBy($this->settingArr['dbId'], 'DESC');
        $result = $queryObj->paginate(20);
        $settingArr = $this->settingArr;
        $arrSearch = $this->arrSearch;
        $dataArr = $this->arrFList;
        $idf = $this->settingArr['dbId'];
        return view('back.mod.index', compact('title', 'msg', 'result', 'settingArr', 'arrSearch', 'dataArr', 'idf', 'searchDataArr'));
    }
    public function set_order()
    {
        $title = FindInsettingArr('business_name') . ': ' . $this->settingArr['mainPageTitle'];
        $msg = '';
        $result = Mod::orderBy($this->settingArr['db_order_key'], 'asc')->get();
        $settingArr = $this->settingArr;
        $arrSearch = $this->arrSearch;
        $dataArr = $this->arrOrder;
        $idf = $this->settingArr['dbId'];
        return view('back.mod.order', compact('title', 'msg', 'result', 'settingArr', 'arrSearch', 'dataArr', 'idf'));
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
                $dbObj = Mod::find($recordIDValue);
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
        if (Auth::user()->type != 'super-admin')
            return redirect(route('admin.index'));
        $title = FindInsettingArr('business_name') . ': Admin Users Management | Add new';
        $settingArr = $this->settingArr;
        return view('back.mod.create', compact('title', 'settingArr'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationArr = Mod_convert_validation_arr($this->arrFAdd);
        $validatord = Validator::make(
            $request->all(),
            $validationArr[0],
            $validationArr[1]
        );
        if ($validatord->fails()) {
            echo json_encode($validatord->errors());
            exit;
        }
        $dbObj = new Mod;
        foreach ($this->arrFAdd as $key => $value) {
            $dbObj->$key = Mod_convert_db_value($request, $key, $value);
        }
        $dbObj->save();
        echo json_encode(array('success' => 'done'));
        exit;
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
        $row = Mod::find($id);
        $arrFields = $this->arrFView;
        $settingArr = $this->settingArr;
        return view('back.mod.detail', compact('title', 'msg', 'row', 'settingArr', 'arrFields'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = FindInsettingArr('business_name') . ': Admin Users Management | Add new';
        $row = Mod::find($id);
        $settingArr = $this->settingArr;
        $dataArr = $this->arrFEdit;
        $idf = $this->settingArr['dbId'];
        return view('back.mod.edit', compact('user', 'title', 'settingArr', 'dataArr', 'row', 'idf'));
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
        $validationArr = Mod_convert_validation_arr($this->arrFEdit);
        $validatord = Validator::make(
            $request->all(),
            $validationArr[0],
            $validationArr[1]
        );
        if ($validatord->fails()) {
            echo json_encode($validatord->errors());
            exit;
        }
        $dbObj = Mod::find($id);
        foreach ($this->arrFEdit as $key => $value) {
            $dbObj->$key = Mod_convert_db_value($request, $key, $value);
        }
        $dbObj->save();
        echo json_encode(array('success' => 'done'));
        exit;
    }
    public function update_status(Request $request)
    {
        $validationArr = Mod_convert_validation_arr($this->arrFEdit);
        $validatord = Validator::make(
            $request->all(),
            [
                'sts' => 'required|in:Yes,No',
                'idd' => 'required|integer',
                'fld' => 'required'
            ]
        );
        if ($validatord->fails()) {
            echo json_encode($validatord->errors());
            exit;
        }
        $stsF = $request->fld;
        $dbObj = Mod::find($request->idd);
        $dbObj->$stsF = $request->sts;
        $dbObj->save();
        echo json_encode(array('success' => 'done'));
        exit;
    }
    public function update_feature(Request $request)
    {
        $validationArr = Mod_convert_validation_arr($this->arrFEdit);
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
        $dbObj = Mod::find($request->idd);
        $dbObj->$featuref = $request->sts;
        $dbObj->save();
        echo json_encode(array('success' => 'done'));
        exit;
    }
    public function edit_ajax(Request $request, $id)
    {
        $title = $this->settingArr['mainTitle'] . ' Detail | ' . FindInsettingArr('business_name');
        $msg = '';
        $row = Mod::find($id);
        $arrFields = $this->arrFEdit;
        $settingArr = $this->settingArr;
        return view('back.mod.detail', compact('title', 'msg', 'row', 'settingArr', 'arrFields'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->settingArr['delete_func'] == false) {
            echo 'ERROR';
            exit;
        }
        Mod::destroy($id);
        return json_encode(array("status" => true));
    }
    public function pop()
    {
        $type = '';
        if (isset($_GET['typ']) && $_GET['typ'] != '') {
            $type = $_GET['typ'];
            $allowedpops = array();
            if ($this->settingArr['add_func'] == true) {
                $allowedpops[] = 'add';
            }
            if (in_array($type, $allowedpops)) {
                $dataArr = $this->arrFAdd;
                $settingArr = $this->settingArr;
                //if($type=='det'){--}
                return view('back.mod.' . $type, compact('dataArr', 'settingArr'));
            }
        } else {
            echo 'ERROR';
            exit;
        }
    }
    function add_step1()
    {
        $title = 'Step1';
        $heading = 'Step1';
        $settingArr = $this->settingArr;
        $Mod = Mod::get();
        $ModTemplate = ModTemplate::get(); //Laravel
        $ModActions = ModActions::get(); //status,price,qty
        $ModMainActions = ModMainActions::get(); //add,edit,delete,order etc
        $ModTemplateActions = ModTemplateActions::get();
        return view('back.mod.create.step1', compact('title', 'heading', 'settingArr', 'Mod', 'ModTemplate', 'ModActions', 'ModMainActions', 'ModTemplateActions'));
    }
    function add_step2($mod)
    {
        $step = 2;
        $title = 'Table Field Types';
        $heading = 'Table Field Types';
        $settingArr = $this->settingArr;
        $dataArr = $this->addArr($step);
        $tblArr = Mod::find($mod)->toArray();
        $qObj = \DB::select('DESCRIBE ' . $tblArr['table_name']);
        $q = (array)$qObj;
        $oldData = ModTableFields::where('t_id', $tblArr['t_id'])->get()->toArray();
        $ModTemplate = ModTemplate::get(); //Laravel
        $ModActions = ModActions::get(); //status,price,qty
        $ModMainActions = ModMainActions::get(); //add,edit,delete,order etc
        $ModTemplateActions = ModTemplateActions::get();
        return view('back.mod.create.step2', compact('title', 'heading', 'settingArr', 'Mod', 'ModTemplate', 'ModActions', 'ModMainActions', 'ModTemplateActions', 'dataArr', 'tblArr', 'oldData', 'q', 'step', 'mod'));
    }
    function add_step3($mod)
    {
        $step = 3;
        $title = 'Module Functons';
        $heading = 'Module Functons';
        $settingArr = $this->settingArr;
        $dataArr = $this->addArr($step);
        $tblArr = Mod::find($mod)->toArray();
        $qObj = \DB::select('DESCRIBE ' . $tblArr['table_name']);
        $q = (array)$qObj;
        $fArr = ModTableFields::where('t_id', $tblArr['t_id'])->get()->toArray();
        $RSA = ModMainActions::where('status', 'Yes')->get()->toArray();
        $actionDataArr = ModTemplateActions::where('t_id', $mod)->get()->toArray();
        $ModTemplate = ModTemplate::get(); //Laravel
        $ModActions = ModActions::get(); //status,price,qty
        $ModMainActions = ModMainActions::get(); //add,edit,delete,order etc
        $ModTemplateActions = ModTemplateActions::get();
        return view('back.mod.create.step3', compact('title', 'heading', 'settingArr', 'Mod', 'ModTemplate', 'ModActions', 'ModMainActions', 'ModTemplateActions', 'dataArr', 'tblArr', 'fArr', 'q', 'step', 'mod', 'RSA', 'actionDataArr'));
    }
    function add_step4($mod)
    {
        $step = 3;
        $title = 'Module Functons';
        $heading = 'Module Functons';
        $settingArr = $this->settingArr;
        $dataArr = $this->addArr($step);
        $tblArr = Mod::find($mod)->toArray();
        $qObj = \DB::select('DESCRIBE ' . $tblArr['table_name']);
        $q = (array)$qObj;
        $fArr = ModTableFields::where('t_id', $tblArr['t_id'])->get()->toArray();
        $RSA = ModMainActions::where('status', 'Yes')->get()->toArray();
        $actionDataArr = ModTemplateActions::where('t_id', $mod)->get()->toArray();
        $ModTemplate = ModTemplate::get(); //Laravel
        $ModActions = ModActions::get(); //status,price,qty
        $ModMainActions = ModMainActions::get(); //add,edit,delete,order etc
        $ModTemplateActions = ModTemplateActions::get();
        return view('back.mod.create.step4', compact('title', 'heading', 'settingArr', 'Mod', 'ModTemplate', 'ModActions', 'ModMainActions', 'ModTemplateActions', 'dataArr', 'tblArr', 'fArr', 'q', 'step', 'mod', 'RSA', 'actionDataArr'));
    }
    function post_step2($mod)
    {
        $dataArrInsert = array();
        foreach ($_POST['fname_arr'] as $key => $val) {
            $dataArrInsert[] = array(
                't_id' => $mod,
                'title' => $_POST['title_arr'][$key],
                'db_name' => $val,
                'type' => $_POST['type_arr'][$key]
            );
        }
        ModTableFields::where('t_id', $mod)->delete();
        ModTableFields::insert($dataArrInsert);
        return redirect()->to('myadmin/mod/step/3/' . $mod);
        exit;
    }
    function post_step($step, $mod = 0)
    {
        $id = '';
        if ($step == 4) {
            $this->finalStep($mod);
            return redirect()->to('myadmin/' . $this->settingArr['contr_name']);
            exit;
        }
        if ($step == 3) {
            if (!isset($_POST['ok'])) {
                echo error_show('No Function selected(checked). Click on Back Button and Try agin.');
                exit;
            }
            $functionChecked = $_POST['ok'];
            $dataArrInsert = array();
            foreach ($functionChecked as $funcid) {
                if ($funcid != 3 && $funcid != 4) {
                    foreach ($_POST['a' . $funcid . '_fname_arr'] as $key => $val) {
                        if ($_POST['a' . $funcid . '_active'][$key] == 'Yes') {
                            $dataArrInsert[] = array(
                                't_id' => $mod,
                                'field_title' => $_POST['a' . $funcid . '_title_arr'][$key],
                                'db_name' => $val,
                                'action_id' => $funcid,
                                'field_type' => $_POST['a' . $funcid . '_type_arr'][$key]
                            );
                        }
                    }
                }
            }
            ModTemplateActions::where(['t_id' => $mod])->delete();
            ModTemplateActions::insert($dataArrInsert);
            // $this->db->insert_batch('ab_gen_actions',$dataArrInsert);
            Mod::where('t_id', $mod)->update(['action_allowed' => implode(',', $functionChecked)]);
            // update1('action_allowed',,$this->settingArr['dbName'],"=".$loc_id);
            return redirect()->to('myadmin/mod/step/4' . '/' . $mod);
            exit;
        }
        $timingData = '';
        if ($step == 3) {
            $timingData = json_encode($_POST['timing']);
        }
        $data = array();
        $autoArr = array();
        $dataArr = $this->addArr($step);
        $data['settingArr'] = $this->settingArr;
        unset($dataArr['auto']);
        $data['dataArr'] = $dataArr;
        $data['step'] = $step;
        if (isset($dataArr['auto'])) {
            $autoArr = $dataArr['auto'];
            unset($dataArr['auto']);
        }
        /*foreach($dataArr as $key=>$val){
                $this->form_validation->set_rules($key, $val[1], 'trim');
        }
        if ($this->form_validation->run() === FALSE) {
                $this->load->view('add_loc',$data);return;
        }*/
        $dataArrInsert = array();
        foreach ($dataArr as $key => $val) {
            if ($val[1] == 'cb') {
                if (isset($_POST[$key])) {
                    $dataArrInsert[$key] = 'Yes';
                } else {
                    $dataArrInsert[$key] = 'No';
                }
            } else {
                $dataArrInsert[$key] = $_POST[$key];
            }
        }
        if (!empty($autoArr)) {
            foreach ($autoArr as $key => $val) {
                $dataArrInsert[$key] = auto_f_value($val[1]);
            }
        }
        //$this->db->where($this->settingArr['dbId'],$idd);
        if ($step == 1) {
            // cp($dataArrInsert);
            $insertQ = Mod::insert($dataArrInsert);
            $ModTableFields = Mod::orderBy('t_id', 'DESC')->first();
            $id = $ModTableFields->t_id;
        } else {
            // $ModTableFields= Mod::where($this->settingArr['dbId'],$loc_id)
            // ->update([$this->settingArr['dbId']=>$loc_id]);
        }
        return redirect()->to('myadmin/mod/step/2/' . $id);
        exit;
    }
    public function addArr($step)
    {
        $step1Arr =
            array(
                'table_name' => array('Table name', '', 'is_unique[ab_gen_table_info.table_name]'),
                'mod_name' => array('Mod name', '', 'is_unique[ab_gen_table_info.mod_name]'),
                'mod_url' => array('Mod url', '', 'is_unique[ab_gen_table_info.mod_url]'),
                'page_size' => array('Page size', '', 'trim'),
                'img_url' => array('Img url', '', 'trim'),
                'templ_type' => array('Templ type', '', 'trim'),
            );
        $step2Arr = array(
            'facebook_link' => array('Facebook link', '', 'trim'),
            'twitter_link' => array('Twitter link', '', 'trim'),
            'google_plus_link' => array('Google plus link', '', 'trim'),
            'linkedin_link' => array('Linkedin link', '', 'trim'),
            'pinterest_link' => array('Pinterest link', '', 'trim'),
            'youtube_link' => array('Youtube link', '', 'trim'),
            'stumbleupon_link' => array('Stumbleupon link', '', 'trim'),
            'rss_link' => array('RSS link', '', 'trim'),
            'instagram_link' => array('Instagram link', '', 'trim'),
            'yelp_link' => array('Yelp link', '', 'trim')
        ); //Social Media
        $step3Arr = array('timing' => array('Timing', '', 'trim'));
        $step4Arr = array(
            'meta_title' => array('Page Title', '', ''),
            'meta_description' => array('Page Description', 'textarea', ''),
            'meta_keywords' => array('Keywords', 'textarea', '')
        ); //Seo
        $step5Arr = array(); //Seo
        $step6Arr = array(); //Seo
        $step7Arr = array(); //Seo
        $step111Arr = array(
            '_sec3_' => array('Main Location Page SEO', '', ''),
            'meta_title' => array('Page Title', '', ''),
            'meta_description' => array('Page Description', 'textarea', 'trim'),
            'meta_keywords' => array('Keywords', 'textarea', 'trim'),
            '_sec_' => array('Service Page SEO', '', ''),
            'service_meta_title' => array('Page Title', '', ''),
            'service_meta_description' => array('Page Description', 'textarea', 'trim'),
            'service_meta_keywords' => array('Keywords', 'textarea', 'trim'),
            '_sec2_' => array('Article page SEO', '', ''),
            'article_meta_title' => array('Page Title', '', ''),
            'article_meta_description' => array('Page Description', 'textarea', 'trim'),
            'article_meta_keywords' => array('Keywords', 'textarea', 'trim'),
            '_sec5_' => array('Contact page SEO', '', ''),
            'contact_meta_title' => array('Page Title', '', 'trim'),
            'contact_meta_description' => array('Page Description', 'textarea', 'trim'),
            'contact_meta_keywords' => array('Keywords', 'textarea', 'trim'),
            '_sec6_' => array('Contact Us Email Recipients', '', ''),
            'contact_to' => array('To', '', 'trim|required|valid_emails'),
            'contact_cc' => array('CC', '', 'trim|valid_emails'),
            'contact_bcc' => array('BCC', '', 'trim|valid_emails'),
            '_sec4_' => array('General Settings', '', ''),
            'loc_name' => array('Location Name', '', ''),
            'phone' => array('Location Phone', '', ''),
            'fax' => array('Location Fax', '', 'trim'),
            'allow_loc_page_map' => array('Show Location Map on Main Page', 'cb', 'trim'),
            'allow_loc_geographic_map' => array('Show "Geographic Areas We Serve" Map', 'cb', 'trim'),
            'allow_loc_zipcode_area' => array('Show "Zip Codes We Serve" Section', 'cb', 'trim')
        ); //Seo
        $step112Arr = array(
            '_sec3_' => array(
                'meta_title' => array('Page Title', '', ''),
                'meta_description' => array('Page Description', 'textarea', 'trim'),
                'meta_keywords' => array('Keywords', 'textarea', 'trim')
            ),
            '_sec_' => array(
                'service_meta_title' => array('Page Title', '', ''),
                'service_meta_description' => array('Page Description', 'textarea', 'trim'),
                'service_meta_keywords' => array('Keywords', 'textarea', 'trim')
            ),
            '_sec2_' => array(
                'article_meta_title' => array('Page Title', '', ''),
                'article_meta_description' => array('Page Description', 'textarea', 'trim'),
                'article_meta_keywords' => array('Keywords', 'textarea', 'trim')
            ),
            '_sec5_' => array(
                'contact_meta_title' => array('Page Title', '', 'trim'),
                'contact_meta_description' => array('Page Description', 'textarea', 'trim'),
                'contact_meta_keywords' => array('Keywords', 'textarea', 'trim')
            ),
            '_sec6_' => array(
                'contact_to' => array('To', '', 'trim|required|valid_emails'),
                'contact_cc' => array('CC', '', 'trim|valid_emails'),
                'contact_bcc' => array('BCC', '', 'trim|valid_emails')
            ),
            '_sec4_' => array(
                //'loc_name'=>array('Location Name','',''),
                'phone' => array('Location Phone', '', ''),
                'fax' => array('Location Fax', '', 'trim'),
                'allow_loc_page_map' => array('Show Location Map on Main Page', 'cb', 'trim'),
                'allow_loc_geographic_map' => array('Show "Geographic Areas We Serve" Map', 'cb', 'trim'),
                'allow_loc_zipcode_area' => array('Show "Zip Codes We Serve" Section', 'cb', 'trim')
            )
        ); //Seo
        $retArr = 'step' . $step . 'Arr';
        return $$retArr;
    }
    public function finalStep($mod)
    {
        //Code Generate
        $mod = (int)$mod;
        $mainSettingArr = Mod::find($mod)->toArray();
        //cp($mainSettingArr);
        $module_active = explode(',', $mainSettingArr['action_allowed']);
        $funcArr = ModMainActions::get()->toArray();
        $strFunc = '';
        foreach ($funcArr as $key => $func) {
            if (in_array($func['id'], $module_active)) {
                $strFunc .= '\'' . $func['func_key'] . '\'=>true,' . chr(13);
            } else {
                $strFunc .= '\'' . $func['func_key'] . '\'=>false,' . chr(13);
            }
        }
        $templArr = ModTemplate::first()->toArray($mainSettingArr['templ_type']);
        if (!is_array($templArr) || empty($templArr)) {
            cp('ERROR: Template Not defined');
        }
        // $table_key=GetDbValue('db_name','ab_gen_table_fields',"t_id='$loc_id' AND type='dbId'");
        $table_key = ModTableFields::where('t_id', $mod)->where('type', 'dbId')->value('db_name');
        $table_status = ModTableFields::where('t_id', $mod)->where('type', 'dbId')->value('db_name');
        $table_order_title = ModTableFields::where('t_id', $mod)->where('type', 'title')->value('db_name');
        $table_order_key = ModTableFields::where('t_id', $mod)->where('type', 'orderr')->value('db_name');
        $actionArr = ModTemplateActions::where('t_id', $mod)->first()->toArray();
        $Modname = ucwords(strtolower($mainSettingArr['mod_url']));
        //cp(__DIR__);
        //cp($Modname.'Generate Code Starts here....');
        //
        $baseModPath = __DIR__ . '/' . ucwords($mainSettingArr['mod_url']) . 'Controller.php';
        $baseModModePath = app_path() . '/models/Back/' . ucwords($mainSettingArr['mod_url']) . '.php';
        $baseWebPath = app_path() . '/../routes/web.php';
        $contrF = file_get_contents(app_path() . '/../resources/views/back/mod/code_generate/' . $templArr['folder_name'] . '/controller/TestController.php', "r");
        $modelF = file_get_contents(app_path() . '/../resources/views/back/mod/code_generate/' . $templArr['folder_name'] . '/models/Test.php', "r");
        $webF = file_get_contents(app_path() . '/../resources/views/back/mod/code_generate/' . $templArr['folder_name'] . '/routes/web.php', "r");
        $contrF = $this->text_replace(
            $contrF,
            $mainSettingArr,
            $table_key,
            $Modname,
            $table_status,
            $table_order_title,
            $table_order_key,
            $strFunc
        );
        $modelF = $this->text_replace(
            $modelF,
            $mainSettingArr,
            $table_key,
            $Modname,
            $table_status,
            $table_order_title,
            $table_order_key,
            $strFunc
        );
        $webF = $this->text_replace(
            $webF,
            $mainSettingArr,
            $table_key,
            $Modname,
            $table_status,
            $table_order_title,
            $table_order_key,
            $strFunc
        );
        $webRoutes = file_get_contents(app_path() . '/../routes/web.php', "r");
        $writeWebCode = true;
        if (strpos($webRoutes, '//start ' . $Modname) !== false) {
            $writeWebCode = false;
        }
        $webF = str_replace('/*DCODE HERE*/', $webF, $webRoutes);
        $file = fopen($baseModModePath, "w+");
        fwrite($file, $modelF);
        fclose($file);
        if ($writeWebCode) {
            $file = fopen($baseWebPath, "w+");
            fwrite($file, $webF);
            fclose($file);
        }
        //{FUNCATION_ARRAY}
        $autoArr = array();
        ob_start();
        //$RS=GetDbRowAll('ab_gen_action_list','1');
        $RS = ModMainActions::get()->toArray();
        foreach ($RS as $key => $aval) {
            if ($aval['have_multiple_val'] == 'Yes') {
?>public $<?php echo $aval['arrName'] ?>=array(//index view page
<?php
                // $RSF=GetDbRowAll('ab_gen_actions',"t_id='$loc_id' AND action_id='".$aval['id']."'");
                $loc_id = $mod;
                $RSF = ModTemplateActions::where('t_id', $loc_id)->where('action_id', $aval['id'])->get()->toArray();
                foreach ($RSF as $hhhh => $sfval) {
                    if (($sfval['action_id'] == '1' || $sfval['action_id'] == '2') && ($sfval['field_type'] == 'cdate' || $sfval['field_type'] == 'cip')) {
                        $autoArr[] = $sfval;
                    } else {
?>'<?php echo $sfval['db_name']; ?>'=>array('<?php echo $sfval['field_title']; ?>','<?php echo $sfval['field_type']; ?>',''),
<?php }
                } ?>
<?php if ($aval['id'] == 1 || $aval['id'] == 2) { ?>
    <?php
                    foreach ($autoArr as $tttt => $sfval) { ?>
        '<?php echo $sfval['db_name']; ?>'=>array('<?php echo $sfval['field_title']; ?>','<?php echo substr($sfval['field_type'], 1, 55555); ?>',''),
    <?php } ?>
<?php } ?>
);
<?php
            } //if
        } //foreach
        $fwData = ob_get_contents();
        ob_clean();
        $contrF = str_replace('{FIELD_ARRAY}', $fwData, $contrF);
        $file = fopen($baseModPath, "w+");
        fwrite($file, $contrF);
        fclose($file);
        /////////////////////Create Model//////////////////////////////////////
        //mkdir($baseModPath.'/models');
        //copy(APPPATH.'back-modules/ab_gen/templ/test/models/Users_model.php',$baseModPath.'/models'.'/Users_model.php');
        /////////////////////Create Views//////////////////////////////////////
        //mkdir($baseModPath.'/resources/views/back/'.$mainSettingArr['mod_url']);
        $this->copyr(
            app_path() . '/../resources/views/back/mod/code_generate/' . $templArr['folder_name'] . '/views/',
            app_path() . '/../resources/views/back/' . $mainSettingArr['mod_url']
        );
        return true;
    }
    public function copyr($source, $dest)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }
        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }
        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest);
        }
        // Loop through the folder
        $dir = dir($source);
        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            // Deep copy directories
            $this->copyr("$source/$entry", "$dest/$entry");
        }
        // Clean up
        $dir->close();
        return true;
    }
    public function delTree($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }
    public function text_replace(
        $fileText,
        $mainSettingArr,
        $table_key,
        $Modname,
        $table_status,
        $table_order_title,
        $table_order_key,
        $strFunc
    ) {
        foreach ($mainSettingArr as $key => $val) {
            $fileText = str_replace('{' . $key . '}', $val, $fileText);
        }
        //HERE
        $fileText = str_replace('{table_key}', $table_key, $fileText);
        $fileText = str_replace('{mod_url_c}', $Modname, $fileText);
        $fileText = str_replace('{mod_url}', strtolower($Modname), $fileText);
        //$fileText=str_replace('{mod_class}',ucwords(strtolower($Modname),$fileText));
        $fileText = str_replace('{table_status}', $table_status, $fileText);
        $fileText = str_replace('{table_title}', $table_order_title, $fileText);
        $fileText = str_replace('{table_order}', $table_order_key, $fileText);
        $fileText = str_replace('{FUNCATION_ARRAY}', $strFunc, $fileText);
        return $fileText;
    }
}
