<?php

namespace App;

use App\Model\User\Answer;
use App\Model\User\Question;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $appends = ['url', 'avatar'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions(){

        return $this->hasMany(Question::class);

    }

    public function favorites(){

        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    public function votesAnswers(){

        return $this->morphedByMany(Answer::class,  'votable')->withTimestamps();

    }

    public function votesQuestions(){

        return $this->morphedByMany(Question::class,  'votable')->withTimestamps();

    }

    public function getUrlAttribute(){

        return '#';
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }
}
