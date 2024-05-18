<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;
    protected $table='webinar';
    public $timestamps = true;
    
    public function event(){
        return $this->hasOne("App\Models\Event", 'id', 'event_id');
    }
}
