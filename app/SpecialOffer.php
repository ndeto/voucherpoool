<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/18/18
 * Time: 3:35 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model {
	protected $fillable = ['name', 'fixed_percentage_discount'];
}