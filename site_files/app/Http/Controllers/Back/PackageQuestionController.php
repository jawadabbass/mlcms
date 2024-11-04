<?php
namespace App\Http\Controllers\Back;
use App\Http\Controllers\Controller;
use App\Models\Back\CmsModuleData;
use App\Models\Back\Product;
use App\Models\Back\PackageQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
class PackageQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sendResult = array('package_id' => '',);
        if (isset($_GET['package_id']) && $_GET['package_id'] == 'All') {
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
            $dataQ = PackageQuestion::with('package');
            $dataQ->orderBy('item_order', 'ASC');
            $products = $dataQ->paginate(20);
            $serachLink = rtrim($serachLink, '&');
            $products->setPath('?' . $serachLink);
        } elseif (isset($_GET['package_id']) && $_GET['package_id'] !== 'All') {
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
            $dataQ = PackageQuestion::with('package')->where($searchArr);
            $dataQ->orderBy('item_order', 'ASC');
            $products = $dataQ->paginate(20);
            $serachLink = rtrim($serachLink, '&');
            $products->setPath('?' . $serachLink);
        } else {
            $products = PackageQuestion::with('package')->orderBy('item_order', 'ASC')->paginate(20);
        }
        $title = FindInsettingArr('business_name') . ': Package Question\'s Management';
        $msg = '';
        $get_all_packages = getModuleData(37);
        return view('back.package_questions.index', compact('products', 'title', 'msg', 'get_all_packages'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $list_order = $request->list_order;
        $list = explode(',', $list_order);
        $i = 1;
        print_r($list);
        foreach ($list as $id) {
            // $product = Product::find($id);
            // $product->item_order = $i;
            // $product->save();
            $data = ['item_order' => $i,];
            $products = \DB::table('package_questions')->where('id', $id)->update($data);
            $i++;
            echo $i . ' ' . $id;
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required'
        ]);
        if ($validator->passes()) {
            if ($request->additional_fields == 0) {
                return back()->with('error', 'Please Select One Design Pattern');
            } elseif ($request->additional_fields == 1) {
                if (count($request->radio_field) < 2) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->radio_field as $key => $radio) {
                    if ($radio == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'package_id' => $request->package_id,
                    'pattern' => 'radio',
                    'value' => json_encode($request->radio_field),
                ];
                $create = \DB::table('package_questions')->insert($data);
                return back()->with('success', 'Record Added Successfully');
            } elseif ($request->additional_fields == 2) {
                if (count($request->check_field) < 1) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->check_field as $key => $check) {
                    if ($check == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'package_id' => $request->package_id,
                    'pattern' => 'check',
                    'value' => json_encode($request->check_field),
                ];
                $create = \DB::table('package_questions')->insert($data);
                return back()->with('success', 'Record Added Successfully');
            } else {
                $data = [
                    'question' => $request->question,
                    'package_id' => $request->package_id,
                    'pattern' => 'input',
                    'value' => 'input',
                ];
                $create = \DB::table('package_questions')->insert($data);
                return back()->with('success', 'Record Added Successfully');
            }
        }
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required'
        ]);
        if ($validator->passes()) {
            if ($request->additional_fields == 0) {
                return back()->with('error', 'Please Select One Design Pattern');
            } elseif ($request->additional_fields == 1) {
                if (count($request->radio_field) < 2) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->radio_field as $key => $radio) {
                    if ($radio == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'package_id' => $request->package_id,
                    'pattern' => 'radio',
                    'value' => json_encode($request->radio_field),
                ];
                $create = \DB::table('package_questions')->where('id', $id)->update($data);
                return redirect()->route('question.index')->with('success', 'Record Updated Successfully');
            } elseif ($request->additional_fields == 2) {
                if (count($request->check_field) < 1) {
                    return back()->with('error', 'Radio Pattern Atleast 2 Values Required');
                }
                foreach ($request->check_field as $key => $check) {
                    if ($check == null) {
                        return back()->with('error', 'Radio Field Value Can Not Empty');
                    }
                }
                $data = [
                    'question' => $request->question,
                    'package_id' => $request->package_id,
                    'pattern' => 'check',
                    'value' => json_encode($request->check_field),
                ];
                $create = \DB::table('package_questions')->where('id', $id)->update($data);
                return redirect()->route('question.index')->with('success', 'Record Updated Successfully');
            } else {
                $data = [
                    'question' => $request->question,
                    'package_id' => $request->package_id,
                    'pattern' => 'input',
                    'value' => 'input',
                ];
                $create = \DB::table('package_questions')->where('id', $id)->update($data);
                return redirect()->route('question.index')->with('success', 'Record Updated Successfully');
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($id == '') {
            echo 'error';
            return;
        }
        $obj = PackageQuestion::find($id);
        $status = $obj->sts;
        if ($status == '') {
            echo 'invalid current status provided.';
            return;
        }
        if ($status == 1)
            $new_status = 0;
        else
            $new_status = 1;

        $obj->sts = $new_status;
        $obj->update();
        echo $new_status;
        return;
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $packages = getModuleData(37);
        $title = FindInsettingArr('business_name') . ':Edit Package Question';
        $msg = '';
        $result = \DB::table('package_questions')->where('id', $id)->first();
        return view('back.package_questions.edit', compact('result', 'title', 'msg', 'packages'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $update = \DB::table('package_questions')->where('id', $id)->delete();
        session(['message' => 'Deleted Successfully', 'type' => 'success']);
    }
    public function addView()
    {
        $get_all_packages = getModuleData(37);
        $title = 'Add New Package Question';
        return view('back.package_questions.add', compact('get_all_packages', 'title'));
    }
}
