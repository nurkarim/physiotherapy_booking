<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Categories;
use App\Http\Models\Vat;
use App\Http\Models\Day;
use App\Http\Models\WeekType;
use App\Http\Models\Country;
use App\Http\Models\Company;
use App\Http\Models\Availability;
class GenarelSettingController extends Controller
{
    public function create()
    {
    	$category=Categories::all();
        $select_vat=Vat::all();
        $days=Day::all();
        $week_type=WeekType::all();
        $week_day=WeekType::selectWeekDay();
    	$country=Country::all();
        $select_time=Availability::selectTime();
    	return view('backend.genarel_setting.create',compact('category','select_vat','days','week_type','week_day','country','select_time'));
    }

    public function store(Request $request)
    {
    	$save=Vat::create($request->all());
    	if ($save) {
    		$request->session()->flash('success', "vat-class create successfully");
    	}else{
    		$request->session()->flash('error', "Sorry!!vat-class create Unsuccessfully");
    	}
    	return back();
    }

public function update(Request $request)
    {

    	$save=Vat::where('id',$request->id)->update(['vat_number'=>$request->vat_number,'vat_type'=>$request->vat_type]);
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

        $save=Vat::where('id',$id)->delete();
         if ($save == true) {
             return response()->json(['success' => true, 'status' => "delete  Successfull"]);
        }elseif($save == false){
             return response()->json(['success'   => false, 'status' => "No Change Occour."]);
        }else{
             return response()->json(['error'   => true, 'status' => "delete  Unsuccessfull"]);
        }
        
    } 


    public function storeWeekType(Request $request)
    {
        $save=WeekType::saveWeekTypes($request->all());
        if ($save) {
            $request->session()->flash('success', " create successfully");
        }else{
            $request->session()->flash('error', "Sorry!! create Unsuccessfully");
        }
        return back();
    }


    public function deleteWeekType($id)
    {

        $save=WeekType::deleteWeekType($id);
         if ($save == true) {
             return response()->json(['success' => true, 'status' => "delete  Successfull"]);
        }elseif($save == false){
             return response()->json(['success'   => false, 'status' => "No Change Occour."]);
        }else{
             return response()->json(['error'   => true, 'status' => "delete  Unsuccessfull"]);
        }
        
    }


    public function companyIndex()
    {
        $data=Company::where('id_number',123)->first();
       return view('backend.setting.companySetting',compact('data'));
    }

    public function saveCompany(Request $request)
    {
        $save=Company::saveCompany($request->all());

        if ($save) {
            $request->session()->flash('success', " create successfully");
        }else{
            $request->session()->flash('error', "Sorry!! create Unsuccessfully");
        }
        return back();
    }

    public function editWeekTypeDayTime($dayId,$weekTypeId)
    {

        $select_time=Availability::selectTime();
        $weekDays=WeekType::weekTypesDaysEdit($dayId,$weekTypeId);
       return view('backend.genarel_setting.editDayTimes',compact('select_time','weekDays','dayId','weekTypeId'));

    }
    public function weekTypesDayTimesUpdate(Request $request)
    {
       
        $save=WeekType::weekTypesDayTimesUpdate($request->all());
        if ($save) {
            $request->session()->flash('success', " updated successfully");
        }else{
            $request->session()->flash('error', "Sorry!! updated Unsuccessfully");
        }
        return back();
    }

}
