<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;
//use Illuminate\Database\Eloquent\Model;
use \MongoDB\BSON\ObjectID as MongoId;

class FeedbackQuestion extends Model
{
    protected $collection = 'feedbackquestions';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

      protected $fillable = [
        'question','questionType','answerType','options'
    ];

}
