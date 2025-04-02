<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // 例: どのカラムを一括代入できるか
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'department_id',
        'hire_date',
    ];

    // テーブル名を明示する場合はここで指定
    // protected $table = 'employees';
}