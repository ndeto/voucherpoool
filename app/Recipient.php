<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/18/18
 * Time: 12:29 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Recipient extends Model {
	protected $fillable = ['name', 'email'];
}