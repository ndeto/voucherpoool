<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/18/18
 * Time: 4:30 PM
 */


use App\Recipient;
use App\Voucher;
use Laravel\Lumen\Testing\DatabaseTransactions;


$v = "";

class VoucherTest extends TestCase{
	use DatabaseTransactions;

	public function testVerify()
	{

		$recipient = Recipient::all()->first();

		$voucher = Voucher::where('recipient_id',$recipient->id)->first();

		$GLOBALS['v'] = $voucher;

		$this->json('POST','/voucher/verify',[ 'email' => $recipient->email, 'code' =>$voucher->code])
		     ->seeJson([
			     'status'=>true
		     ]);

	}

	public function testGenerate(){

		$voucher = $GLOBALS['v'];

		$this->post('/voucher/generate',['special_offer_id' => $voucher->special_offer_id,'expiration_date'=>$voucher->expiration_date])
		     ->seeJson([
			     'status'=>true
		     ]);
	}
}