<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[Fillable(['name', 'is_completed'])]
class Task extends Model
{
    
    /** @use HasFactory<\Database\Factories\TestFactory> */
    use HasFactory;
}
