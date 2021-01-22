<?php

namespace App\Models;
//use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use \MongoDB\BSON\ObjectID as MongoId;

class Pattern extends Model
{
    protected $collection = 'patterns';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

      protected $fillable = [
        'word_face_id', 'probe','threat_position','probe_position','isThreatTop'];
    
    public function createPattern($data){
		$_iddd = new MongoId($data['word_face_id']);
        return self::create([
		    'word_face_id'=>$_iddd??null,
            'probe'=>$data['probe']??null,         
            'threat_position'=>$data['threat_position']??null,         
            'probe_position'=>$data['probe_position']??null,         
            'isThreatTop'=>$data['isThreatTop']??null,         
        ]);
    }
}
