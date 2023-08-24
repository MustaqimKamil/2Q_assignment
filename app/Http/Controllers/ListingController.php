<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listing
    public function index() {
        // rendering resources/views/listings/index.blade.php, the second argument for passing data to corresponding accessed file
        return view('listings.index', [
            /* store fetched data from listings DB inside "listings" array from "Listing" model, latest(): function that fetch data in latest order, 
            filter(): an array storing value form request(['tag', 'search']), paginate(): function that help pagination process*/
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }
    
    // Show single listing
    /* the {listing} value from routes/web.php will be captured and store in $listing, the Listing inside this (Listing $listing) is accessing app/Model/Listing.php,
    The data in DB that matched with the $listing value will be fetched */
    // *additional note: the value fetch from {listing}(example: listing = 1) will automatically treated as a primary key value in Laravel.
    public function show(Listing $listing) {
        // rendering resources/views/listings/show.blade.php, the second argument for passing data to corresponding accessed file
        return view('listings.show', [
            // store all fetched data inside 'listing' array
            'listing' => $listing
        ]);
    }

    // Show create form
    public function create() {
        // rendering resources/views/listings/create.blade.php, the second argument for passing data to corresponding accessed file
        return view('listings.create');
    }

    // Store listing data
    public function store(Request $request) {

        // Validating the all value store in $request, all validation rule store in an array
        $formFields = $request->validate([
            'title' => 'required',
            // Rule::unique('DB name', 'column_name'): only accept unique value
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        // if 'logo' exist, fetch 'logo' string and store it in storage/app/public/logos 
        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // 'id' value fetch from auth() will be stored in 'user_id'
        $formFields['user_id'] = auth()->id();

        // create a dataset and store in database by "Listing" model, :: is a static method
        Listing::create($formFields);

        // redirect to '/' file with flash message
        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // Show edit form
    public function edit(Listing $listing) {
        // rendering resources/views/listings/edit.blade.php, the second argument for passing data to corresponding accessed file
        return view('listings.edit', ['listing' => $listing]);
    }

    // Update listing data
    public function update(Request $request, Listing $listing) {

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        // Validating the all value store in $request, all validation rule store in an array
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        // if 'logo' exist, fetch 'logo' string and store it in storage/app/public/logos
        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        // update a dataset and store in database by "Listing" model, -> is a regular method
        $listing->update($formFields);

        // back(): redirect to current file with flash message (in this case: resources/views/listings/edit.blade.php)
        return back()->with('message', 'Listing updated successfully!');
    }

    // Delete listing
    public function destroy(Listing $listing) {

        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        // delete(): delete data (in this case: all value inside $listing array)
        $listing->delete();
        
        // rendering resources/views/listings/edit.blade.php, the second argument for passing data to corresponding accessed file
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    // Manage listing
    public function manage() {
        // rendering resources/views/listings/manage.blade.php, the second argument for passing data to corresponding accessed file
        // auth(): access the authentication, user(): access the value carry by 'user' model session, listings(): access listings value from 'user' session , get(): fetch data
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}
?>