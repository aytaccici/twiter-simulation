<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('name');
            $table->string('surname');
            $table->string('phone_number',50);
            $table->string('email')->unique();
            $table->string('twitter')->unique();
            $table->integer('twitter_id')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->string('password');
            $table->rememberToken();
            $table->string('api_token', 80)
                ->unique()
                ->nullable();
            $table->string('verification_code', 10)
                ->nullable();
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
