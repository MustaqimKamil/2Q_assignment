<x-layout>
<!-- display resources/views/partials/_hero.blade.php content -->
@include('partials._hero')

<!-- display resources/views/partials/_search.blade.php content -->
@include('partials._search')

    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4
    md:space-y-0 mx-4">

        <!-- display content if $listing is not 0 -->
        @unless (count($listings) == 0)

        @foreach ($listings as $listing)
            <!-- access the resources/views/components/listing-card.blade.php by using <x-"file_name"> , : = for binding, bind 'listing' prop to $listing -->
            <x-listing-card :listing="$listing" />
        @endforeach

        <!-- display content if $listing is 0 -->
        @else
        <p>No listing found</p> 
        @endunless

    </div>

    <div class="mt-6 p-4">
        <!-- links(): create a pagination link for total value in $listings -->
        {{$listings->links()}}
    </div>
</x-layout>