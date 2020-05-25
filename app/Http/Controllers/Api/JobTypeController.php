<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\JobType;

class JobTypeController extends Controller
{
    /*
    |   Creates, Reads, Updates,
    |   Deletes and searches for Job types 
    |   for admin users.
    */

    /*
    |-------------------------------------------------------------------------------
    |   Get All job types
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobtypes
    |   Method:         GET
    |   Description:    Gets all the job types in the application
    */
    public function index() 
    {
        $jobtypes = JobType::withCount('jobs')->get();
        
        return response()->json($jobtypes);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Create a new job type
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobtypes
    |   Method:         POST
    |   Description:    Creates a new job type in the application
    */
    public function create(Request $request) 
    {
        $jobtype = new JobType;

        $jobtype->name = $request->input('name');
        $jobtype->slug = $jobtype->name;
        $jobtype->created_at = Carbon::now()->addMonth();

        $jobtype->save();

        return response()->json([
            'data' => $jobtype,
            'status' => $jobtype ? 'New job type created' : 'Unable to create a job type'
        ]);
        //return response()->json('Unable to create company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Update a job type
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobtypes/id
    |   Method:         PUT
    |   Description:    Updates a job type in the application
    */
    public function update($id, Request $request) 
    {
        $jobtype = JobType::where('id', '=', $id)->first();
        
        $jobtype->name = $request->input('name');
        $jobtype->slug = $jobtype->name;

        $jobtype->save();

        return response()->json([
            'data' => $jobtype,
            'status' => $jobtype ? 'Job type updated' : 'Unable to update job type'
        ]);
    
        //return response()->json('Unable to update company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Delete a job type
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobtypes/id
    |   Method:         DELETE
    |   Description:    Deletes a job type from the application
    */
    public function delete($id) 
    {
        $jobtype = JobType::where('id', '=', $id)->first();
        
        $jobtype->delete();

        return response()->json([
            'status' => $jobtype ? 'Job type deleted' : 'Unable to delete job type'
        ]);

        //return response()->json('Unable to delete company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Search for a job type
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobtypes/search
    |   Method:         GET
    |   Description:    Searches for a job type in the application
    */
    public function jobTypeSearch(Request $request ) 
    {
        $term = $request->input('search');

        // iLIKE works cos postgres
        $jobtypes = JobType::where('name', 'iLIKE', '%'.$term.'%')->get();

        return response()->json(['jobtypes' => $jobtypes]);
    }
}
