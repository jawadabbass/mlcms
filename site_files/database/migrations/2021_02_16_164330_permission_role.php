<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PermissionRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {

            $table->id();
            $table->integer('role_id')->nullable()->default(0);
            $table->integer('permission_id')->nullable()->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index('role_id');
            $table->index('permission_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_role');
    }
}
