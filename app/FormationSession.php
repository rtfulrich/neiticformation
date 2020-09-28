<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormationSession extends Model
{
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];
    
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

}
