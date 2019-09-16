<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RawRecord
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RawRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RawRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RawRecord query()
 * @mixin \Eloquent
 */
class RawRecord extends Model
{
    protected $table = 'raw_record';

    public $timestamps = false;

    protected $fillable = ['staff_id', 'staff_name', 'date', 'class', 'remarks', 'start_work_time', 'leave_work_time', 'late_to_work_day', 'late_to_work_minute', 'early_leave_day', 'early_leave_minute', 'weekday_ot', 'weekday_ot_hour', 'festival_ot', 'festival_ot_hour', 'holiday_ot', 'holiday_ot_hour', 'no_show_day', 'annual_leave', 'biz_trip_day', 'sick_leave', 'public_holiday', 'others_day', 'total_work_hour', 'work_day', 'actual_work_day'];

}
