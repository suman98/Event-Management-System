<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = ['title','start_date','end_date','description','location_id','user_id'];

    protected $appends = ['event_status'];

    public function getEventStatusAttribute() {
        
        if (strtotime($this->start_date) >= strtotime(date('Y-m-d'))) {
            return '<span class="badge badge-primary">Up Comming</span>';
        }

        if (strtotime($this->start_date) < strtotime(date('Y-m-d'))) {
            return '<span class="badge badge-success">Finished</span>';
        }

        return '';

    }

    public function location() {

        return $this->belongsTo('App\Models\Location');   
    }

    public function user() {

        return $this->belongsTo('App\Models\User');   
    }
}
