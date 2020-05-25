<?php

namespace App\Services;

use App\Company;
use App\Industry;
use Auth;
use Storage;

class CompanyService{

    // public static function show($id)
    // {
    //     $company = Company::with('posts')
    //                 ->where('id', '=', $id)
    //                 ->first();
    // }

    public static function create($data) {
        $company = Company::firstOrNew(['name' => $data['name']]);

        $company->user_id = Auth::user()->id;
        $company->industry_id = $data['industry_id'];
        $company->about = $data['about'];
        $company->address = $data['address'];
        $company->company_email = $data['company_email'];
        $company->website = $data['website'];
        $company->twitter_url = $data['twitter_url'];
        $company->facebook_url = $data['facebook_url'];
        $company->linkedin_url = $data['linkedin_url'];
        $company->contact_number = $data['contact_number'];

        

        // if($data['logo']) {
        //     $avatar = $data['logo'];
            
        //     $filename = time() . '.' . $avatar->getClientOriginalExtension();
        //     Image::make($avatar)->resize(300, 300)->save( storage_path('/uploads/' . $filename ) );

        //     $company->logo = $filename;
        //     $company->save();
        // }

        $company->save();

        return $company;
    }

    public static function update($id, $data )
    {
        // Create or update if company already exists
        //dd($data['company_name']);
        // $industry = Industry::where( 'id', '=', $data['industry_id'] )->first();

        $company = Company::find($id);

        if( isset( $data['industry_id'] ) ){
            $industry = $data['industry_id'];
        }else{
            $industry = $company->industry_id;
        }

        if( isset( $data['name'] ) ){
            $name = $data['name'];
        }else{
            $name = $company->name;
        }

        if( isset( $data['about'] ) ){
            $about = $data['about'];
        }else{
            $about = $company->about;
        }

        if( isset( $data['address'] ) ){
            $address = $data['address'];
        }else{
            $address = $company->address;
        }

        if( isset( $data['company_email'] ) ){
            $email = $data['company_email'];
        }else{
            $email = $company->company_email;
        }

        if( isset( $data['website'] ) ){
            $website = $data['website'];
        }else{
            $website = $company->website;
        }

        if( isset( $data['twitter_url'] ) ){
            $twitter = $data['twitter_url'];
        }else{
            $twitter = $company->twitter_url;
        }

        if( isset( $data['facebook_url'] ) ){
            $facebook = $data['facebook_url'];
        }else{
            $facebook =  $company->facebook_url;
        }

        if( isset( $data['linkedin_url'] ) ){
            $linkedin = $data['linkedin_url'];
        }else{
            $linkedin =  $company->linkedin_url;
        }

        if( isset( $data['contact_number'] ) ){
            $contact = $data['contact_number'];
        }else{
            $contact =  $company->contact_number;
        }
        
        $company->industry_id = $industry;
        $company->name = $name;
        $company->about = $about;
        $company->address = $address;
        $company->company_email = $email;
        $company->website = $website;
        $company->twitter_url = $twitter;
        $company->facebook_url = $facebook;
        $company->linkedin_url = $linkedin;
        $company->contact_number = $contact;

        $company->save();

        return $company;
        
    }

    public static function search( $data )
    {
        $term = $data['search'];

        // iLIKE works because postgres
        $companies = Company::where('name', 'iLIKE', '%'.$term.'%')->get();
        return $companies;

        
    }
}