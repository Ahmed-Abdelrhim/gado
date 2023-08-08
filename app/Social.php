<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
	protected $table = 'social_media';
	
	public function CompanySocialmedia()
    {
        return $this->hasMany('Modules\Guide\Entities\Company_Social_media', 'social_id', 'id');
    }
	
}
