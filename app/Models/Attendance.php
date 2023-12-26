<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table        = 'attendance';

    public $timestamps      = false;

    protected $fillable     = [
        'nip',
        'checked_in',
        'checked_out'
    ];
}