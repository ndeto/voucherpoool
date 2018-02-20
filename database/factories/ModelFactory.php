<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\Recipient::class, function (Faker\Generator $faker) {

	return [
		'name'  => $faker->name,
		'email' => $faker->email,
	];
});

$factory->define(App\SpecialOffer::class, function (Faker\Generator $faker) {

	return [
		'name'  => $faker->name,
		'fixed_percentage_discount' => $faker->randomDigit,
	];
});

$factory->define(App\Voucher::class, function (Faker\Generator $faker) {
	$special_offer = factory('App\SpecialOffer')->make();
	$user = factory( 'App\Recipient' )->make();
	return [
		'code'  => \App\Http\Controllers\VoucherController::random(8),
		'recipient_id' => $user->id,
		'special_offer_id'=> $special_offer->id,
		'expiration_date'=> $faker->dateTime,
		'used'=> false,
		'date_used'=>$faker->dateTime
	];
});