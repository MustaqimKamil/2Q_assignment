<?php
// declare class "Listing" belong to App\Models
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// make Listing class can use what Model class have
class Listing extends Model
{
    use HasFactory;

    /* This MAR is not needed if Model::unguard use in app/Providers/AppServiceProvider.php */
    // // handling the mass assignment with mass assignment rule (this occur when trying to insert multiple data into database)
    // protected $fillable = ['title', 'company', 'location', 'website', 'email', 'description' , 'tags'];

    // scopeFilter: filtering on $query using $filters array value
    public function scopeFilter($query, array $filters) {
        // if statement for $filters['tag'] if it is not false
        if($filters['tag'] ?? false) {
            // fetch data from database with WHERE condition
            $query->where('tags', 'like', '%' . request('tag') . '%');
        }

        // if statement for $filters['search'] if it is not false
        if($filters['search'] ?? false) {
            // fetch data from database with WHERE condition
            $query->where('title', 'like', '%' . request('search') . '%')
                  ->orWhere('tags', 'like', '%' . request('search') . '%')
                  ->orWhere('company', 'like', '%' . request('search') . '%')
                  ->orWhere('location', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
        }
    }

    // Relationship to user with it's listing creation
    public function user() {
        return$this->belongsTo(User::class, 'user_id');
    }
}
?>