<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->bigInteger('job_type_id')->unsigned()->nullable();
            $table->foreign('job_type_id')->references('id')->on('job_types');
            $table->bigInteger('job_field_id')->unsigned()->nullable();
            $table->foreign('job_field_id')->references('id')->on('job_fields');
            $table->string('job_title');
            $table->string('slug');
            $table->longText('job_description');
            $table->string('job_location');
            $table->string('salary')->nullable();
            $table->string('qualifications')->nullable();
            $table->string('competencies')->nullable();
            $table->string('application_email')->nullable();
            $table->string('application_link')->nullable();
            $table->string('status')->default('unverified');
            $table->integer('verified_by')->nullable();
            $table->date('closing_date');
            $table->softDeletes();
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
        Schema::dropIfExists('jobs');
    }
}
