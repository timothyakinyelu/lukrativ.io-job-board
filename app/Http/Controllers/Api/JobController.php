<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JobService;
use App\Http\Requests\NewJobRequest;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Exceptions\JobNotFoundException;
use App\Job;
use App\User;
use App\Company;
use Auth;

class JobController extends Controller
{
    /*
    |-------------------------------------------------------------------------------
    | Get All Verified jobs
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs
    | Method:         GET
    | Description:    Gets all the verified jobs in the application
    */
    public function index() {
        $status = 'verified';

        return JobCollection::collection(
            Job::where('status', '=', $status)
            ->orderBy('updated_at', 'DESC')
            ->paginate(10)
        );

    }

    /*
    |-------------------------------------------------------------------------------
    | Get All Unverified Jobs
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/unverified
    | Method:         GET
    | Description:    Gets all the unverified jobs in the application
    */
    public function drafts()
    {
        $status = 'unverified';

        return JobCollection::collection(
            Job::where('status', '=', $status)
            ->orderBy('created_at', 'DESC')
            ->paginate(10)
        );
    }

    /*
    |-------------------------------------------------------------------------------
    | Add a New Job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs
    | Method:         POST
    | Description:    Adds a new job to the application
    */
    public function create(JobService $action, NewJobRequest $request) {

        $job = $action->create($request->all());
    
        if($job) {
            return response()->json([
                'data' => new JobResource($job),
            ], 201);
        } else {
            return response()->json([
                'status' => 'Unable to create job'
            ], 204);
        }
    }

    /*
    |-------------------------------------------------------------------------------
    | Get An Individual Job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/{job}/edit
    | Method:         GET
    | Description:    Gets an individual job
    */
    public function edit($id) {
        

        try {
            $job = Job::with('company')
            ->with('job_type')
            ->with('job_field')
            ->where('id', '=', $id)
            ->first();

            return response()->json( $job );
        } catch(\Exception $e) {
            // report($e);

            return response()->json($e->getMessage);
        }

    }

    /*
    |-------------------------------------------------------------------------------
    | Update A Job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/{job}/edit
    | Method:         PUT
    | Description:    Update an individual job
    */
    public function update(Job $job, Request $request ) {
        if(Auth::user()->can('update', $job) ) {

            $updatedJob = JobService::update( $job->id, $request->all(), true );
       
            return response()->json( new JobResource($updatedJob), 201 );
        }
        return response()->json('Unable to update job', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    | Verify A Job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/{id}/verify
    | Method:         POST
    | Description:    Verify a job
    */
    public function verify($id)
    {
        $verified = 'verified';
        $job = Job::where('id', '=', $id)->first();
        if( Auth::user()->can('update', $job ) ){
            $job->verified_by = Auth::user()->id;
            $job->status = $verified;
            $job->save();

            return response()->json([
                'status' => 'Job has been verified!'
            ]);
        }else{
            return response()->json('Unauthorized', 403);
        }
    }
    
    /*
    |-------------------------------------------------------------------------------
    | Deletes A Job
    |-------------------------------------------------------------------------------
    | URL:            /api/v1/jobs/{job}
    | Method:         DELETE
    | Description:    Deletes a job
    */
	public function delete(Job $job ){
        /*
            Checks if the user can delete the job through
            our JobPolicy.
        */
        if( Auth::user()->can('delete', $job ) ){
            $job->delete();

            return response()->json([
                'status' => 'Job deleted',
                204
            ]);
        }
	}
}
