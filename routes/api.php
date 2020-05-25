<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your Api!
|
*/

Route::group(['prefix' => 'v1'], function(){
    //Route::post('login', 'Api\AuthController@login');
    // Route::post('register', 'Api\AuthController@register');

    Route::post('verify-email', 'Api\AuthController@checkEmail');
    Route::post('confirm-password', 'Api\AuthController@confirmPassword');

    // Send reset password mail
    Route::post('/sendPasswordResetLink', 'Api\ResetPasswordController@sendEmail');
    
    // handle reset password form process
    Route::post('/settings/resetPassword', 'Api\ChangePasswordController@process');

    /*
    |-------------------------------------------------------------------------------
    | Search Verified jobs
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs
    | Controller:     Api\PublicJobController@search
    | Method:         GET
    | Description:    Search verified jobs in the application
    */
    Route::get('/jobs/search', 'Api\PublicJobController@search');

    /*
    |-------------------------------------------------------------------------------
    | Get single job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/job/{id}
    | Controller:     Api\PublicJobController@show
    | Method:         GET
    | Description:    Fetch single job from db
    */
    Route::get('/jobs/job/{id}', 'Api\PublicJobController@show');

    /*
    |-------------------------------------------------------------------------------
    | Post a job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/job
    | Controller:     Api\PublicJobController@store
    | Method:         POST
    | Description:    Submit a job into the db
    */
    Route::post('/jobs/job', 'Api\PublicJobController@store');

    /*
    |-------------------------------------------------------------------------------
    | Search for a Company
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/companies/search
    | Controller:     Api\CompanyController@companySearch
    | Method:         GET
    | Description:    Search company
    */
    Route::get('/companies/search', 'Api\CompanyController@companySearch');

    
    Route::group(['middleware' => ['auth:api']], function() {
       
        Route::get('getUser', 'Api\AuthController@getUser');

        /*
        |-------------------------------------------------------------------------------
        | Fetches the authenticated Users detals to edit
        |-------------------------------------------------------------------------------
        | URL:            /api/v1/users/{id}/editSelf
        | Controller:     Api\UserController@editSelf
        | Method:         POST
        | Description:    Gets the authenticated users details from the db to edit
        */
        Route::get('users/{id}/editSelf', 'Api\UserController@editSelf');

        Route::group(['middleware' => ['user.profile']], function() {
            /*
            |-------------------------------------------------------------------------------
            | Updates An Individual User
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/users/{id}
            | Controller:     Api\UserController@update
            | Method:         PUT
            | Description:    Updates an individual user
            */
            Route::put('/users/{id}/update', 'Api\UserController@update');
        });

        
        Route::group(['middleware' => ['admin']], function() {
            /*
            |-------------------------------------------------------------------------------
            | Mark notification as read
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/notifications/mark-as-read/{id}
            | Controller:     API\NotificationsController@markAsRead
            | Method:         GET
            | Description:    Removes notification after reading
            */
            Route::get('/notifications/mark-as-read/{id}', 'API\NotificationController@markNotificationAsRead');

            /*
            |-------------------------------------------------------------------------------
            | Adds a New Post
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobs
            | Controller:     Api\JobController@create
            | Method:         POST
            | Description:    Adds a new job to the application
            */
            Route::post('/jobs', 'Api\JobController@create');

            /*
            |-------------------------------------------------------------------------------
            | Get All Verified jobs
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobs/verified
            | Controller:     Api\JobController@index
            | Method:         GET
            | Description:    Gets all the verified jobs in the application
            */
            Route::get('/jobs/verified', 'Api\JobController@index');

            /*
            |-------------------------------------------------------------------------------
            | Get All jobs
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobs/unverified
            | Controller:     Api\JobController@drafts
            | Method:         GET
            | Description:    Gets all of the jobs in the application
            */
            Route::get('/jobs/unverified', 'Api\JobController@drafts');

            /*
            |-------------------------------------------------------------------------------
            | Get An Individual Post
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobs/{id}/edit
            | Controller:     Api\JobController@edit
            | Method:         GET
            | Description:    Gets an individual job
            */
            Route::get('/jobs/{id}/edit', 'Api\JobController@edit');

            /*
            |-------------------------------------------------------------------------------
            | Updates a Post
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobs/{job}
            | Controller:     Api\JobController@update
            | Method:         PUT
            | Description:    Updates a job
            */
            Route::put('/jobs/{job}/update', 'Api\JobController@update');

            /*
            |-------------------------------------------------------------------------------
            | Verify An Individual Job
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobs/{job}/verify
            | Controller:     Api\JobController@verify
            | Method:         PUT
            | Description:    Verify job
            */
            Route::put('/jobs/{id}/verify', 'Api\jobController@verify');

            /*
            |-------------------------------------------------------------------------------
            | Deletes A Post
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobs/{job}
            | Controller:     Api\JobController@delete
            | Method:         DELETE
            | Description:    Deletes a job
            */
            Route::delete('/jobs/{job}/delete', 'Api\JobController@delete');
            
            /*
            |-------------------------------------------------------------------------------
            | Get All Companies
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/companies
            | Controller:     Api\CompanyController@index
            | Method:         GET
            | Description:    Gets all of the companies in the application
            */
            Route::get('/companies', 'Api\CompanyController@index');

            /*
            |-------------------------------------------------------------------------------
            | Adds a New Company
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/companies
            | Controller:     Api\CompaniesController@create
            | Method:         POST
            | Description:    Adds a new company to the application
            */
            Route::post('/companies', 'Api\CompanyController@create');

            /*
            |-------------------------------------------------------------------------------
            | Updates An Individual Company
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/companies/{id}/update
            | Controller:     Api\CompanyController@update
            | Method:         PUT
            | Description:    Updates an individual company
            */
            Route::put('/companies/{id}/update', 'Api\CompanyController@update');

            /*
            |-------------------------------------------------------------------------------
            | Deletes An Individual Company
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/companies/{id}/delete
            | Controller:     Api\CompanyController@delete
            | Method:         DELETE
            | Description:    Deletes an individual company
            */
            Route::delete('/companies/{id}/delete', 'Api\CompanyController@delete');

            /*
            |-------------------------------------------------------------------------------
            | Get All Industries
            |-------------------------------------------------------------------------------
            | URL:            /Api/v1/industries
            | Controller:     Api\IndustryController@index
            | Method:         GET
            | Description:    Gets all of the industries in the application
            */
            Route::get('/industries', 'Api\IndustryController@index');

            /*
            |-------------------------------------------------------------------------------
            | Adds a New Industry
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/industries
            | Controller:     Api\IndustryController@create
            | Method:         POST
            | Description:    Adds a new industry to the application
            */
            Route::post('/industries', 'Api\IndustryController@create');

            /*
            |-------------------------------------------------------------------------------
            | Updates An Individual Industry
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/industries/{id}
            | Controller:     Api\IndustryController@update
            | Method:         PUT
            | Description:    Updates an individual industry
            */
            Route::put('/industries/{id}/update', 'Api\IndustryController@update');

            /*
            |-------------------------------------------------------------------------------
            | Deletes An Individual Industry
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/industries/{id}/delete
            | Controller:     Api\IndustryController@delete
            | Method:         DELETE
            | Description:    Deletes an individual industry
            */
            Route::delete('/industries/{id}/delete', 'Api\IndustryController@delete');

            /*
            |-------------------------------------------------------------------------------
            | Get All Job types
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobtypes
            | Controller:     Api\JobTypeController@index
            | Method:         GET
            | Description:    Gets all of the job types in the application
            */
            Route::get('/jobtypes', 'Api\JobTypeController@index');

            /*
            |-------------------------------------------------------------------------------
            | Adds a New Job type
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobtypes
            | Controller:     Api\JobTypeController@create
            | Method:         POST
            | Description:    Adds a new job type to the application
            */
            Route::post('/jobtypes', 'Api\JobTypeController@create');

            /*
            |-------------------------------------------------------------------------------
            | Updates An Individual Job type
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobtypes/{id}/update
            | Controller:     Api\JobTypeController@update
            | Method:         PUT
            | Description:    Updates an individual job type
            */
            Route::put('/jobtypes/{id}/update', 'Api\JobTypeController@update');

            /*
            |-------------------------------------------------------------------------------
            | Deletes An Individual Job type
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobtypes/{id}/delete
            | Controller:     Api\JobTypeController@delete
            | Method:         DELETE
            | Description:    Deletes an individual job type
            */
            Route::delete('/jobtypes/{id}/delete', 'Api\JobTypeController@delete');

            /*
            |-------------------------------------------------------------------------------
            | Search for a Job Type
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobtypes/search
            | Controller:     Api\JobTypeController@jobTypeSearch
            | Method:         GET
            | Description:    Search job type
            */
            Route::get('/jobtypes/search', 'Api\JobTypeController@jobTypeSearch');

            /*
            |-------------------------------------------------------------------------------
            | Get All Job fields
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobfields
            | Controller:     Api\JobFieldController@index
            | Method:         GET
            | Description:    Gets all of the job fields in the application
            */
            Route::get('/jobfields', 'Api\JobFieldController@index');

            /*
            |-------------------------------------------------------------------------------
            | Adds a New Job field
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobfields
            | Controller:     Api\JobFieldController@create
            | Method:         POST
            | Description:    Adds a new job field to the application
            */
            Route::post('/jobfields', 'Api\JobFieldController@create');

            /*
            |-------------------------------------------------------------------------------
            | Updates An Individual Job field
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobfields/{id}/update
            | Controller:     Api\JobFieldController@update
            | Method:         PUT
            | Description:    Updates an individual job field
            */
            Route::put('/jobfields/{id}/update', 'Api\JobFieldController@update');

            /*
            |-------------------------------------------------------------------------------
            | Deletes An Individual Job field
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobfields/{id}/delete
            | Controller:     Api\JobFieldController@delete
            | Method:         DELETE
            | Description:    Deletes an individual job field
            */
            Route::delete('/jobfields/{id}/delete', 'Api\JobFieldController@delete');

            /*
            |-------------------------------------------------------------------------------
            | Search for a Job Field
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/jobfields/search
            | Controller:     Api\JobFieldController@jobFieldSearch
            | Method:         GET
            | Description:    Search job field
            */
            Route::get('/jobfields/search', 'Api\JobFieldController@jobFieldSearch');
        });

        Route::group(['middleware' => ['admin.super']], function() {
            /*
            |-------------------------------------------------------------------------------
            | Get All Users
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/users
            | Controller:     API\AdminUsersController@index
            | Method:         GET
            | Description:    Gets all of the users in the application
            */
            Route::get('users', 'Api\UserController@index');

            /*
            |-------------------------------------------------------------------------------
            | Adds a New User
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/users
            | Controller:     API\UserController@create
            | Method:         POST
            | Description:    Adds a new user to the application
            */
            Route::post('/users', 'Api\UserController@create');

            /*
            |-------------------------------------------------------------------------------
            | Fetches a User
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/users/{id}/show
            | Controller:     Api\UserController@show
            | Method:         POST
            | Description:    Gets a user from the db
            */
            Route::get('users/{id}/show', 'Api\UserController@show');

            /*
            |-------------------------------------------------------------------------------
            | Fetches a User to edit
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/users/{id}/edit
            | Controller:     Api\UserController@edit
            | Method:         POST
            | Description:    Gets a user from the db to edit
            */
            Route::get('users/{id}/edit', 'Api\UserController@edit');

            /*
            |-------------------------------------------------------------------------------
            | Deletes A User
            |-------------------------------------------------------------------------------
            | URL:            /api/v1/users/{id}/delete
            | Controller:     Api\UserController@destroy
            | Method:         DELETE
            | Description:    Deletes a user
            */
            Route::delete('/users/{id}/delete', 'Api\UserController@destroy');
        });
    });
});