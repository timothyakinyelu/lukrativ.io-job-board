<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Http\Requests\CompanyRequest;
use App\Company;
use Auth;
use Image;
use Storage;

class CompanyController extends Controller
{
     /*
    |   Creates, Reads, Updates,
    |   Deletes and searches Companies
    |   for users.
    */

    /*
    |-------------------------------------------------------------------------------
    |   Get All companies
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/companies
    |   Method:         GET
    |   Description:    Gets all companies in the application
    */
    public function index() 
    {
        $companies = Company::with('industry')
                    ->withCount('jobs')
                    ->get();
    
        return response()->json($companies);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Create a new company
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/companies
    |   Method:         POST
    |   Description:    Creates a new company in the application
    */
    public function create(CompanyRequest $request) 
    {
        // dd($request->all());
        $company = CompanyService::create($request->all());

        if($request->hasFile('logo')) {
            $featured = $request->file('logo');
            
            $filename = time() . '.' . $featured->getClientOriginalName();
            Image::make($featured)->resize(300, 300)->save( public_path('/uploads/logo/' .$filename ) );
    
            $company->logo = '/uploads/logo/' .$filename;

            $company->save();
        }

        return response()->json([
            'data' => $company,
            'status' => $company ? 'New company created' : 'Unable to create a company'
        ]);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Update a company
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/companies/id
    |   Method:         PUT
    |   Description:    Updates a company in the application
    */
    public function update($id, Request $request) 
    {
        $company = Company::where('id', '=', $id)->first();
        if(Auth::user()->can('update', $company) ) {
            $updatedCompany = CompanyService::update( $company->id, $request->all(), true );

            if($request->hasFile('logo')) {
                $featured = $request->file('logo');
                
                $filename = time() . '.' . $featured->getClientOriginalName();
                Image::make($featured)->resize(300, 300)->save( public_path('/uploads/logo/' .$filename ) );
                $oldPhoto = $company->logo;
        
                $updatedCompany->logo = '/uploads/logo/' .$filename;
    
                $updatedCompany->save();

                $oldPhoto->delete();
                unlink(public_path('/uploads/logo/' .$filename ));
            }

            return response()->json( $updatedCompany, 201 );
        }
        return response()->json('Unable to update company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Delete a company
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/companies/id
    |   Method:         DELETE
    |   Description:    Deletes a company from the application
    */
    public function delete($id) 
    {
        $company = Company::where('id', '=', $id)->first();
        if(Auth::user()->can('delete', $company) ) {
            $company->delete();
            Storage::delete($company->logo);
            
            return response()->json( '', 201 );
        }
        return response()->json('Unable to delete company', 204);
    }

    /*
    |-------------------------------------------------------------------------------
    |   Search for a company
    |-------------------------------------------------------------------------------
    |   URL:            /api/v1/companies/search
    |   Method:         GET
    |   Description:    Searches for a company in the application
    */
    public function companySearch(Request $request, CompanyService $service ) 
    {
        $companies = $service->search($request->all());

        return response()->json(['companies' => $companies]);
    }
}
