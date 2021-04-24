<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Categories;
use App\Http\Models\Product;
use App\Http\Models\Shop;
use Session;
class ShopController extends Controller
{
    public function index()
    {
    $category=Categories::all();
        return view('layouts.shop.category',compact('category'));
    }
    public function products($id)
    {
    $category=Categories::all();
    $select_category=Categories::find($id);
    $products=Product::where('category_id',$id)->orderBy('id','DESC')->paginate(9);

        return view('layouts.shop.product',compact('category','select_category','products'));
    }

public function rangerProduct($value='')
{
    $productsarr= array();
    $products=Product::whereBetween('amount',[0, $value])->get();
    foreach ($products as $key => $productsValue) {
        $url=explode(' ',$productsValue->product_name);
$imp=implode($url, '_');
$exp=explode('-', $imp);
$url1=implode($exp, '_');

        $productsarr[]= array('id' =>$productsValue->id ,'url'=>$url1,'product_name'=>$productsValue->product_name,'desplay_image'=>$productsValue->desplay_image,'amount'=>$productsValue->amount);
    }
   if (count($productsarr)>0) {
       return $productsarr;
   }else{

    return response()->json(["success"=>false]);
    
   }
}


    public function overview($id)
    {
    $product=Product::find($id);
    if ($product) {
    $category=Categories::all();
    $option_product=Product::optionProductPrice($id);
    $product_image=Product::productImages($id);
    $releted_product=Product::reletedProduct($id);
        return view('layouts.shop.overview',compact('category','product','option_product','product_image','releted_product'));
    }else{
    return view('errors.503');
    }
    }
    public function addCart(Request $request)
    {
    $save=Shop::shopCart($request->all());
    if ($save==true) {

    return response()->json(['success'=>true]);
    }else{
    return response()->json(['success'=>false]);
    }
    }
    public function checkOptionProduct($id='')
    {
         $data=Shop::checkOptionProduct($id);
         if ($data) {
              return response()->json(['success'=>true,'price'=>$data[0]->amount]);
    }else{
    return response()->json(['success'=>false,'price'=>0.00]);
    }
         
    }

    public function deleteCart(Request $request,$id)
    {
        $result=Shop::deleteCart($id);
        if ($result) {
            $request->session()->flash('success', "delete successfully");
        }else{
            $request->session()->flash('error', 'sorry!! some was problem');

        }
        return back();
    }

    public function updateCart(Request $request)
    {


        $result=Shop::updateCart($request->all());
        if ($result) {
              return response()->json(['success'=>true]);
    }else{
    return response()->json(['success'=>false]);
    }
    }
}