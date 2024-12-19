<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //Zorg dat alle velden gevuld mogen worden
    protected $fillable = ['title','start_date','end_date','description'];
}
