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

Route::get('/',"PageController@index")->name('home');
//Route::get('/login',function);
// user

Route::get('/member/{id}',"PageController@profileUser")->name('profile_user');

// session
Route::get('session/un-question',"PageController@showSessionUnQuestion")->name('un_question');
Route::get('qa/session/check/{id}',"PageController@showCheckPass")->name("check_pass");
Route::get('session/{id}',"PageController@showSession")->name("show_detail_session")->middleware('required_pass:id');
Route::post('add/qa/{id}',"PageController@addQaToSession")->name("add_qa_session");
Route::get('required/qa/{id}',"PageController@requiredPassword")->name('required_password');
Route::post('post-password-required/{id}',"PageController@postRequiredPassword")->name("post_required_password");
Route::get('session/question/{id_question}/{id}',"PageController@showQuestion")->name("show_question");
Route::post('post/comment/{id_question}',"PageController@addCommentToQuestion")->name('add_comment');
Route::post('post/comment/in/{id_question}/{id_comment}',"PageController@addCommentToComment")->name('add_comment_in_comment');
Route::get('like/question/{id_question}',"PageController@likeQuestion")->name('like_question');
Route::get('unlike/question/{id_question}',"PageController@unlikeQuestion")->name('un_like_question');
Route::get('delete/session/{id}',"PageController@deleteSession")->name('delete_session');
Auth::routes();


// create session
Route::post('/session',"PageController@createSession")->name('session');
// Authentication Routes...
Route::get('login', [
    'as' => 'login',
    'uses' => 'Auth\LoginController@showLoginForm'
]);
Route::post('login', [
    'as' => 'post_login',
    'uses' => 'Auth\LoginController@login'
]);
Route::get('logout', [
    'as' => 'logout',
    'uses' => 'Auth\LoginController@logout'
]);

// Password Reset Routes...
Route::post('password/email', [
    'as' => 'password.email',
    'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
    'as' => 'password.request',
    'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
    'as' => 'password.update',
    'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
    'as' => 'password.reset',
    'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...
Route::get('register', [
    'as' => 'register',
    'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
    'as' => 'post_register',
    'uses' => 'Auth\RegisterController@register'
]);
//liem
Route::match(['get', 'post'], '/admin', 'AdminController@login');

Route::group(['middleware' => ['auth']], function ()
{
    Route::get('/admin/dashboard', 'AdminController@dashboard');
    Route::get('/admin/settings', 'AdminController@settings');
    Route::get('/admin/check-pwd', 'AdminController@checkPassword');
    Route::match(['get', 'post'], '/admin/update-pwd', 'AdminController@updatePassword');
    //session language
    Route::get('/lg', function(){
        Session::put('lg', 'vi');
        echo "put session language ok!";
        if(Session::has('lg'))
        {
            echo Session::get("lg");
        }
    });
    Route::get('/admin/language/{lg}', 'AdminController@language');
    //new
    Route::match(['get', 'post'], '/admin/descLevels', 'AdminController@descLevels');
    Route::get('/admin/descLevels/edit/{id}', 'AdminController@editDL');
    Route::post('/admin/descLevels/edited/{id}', 'AdminController@editedDL');

    Route::match(['get', 'post'], '/admin/suggest/{idTemplate}', 'AdminController@suggest');
    Route::get('/admin/editSuggest/{idTemp}/{idLV}', 'AdminController@editSG');
    Route::post('/admin/editedSuggest/{idTemp}/{idLV}', 'AdminController@editedSG');

    Route::match(['get', 'post'], '/admin/methods', 'AdminController@methods');
    Route::get('/admin/methods/edit/{id}', 'AdminController@editMT');
    Route::post('/admin/methods/edited/{id}', 'AdminController@editedMT');

    Route::match(['get', 'post'], '/admin/customers', 'AdminController@customers');
    Route::post('/admin/listCustomer', 'AdminController@listCustomer');
    Route::get('/admin/syllabus/{id}', 'AdminController@syllabus');
    Route::get('/admin/syllabus/ajax/content/{id}','AdminController@getContent');
    Route::get('/admin/customer/delete/{id}', 'AdminController@deleteCustomer');
    Route::get('/admin/add/{id}', 'AdminController@addAdmin');
    Route::get('/admin/editUser/{id}', 'AdminController@editUser');
    Route::post('/admin/editedUser/{id}', 'AdminController@editedUser');
    Route::match(['get', 'post'], '/admin/editConstraintLB', 'AdminController@editConstraintLB');
    Route::match(['get', 'post'], '/admin/editedConstraintLB', 'AdminController@editedConstraintLB');


});
Route::get('/admin/logout', 'AdminController@logout');