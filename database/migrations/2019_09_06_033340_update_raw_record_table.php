<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRawRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('raw_record');
        Schema::create('raw_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('staff_id')->nullable();
            $table->string('staff_name');
            $table->date('date');
            $table->string('class')->nullable();
            $table->string('remarks')->nullable();
            $table->dateTime('start_work_time');
            $table->dateTime('leave_work_time');
            $table->integer('late_to_work_day')->nullable();
            $table->integer('late_to_work_minute')->nullable();
            $table->integer('early_leave_day')->nullable();
            $table->integer('early_leave_minute')->nullable();
            $table->integer('weekday_ot')->nullable();
            $table->integer('weekday_ot_hour')->nullable();
            $table->integer('festival_ot')->nullable();
            $table->integer('festival_ot_hour')->nullable();
            $table->integer('holiday_ot')->nullable();
            $table->integer('holiday_ot_hour')->nullable();
            $table->integer('no_show_day')->nullable();
            $table->integer('annual_leave')->nullable();
            $table->integer('biz_trip_day')->nullable();
            $table->integer('sick_leave')->nullable();
            $table->integer('public_holiday')->nullable();
            $table->integer('others_day')->nullable();
            $table->integer('total_work_hour')->nullable();
            $table->integer('work_day')->nullable();
            $table->integer('actual_work_day')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
