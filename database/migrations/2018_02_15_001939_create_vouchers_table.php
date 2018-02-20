<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('recipient_id')->unsigned();
			$table->integer('special_offer_id')->unsigned();
	        $table->date('expiration_date');
	        $table->boolean('used')->default(0);
	        $table->date('date_used')->default(null);
            $table->timestamps();
        });

	    Schema::table('vouchers', function (Blueprint $table) {
		    $table->foreign('recipient_id')->references('id')->on('recipients');
		    $table->foreign('special_offer_id')->references('id')->on('special_offers');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
