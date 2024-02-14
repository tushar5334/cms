<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->uuid('inquiry_id');
            $table->string('name', 250);
            $table->string('phone', 30);
            $table->string('email', 250);
            $table->string('product_looking_for', 500);
            $table->string('end_use_application', 500);
            $table->string('company_name', 500);
            $table->text('company_address');
            $table->text('additional_remark');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inquiries');
    }
};
