<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/18/18
 * Time: 1:53 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Voucher extends Model {
	protected $fillable = ['recipient_id', 'special_offer_id','code','expiration_date','date_used','used'];
}