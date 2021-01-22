<?php

namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model;
use \MongoDB\BSON\ObjectID as MongoId;
use Hash;

class User extends Model
{
    protected $collection = 'users';
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

      protected $fillable = [
        'userType', 'userId','study', 'pin','options','hashed_password','deviceToken','isSessionCompleted','isReminder'
    ];
    public function createUser($data){
		$_iddd = new MongoId($data['study_id']);
		$laravel_hash=Hash::make($data['password']);
		$finalNodeGeneratedHash = str_replace("$2y$", "$2a$", $laravel_hash);
        return self::create([
            //'token'=>$data['_token'],
			'hashed_password'=>$finalNodeGeneratedHash,
            'userId'=>$data['user_id'],
             //'study'=> new MongoDB\BSON\ObjectId($data['study_id']),
             'study'=>$_iddd,
			 'isSessionCompleted'=>false,
			 'isReminder'=>false,
             'pin'=>$data['password'],
             'options'=>$data['training_option'], 
        ]);
    }


}
