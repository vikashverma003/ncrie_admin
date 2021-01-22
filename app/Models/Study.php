<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Study extends Model
{
    protected $collection = 'studies';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    //"condition":"ABM_WITH_WORDS", 
       protected $fillable = [
        'studyId', 'trainingCycle', 'maximumDays','duration',
        'trialCount','durationTraining',
        'trialCountTraining','condition','totalStudyDays','totalExtendedDays'
    ];
    public function createStudy($data){
        return self::create([
            'studyId'=>$data['name'], 
            'trainingCycle'=>(int) $data['training_cycle'],
             'maximumDays'=>(int) $data['maximum_days'],
             'duration'=>(int) $data['assessment_duration'],
            'trialCount'=>(int) $data['assessment_trial_count'],
            'durationTraining'=>(int) $data['training_duration'],
            'trialCountTraining'=>(int) $data['training_trial_count'],
            'totalStudyDays'=>(int) $data['totalStudyDays'],
            'totalExtendedDays'=>(int) $data['totalExtendedDays'],
            'condition'=>$data['condition']
        ]);
    }
}
