<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTLSLOG extends Model
{
    use HasFactory;
    protected $connection = "second_sqlsrv";
    protected $table = "TLSLOG_TBL";
    protected $fillable = [
        'TLSLOG_TSKNO'
    ];
}
