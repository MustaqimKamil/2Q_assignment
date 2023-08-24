<!-- card closer -->
<!-- merge([''])= merge attribute in the array form from other file, store it in $attributes,
    the value stated below is for default but new value can be merge from other file spesification -->
<div {{ $attributes->merge(['class' => 'bg-gray-50 border border-gray-200 rounded p-6']) }}>
    <!-- all content located within this card closer store in $slot -->
    {{$slot}}
</div>