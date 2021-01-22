<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;
//use Illuminate\Database\Eloquent\Model;
use \MongoDB\BSON\ObjectID as MongoId;

class Questions extends Model
{
    //
    protected $collection = 'questions';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

      protected $fillable = [
        'question','study','questionType','answerType','options','follow_up_day',
    ];

    public function addQuestions($data){
		$_iddd = new MongoId($data['study']);
        return self::create([
            'question'=>$data['question'], 
            'study'=>$_iddd, 
            'questionType'=>$data['question_type'], 
            'answerType'=>$data['answer_type'], 
            'options'=>json_encode($data['options']), 
        ]);
    }
}
