<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/18/18
 * Time: 12:15 PM
 */

namespace App\Http\Controllers;
use App\Recipient;
use App\Voucher;
use Illuminate\Http\Request;
use App\SpecialOffer;
use Carbon\Carbon;



class VoucherController extends Controller {

public function generate(Request $request){

	$recipients = Recipient::all();

	foreach ($recipients as $i){
		$input = [];
		$code = $this->random(8);
		$input['code'] = $code;
		$input['recipient_id'] = $i->id;
		$input['expiration_date'] = $request->input('expiration_date');
		$input['special_offer_id'] = $request->input('special_offer_id');
		Voucher::create( $input );
	}

	return response()->json(["status"=>true]);
}

public function verify(Request $r){

	$email = $r->input('email');
	$recipient = Recipient::whereEmail($email)->first();

	if($recipient){
		$voucher = Voucher::where('recipient_id',$recipient->id)->where('code',$r->input('code'))->first();

		if(!empty($voucher)){

			//check if it has been used
		if($voucher->used){
			return response()->json(["status"=>"false","message"=>"voucher has already been used"]);
		}
			//check if its expired
		if($voucher->expiration_date < Carbon::now()){
			return response()->json(["status"=>"false","message"=>"voucher has already expired"]);
		}

			//mark as used
			$voucher->used = true;
			$voucher->date_used = Carbon::now();
			$voucher->save();


			//return the offer and percentage
			return response()->json(["status"=>true,"percent"=>SpecialOffer::where('id',$voucher->special_offer_id)->first()->fixed_percentage_discount]);

		}
		else{
			//Return error if voucher has not been found
			return response()->json(["status"=>"false","message"=>"no valid voucher found"]);
		}

	}else{
		//Return error if email not found
		return response()->json(["status"=>"false","message"=>"email not found"]);
	}



}

public function getcodes(Request $request){


	//Retrieve The recipient
	$recipient = Recipient::where('email',$request->input('email'))->first();


	//Return error if recipient has not been found

	if(!$recipient){
		return response()->json(['status'=>'false','message'=>'Email not found']);
	}

	//create response for the found valid offers

	$recipient_id = $recipient->id;

	//Check for valid codes
	$codes = Voucher::where('recipient_id', $recipient_id)->whereDate('expiration_date', '>', Carbon::now())->where('used',false)->get();


	$result = [];


	if(!empty($codes)) {

		$i = 0;

		foreach ( $codes as $code ) {
			$result[$i] = array(SpecialOffer::where('id',$code['special_offer_id'])->first()->name => $code["code"]);
			$i =+1;
		}


	}else{

		// return error if there are no valid codes for the email
		echo "No valid codes found for the email";
	}

	$r[$request->input('email')] =$result;

	return response()->json($r);
}

public static function random($length) {
	$pool = array_merge(range(0,9),range('A', 'Z'));
	$key ='';

	for($i=0; $i < $length; $i++) {
		$key .= $pool[mt_rand(0, count($pool) - 1)];
	}
	return $key;
}

}