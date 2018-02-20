<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Recipient;
use App\SpecialOffer;
use App\Voucher;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    SpecialOffer::create([
		    'name' => 'Valentines Discount',
		    'fixed_percentage_discount' => rand(1,50),
	    ]);
	    SpecialOffer::create([
			    'name' => 'Easter Discount',
			    'fixed_percentage_discount' => rand(1,50),
	    ]);
	    SpecialOffer::create([
			    'name' => 'Black Friday Discount',
			    'fixed_percentage_discount' => rand(1,50),
		    ]);

	    factory( 'App\Recipient', 10)->create();
    }

    public function clear_db(){
	    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	    Voucher::truncate();
	    Recipient::truncate();
	    SpecialOffer::truncate();
	    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
