@extends('layouts.app')
@section('main-content')

@if(!empty($contact))
<x-contact-detail :contact="$contact" />
@endif

@endsection