<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Wildside\Userstamps\Userstamps;
use App\Http\Helper;
use DB;
use Auth;
use App\Http\Models\Wallet;
use App\Http\Models\UserAddress;
class User extends Authenticatable
{
    use Notifiable;
    use Userstamps;
  protected $guarded =['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

public function wallet()
    {
        return $this->hasOne('App\Http\Models\Wallet');
    }

    public function UserAddressJoin()
    {
        return $this->hasOne('App\Http\Models\UserAddress');
    }



public static function selectTime()
    {
        $data=DB::table('times')
            ->get();
            return $data;
    }
public static function appointmentTypes()
    {
        $data=DB::table('appointment_types')
            ->paginate(10);
            return $data;
    }

public static function userAddress($id='')
{
    $data=DB::table('user_address')->where('user_id',$id)->first();
    return $data;
}

public static function userAddressSelect($id='')
{
    $data=DB::table('user_address')
    ->leftjoin('countryes','user_address.country_name','=','countryes.id')
    ->leftjoin('countryes as sCountry','user_address.shipping_country_name','=','sCountry.id')
    ->select('user_address.*','countryes.name as iCName','sCountry.name as ScName')
    ->where('user_address.user_id',$id)
    ->first();
    return $data;
}

public static function saveUser($data='')
{
    $save=User::create([
        'first_name'=>$data['fname'],
        'last_name'=>$data['last_name'],
        'email'=>$data['email'],
        'password'=>bcrypt('password'),
        'vat_number'=>$data['vat_number'],
        'title'=>$data['title'],
        'role_id'=>$data['role_id'],
        'user_type'=>3,
        'is_specialist'=>@$data['is_specialist'],
        'phone_number'=>$data['phone_number'],
        'another_phone_number'=>$data['another_phone_number'],
        'created_at'=>date('Y-m-d H:i:s'),
    ]);
    if ($save) {

if (!empty($data['image_file'])) {
    $fileName=Helper::imageUpload($save->id,$data['image_file'],"/image/users/");
            DB::table('users')->where('id',$save->id)->update([
                    'image'=>$fileName
                ]);
}

    DB::table('user_address')->insert([
        'user_id'=>$save->id,
        'invoice_address'=>$data['i_address'],
        'post_code'=>$data['i_code'],
        'city'=>$data['i_city'],
        'country_name'=>$data['i_country'],
        'shipping_address'=>$data['s_address'],
        'shipping_post_code'=>$data['s_code'],
        'shopping_city'=>$data['s_city'],
        'shipping_country_name'=>$data['s_country'],
        'status'=>1,
    ]);

    return true;
    }
    return false;
}

public static function updateUser($data='',$id)
{
    $save=User::where('id',$id)->update([
        'first_name'=>$data['fname'],
        'last_name'=>$data['last_name'],
        'email'=>$data['email'],
        'password'=>bcrypt('password'),
        'vat_number'=>$data['vat_number'],
        'title'=>$data['title'],
        'role_id'=>$data['role_id'],
        'user_type'=>3,
        'phone_number'=>$data['phone_number'],
        'another_phone_number'=>$data['another_phone_number'],
        'created_at'=>date('Y-m-d H:i:s'),
    ]);
    if ($save) {

if (!empty($data['image_file'])) {
    $fileName=Helper::imageUpload($id,$data['image_file'],"/image/users/");
            DB::table('users')->where('id',$id)->update([
                    'image'=>$fileName
                ]);
}

    DB::table('user_address')->where('user_id',$id)->update([
        'invoice_address'=>$data['i_address'],
        'post_code'=>$data['i_code'],
        'city'=>$data['i_city'],
        'country_name'=>$data['i_country'],
        'shipping_address'=>$data['s_address'],
        'shipping_post_code'=>$data['s_code'],
        'shopping_city'=>$data['s_city'],
        'shipping_country_name'=>$data['s_country'],
        'status'=>1,
    ]);

    return true;
    }
    return false;
}


public static function saveNewAccount($data='')
{
    $save=User::create([
        'first_name'=>$data['first_name'],
        'last_name'=>$data['last_name'],
        'email'=>$data['email'],
        'password'=>bcrypt($data['password']),
        'vat_number'=>$data['vat_number'],
        'role_id'=>0,
        'user_type'=>2,
        'created_at'=>date('Y-m-d H:i:s'),
    ]);
    if ($save) {

    DB::table('user_address')->insert([
        'user_id'=>$save->id,
        'invoice_address'=>$data['address'],
        'post_code'=>$data['post_code'],
        'city'=>$data['city'],
        'country_name'=>$data['country'],
        'shipping_address'=>$data['s_address'],
        'shipping_post_code'=>$data['s_post'],
        'shopping_city'=>$data['s_city'],
        'shipping_country_name'=>$data['s_country'],
        'status'=>1,
    ]);

    return true;
    }
    return false;
}

public static function editMyAccount($data='')
{
    $save=User::where('id',Auth::user()->id)->update([
        'first_name'=>$data['first_name'],
        'last_name'=>$data['last_name'],
        'vat_number'=>$data['vat_number'],
        'phone_number'=>$data['phone_number'],
        'role_id'=>0,
        'user_type'=>2,
        'created_at'=>date('Y-m-d H:i:s'),
    ]);
    if ($save) {

    DB::table('user_address')->where('user_id',Auth::user()->id)->update([
        'invoice_address'=>$data['invoice_address'],
        'post_code'=>$data['post_code'],
        'city'=>$data['city'],
        'country_name'=>$data['country'],
        'shipping_address'=>$data['shipping_address'],
        'shipping_post_code'=>$data['shipping_post_code'],
        'shopping_city'=>$data['shopping_city'],
        'shipping_country_name'=>$data['s_country'],
        'status'=>1,
    ]);

    return true;
    }
    return false;
}




}
