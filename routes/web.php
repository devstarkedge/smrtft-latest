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

//Route::get('/', function () {
//    return view('home');
//})->name('home');
Route::get('/', 'Auth\LoginController@index')->name('home');
//Auth Routes
//Auth::routes(['verify' => true]);
//Route::resource('register', 'Auth\RegisterController');
Route::get('searchScholarships', 'HomeController@searchScholarships')->name('search.scholarships');
Route::get('register', 'Auth\RegisterController@index')->name('register.index');
Route::post('start-your-application', 'Auth\RegisterController@store')->name('register.store');
Route::get('thank-you', 'Auth\RegisterController@showThankYouPage')->name('thankyou');
Route::get('login', 'Auth\LoginController@index')->name('login');
Route::post('login', 'Auth\LoginController@authenticate')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');
Route::get('earlyaccess', 'Auth\PasswordController@showAccessCodeForm')->name('early.access');
Route::get('earlyaccess_signup', 'Auth\PasswordController@showGeneratePasswordForm')->name('password.generate.get');
Route::put('earlyaccess_signup', 'Auth\PasswordController@update_user_password')->name('password.generate.post');
Route::get('sponser_scholarships_details/{random_token}', 'HomeController@sponserScholarshipsDetails')->name('home.sponser_scholarships.details');
//footer routes
Route::get('faqs', 'HomeController@getAllFaqs')->name('home.faqs.index');
Route::get('contact-us', 'HomeController@contactUs')->name('home.contact');
Route::get('privacy-policy', 'HomeController@privacyPolicy')->name('home.privacy.policy');
Route::get('terms-conditions', 'HomeController@termsConditions')->name('home.terms.conditions');
Route::get('success-stories', 'HomeController@successStories')->name('home.success.stories');
Route::get('student-success', 'HomeController@studentSuccess')->name('home.student.success');
Route::get('about-us', 'HomeController@about')->name('home.about');
Route::get('fraud-alert', 'HomeController@fraudAlert')->name('home.fraud.alert');
Route::get('unauthorized', 'HomeController@unauthorized')->name('home.401');
Route::post('contact_us', 'HomeController@contactUsSubmit')->name('home.contact_us.submit');
Route::get('all-scholarships', 'HomeController@allScholarships')->name('home.all_scholarships');


