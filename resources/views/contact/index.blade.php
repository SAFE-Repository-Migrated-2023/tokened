@extends('layouts.app')
@section('main-content')

{{-- <div class="mb-10">
    <a href="{{route('contacts.create')}}" class="btn btn-primary">{{ __('Add new contact') }}</a>
</div> --}}

@if(!empty($first))
<x-contact-detail :contact="$first" />
@endif

@if($contacts->isNotEmpty())
<div class="font-semibold mt-10 mb-6 text-2xl text-center text-gray-700">Contacts</div>
<contact-card-list :contacts='@json($contacts)' />
@else
<div>
    No entries
</div>
@endif

@endsection