@if (Session::has('success'))
<div class="bg-green-200 border-green-500 border-l-4 mb-6 p-4" role="alert">
    <p class="font-bold">Success</p>
    <p>{{ Session::get('success') }}</p>
</div>
@endif

@if (Session::has('error'))
<div class="bg-red-200 border-red-500 border-l-4 mb-6 p-4" role="alert">
    <p class="font-bold">Error</p>
    <p>{{ Session::get('error') }}</p>
</div>
@endif

@if (Session::has('warning'))
<div class="bg-yellow-50 border-l-4 border-yellow-500 text-orange-700 p-4 mb-6" role="alert">
    <p class="font-bold">Warning</p>
    <p>{{ Session::get('warning') }}</p>
</div>
@endif

@if (Session::has('info'))
<div class="bg-blue-50 border-l-4 border-blue-500 text-orange-700 p-4 mb-6" role="alert">
    <p class="font-bold">Info</p>
    <p>{{ Session::get('info') }}</p>
</div>
@endif