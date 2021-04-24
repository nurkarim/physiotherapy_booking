<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use App\Http\Helper;
use DB;
class Company extends Model
{
	use Userstamps;

   
    protected $guarded =['id'];
    protected $table ="company_info";

    public static function saveCompany($data)
    {
    	$cmp=Company::where('id_number',123)->first();
    	if ($cmp) {
    		Company::where('id_number',123)->update([
			'name'=>$data["name"],
			'post_code'=>$data["post_code"],
			'city'=>$data["city"],
			'address'=>$data["address"],
			'email'=>$data["email"],
			'contact'=>$data["contact"],
			'vat_number'=>$data["vat_number"],
			'bank_account_number'=>$data["bank_account_number"],
			'country'=>$data["country"],
    		]);

if (!empty($data['logo'])) {
    		$fileName=Helper::imageUpload(123,$data['logo'],"/image/");
    		DB::table('company_info')->where('id_number',123)->update([
					'logo'=>$fileName
				]);
    	}
return true;
    	}else{

			Company::create([
			'id_number'=>123,
			'name'=>$data["name"],
			'post_code'=>$data["post_code"],
			'city'=>$data["city"],
			'address'=>$data["address"],
			'email'=>$data["email"],
			'contact'=>$data["contact"],
			'vat_number'=>$data["vat_number"],
			'bank_account_number'=>$data["bank_account_number"],
			'country'=>$data["country"],
			]);

if (!empty($data['logo'])) {
    		$fileName=Helper::imageUpload(123,$data['logo'],"/image/");
    		DB::table('company_info')->where('id_number',123)->update([
					'logo'=>$fileName
				]);
    	}

return true;

    	}

    }

}
