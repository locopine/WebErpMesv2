<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodsServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('methods_services', function (Blueprint $table) {
            $table->id();
            $table->string('CODE');
			$table->integer('ORDRE');
			$table->string('LABEL');
			$table->integer('TYPE');
			$table->decimal('HOURLY_RATE', 20, 2);
			$table->decimal('MARGIN', 20, 2);
			$table->string('COLOR');
			$table->string('PICTURE')->nullable();
			$table->string('compannie_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('methods_services');
    }
}
