<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type', 'avatar', 'inscription_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groups() {
        return $this->belongsToMany('App\Group', 'access_to', 'user_id', 'group_id')->withPivot('name', 'created_by')->withTimestamps();
    }

    public function rolloflists()
    {
        return $this->hasMany('App\RollOfList');
    }

    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    public function exams()
    {
        return $this->hasMany('App\Exam');
    }

    public function favorites()
    {
        return $this->hasMany('App\Favorite');
    }

    public function modules()
    {
        return $this->hasMany('App\Module');
    }

    public function schoolcycles()
    {
        return $this->hasMany('App\SchoolCycle');
    }

    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
    
    public function inscription() {
        return $this->belongsTo('App\Inscription', 'inscription_id');
    }
}
