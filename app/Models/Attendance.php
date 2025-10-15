<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id','check_in','check_out','duration'
        // 2025_10_07_112456_add_geo_to_attendances_table الأعمدة الجديده
        ,'check_in_latitude'
        ,'check_in_longitude'
    ] ;

    //عشان نخليهم وقت (duration)
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    // كل سجل حضور بيرتبط بمستخدم
    public function user() {
        return $this->belongsTo(User::class);
    }    
}
