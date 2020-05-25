<?php

namespace App\Services;

use Illuminate\Support\Facades\Notification;
use App\Notifications\NewJobNotification;
use Illuminate\Database\Eloquent\RelationNotFoundException;

use App\Job;
use App\User;
use App\Company;
use App\JobType;
use App\JobField;
use Auth;

class JobService{
    public static function create( $data ){
        // Create or update if company already exists

        $job = new Job;

        if(Auth::check()) {
            $job->user_id = Auth::user()->id;
            $job->company_id = $data['company_id'];
            $job->job_type_id = $data['job_type_id'];
            $job->job_field_id = $data['job_field_id'];
            $job->job_title = $data['job_title'];
            $job->slug = $job->job_title;
            $job->job_description = $data['job_description'];
            $job->qualifications = $data['qualifications'];
            $job->competencies = $data['competencies'];
            $job->job_location = $data['job_location'];
            $job->salary = $data['salary'];
            $job->application_email = $data['application_email'];
            $job->application_link = $data['application_link'];
            $job->closing_date = $data['closing_date'];
        } else{
            $job->company_id = $data['company_id'];
            $job->job_type_id = $data['job_type_id'];
            $job->job_field_id = $data['job_field_id'];
            $job->job_title = $data['job_title'];
            $job->slug = $job->job_title;
            $job->job_description = $data['job_description'];
            $job->job_location = $data['job_location'];
            $job->salary = $data['salary'];
            $job->application_email = $data['application_email'];
            $job->application_link = $data['application_link'];
            $job->closing_date = $data['closing_date'];
        }
        

        $job->save();

        try {
            if( $job->user_id) {
                // $user = Auth::user();

                // $user->notify(new newJob($job));
                $users = User::where('id', '!=', $job->user_id)->get();

                $admins = $users->filter(function($user) {
                    return $user->permission == config('constants.ADMIN') || $user->permission == config('constants.SUPER-ADMIN');
                });

                Notification::send($admins, new newJobNotification($job));

                return $job;
            } else {
                $admins = User::all()->filter(function($user) {
                    return $user->permission == config('constants.ADMIN') || $user->permission == config('constants.SUPER-ADMIN');
                });

                // dd(Notification::send($admins, new NewJobNotification($job)));

                return $job;
            }
        } catch(RelationNotFoundException $e) {
            abort(422, 'Job does not contain a user ID');
        } catch(Exception $e) {
            abort(500, 'No users exist');
        }
    }

    public static function update( $id, $data)
    {
        // $company = Company::where( 'id', '=',  )->first();
        // $jobtype = JobType::where( 'id', '=',  )->first();
        // $jobfield = JobField::where( 'id', '=',  )->first();

        $updateJob = Job::find($id );

        if( isset( $data['company_id'] ) ){
            $company = $data['company_id'];
        }else{
            $company = $updateJob->company_id;
        }

        if( isset( $data['job_type_id'] ) ){
            $type = $data['job_type_id'];
        }else{
            $type = $updateJob->job_type_id;
        }

        if( isset( $data['job_field_id'] ) ){
            $field = $data['job_field_id'];
        }else{
            $field = $updateJob->job_field_id;
        }

        if( isset( $data['job_title'] ) ){
            $jobTitle = $data['job_title'];
        }else{
            $jobTitle = $updateJob->job_title;
        }

        if( isset( $data['job_description'] ) ){
            $jobDescription = $data['job_description'];
        }else{
            $jobDescription = $updateJob->job_description;
        }

        if( isset( $data['qualifications'] ) ){
            $qualifications = $data['qualifications'];
        }else{
            $qualifications = $updateJob->qualifications;
        }

        if( isset( $data['competencies'] ) ){
            $competencies = $data['competencies'];
        }else{
            $competencies = $updateJob->competencies;
        }

        if( isset( $data['job_location'] ) ){
            $jobLocation = $data['job_location'];
        }else{
            $jobLocation = $updateJob->job_location;
        }

        if( isset( $data['salary'] ) ){
            $salary = $data['salary'];
        }else{
            $salary = $updateJob->salary;
        }

        if( isset( $data['application_email'] ) ){
            $applicationEmail = $data['application_email'];
        }else{
            $applicationEmail = $updateJob->application_email;
        }

        if( isset( $data['application_link'] ) ){
            $applicationLink = $data['application_link'];
        }else{
            $applicationLink = $updateJob->application_link;
        }

        if( isset( $data['closing_date'] ) ){
            $closingDate = $data['closing_date'];
        }else{
            $closingDate = $updateJob->closing_date;
        }

        if( isset( $data['status'] ) ){
            $status = $data['status'];
        }else{
            $status = $updateJob->status;
        }

        $updateJob->company_id = $company;
        $updateJob->job_type_id = $type;
        $updateJob->job_field_id = $field;
        $updateJob->job_title = $jobTitle;
        $updateJob->slug = $updateJob->job_title;
        $updateJob->job_description = $jobDescription;
        $updateJob->qualifications = $qualifications;
        $updateJob->competencies = $competencies;
        $updateJob->job_location = $jobLocation;
        $updateJob->salary = $salary;
        $updateJob->application_email = $applicationEmail;
        $updateJob->application_link = $applicationLink;
        $updateJob->closing_date = $closingDate;
        $updateJob->status = $status;
        
        $updateJob->save();  

        return $updateJob;
    }
}