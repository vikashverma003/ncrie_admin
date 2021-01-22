<?php

namespace App\Models;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;

class Word extends Model
{
    protected $collection = 'words';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

      protected $fillable = [
        'threat_word', 'neutral_word','threat_faces','neutral_faces','study','arrangements','type','trainingCycle','condition','threat_position','probe','probe_position'
   ,'threat_faces_original', 'threat_faces_thumbnail','neutral_faces_original','neutral_faces_thumbnail','word_face','isThreatTop','isProbeE'];
    
    public function createWord($data){
        return self::create([
		    'word_face'=>$data['word_face']??null,
            'threat_word'=>$data['threat_word']??null,
            'neutral_word'=>$data['neutral_word']??null,
            'type'=>$data['type']??null,
             'condition'=>$data['condition']??null,
            'trainingCycle'=>$data['training_cycle']??null,
			'threat_faces_original'=>$data['threat_faces_original']??null,
			'threat_faces_thumbnail'=>$data['threat_faces_thumbnail']??null,
            'neutral_faces_original'=>$data['neutral_faces_original']??null,
            'neutral_faces_thumbnail'=>$data['neutral_faces_thumbnail']??null,
            'threat_position'=>$data['threat_position']??null,
            'probe'=>$data['probe']??null,
            'probe_position'=>$data['probe_position']??null,
            'isThreatTop'=>$data['isThreatTop']??null,
            'isProbeE'=>$data['isProbeE']??null,
            'threat_faces'=>$data['threat_face_name']??null,
            'neutral_faces'=>$data['neutral_face_name']??null,
        ]);
    }


    public function updateWord($data){
        

        if(empty($data['old_check'])){

            return self::where('threat_word', $data['old_id'])->update([
                'word_face'=>$data['word_face']??null,
                'threat_word'=>$data['threat_word']??null,
                'neutral_word'=>$data['neutral_word']??null,
                'type'=>$data['type']??null,
                 'condition'=>$data['condition']??null,
                'trainingCycle'=>$data['training_cycle']??null,
                // 'threat_faces'=>$data['threat_faces']??null,
                // 'neutral_faces'=>$data['neutral_faces']??null,
                'threat_faces_original'=>$data['threat_faces_original']??null,
                'threat_faces_thumbnail'=>$data['threat_faces_thumbnail']??null,
                'neutral_faces_original'=>$data['neutral_faces_original']??null,
                'neutral_faces_thumbnail'=>$data['neutral_faces_thumbnail']??null,
                
            ]);

        }else{

            return self::where('threat_faces_original', $data['old_id'])->update([
                'word_face'=>$data['word_face']??null,
                'threat_word'=>$data['threat_word']??null,
                'neutral_word'=>$data['neutral_word']??null,
                'type'=>$data['type']??null,
                 'condition'=>$data['condition']??null,
                'trainingCycle'=>$data['training_cycle']??null,
                // 'threat_faces'=>$data['threat_faces']??null,
                // 'neutral_faces'=>$data['neutral_faces']??null,
                'threat_faces_original'=>$data['threat_faces_original']??null,
                'threat_faces_thumbnail'=>$data['threat_faces_thumbnail']??null,
                'neutral_faces_original'=>$data['neutral_faces_original']??null,
                'neutral_faces_thumbnail'=>$data['neutral_faces_thumbnail']??null,
             
            ]);
           
        }
    }

}
