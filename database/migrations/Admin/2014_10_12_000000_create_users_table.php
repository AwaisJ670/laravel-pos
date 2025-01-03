<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->id();
            $table->unsignedInteger('role_id')->nullable();
            $table->string('access_key')->unique();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('first_name', 250);
            $table->string('last_name', 250)->nullable();
            $table->date('dob')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->unique();
            $table->boolean('is_active')->default(1);
            $table->string('last_login')->nullable();
            $table->string('last_ip')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();
            $table->string('password');
            $table->string('readable_password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
