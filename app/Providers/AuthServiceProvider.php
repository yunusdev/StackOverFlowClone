<?php

namespace App\Providers;

use App\Model\User\Answer;
use App\Model\User\Question;
use App\Policies\AnswerPolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
//        'App\Model' => 'App\Policies\ModelPolicy',
        Answer::class => AnswerPolicy::class,
        Question::class => QuestionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::resource('question', 'App\Policies\QuestionPolicy');
//        Gate::resource('answers', 'App\Policies\AnswerPolicy');
//

//        \Gate::define('update_question', function ($user, $question){
//
//            return $user->id == $question->user_id;
//        });
//
//        \Gate::define('delete_question', function ($user, $question){
//
//            return $user->id == $question->user_id;
//        });
    }
}
