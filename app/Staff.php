<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Staff
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Staff query()
 * @mixin \Eloquent
 */
class Staff extends Model
{
    //
    protected  $table = 'staff_info';

    protected $fillable = ['id_team', 'id_office_hour_type', 'staff_name', 'email'];

    public function workHourType() {
        return $this->hasOne('App\WorkHourType', 'id', 'id_office_hour_type');
    }

    public function inOutRecord() {
        return $this->hasMany('App\InOutRecord', 'id_staff', 'id');
    }

}
