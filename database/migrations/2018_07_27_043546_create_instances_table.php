<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('subject', 255)->default('');
            $table->text('recommendations')->default('')->nullable($value = true);
            $table->decimal('fee', 8, 2)->default(0)->nullable($value = true);
            $table->string('wildcard', 255)->default('')->nullable($value = true);
            $table->string('state', 30)->default('');
            $table->timestamps();
        });

        Schema::table('instances', function($table) {
           $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
       });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instances');
    }
}
