<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use DB;
use Session;
class Shop extends Model
{
	use Userstamps;

    protected $guarded =['id'];
    protected $table ="menu";

public static function shopCart($data='')
    {
    	 $cartValue=array(
                    'id'=>$data['product_id'],
                    'name'=>$data['product_name'],
                    'image'=>$data['product_image'],
                    'qty'=>1,
                    'option_products'=>$data['option_products'],
                    'product_price'=>$data['product_price'],
                    'vat'=>$data['vat_class'],
                    'option_products_html'=>$data['option_products_html'],
               
                    
                );
              Session::put('shopcart.product_id'.$data['product_id'],$cartValue);
              return true;

    }

    public static function checkOptionProduct($id='')
    {
       $data=DB::table('option_product_price')
            ->where('id',$id)
            ->get();

            return $data;
    }

  // cart delete
    public static function deleteCart($id){

            Session::forget('shopcart.product_id'.$id);
           return true;
        
    }

    public static function emptyCart(){

            Session::forget('shopcart');
            
           return true;
        
    }


    // cart update
    public static function updateCart($data=''){


            $result=Session::get('shopcart.product_id'.$data['product_id']);
            $update=array(
                    'id'=>$result['id'],
                    'name'=>$result['name'],
                    'image'=>$result['image'],
                    'qty'=>$data['qty'],
                    'option_products'=>$result['option_products'],
                    'product_price'=>$result['product_price'],
                    'vat'=>$result['vat'],
                    'option_products_html'=>$result['option_products_html'],
                );


            Session::forget('shopcart.product_id'.$data['product_id']);
            Session::put('shopcart.product_id'.$result['id'],$update);

            return true;
        }
    }



