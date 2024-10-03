<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataWON extends Model
{
    use HasFactory;
    protected $connection = "second_sqlsrv";
    protected $table = "TSKH_TBL";
    protected $fillable = [
        'TSKH_TSKNO'
    ];
}
