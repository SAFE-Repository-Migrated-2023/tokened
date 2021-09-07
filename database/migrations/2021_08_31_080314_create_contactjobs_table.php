<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactjobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactjobs', function (Blueprint $table) {
            $table->id();
            $table->integer('contact_id')->unsigned()->index();
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('dates')->nullable();
            $table->string('description')->nullable();
            $table->string('certificate', 1024)->nullable();
            $table->string('c_img')->nullable();
            $table->string('c_cat')->nullable();
            $table->string('c_share')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('contact_id')->references('id')->on('contacts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contactjobs');
    }
}
