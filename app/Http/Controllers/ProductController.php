<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Categories;
use App\Http\Models\Vat;
use App\Http\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
    	$product=Product::all();
    	return view('backend.product.index',compact('product'));
    }
    public function create()
    {
    	$category=Categories::all();
    	$vat=Vat::all();
    	return view('backend.product.create',compact('category','vat'));
    }

    public function edit($id)
    {
        $category=Categories::all();
        $vat=Vat::all();
        $product=Product::find($id);
        $optionProduct=Product::optionProductPrice($id);
        $reletedProduct=Product::reletedProduct($id);
        $images=Product::productImages($id);
        return view('backend.product.edit',compact('category','vat','product','optionProduct','reletedProduct','images'));
    }

    public function store(Request $request)
    {
    	
    	$save=Product::saveProduct($request->all());
    	if ($save==true) {
    		$request->session()->flash('success', "product create successfully");
    	}else{
    		$request->session()->flash('error', "Sorry!!product create Unsuccessfully");
    	}

    	return redirect('products');
    }


     public function searchajaxproduct(Request $request) {
        $query = $request->get('term','');
        $iId = $request->iId;
        
        $products=Product::where('product_name','LIKE','%'.$query.'%')->get();
        
        $data=array();
        
        foreach ($products as $product) {
                $data[]=array('value'=>$product->product_name,'id'=>$product->id,'num'=>1);
	
        }
        if(count($data))
             return  $data;
        else
            return ['value'=>'No Result Found','id'=>''];
    }


    public function imagesDelete($id='')
    {
        $delete=Product::imagesDelete($id);
        if ($delete==true) {
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);

        }
    }

   public function destory($id='')
    {
        $delete=Product::deleteProduct($id);
        if ($delete==true) {
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);

        }
    }


    public function update(Request $request,$id)
    {
       $update=Product::updateProduct($request->all(),$id);
       if ($update==true) {
            $request->session()->flash('success', "product update successfully");
        }else{
            $request->session()->flash('error', "Sorry!!product update Unsuccessfully");
        }
        

        return redirect('products');
    }
}
