<?php

namespace App\Model\User;

use App\User;
use function foo\func;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    use VotableTrait;

    protected $appends = ['created_date', 'is_up_voted','is_down_voted', 'body_html', 'status_best', 'is_best', 'can_accept', 'can_edit', 'can_delete'];

    protected $with = ['question', 'votes', 'user'];

    protected $fillable = [
         'body', 'user_id'
    ];

    public static function boot(){

        parent::boot();

        static::created(function ($answer){

            $answer->question->increment('answers_count');

        });

        static::deleted(function($answer){
            $question = $answer->question;
            $question->decrement('answers_count');
            if ($question->best_answer_id == $answer->id){
                $question->best_answer_id = NULL;
                $question->save();
            }
        });

    }

    public function getCanAcceptAttribute(){

        $user = auth()->user();

        if($user){

            return $user->can('accept', $this);

        }

        return false;
    }

    public function getCanEditAttribute(){

        $user = auth()->user();

        if($user){

            return $user->can('update', $this);

        }

        return false;
    }

    public function getCanDeleteAttribute()
    {

        $user = auth()->user();

        if($user){

            return $user->can('delete', $this);

        }

        return false;


    }
    public function user(){

        return $this->belongsTo(User::class);
    }

    public function question(){

        return $this->belongsTo(Question::class);
    }

    public function votes(){

        return $this->morphToMany(User::class, 'votable')->withTimestamps();

    }

    public function getBodyHtmlAttribute(){

        return clean(\Parsedown::instance()->text($this->body));

    }

    public function getCreatedDateAttribute(){

        return $this->created_at->diffForHumans();
    }

    public function getStatusBestAttribute(){

        return $this->id == $this->question->best_answer_id ? 'vote-accepted' : '';

    }

    public function getIsBestAttribute(){

        return $this->id == $this->question->best_answer_id;

    }



}
