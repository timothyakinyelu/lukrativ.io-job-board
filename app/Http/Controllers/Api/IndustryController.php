<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Industry;

class IndustryController extends Controller
{
    /*
    |   Creates, Reads, Updates,
    |   Deletes and searches Industries
    |   for admin users.
    */

    /*
    |-------------------------------------------------------------------------------
    |   Get All industries
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/indutries
    |   Method:         GET
    |   Description:    Gets all industries in the application
    */
    public function index() 
    {
        $industries = Industry::withCount('companies')
                    ->withCount('jobs')
                    ->get();
        
        return response()->json($industries);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Create a new industry
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/industries
    |   Method:         POST
    |   Description:    Creates a new industry in the application
    */
    public function create(Request $request) 
    {
        $industry = new Industry;

        $industry->name = $request->input('name');
        $industry->created_at = Carbon::now()->addMonth();

        $industry->save();

        return response()->json([
            'data' => $industry,
            'status' => $industry ? 'New industry created' : 'Unable to create an industry'
        ]);
        //return response()->json('Unable to create company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Update an industry
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/industries/id
    |   Method:         PUT
    |   Description:    Updates an industry in the application
    */
    public function update($id, Request $request) 
    {
        $industry = Industry::where('id', '=', $id)->first();
        
        $industry->name = $request->input('name');

        $industry->save();

        return response()->json([
            'data' => $industry,
            'status' => $industry ? 'Industry updated' : 'Unable to update industry'
        ]);
    
        //return response()->json('Unable to update company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Delete an industry
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/industries/id
    |   Method:         DELETE
    |   Description:    Deletes an industry from the application
    */
    public function delete($id) 
    {
        $industry = Industry::where('id', '=', $id)->first();
        
        $industry->delete();

        return response()->json([
            'status' => $industry ? 'Industry deleted' : 'Unable to delete industry'
        ]);

        //return response()->json('Unable to delete company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Search for an industry
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/industries/search
    |   Method:         GET
    |   Description:    Searches for an industry in the application
    */
    public function industrySearch(Request $request ) 
    {
        $term = $request->input('search');

        $industries = Industry::where('name', 'LIKE', '%'.$term.'%')->get();

        return response()->json(['industries' => $industries]);
    }
}
