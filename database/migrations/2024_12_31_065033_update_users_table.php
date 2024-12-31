<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Remove the existing 'name' column
            $table->dropColumn('name');

            // Add 'first_name' and 'last_name'
            $table->string('first_name')->after('id'); // Add first_name after the id column
            $table->string('last_name')->after('first_name'); // Add last_name after first_name

            // Add 'phone' column after 'email'
            $table->string('phone')->after('email')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the 'name' column
            $table->string('name')->after('id');

            // Remove 'first_name', 'last_name', and 'phone'
            $table->dropColumn(['first_name', 'last_name', 'phone']);
        });
    }
}

