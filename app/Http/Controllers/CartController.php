<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\Country;
use App\Http\Models\Client;
use App\Http\Models\Appointment;
use App\Http\Models\Vat;
use App\Http\Models\Company;
use App\Http\Models\Cart;
use DB;
use Session;
use App\Http\Requests\ClientRequest;
use Mail;
use App\Order;
class CartController extends Controller
{
    public function index()
    {
    //Session::forget('appoinmentCart');
    return view('layouts.cart.index');
    }

    public function checkout()
    {
        if(count(Session::get('appoinmentCart'))>0 || count(Session::get('shopcart'))>0){
            $country=Country::all();
        return view('layouts.cart.checkout',compact('country'));
            }else{
        return redirect('/');
        }
    }
    public function checkoutAuth($id='')
    {
        $client=Client::find($id);
        $address=Client::clientAddress($id);
        if(count(Session::get('appoinmentCart'))>0 || count(Session::get('shopcart'))>0){
            $country=Country::all();
        return view('layouts.cart.checkout_loggedin',compact('country', 'client', 'address'));
            }else{
        return redirect('/');
        }
    }

    public function checkoutComplete(ClientRequest $request)
    {
      if (count($request->appointment_type_id)>1) {
            
            $save=Appointment::checkOutWithMoreAppointment($request->all());
       
            
        }else{


            $save=Appointment::compelteCheckOut($request->all());
            
        }


       if ($save[0]) {
       if (!empty($request->is_acc)) {
        $email=$request->email;
        $name=$request->first_name;
        $namelst=$request->last_name;
        $data=array('email'=>$email,'name'=>$name,'namelst'=>$request->last_name);
        $cmp=Company::where('id_number',123)->first();
        $res=Mail::send('email.newCustomer',compact('data','cmp'), function($message)use ($data) {
        $message->to($data['email'], $data['name'])->subject('New Account Create');
        $message->from('info@jemkin.be','Jemkine');
    });
        $linkRedirect = $save[1]->links->paymentUrl;
    }
        return redirect($linkRedirect);
     }else{
        return back();
        }
    }

    public function checkoutCompleteAuth(Request $request)
    {


        if (@count($request->appointment_type_id)>1) {

            $save=Appointment::checkOutWithMoreAppointment($request->all());
     
        }else{


            $save=Appointment::compelteCheckOut($request->all());
            
        }

        if ($save[0]) {
       $request->session()->flash('success', "Order or Appointment Successfully");
            $linkRedirect = $save[1]->links->paymentUrl;

        }else{
       $request->session()->flash('error', "Sorry!! Order or Appointment UnSuccessfully");
      }
        return redirect($linkRedirect);
    }

    public function orderSuccess()
    {
        return view('layouts.cart.success');
    }

    public function checkVatAccordingCountry(Request $request)
    {
        $data=Vat::where('country_id',$request->countryId)->first();
        if ($data) {
        return response()->json(['success'=>true,'code'=>$data->vat_type,'vat_number'=>$data->vat_number]);
        }
    }

    public function appointmentCart(Request $request){ 

    $check=Appointment::where('date',$request->date)->where('start_time_id',$request->time_html)->get();
    if (count($check)>0) {
    return response()->json(['success'=>true,'sms'=>"This Time Already Booked"]);
    }else{
    $arrayName = array(
        'date'            => $request->date,
        'start_time_id'   =>$request->select_time,
        'appointment_type'=>$request->appointment_type,
        'specialist'      =>$request->specialist,
        'type_price'      =>$request->type_price,
        'type_name'       =>$request->type_name,
        'start_time'      =>$request->time_html,
        'vat_number'      =>$request->vat_number,
        'color'           =>$request->color);
        $addcart=Cart::appointmentCart($arrayName);
    if ($addcart==true) {
        return response()->json([
            'addsuccess'=>true,
            'sms'=>"Appointment Add Cart Successfully"]);
        }else{
        return response()->json([
            'addsuccess'=>false,
            'sms'=>"This Time Already Booked"]);
        }
    }

    }

    public  function emptyCart(){
    Session::forget('shopcart');
    return back();

    }

      public static function deleteAppCart($id,$date){

            Session::forget('appoinmentCart.time_id'.$id.'_'.$date);
          
           return back();
        
    }
}