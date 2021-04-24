<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;
use App\Http\Helper;
use DB;
class Product extends Model
{
	use Userstamps;

    protected $guarded =['id'];


public static function saveProduct($data='')
{
	$save=Product::create([
		'product_name'=>$data['product_name'],
		'category_id'=>$data['category_id'],
		'short_description'=>$data['short_description'],
		'description'=>$data['description'],
		'amount'=>$data['amount'],
		'vat_number'=>$data['vat_number'],
		'is_veriable_product'=>@$data['is_veriable_product'],
		
		'status'=>1,
	]);
	if ($save) {

if (!empty($data['image_file'])) {
    		$fileName=Helper::imageUpload($save->id,$data['image_file'],"/image/products/display/");
    		DB::table('products')->where('id',$save->id)->update([
					'desplay_image'=>$fileName
				]);
    	}
if (!empty($data['image_path'])) {
    if (count($data['image_path'])>0) {
for ($e=1; $e <sizeof($data['image_path']) ; $e++) { 
    		$fileNameOr=Helper::imageUpload($save->id,$data['image_path'][$e],"/image/products/");
    		DB::table('produtc_image')->insert([
					'product_id'=>$save->id,
					'image'=>$fileNameOr
				]);
    	}
}
}
		if (!empty($data['option_name'])) {
			if (count($data['option_name'])>0) {
				for ($i=0; $i <sizeof($data['option_name']) ; $i++) { 
				DB::table('option_product_price')->insert([
					'name'=>$data['option_name'][$i],
					'product_id'=>$save->id,
					'amount'=>$data['option_price'][$i],
					'status'=>1,
				]);
				}
			}
		}

		if (!empty($data['product_id'])) {
			if (count($data['product_id'])>0) {
				for ($a=0; $a <sizeof($data['product_id']) ; $a++) { 
				DB::table('related_products')->insert([
					'product_id'=>$save->id,
					'releted_product_id'=>$data['product_id'][$a],
					'status'=>1,
				]);
				}
			}
		}

return true;
	}

}

public static function updateProduct($data='',$id)
{
	$save=Product::where('id',$id)->update([
		'product_name'=>$data['product_name'],
		'category_id'=>$data['category_id'],
		'short_description'=>$data['short_description'],
		'description'=>$data['description'],
		'amount'=>$data['amount'],
		'vat_number'=>$data['vat_number'],
		'is_veriable_product'=>@$data['is_veriable_product'],
		'status'=>1,
	]);
	if ($save) {


    	if (!empty($data['image_file'])) {
    			$fileName=Helper::imageUpload($id,$data['image_file'],"/image/products/display/");
    		DB::table('products')->where('id',$id)->update([
					'desplay_image'=>$fileName
				]);
    	}
    	if (!empty($data['image_path'])) {
    if (count($data['image_path'])>0) {
    	
for ($e=0; $e <sizeof($data['image_path']) ; $e++) { 
    		$fileNameOr=Helper::imageUpload($id,$data['image_path'][$e],"/image/products/");
    		DB::table('produtc_image')->insert([
					'product_id'=>$id,
					'image'=>$fileNameOr,
					'updated_at'=>date('Y-m-d H:i:s'),
				]);
    	}
    	 }}

		if (!empty($data['option_name'])) {
			if (count($data['option_name'])>0) {
				DB::table('option_product_price')->where('product_id',$id)->delete();

				for ($i=0; $i <sizeof($data['option_name']) ; $i++) { 
				DB::table('option_product_price')->insert([
					'name'=>$data['option_name'][$i],
					'product_id'=>$id,
					'amount'=>$data['option_price'][$i],
					'status'=>1,
				]);
				}
			}
		}

		if (!empty($data['product_id'])) {
			if (count($data['product_id'])>0) {
				DB::table('related_products')->where('product_id',$id)->delete();
				for ($a=0; $a <sizeof($data['product_id']) ; $a++) { 
				DB::table('related_products')->insert([
					'product_id'=>$id,
					'releted_product_id'=>$data['product_id'][$a],
					'status'=>1,
				]);
				}
			}
		}

return true;
	}

}



public static function optionProductPrice($id)
{
	$data=DB::table('option_product_price')
		->where('product_id',$id)
		->get();
		return $data;
}
public static function reletedProduct($id)
{
	$data=DB::table('related_products')
		->join('products','related_products.releted_product_id','=','products.id')
		->select('products.product_name','products.desplay_image','products.id as productId','products.amount','related_products.*')
		->where('related_products.product_id',$id)
		->get();
		return $data;
}
public static function productImages($id)
{
	$data=DB::table('produtc_image')

		->where('product_id',$id)
		->get();
		return $data;
}

public static function imagesDelete($id)
{
	$data=DB::table('produtc_image')
		->where('id',$id)
		->delete();
		if ($data) {
			return true;
		}
		return false;
}

public static function deleteProduct($id='')
{
	$result=Product::where('id',$id)->delete();
	if ($result) {
		DB::table('produtc_image')
		->where('id',$id)
		->delete();
		DB::table('option_product_price')
		->where('product_id',$id)
		->delete();
		DB::table('related_products')
		->where('product_id',$id)
		->delete();
		return true;
		
	}

	return false;
}

}
