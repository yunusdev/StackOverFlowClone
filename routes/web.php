<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['namespace'=> 'User'], function (){

    Route::get('/',  'QuestionController@index');

    Route::resource('questions', 'QuestionController')->except('show');

    Route::get('questions/{slug}', 'QuestionController@show')->name('questions.show');

    Route::resource('questions.answers', 'AnswerController')->except(['index', 'show', 'create']);

    Route::post('/answer/{answer}/accept', 'AnswerAcceptController')->name('accept.answer');

    Route::post('/user/{question}/favorite', 'FavoritesController@fav')->name('favorite.question');

    Route::delete('/user/{question}/favorite', 'FavoritesController@unFav')->name('unFavorite.question');

    Route::post('/question/{question}/vote', 'VoteQuestionController@upVoteQuestion')->name('upVote.question');

    Route::post('/question/{question}/unvote', 'VoteQuestionController@downVoteQuestion')->name('downVote.question');

    Route::post('/answer/{answer}/vote', 'VoteAnswerController@upVoteAnswer')->name('upVote.answer');

    Route::post('/answer/{answer}/unvote', 'VoteAnswerController@downVoteAnswer')->name('downVote.answer');

});

