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
use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});


Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::get('login','UserController@index')->name('login');
    Route::post('check_user','UserController@login');

    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard','DashboardController@index');
        Route::get('logout','UserController@logout');
        Route::resource('study','StudyController');
        Route::get('studyData','StudyController@studyData')->name('studyData');
        Route::post('training_cycle','StudyController@training_cycle')->name('training_cycle');

        Route::resource('users','AppUserController');
        Route::get('usersData','AppUserController@usersData')->name('usersData');
        Route::post('change_pin','AppUserController@change_pin')->name('change_pin');
        Route::post('single_user','AppUserController@single_user')->name('single_user');
        Route::post('search_users','AppUserController@search_users')->name('search_users');
        Route::get('download_csv_single_user/{id}','AppUserController@download_csv_single_user');
        Route::get('download_csv_all_user','AppUserController@download_csv_all_user');
	    Route::any('multiple_download_user','AppUserController@multiple_download_user')->name('multiple_download_user');
	   //Route::any('multiple_download_user1/{id}','AppUserController@multiple_download_user1');
       Route::get('multiple_download_user1/{id}/dwn', ['as' => 'multiple_download_user1.dwn', 'uses' => 'AppUserController@multiple_download_user1']);
       Route::get('generate_report/{id}','AppUserController@generate_report');



        Route::resource('words','WordController');
        Route::get('wordData','WordController@wordData')->name('wordData');
        Route::post('upload_words','WordController@upload_words')->name('upload_words');
        Route::post('match_studies','WordController@match_studies')->name('match_studies');
	    Route::get('edit_words/{id}','WordController@edit_words')->name('edit_words');
	    Route::post('update_words','WordController@update_words')->name('update_words');
	    Route::get('delete_words/{id}','WordController@delete_words')->name('delete_words');
		Route::get('download_sample_file','WordController@download_sample_file')->name('download_sample_file');


        Route::resource('questions','SecurityQuestionController');
        Route::post('questions/{id}/update', ['as' => 'questions.update', 'uses' => 'SecurityQuestionController@update']);
        Route::get('questions/{id}/delete', ['as' => 'questions.delete', 'uses' => 'SecurityQuestionController@destroy']);
        Route::resource('new_questions','QuestionController');
        Route::post('update_order','QuestionController@update_order');
        Route::post('add_questionss','QuestionController@add_questions')->name('add_questionss');
        Route::get('all_questions/{id}','QuestionController@all_questions');
        Route::get('edit_question/{id}','QuestionController@edit_question');
        Route::post('update_question/{id}/update','QuestionController@update_question');
        Route::get('new_questions/{id}/delete','QuestionController@destroy');
		Route::get('add_duplicate_question/{id}','QuestionController@add_duplicate_question');

       //Route::post('new_questions/{id}/delete','QuestionController@destroy');

        Route::post('search','QuestionController@searchStudy')->name('search');
		Route::get('add_message','PopUpMessageController@add_message')->name('add_message');
		Route::post('store_message','PopUpMessageController@store_message')->name('store_message');
		Route::get('show_messages','PopUpMessageController@show_messages')->name('show_messages');
		Route::get('edit_message/{id}','PopUpMessageController@edit_message')->name('edit_message');
		Route::post('update_message/{id}','PopUpMessageController@update_message')->name('update_message');
		Route::get('add_question','FeedbackQuestionController@add_question')->name('add_question');
        Route::post('store_question','FeedbackQuestionController@store_question')->name('store_question');
		Route::post('update_question','FeedbackQuestionController@update_question')->name('update_question');
        Route::get('all_feedback_question','FeedbackQuestionController@index')->name('index');
        Route::get('feedback/delete/{id}','FeedbackQuestionController@deleteFeedback');
		Route::get('feedback/edit/{id}','FeedbackQuestionController@editFeedback');






    });
});

