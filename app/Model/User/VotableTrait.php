<?php
/**
 * Created by PhpStorm.
 * User: QUDUS
 * Date: 2/10/2019
 * Time: 11:53 AM
 */

namespace App\Model\User;

trait VotableTrait{

    public  function isUpVoted(){

        return $this->votes()->withPivot('vote')->wherePivot('vote', 1)
            ->wherePivot('user_id', auth()->id())
            ->wherePivot('votable_id', $this->id)->exists();
    }

    public  function isDownVoted(){

        return $this->votes()->withPivot('vote')->wherePivot('vote', -1)
            ->wherePivot('user_id', auth()->id())
            ->wherePivot('votable_id', $this->id)->exists();
    }

    public function getIsUpVotedAttribute(){

        return $this->isUpVoted();

    }

    public function getIsDownVotedAttribute()
    {

        return $this->isDownVoted();

    }

}