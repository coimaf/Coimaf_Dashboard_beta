<?php

namespace App\Models;

use App\Models\R4;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TypeR4 extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function r4s()
{
    return $this->hasMany(R4::class);
}

}
