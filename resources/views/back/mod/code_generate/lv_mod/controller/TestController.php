<?php
namespace App\Http\Controllers\Back;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Back\{mod_url_c};
class {mod_url_c}Controller extends Controller
{
    public $settingArr=array(
    'mainTitle'=>'{mod_name}',
    'mainPageTitle'=>'{mod_name}',
    'contr_name'=>'{mod_url}',
    'view_add'=>'add_ajax',
    'view_edit'=>'edit_ajax',
    'view_main'=>'index_view',
    'dbName'=>'{table_name}',
    'dbId'=>'{table_key}',
    'baseImg'=>'{img_url}',
    'dbStatus'=>'{table_status}',
    'db_order_title'=>'{table_title}',
    'db_order_key'=>'{table_order}',
    {FUNCATION_ARRAY}
    );
    
    {FIELD_ARRAY}
     public $arrOrder=array(
            'title'=>array('Title','title','')
        );		
   
    public function index()
    {
        $title = config('Constants.SITE_NAME').': '.$this->settingArr['mainPageTitle'];
        $msg = '';
        $searchDataArrAll = $_GET;
        $queryObj ={mod_url_c}::where($this->settingArr['dbId'],'<>','0');
        $searchDataArr=[];
        if(isset($_GET['sr']) && $_GET['sr']=='y'){
            $searchDataArr=filter_search_param($_GET,$this->arrSearch);
            if(sizeof($searchDataArr)>0){
                foreach ($searchDataArr as $key => $value) {
                    if($this->settingArr['dbId']==$key){
                        $queryObj->where($key,$value);
                    }
                    else
                    {
                    $queryObj->where($key,'like','%'.$value.'%');
                    }
                }
            }
        }
        
        $queryObj->orderBy($this->settingArr['dbId'],'DESC');
        $result=$queryObj->paginate(20);
        $result->appends($searchDataArrAll);
       
        $settingArr=$this->settingArr;
        $arrSearch=$this->arrSearch;
        $dataArr=$this->arrFList;
        $idf=$this->settingArr['dbId'];
        return view('back.{mod_url}.index',compact('title','msg','result','settingArr','arrSearch','dataArr','idf','searchDataArr'));
    }
    public function set_order()
    {
        $title = config('Constants.SITE_NAME').': '.$this->settingArr['mainPageTitle'];
        $msg = '';
        $result ={mod_url_c}::orderBy($this->settingArr['db_order_key'],'asc')->get();
        $settingArr=$this->settingArr;
        $arrSearch=$this->arrSearch;
        $dataArr=$this->arrOrder;
        $idf=$this->settingArr['dbId'];
        return view('back.{mod_url}.order',compact('title','msg','result','settingArr','arrSearch','dataArr','idf'));
    }
    public function update_order(Request $request)
    {
        if($this->settingArr['order_func']==false){echo 'ERROR';exit;}
        //echo '<pre>';print_r($_POST);echo '</pre>';exit;
        $action = $request->action;
        $updateRecordsArray = $request->recordsArray;
        if ($action == "updateRecordsListings") {
            $listingCounter = 1;
            foreach ($updateRecordsArray as $recordIDValue) {
                $oderf=$this->settingArr['db_order_key'];
                $dbObj= {mod_url_c}::find($recordIDValue);
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
	    if(Auth::user()->type != 'super-admin')
		    return redirect(route('admin.index'));
	    $title = config('Constants.SITE_NAME').': Admin Users Management | Add new';
        $settingArr=$this->settingArr;
        return view('back.{mod_url}.create',compact('title','settingArr'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validationArr=Mod_convert_validation_arr($this->arrFAdd);
        $validatord = Validator::make($request->all(),
            $validationArr[0],$validationArr[1]
            
        );
          if ($validatord->fails()) {
            echo json_encode($validatord->errors());exit;
          }
        $dbObj = new {mod_url_c};
        foreach ($this->arrFAdd as $key => $value) {
            $dbObj->$key = Mod_convert_db_value($request,$key,$value);
        }
        
        $dbObj->save();
        echo json_encode(array('success'=>'done'));exit;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
	    $title = $this->settingArr['mainTitle'].' Detail | '.config('Constants.SITE_NAME');
	    $msg = '';
        $row={mod_url_c}::find($id);
        $arrFields=$this->arrFView;
        $settingArr=$this->settingArr;
	    return view('back.{mod_url}.detail',compact('title','msg','row','settingArr','arrFields'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = config('Constants.SITE_NAME').': Admin Users Management | Add new';
        $row = {mod_url_c}::find($id);
        $settingArr=$this->settingArr;
        $dataArr=$this->arrFEdit;
        $idf=$this->settingArr['dbId'];
        return view('back.{mod_url}.edit',compact('user','title','settingArr','dataArr','row','idf'));
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
        $validationArr=Mod_convert_validation_arr($this->arrFEdit);
        $validatord = Validator::make($request->all(),
            $validationArr[0],$validationArr[1]
            
        );
          if ($validatord->fails()) {
            echo json_encode($validatord->errors());exit;
          }
        $dbObj = {mod_url_c}::find($id);
        foreach ($this->arrFEdit as $key => $value) {
            $dbObj->$key = Mod_convert_db_value($request,$key,$value);
        }
	    
	    $dbObj->save();
	    echo json_encode(array('success'=>'done'));exit;
    }
public function update_status(Request $request)
{
    $validationArr=Mod_convert_validation_arr($this->arrFEdit);
    $validatord = Validator::make($request->all(),
        [
            'sts'=>'required|in:Yes,No',
            'idd'=>'required|integer',
            'fld'=>'required'
        ]
        
    );
      if ($validatord->fails()) {
        echo json_encode($validatord->errors());exit;
      }
    $stsF=$request->fld;
    $dbObj = {mod_url_c}::find($request->idd);
    $dbObj->$stsF = $request->sts;        
    $dbObj->save();
    echo json_encode(array('success'=>'done'));exit;
}
public function update_feature(Request $request)
{
    $validationArr=Mod_convert_validation_arr($this->arrFEdit);
    $validatord = Validator::make($request->all(),
        [
            'sts'=>'required|in:Yes,No',
            'idd'=>'required|integer'
        ]
        
    );
      if ($validatord->fails()) {
        echo json_encode($validatord->errors());exit;
      }
    $featuref=$this->settingArr['dbFeature'];
    $dbObj = {mod_url_c}::find($request->idd);
    $dbObj->$featuref = $request->sts;        
    $dbObj->save();
    echo json_encode(array('success'=>'done'));exit;
}
    public function edit_ajax(Request $request,$id)
    {
        $title = $this->settingArr['mainTitle'].' Detail | '.config('Constants.SITE_NAME');
        $msg = '';
        $row={mod_url_c}::find($id);
        $arrFields=$this->arrFEdit;
        $settingArr=$this->settingArr;
        return view('back.{mod_url}.detail',compact('title','msg','row','settingArr','arrFields'));
    }    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->settingArr['delete_func']==false){
            echo 'ERROR';exit;
        }
	    {mod_url_c}::destroy($id);
	    return json_encode(array("status" => true));
    }
    public function pop(){
        $type='';
        if(isset($_GET['typ']) && $_GET['typ']!=''){
            $type=$_GET['typ'];
            $allowedpops=array();
            if($this->settingArr['add_func']==true){
                $allowedpops[]='add';
            }
            if(in_array($type,$allowedpops)){
                $dataArr=$this->arrFAdd;
                $settingArr=$this->settingArr;
                //if($type=='det'){--}
                return view('back.{mod_url}.'.$type,compact('dataArr','settingArr'));
            }
        }
        else{
            echo 'ERROR';exit;
        }
    }
}
