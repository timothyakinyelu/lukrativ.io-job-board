<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewJobNotification;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Job;
use App\User;
use App\Company;
use App\JobType;
use App\JobField;

class PublicJobController extends Controller
{
    /*
    |-------------------------------------------------------------------------------
    | Get All Verified jobs
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/
    | Method:         GET
    | Description:    Gets all the verified jobs in the application
    */
    public function search(Request $request) {
        //Regular search function
        // iLIKE works cos postgres

        $keyword = $request->get('keyword');
        $locale = $request->get('locale');

        $s = explode(' ,/+ ', $keyword);
        $status = 'verified';
        
        if(!empty($keyword) && !empty($locale)) {
            $jobs = Job::where(function ($query) use ($s, $locale) {
                $query->where('status', '=', 'verified');
                $query->where('job_location', 'iLIKE', $locale);
                foreach ($s as $value) {
                    $query->where('job_title', 'iLIKE', "%{$value}%");
                    $query->orWhere('updated_at', 'iLIKE', "%{$value}%");
                }
            })
            ->orWhereHas('company', function($q) use ($s, $locale) {
                $q->where('status', '=', 'verified');
                $q->where('job_location', 'iLIKE', $locale);
                foreach ($s as $value) {
                    $q->where('name', 'iLIKE', "%{$value}%");
                }
            })
            ->orWhereHas('job_type', function($q) use ($s, $locale) {
                $q->where('status', '=', 'verified');
                $q->where('job_location', 'iLIKE', $locale);
                foreach ($s as $value) {
                    $q->where('name', 'iLIKE', "%{$value}%");
                }
            })->paginate(20);
        } else if(empty($locale) && !empty($keyword)) {
            $jobs = Job::where('status', $status)
                ->where(function ($query) use ($s) {
                foreach ($s as $value) {
                    $query->where('job_location', 'iLIKE', "%{$value}%"); 
                    $query->orWhere('job_title', 'iLIKE', "%{$value}%");
                }
            })
            ->orWhereHas('company', function($q) use ($s, $status) {
                $q->where('status', $status);
                foreach ($s as $value) {
                    $q->where('name', 'iLIKE', "%{$value}%");
                }
            })
            ->orWhereHas('job_type', function($q) use ($s, $status) {
                $q->where('status', $status);
                foreach ($s as $value) {
                    $q->where('name', 'iLIKE', "%{$value}%");
                }
            })->paginate(20);
        } else if(!empty($locale) && empty($keyword)) {
            $jobs = Job::where('status', $status)
            ->where('job_location', 'iLIKE', "%{$locale}%")
            ->paginate(20);
        } else {
            $jobs = Job::where('status', $status)
            ->orderBy('updated_at', 'DESC')
            ->paginate(20);
        }

        if(count($jobs) > 0) {
            return JobCollection::collection($jobs);
        } else {
            return response()->json([
                'error' => 'No Job matches your criteria!'
            ], 404);
        }
    }

    /*
    |-------------------------------------------------------------------------------
    | Get An Individual Job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/job/{id}
    | Method:         GET
    | Description:    Gets an individual job
    */
    public function show($id)
    {
        $job = Job::find($id);
        
        $related = Job::where('job_field_id', '=', $job->job_field->id)
        ->where('id', '!=', $id)
        ->take(3)
        ->orderBy('id', 'desc')
        ->get();

        return response()->json(
            [
                'data' => new JobResource($job),
                'related' => JobCollection::collection($related)
            ]
        );
    }

    /*
    |-------------------------------------------------------------------------------
    | Post a Job for free
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/job
    | Method:         POST
    | Description:    GSubmit a new job
    */
    public function store(Request $request)
    {
        // Create or update if company already exists
        $company = Company::updateOrCreate([
            //Add unique field combo to match here
            //For example, perhaps you only want one entry per user:
            'name'   => $request->input('name'),
        ],[
            'about' => $request->input('company'),
            'address' => $request->input('address'),
            'website'    => $request->input("website"),
            'contact_number' => $request->input('contact_number')
        ]);

        $request->validate([
            'job_title'=>'required',
            'job_description'=> 'required',
            'job_location' => 'required'
        ]);
        $post = new Job([
            'company_id' => $company->id,
            'job_title' => $request->input('job_title'),
            'job_description'=> $request->get('job_description'),
            'job_location'=> $request->input('job_location'),
            'salary'=> $request->input('salary'),
            'application_email'=> $request->input('application_email'),
            'application_link'=> $request->input('application_link'),
            'closing_date' => $request->input('closing_date')
        ]);
        $post->slug = $post->job_title;
        $post->save();

        if($post) {
            $admins = User::all()->filter(function($user) {
                return $user->permission == config('constants.ADMIN') || $user->permission == config('constants.SUPER-ADMIN');
            });

            Notification::send($admins, new NewJobNotification($post));
            return response()->json([
                'success' => 'Your job has been submitted and pending verification!'
            ], 200);
        } else {
            return response()->json([
                'error' => 'Unable to submit job!'
            ], 500);
        }
        return redirect('jobs.create')->with('success', 'Your Job has been posted');
    }
}
