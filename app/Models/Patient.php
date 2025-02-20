<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname', 'mname', 'lname', 'sex', 'bdate', 'civstat', 
        'nlity', 'hadd', 'badd', 'pnum', 'email', 'philnum', 'occup', 'rlgion', 
        'dpcon', 'sdel'
    ];
}
