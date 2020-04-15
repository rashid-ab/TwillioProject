<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('avatar',1000)->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('verify_code')->nullable();
            $table->string('verify_status')->default(0);
            $values=array(1,0);
            $table->enum('status',$values);
            $table->string('device_token')->nullable();
            $table->enum('delete_status',$values);
            $values=array('super','admin','user');
            $table->enum('roles',$values)->nullable();
            $table->string('social_token')->nullable();
            $table->string('app_token')->nullable();
            $table->string('social_name')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
