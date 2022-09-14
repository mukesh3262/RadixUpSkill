<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory, SoftDeletes, Notifiable;
    protected $guarded = [];
    protected $table = "employee";
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'company_id',
    ];

    public function company(){
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

}
