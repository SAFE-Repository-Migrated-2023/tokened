@extends('layouts.app')
@section('main-content')

@if(isset($entry->id))
<div class="font-semibold text-2xl text-gray-700">{{ __('Edit contact') }}</div>
@else
<div class="font-semibold text-2xl text-gray-700">{{ __('Add new contact') }}</div>
@endif

<div class="rounded-xl shadow-md p-4 my-4">
<form method="POST" action="{{ isset($entry->id) ? route('contacts.update', $entry->id) : route('contacts.store') }}" autocomplete="off" enctype="multipart/form-data">
    @csrf
    @if(isset($entry->id))
    @method('PUT')
    @endif
    <div class="grid grid-cols-1 gap-6">
        <div>
            <label class="block text-gray-700">Image</label>
            @if(isset($entry->id) && $entry->img)
            <div class="flex items-center mb-3">
                <div class="mr-6 bg-gray-50 p-2">
                    <img class="rounded w-28 h-auto mb-3" src="{{$entry->image}}" alt="image">
                    <label class="inline-flex items-center" for="delete-image">
                        <input type="checkbox" name="delete-image" id="delete-image" >
                        <span class="ml-2">Delete existing image</span>
                    </label>
                </div>

                <label for="share_image" class="flex items-center cursor-pointer px-5 py-1.5">
                    <div class="relative">
                        <input type="checkbox" name="share[]" id="share_image" value="image" class="sr-only" 
                        @if (in_array('image', old('share[]', $entry->share ?? []))) checked @endif>
                        <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                    </div>
                    <div class="ml-3 text-gray-700 font-medium">Share</div>
                </label>

            </div>
            @endif
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md @error('upload') border-red-600 @enderror">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                        <span>Upload a file</span>
                        <input id="upload" name="upload" type="file" class="sr-only">
                        </label>
                        <p class="pl-1">PNG, JPG up to 10MB</p>
                    </div>
                </div>
            </div>
            @error('upload')
                <span class="text-red-500 font-semibold block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Name --}}
        <div class="flex items-end">
            <label class="flex-grow mr-3">
                <span class="text-gray-700">Name</span>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name', $entry->name ?? null) }}" 
                    class="@error('name') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
                    placeholder="Name" 
                    required 
                    autofocus
                >
                @error('name')
                <span class="text-red-500 font-semibold block">{{ $message }}</span>
                @enderror
            </label> 
            <label for="share_name" class="flex items-center cursor-pointer px-5 py-1.5">
                <div class="relative">
                    <input type="checkbox" name="share[]" id="share_name" value="name" class="sr-only" 
                    @if (in_array('name', old('share[]', $entry->share ?? []))) checked @endif>
                    <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                </div>
                <div class="ml-3 text-gray-700 font-medium">Share</div>
            </label>
        </div>

        {{-- Title --}}
        <div class="flex items-end">
            <label class="flex-grow mr-3">
                <span class="text-gray-700">Title</span>
                <input 
                    type="text" 
                    name="title" 
                    value="{{ old('title', $entry->title ?? null) }}" 
                    class="@error('title') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
                    placeholder="Title"
                >
                @error('title')
                <span class="text-red-500 font-semibold block">{{ $message }}</span>
                @enderror
            </label>
            <label for="share_title" class="flex items-center cursor-pointer px-5 py-1.5">
                <div class="relative">
                    <input type="checkbox" name="share[]" id="share_title" value="title" class="sr-only" 
                    @if (in_array('title', old('share[]', $entry->share ?? []))) checked @endif>
                    <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                </div>
                <div class="ml-3 text-gray-700 font-medium">Share</div>
            </label>
        </div>

        {{-- Company --}}
        {{-- <label class="block">
          <span class="text-gray-700">Company</span>
          <input 
            type="text" 
            name="company" 
            value="{{ old('company', $entry->company ?? null) }}" 
            class="@error('company') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
            placeholder="Company"
        >
        @error('company')
            <span class="text-red-500 font-semibold block">{{ $message }}</span>
        @enderror
        </label> --}}

        {{-- Education --}}
        {{-- <label class="block">
          <span class="text-gray-700">Education</span>
          <input 
            type="text" 
            name="education" 
            value="{{ old('education', $entry->education ?? null) }}" 
            class="@error('education') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
            placeholder="Education"
        >
        @error('education')
            <span class="text-red-500 font-semibold block">{{ $message }}</span>
        @enderror
        </label> --}}

        

        {{-- Contact share toggle --}}
        {{-- <div class="flex items-center justify-center w-full">  
            <label for="share" class="flex items-center cursor-pointer">
              <div class="relative">
                <input type="checkbox" name="share" id="share" class="sr-only" @if (old('share', $entry->share ?? false)) checked @endif >
                <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
              </div>
              <div class="ml-3 text-gray-700 font-medium">Share</div>
            </label>
        </div> --}}

        {{-- <label class="block">
          <span class="text-gray-700">Additional details</span>
          <textarea class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" rows="3"></textarea>
        </label> --}}

        <button type="submit" class="btn btn-primary md:m-auto md:w-1/2">@if(isset($entry->id)) {{ __('Save') }} @else {{ __('Add') }} @endif</button>
    </div>
</form>
</div>

@endsection