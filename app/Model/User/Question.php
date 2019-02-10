<?php

namespace App\Model\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use VotableTrait;

    protected $fillable = [
        'title', 'body'
    ];
    public function user(){

        return $this->belongsTo(User::class);

    }

    public  function  answers(){

        return $this->hasMany(Answer::class);

    }

    public function favorites(){

        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function votes(){

        return $this->morphToMany(User::class, 'votable')->withTimestamps();

    }

    public function acceptBestAnswer(Answer $answer){

        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function setTitleAttribute($value){

        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttribute(){

        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute(){

        return $this->created_at->diffForHumans();

    }

    public function getStatusAttribute(){

        if ($this->answers_count > 0){

            if ($this->best_answer_id){
                return 'answered-accepted';
            }
            return 'answered';
        }

        return 'unanswered';
    }

    public function getBodyHtmlAttribute(){

        return \Parsedown::instance()->text($this->body);

    }

    public function isFavorited(){

        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute(){

        return $this->isFavorited();
    }

    public function getFavoritesCountsAttribute(){

        return $this->favorites->count();
    }


}