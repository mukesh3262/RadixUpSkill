<?php

namespace App\Models;

use App\Traits\Imageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes, Imageable;
    
    protected $table = "company";
    
    protected $fillable = [
        'name',
        'email',
        'website',
        'logo',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
