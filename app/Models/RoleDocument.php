<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleDocument extends Model
{
    use HasFactory;

    protected $table = 'role_document';

    protected $fillable = ['role_id', 'document_id'];
}
