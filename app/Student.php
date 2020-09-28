<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $fillable = [
        'fname', 'lname', 'birth_date', 'sex', 'family_situation', 'formation_session_id',
    ];
    
    public function formationSession()
    {
        return $this->belongsTo(FormationSession::class);
    }

}
