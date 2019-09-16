<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\WorkHourType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WorkHourType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WorkHourType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\WorkHourType query()
 * @mixin \Eloquent
 */
class WorkHourType extends Model
{
    //
    protected  $table = 'work_hour';

    function staff() {
        $this->belongsTo('App\Staff', 'id_office_hour_type', 'id');
    }
}
