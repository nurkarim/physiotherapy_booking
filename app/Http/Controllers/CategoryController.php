<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Categories;
use App\Http\Helper;
class CategoryController extends Controller
{
    
    public function store(Request $request)
    {
    	$save=Categories::create([
            'name'=>$request->name,
            'status'=>1,
        ]);
    	if ($save) {
        $fileName=Helper::imageUpload($save->id,$request->category_image,'/image/category/');
        $obj=Categories::find($save->id);
        $obj->image=$fileName;
        $obj->save();
    		$request->session()->flash('success', "categorie create successfully");
    	}else{
    		$request->session()->flash('error', "Sorry!!categorie create Unsuccessfully");
    	}
    	return back();
    }

    public function update(Request $request)
    {

    	$save=Categories::where('id',$request->id)->update(['name'=>$request->name]);
    	 if ($save == true) {
    		 return response()->json(['success' => true, 'status' => "Update  Successfull"]);
    	}elseif($save == false){
    		 return response()->json(['success'   => false, 'status' => "No Change Occour."]);
    	}else{
    		 return response()->json(['error'   => true, 'status' => "Update  Unsuccessfull"]);
    	}
    	
    }   
    public function delete($id)
    {

    	$save=Categories::where('id',$id)->delete();
    	 if ($save == true) {
    		 return response()->json(['success' => true, 'status' => "delete  Successfull"]);
    	}elseif($save == false){
    		 return response()->json(['success'   => false, 'status' => "No Change Occour."]);
    	}else{
    		 return response()->json(['error'   => true, 'status' => "delete  Unsuccessfull"]);
    	}
    	
    }


}
