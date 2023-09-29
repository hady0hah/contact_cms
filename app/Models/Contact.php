<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $table = 'contact';

    protected $fillable = ['first_name','last_name','phone_number','DOT','city'];



    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
