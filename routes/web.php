<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Resources naming method references

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing 

Resources naming method references */

// All listings
// use GET in route '/', run ListingController, find and run 'index' method
Route::get('/', [ListingController::class, 'index']);


/* Instead of this

// use GET in route '/listings/{id}', the id value will be captured and store in $id, run function($id)
Route::get('/listings/{id}', function ($id) {

    // fetched single data from listings DB accessed from "Listing" model that match the $id, store this method inside $listing
    $listing = Listing::find($id);

    if($listing) {
        // rendering resources/views/listing.blade.php, the second argument for passing data to corresponding accessed file
        return view('listing', [
            // store all fetched data inside 'listing' array
            'listing' => $listing
        ]);
    } else {
        abort('404');
    }
    
});

Instead of this

You can use route model binding */

// Show create form
// use GET in route '/listings/create', run ListingController, find and run 'create' method, middleware('middleware_name'): help put authenthication for this page
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// Store listing data
// use POST in route '/', run ListingController, find and run 'store' method, middleware('middleware_name'): help put authenthication for this page
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Show edit form
// use GET in route '/listings/{listing}/edit', run ListingController, find and run 'edit' method, middleware('middleware_name'): help put authenthication for this page
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

// Update listing
// use PUT in route '/listings/{listing}', run ListingController, find and run 'update' method, middleware('middleware_name'): help put authenthication for this page
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete listing
// use DELETE in route '/listings/{listing}', run ListingController, find and run 'destroy' method, middleware('middleware_name'): help put authenthication for this page
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Manage listings
/* use GET in route '/listings/manage', run ListingController, find and run 'manage' method,  */
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Single listing
/* use GET in route '/listings/{listing}', run ListingController, find and run 'show' method,  */
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show register/create form
/* use GET in route '/register', run UserController, find and run 'create' method, middleware('middleware_name'): help put authenthication for this page */
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create new user
/* use POST in route '/users', run UserController, find and run 'store' method,  */
Route::post('/users', [UserController::class, 'store']);

// Log user out
/* use POST in route '/logout', run UserController, find and run 'logout' method, middleware('middleware_name'): help put authenthication for this page */
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show login form
/* use GET in route '/login', run UserController, find and run 'login' method, name('login'): naming this page as 'login', to be used at app/Http/Middleware/Authenticate.php, middleware('middleware_name'): help put authenthication for this page */
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log in user
/* use POST in route '/users/authenticate', run UserController, find and run 'authenticate' method,  */
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

/* You can use route model binding */

/*WEB EXAMPLE
Route::get('/hello', function () {
    return response('<h1>Hello World<h1>', 200) 
    ->header('Content-Type', 'text/plain')
    ->header('foo', 'bar');
});

Route::get('/posts/{id}', function ($id) {
    //ddd($id); (die, dump, debug function)
    return response('Post' . $id);
})->where('id', '[0-9]+');

Route::get('/search', function(Request $request) {
    //dd($request);
    return $request->name . ' ' . $request->age;
}); 
WEB EXAMPLE */