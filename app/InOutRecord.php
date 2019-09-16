<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\InOutRecord
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InOutRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InOutRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\InOutRecord query()
 * @mixin \Eloquent
 */
class InOutRecord extends Model
{
    protected  $table = 'in_out_record';

    public function staff() {
        return $this->belongsTo('App\Staff', 'id_staff', 'id');
    }

    protected $fillable = ['id', 'id_staff', 'in_time', 'out_time'];
}
