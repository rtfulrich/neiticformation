<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $casts = [
        'full_name' => 'string',
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];
    
    public function formationSession()
    {
        return $this->HasMany(\App\FormationSession::class);
    }

}
