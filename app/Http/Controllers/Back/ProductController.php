<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Back\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = config('Constants.SITE_NAME') . ': PRODUCTS\'s Management';
        $msg = '';
        $products = Product::orderBy('item_order', 'ASC')->get();

        return view('back.product.index', compact('products', 'title', 'msg'));
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
            $product = Product::find($id);
            $product->item_order = $i;
            $product->save();
            ++$i;
            echo $i . ' ' . $id;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_slug' => 'required',
            'product_description' => 'required',
            'price' => 'required',
        ]);
        if ($validator->passes()) {
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->product_slug = $request->product_slug;
            $product->product_description = $request->product_description;
            $product->price = $request->price;
            $product->meta_title = $request->meta_title;
            $product->meta_keywords = $request->meta_keywords;
            $product->meta_description = $request->meta_description;
            $product->canonical_url = $request->canonical_url;
            if (!empty($request->featured_img)) {
                $product->product_img = $request->featured_img;
            }
            $product->product_img_title = $request->product_img_title;
            $product->product_img_alt = $request->product_img_alt;

            $product->dated = date('Y-m-d H:i:s');
            $product->save();

            return json_encode(['status' => true]);
        }
        $html = '';
        foreach ($validator->errors()->all() as $key => $value) {
            $html .= '<li>' . $value . '</li>';
        }

        return json_encode(['status' => false, 'errors' => $html]);
        // return json_encode(["status" => false, 'errors' => $validator->errors()->all()]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_slug' => 'required',
            'product_description' => 'required',
            'price' => 'required',
        ]);
        if ($validator->passes()) {
            $product = Product::find($id);
            $product->product_name = $request->product_name;
            $product->product_slug = $request->product_slug;
            $product->product_description = $request->product_description;
            if (!empty($request->featured_img)) {
                $product->product_img = $request->featured_img;
            }
            $product->product_img_title = $request->product_img_title;
            $product->product_img_alt = $request->product_img_alt;

            $product->price = $request->price;
            $product->meta_title = $request->meta_title;
            $product->meta_keywords = $request->meta_keywords;
            $product->meta_description = $request->meta_description;
            $product->canonical_url = $request->canonical_url;
            $product->save();

            return json_encode(['status' => true]);
        }
        $html = '';
        foreach ($validator->errors()->all() as $key => $value) {
            $html .= '<li>' . $value . '</li>';
        }

        return json_encode(['status' => false, 'errors' => $html]);
        // return json_encode(["status" => false, 'errors' => $validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($id == '') {
            echo 'error';

            return;
        }
        $status = $request->status;
        if ($status == '') {
            echo 'invalid current status provided.';

            return;
        }
        if ($status == 'active') {
            $new_status = 'blocked';
        } else {
            $new_status = 'active';
        }
        $product = Product::find($id);
        $product->sts = $new_status;
        $product->save();
        echo $new_status;

        return;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        return json_encode($product);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
    }

    public function productSellStatus(Request $request)
    {
        $product_status = explode(',', $request->product_Sale_Status)[0];
        $id = explode(',', $request->product_Sale_Status)[1];
        $result = Product::where('id', $id)->first();
        if ($product_status == 1) {
            $result->sell_status = 0;
        } else {
            $result->sell_status = 1;
        }

        $result->save();

        return json_encode(['status' => true]);
    }
}
