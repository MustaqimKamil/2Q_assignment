<!-- declare listing as prop, passed array value inside listing, treat as $listing -->
@props(['listing'])

<!-- card closer accessed from resources/views/components/card.blade.php -->
<x-card>
    <div class="flex">
        <!-- asset() = laravel function to generate URL for selected file, if 'logo' value exist, access storage/app/public/logos/(DB value), else access public/images/no-image.png -->
        <img
            class="hidden w-48 mr-6 md:block"
            src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}"
            alt=""
        />
        <div>
            <h3 class="text-2xl">
                <!-- call function from routes/web.php by "Route::get('/listings/{id}')", access DB from app\Models\Listing.php from web.php,
                    fetch data using Listing::find($id) in web.php, store it in 'listing', 
                    display the data by $listing->id and  $listing->title-->
                <a href="/listings/{{$listing->id}}">{{$listing->title}}</a>
            </h3>
            <!-- display the data by $listing->company -->
            <div class="text-xl font-bold mb-4">{{$listing->company}}</div>
            <!-- access the resources/views/components/listing-tags.blade.php by using <x-"file_name"> , : = for binding, bind 'tagsCsv' prop to $tagsCsv -->
            <x-listing-tags :tagsCsv="$listing->tags" />
            <div class="text-lg mt-4">
                <!-- display the data by $listing->location -->
                <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
            </div>
        </div>
    </div>
</x-card>