//Reset Password Routes
Route::group(['prefix' => 'password'], function () {
    Route::get('email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.email');
    Route::post('email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.send');
    Route::get('reset', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('reset', 'Auth\ResetPasswordController@reset')->name('password.store');
});

//Routes after successfull login
Route::group(['middleware' => ['auth']], function () {
    Route::get('account', 'UserController@show')->name('user.profile');
    Route::post('account', 'UserController@update')->name('user.profile.update');
    Route::group(['prefix' => 'account'], function () {
        Route::get('security', 'UserController@changePasswordForm')->name('change.password.show');
        Route::put('security', 'UserController@changeUserPasword')->name('change.password');
    });

    Route::get('user/dashboard', 'UserController@index')->name('user.dashboard');
    Route::get('user/all-scholarships', 'UserController@userAllScholarships')->name('user.all_scholarships');
    Route::post('apply_scholarship', 'UserController@applyScholarship')->name('apply.scholarship');
    Route::post('cancel_scholarship', 'UserController@cancelScholarship')->name('cancel.scholarship');
    Route::get('my_applications', 'User\ApplicationController@index')->name('user.applications');
    Route::get('user/scholarship_details/{scholarship_id}', 'UserController@scholarshipDetails')->name('user.scholarship.details');
    Route::get('user/scholarship_question__details/{scholarship_id}', 'UserController@scholarshipQuestionDetails')->name('user.scholarship.question.details');
     Route::post('user_apply_scholarship', 'UserController@userApplyScholarship')->name('user.apply.scholarship');
    Route::get('my_all_applications', 'User\ApplicationController@myAllApplications')->name('user.all.applications');   
    Route::get('membership', 'User\ApplicationController@getPlans')->name('membership.plans');
    Route::get('membership/success', 'User\ApplicationController@planSuccess')->name('membership.success');
    Route::get('membership/failure', 'User\ApplicationController@planFailure')->name('membership.failure');
    Route::post('payment_callback', 'UserController@makeTransaction')->name('payment.callback');

    //partner routes
    Route::resource('partner/scholarships', 'Partner\ScholarshipController')->middleware('role:Partner');
    Route::get('partner/dashboard/{active?}', 'PartnerController@index')->name('partner.dashboard')->middleware('role:Partner');
    Route::get('partner/profile', 'PartnerController@showProfile')->name('partner.profile')->middleware('role:Partner');
});

//partner routes
Route::group(['middleware' => ['auth','role:Partner']], function () {
    Route::resource('partner/scholarships', 'Partner\ScholarshipController');
    Route::get('partner/dashboard/{active?}', 'PartnerController@index')->name('partner.dashboard');
    Route::get('partners/users_list', 'Partner\DashboardController@index')->name('partner.users_list');
    Route::get('partner/user_application_details/{user_scholarship_id}', 'Partner\DashboardController@userApplicationDetails')->name('partner.application.details');
    Route::post('partners/approve_scholarship', 'Partner\DashboardController@approveScholarship')->name('partner.scholarship.approve');
    
});

//Admin routes
Route::group(['middleware' => ['auth', 'role:Administrator,SubAdmin'], 'prefix' => 'admin'], function () {
    Route::get('dashboard', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('category/create', 'Admin\AdminController@createCategory')->name('admin.category.create');
    Route::post('category/save', 'Admin\AdminController@saveCreateCategory')->name('admin.category.save');
    Route::get('subcategorylist', 'Admin\AdminController@subCategoryList')->name('admin.subcategory.list');
    Route::get('subcategory/create', 'Admin\AdminController@createSubCategory')->name('admin.subcategory.create');
    Route::post('subcategory/save', 'Admin\AdminController@saveSubCreateCategory')->name('admin.subcategory.save');
    Route::get('trainerlist', 'Admin\AdminController@trainerList')->name('admin.trainer.list');
    Route::get('trainer/create', 'Admin\AdminController@createTrainer')->name('admin.trainer.create');
    Route::post('trainer/save', 'Admin\AdminController@saveTrainer')->name('admin.trainer.save');
    Route::get('trainer/edit/{id}', 'Admin\AdminController@editTrainer')->name('admin.trainer.edit');
    Route::post('trainer/update/{id}', 'Admin\AdminController@updateTrainer')->name('admin.trainer.update');
    Route::get('trainer/delete/{id}', 'Admin\AdminController@deleteTrainer')->name('admin.trainer.delete');
    Route::get('workoutlist', 'Admin\AdminController@workoutList')->name('admin.workout.list');
    Route::get('workout/create', 'Admin\AdminController@createWorkout')->name('admin.workout.create');
    Route::post('workout/save', 'Admin\AdminController@saveWorkout')->name('admin.workout.save');
     Route::post('workoutindexupdate', 'Admin\AdminController@workoutIndexUpdate')->name('admin.workout.index.update');
    Route::get('workout/edit/{id}', 'Admin\AdminController@editWorkout')->name('admin.workout.edit');
    Route::post('workout/update/{id}', 'Admin\AdminController@updateWorkout')->name('admin.workout.update');
    Route::get('programlist', 'Admin\AdminController@programList')->name('admin.program.list');
    Route::get('program/create', 'Admin\AdminController@createProgram')->name('admin.program.create');
    Route::post('program/save', 'Admin\AdminController@saveProgram')->name('admin.program.save');
    Route::get('program/edit/{id}', 'Admin\AdminController@editProgram')->name('admin.program.edit');
    Route::post('program/update/{id}', 'Admin\AdminController@updateProgram')->name('admin.program.update');
    Route::get('user/create', 'Admin\AdminController@createUser')->name('admin.user.create');
    Route::post('user/save', 'Admin\AdminController@saveUser')->name('admin.user.save');
    
    Route::get('userlist', 'Admin\AdminController@userList')->name('admin.user.list');
    Route::get('user/edit/{id}', 'Admin\AdminController@editUser')->name('admin.user.edit');
    Route::post('user/update/{id}','Admin\AdminController@updateUser')->name('admin.user.update');

    Route::get('profile', 'Admin\AdminController@showProfile')->name('admin.profile.show');
    Route::post('profileupdate', 'Admin\AdminController@profileUpdate')->name('admin.profile.update');
    Route::get('trainerworkoutlist','Admin\AdminController@trainerWorkoutList')->name('admin.trainerworkout.list');
    Route::get('trainer/workoutlist/{id}', 'Admin\AdminController@trainerWorkouts')->name('admin.trainer.workout.list');
    Route::get('trainerprogramlist','Admin\AdminController@trainerProgramList')->name('admin.trainerprogram.list');
    Route::get('trainer/programlist/{id}', 'Admin\AdminController@trainerPrograms')->name('admin.trainer.program.list');
    Route::get('trainer/programdetails/{id}', 'Admin\AdminController@trainerProgramDetails')->name('admin.trainer.program.details');
    Route::get('trainer/addprogramdetails/{id}', 'Admin\AdminController@addProgramDetails')->name('admin.trainer.addprogram.details');
    Route::post('trainer/saveprogramdetails/{id}', 'Admin\AdminController@saveProgramDetails')->name('admin.trainer.saveprogram.details');
     Route::get('trainer/editprogramdetails/{id}', 'Admin\AdminController@editProgramdetails')->name('admin.trainer.edit.details');
    Route::post('trainer/updateProgramDetails/{id}','Admin\AdminController@updateProgramDetails')->name('admin.trainer.updateprogram.details');
    Route::get('nutritionlist', 'Admin\AdminController@nutritionList')->name('admin.nutrition.list');
    Route::get('nutrition/create', 'Admin\AdminController@createNutrition')->name('admin.nutrition.create');
    Route::post('nutrition/save', 'Admin\AdminController@saveNutrition')->name('admin.nutrition.save');
    Route::get('nutrition/edit/{id}', 'Admin\AdminController@editNutrition')->name('admin.nutrition.edit');
    Route::post('nutrition/update/{id}','Admin\AdminController@updateNutrition')->name('admin.nutrition.update');
    Route::get('signup-user-list', 'Admin\AdminController@signupUserList')->name('admin.signup.user.list');
    Route::get('approve_user/{id}', 'Admin\AdminController@approveUser')->name('admin.user.approve');
    Route::get('reject_user/{id}', 'Admin\AdminController@rejectUser')->name('admin.user.reject');
     Route::get('workout/exercises/{id}', 'Admin\AdminController@workoutExercises')->name('admin.workout.exercises');
    Route::get('workout/addexercises/{id}', 'Admin\AdminController@addExercises')->name('admin.workout.addexerxcises');
    Route::post('workout/saveExercises/{id}', 'Admin\AdminController@saveExercises')->name('admin.workout.saveexercises');
     Route::get('workout/editexercises/{id}', 'Admin\AdminController@editExercises')->name('admin.workout.edit.exercises');
    Route::post('workout/updateexercises/{id}','Admin\AdminController@updateExercises')->name('admin.workout.updateexercises');

    // old api
    
    Route::get('approve_scholarship/{scholarship_id}', 'Admin\AdminController@approveScholarship')->name('admin.scholarship.approve');
    Route::get('decline_scholarship/{scholarship_id}', 'Admin\AdminController@declineScholarship')->name('admin.scholarship.decline');
    Route::get('active_scholarships', 'Admin\AdminController@activeScholarships')->name('admin.active.scholarship');
    Route::get('user_applications', 'Admin\AdminController@userScholarshipApplications')->name('admin.user_applications');
    Route::resource('plans', 'Admin\PlanController');
    Route::resource('faqs', 'Admin\FrequentlyAskedQuesntionController');
    Route::get('settings', 'Admin\SettingController@index')->name('admin.settings.index');
    Route::get('settings/create', 'Admin\SettingController@create')->name('admin.settings.create');
    Route::post('settings', 'Admin\SettingController@store')->name('admin.settings.store');
    Route::get('settings/{id}', 'Admin\SettingController@edit')->name('admin.settings.edit');
    Route::put('settings/{id}', 'Admin\SettingController@update')->name('admin.settings.update');
    Route::get('users', 'Admin\UserController@index')->name('admin.users.index');
    Route::get('users/create', 'Admin\UserController@create')->name('admin.users.create');
    Route::post('users/save', 'Admin\UserController@save')->name('admin.users.store');
    Route::get('users/edit/{id}', 'Admin\UserController@edit')->name('admin.users.edit');
    Route::put('users/update/{id}', 'Admin\UserController@update')->name('admin.users.update');
    Route::delete('users/destroy/{id}', 'Admin\UserController@destroy')->name('admin.users.destroy');
});

//commands
Route::get('seed', function () {
    Artisan::call('db:seed');
    dd('done');
});
Route::get('migrate', function () {
    Artisan::call('migrate:fresh');
    dd('done');
});
Route::get('clear-cache', function () {
    Artisan::call('config:cache');
    dd('done');
});

