<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Country;
class CountryController extends Controller
{
    public function index()
    {
    	$country=Country::all();
    	return view('backend.country.index',compact('country'));
    }


    public function create()
    {
    	
    	return view('backend.country.create');
    }

    public function store(Request $request)
   {

    $save=Country::create([
        'name'=>$request->name,
        'code'=>$request->code,
    ]);
     if ($save==true) {
            $request->session()->flash('success', " create successfully");
        }else{
            $request->session()->flash('error', "Sorry!! create Unsuccessfully");
        }

        return redirect('country');
   }

    public function edit($id)
    {
        $country=Country::find($id);
        return view('backend.country.edit',compact('country'));
    }
       
 public function destory($id)
    {
        $save=Country::where('id',$id)->delete();
         if ($save == true) {
             return response()->json(['success' => true, 'status' => "delete  Successfull"]);
        }elseif($save == false){
             return response()->json(['success'   => false, 'status' => "No Change Occour."]);
        }else{
             return response()->json(['error'   => true, 'status' => "delete  Unsuccessfull"]);
        }
    }

  public function update(Request $request,$id)
   {

    $save=Country::where('id',$id)->update([
        'name'=>$request->name,
        'code'=>$request->code,
    ]);
     if ($save==true) {
            $request->session()->flash('success', " edit successfully");
        }else{
            $request->session()->flash('error', "Sorry!! edit Unsuccessfully");
        }

        return redirect('country');
   }

}
