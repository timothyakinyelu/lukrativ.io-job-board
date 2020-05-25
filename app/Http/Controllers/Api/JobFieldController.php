<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\JobField;

class JobFieldController extends Controller
{
    /*
    |   Creates, Reads, Updates,
    |   Deletes and searches Job fields 
    |   for admin users.
    */

    /*
    |-------------------------------------------------------------------------------
    |   Get All job fields
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobfields
    |   Method:         GET
    |   Description:    Gets all the job fields in the application
    */
    public function index() 
    {
        $jobfields = JobField::withCount('jobs')->get();
        
        return response()->json($jobfields);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Create a new job field
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobfields
    |   Method:         POST
    |   Description:    Creates a new job field in the application
    */
    public function create(Request $request) 
    {
        $jobfield = new JobField;

        $jobfield->name = $request->input('name');
        $jobfield->slug = $jobfield->name;
        $jobfield->created_at = Carbon::now()->addMonth();

        $jobfield->save();

        return response()->json([
            'data' => $jobfield,
            'status' => $jobfield ? 'New job field created' : 'Unable to create a job field'
        ]);
        //return response()->json('Unable to create company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Update a job field
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobfields/id
    |   Method:         PUT
    |   Description:    Updates a job field in the application
    */
    public function update($id, Request $request) 
    {
        $jobfield = JobField::where('id', '=', $id)->first();
        
        $jobfield->name = $request->input('name');
        $jobfield->slug = $request->input('slug');

        $jobfield->save();

        return response()->json([
            'data' => $jobfield,
            'status' => $jobfield ? 'Job field updated' : 'Unable to update job field'
        ]);
    
        //return response()->json('Unable to update company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Delete a job field
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobfields/id
    |   Method:         DELETE
    |   Description:    Deletes a job field from the application
    */
    public function delete($id) 
    {
        $jobfield = JobField::where('id', '=', $id)->first();
        
        $jobfield->delete();

        return response()->json([
            'status' => $jobfield ? 'Job field deleted' : 'Unable to delete job field'
        ]);

        //return response()->json('Unable to delete company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Search for a job field
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/jobfields/search
    |   Method:         GET
    |   Description:    Searches for a job field in the application
    */
    public function jobFieldSearch(Request $request ) 
    {
        $term = $request->input('search');

        // iLIKE works cos postgres
        $jobfields = JobField::where('name', 'iLIKE', '%'.$term.'%')->get();

        return response()->json(['jobfields' => $jobfields]);
    }
}
