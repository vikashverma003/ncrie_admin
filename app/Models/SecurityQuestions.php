<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;
//use Illuminate\Database\Eloquent\Model;

class SecurityQuestions extends Model
{
	protected $collection = 'securityquestions';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

      protected $fillable = [
        'question',
    ];

    public function createQuestions($data){
        return self::create([
            'question'=>$data['question'], 
        ]);
    }
    
}
