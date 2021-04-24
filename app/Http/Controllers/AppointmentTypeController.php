<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Vat;
use App\Http\Models\AppointmentType;


class AppointmentTypeController extends Controller
{
	  public function index()
    {
    	$dataType=AppointmentType::all();
    	return view('backend.appointment_type.index',compact('dataType'));
    	
    }
    public function create()
    {
    	$vat=Vat::all();
        return view('backend.appointment_type.create',compact('vat'));
    } 
    public function store(Request $request)
    {
    	$save=AppointmentType::saveTypes($request->all());
    	if ($save==true) {
    		$request->session()->flash('success', " create successfully");
    	}else{
    		$request->session()->flash('error', "Sorry!! create Unsuccessfully");
    	}

    	return redirect('appointment/types');
    }
	public function edit($id)
	{
		$vat=Vat::all();
		$dataType=AppointmentType::find($id);
        return view('backend.appointment_type.edit',compact('vat','dataType'));
	}

	public function update(Request $request,$id)
	{
		$save=AppointmentType::editType($request->all(),$id);
		if ($save==true) {
    		$request->session()->flash('success', " updated successfully");
    	}else{
    		$request->session()->flash('error', "Sorry!! updated Unsuccessfully");
    	}

    	return redirect('appointment/types');
	}

	public function destory($id='')
	{
		$result=AppointmentType::deleteType($id);
		if ($result==true) {
			return response()->json(['success'=>true]);
		}else{
			return response()->json(['success'=>false]);
		}

	}
}
