<?php

namespace App\Model\User;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use VotableTrait;

    public $with = ['user'];

    protected $appends = ['url', 'body_html', 'created_date', 'is_up_voted','is_down_voted', 'status', 'excerpt', 'is_favorited', 'favorites_counts', 'can_edit', 'can_delete'];

    protected $fillable = [
        'title', 'body'
    ];
    public function user(){

        return $this->belongsTo(User::class);

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

    public  function  answers(){

        return $this->hasMany(Answer::class)->orderBy('votes_count','DESC');

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



    public function isFavorited(){

        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute(){

        return $this->isFavorited();
    }

    public function getFavoritesCountsAttribute(){

        return $this->favorites->count();
    }

    public function excerpts($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getBodyHtmlAttribute(){

        return clean($this->bodyHtml());


    }
    public function getExcerptAttribute(){

        return $this->excerpts(250);
    }



}
