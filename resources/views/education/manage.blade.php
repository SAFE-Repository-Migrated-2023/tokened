@extends('layouts.app')
@section('main-content')

@if(isset($entry->id))
<div class="font-semibold text-2xl text-gray-700">{{ __('Edit education') }} for {{$contact->name}}</div>
@else
<div class="font-semibold text-2xl text-gray-700">{{ __('Add new education') }} for {{$contact->name}}</div>
@endif

<div class="rounded-xl shadow-md p-4 my-4">
<form method="POST" action="{{ isset($entry->id) ? route('educations.update', $entry->id) : route('educations.store') }}" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" value="{{$contact->id}}" name="contact_id" />
    @csrf
    @if(isset($entry->id))
    @method('PUT')
    @endif
    <div class="grid grid-cols-1 gap-6">

        {{-- Certificate --}}
        <legend class="text-base font-medium text-gray-900">Certification</legend>
        <label class="block">
            <span class="text-gray-700">Enter Certificate URL or Token</span>
            <input 
            type="text" 
            name="certificate" 
            value="{{ old('certificate', $entry->certificate ?? null) }}" 
            class="@error('certificate') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
            placeholder="Certificate"
        >
        @error('certificate')
            <span class="text-red-500 font-semibold block">{{ $message }}</span>
        @enderror
        </label>
        <div>
            @if(isset($entry->id) && $entry->c_img)
            <div>
                <p>Existing certificate:</p>
                <div class="my-1">
                    <img class="rounded w-28 h-auto mr-6" src="{{$entry->image}}" alt="image">
                </div>
                <label class="inline-flex items-center" for="delete-c_image">
                    <input type="checkbox" name="delete-cert-image" id="delete-c_image" >
                    <span class="ml-2">Delete existing image</span>
                </label>
            </div>
            @endif

            <label class="block text-gray-700">Enter Certificate URL or Token:</label>
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

        <div class="grid md:grid-cols-4 gap-6 mb-6">
            <fieldset>
                <div>
                <legend class="text-base font-medium text-gray-900">Certificate category</legend>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <input id="c_cat1" name="c_cat" type="radio" value="Education" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                        @if (old('c_cat', $entry->c_cat ?? false) == 'Education') checked @endif
                    >
                    <label for="c_cat1" class="ml-3 block text-sm font-medium text-gray-700">Education</label>
                </div>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <input id="c_cat2" name="c_cat" type="radio" value="Employment" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                    @if (old('c_cat', $entry->c_cat ?? false) == 'Employment') checked @endif
                    >
                    <label for="c_cat2" class="ml-3 block text-sm font-medium text-gray-700">Employment</label>
                </div>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <input id="c_cat3" name="c_cat" type="radio" value="Trade Certification" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                    @if (old('c_cat', $entry->c_cat ?? false) == 'Trade Certification') checked @endif
                    >
                    <label for="c_cat3" class="ml-3 block text-sm font-medium text-gray-700">Trade Certification</label>
                </div>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <input id="c_cat4" name="c_cat" type="radio" value="Other" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                    @if (old('c_cat', $entry->c_cat ?? false) == 'Other') checked @endif
                    >
                    <label for="c_cat4" class="ml-3 block text-sm font-medium text-gray-700">Other</label>
                </div>
                </div>
            </fieldset>

            {{-- Certificate attributes --}}
            <fieldset>
                <div>
                <legend class="text-base font-medium text-gray-900">Certificate attributes</legend>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <span class="mr-3 w-32 block text-sm font-medium text-gray-700">Display attribute 1</span>
                    <label for="c_share1" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="c_share[]" id="c_share1" value="1" class="sr-only"
                                @if (in_array(1, old('share[]', $entry->c_share ?? []))) checked @endif 
                            >
                            <div class="block bg-gray-600 w-8 h-5 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                        </div>
                        <div class="ml-3 text-gray-700 font-medium">Share</div>
                    </label>
                </div>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <span class="mr-3 w-32 block text-sm font-medium text-gray-700">Display attribute 2</span>
                    <label for="c_share2" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="c_share[]" id="c_share2" value="2" class="sr-only" 
                                @if (in_array(2, old('share[]', $entry->c_share ?? []))) checked @endif 
                            >
                            <div class="block bg-gray-600 w-8 h-5 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                        </div>
                        <div class="ml-3 text-gray-700 font-medium">Share</div>
                    </label>
                </div>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <span class="mr-3 w-32 block text-sm font-medium text-gray-700">Display attribute 3</span>
                    <label for="c_share3" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="c_share[]" id="c_share3" value="3" class="sr-only"
                                @if (in_array(3, old('share[]', $entry->c_share ?? []))) checked @endif
                            >
                            <div class="block bg-gray-600 w-8 h-5 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                        </div>
                        <div class="ml-3 text-gray-700 font-medium">Share</div>
                    </label>
                </div>
                </div>
                <div class="mt-4 space-y-4">
                <div class="flex items-center">
                    <span class="mr-3 w-32 block text-sm font-medium text-gray-700">Display attribute 4</span>
                    <label for="c_share4" class="flex items-center cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="c_share[]" id="c_share4" value="4" class="sr-only"
                                @if (in_array(4, old('share[]', $entry->c_share ?? []))) checked @endif
                            >
                            <div class="block bg-gray-600 w-8 h-5 rounded-full"></div>
                            <div class="dot absolute left-1 top-1 bg-white w-3 h-3 rounded-full transition"></div>
                        </div>
                        <div class="ml-3 text-gray-700 font-medium">Share</div>
                    </label>
                </div>
                </div>

                
            </fieldset>
        </div>

        {{-- Institution name --}}
        <label class="block">
            <span class="text-gray-700">Institution name *</span>
            <input 
              type="text" 
              name="institution_name" 
              value="{{ old('institution_name', $entry->institution_name ?? null) }}" 
              class="@error('institution_name') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
              placeholder="Institution name"
              required
          >
          @error('institution_name')
              <span class="text-red-500 font-semibold block">{{ $message }}</span>
          @enderror
        </label>

        {{-- Degree name --}}
        <label class="block">
          <span class="text-gray-700">Degree name *</span>
          <input 
            type="text" 
            name="degree_name" 
            value="{{ old('degree_name', $entry->degree_name ?? null) }}" 
            class="@error('degree_name') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
            placeholder="Degree name"
            required
        >
        @error('degree_name')
            <span class="text-red-500 font-semibold block">{{ $message }}</span>
        @enderror
        </label>

        {{-- dates --}}
        <label class="block">
          <span class="text-gray-700">Dates</span>
          <input 
            type="text" 
            name="dates" 
            value="{{ old('dates', $entry->dates ?? null) }}" 
            class="@error('dates') border-red-600 @enderror mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" 
            placeholder="Date range"
        >
        @error('dates')
            <span class="text-red-500 font-semibold block">{{ $message }}</span>
        @enderror
        </label>

        <label class="block">
            <span class="text-gray-700">Description</span>
            <textarea 
                name="description"
                class="mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                rows="3">{{ old('description', $entry->description ?? null) }}</textarea>
            @error('description')
            <span class="text-red-500 font-semibold block">{{ $message }}</span>
            @enderror
        </label>

        <button type="submit" class="btn btn-primary md:m-auto md:w-1/2">@if(isset($entry->id)) {{ __('Save') }} @else {{ __('Add') }} @endif</button>
    </div>
</form>
</div>

@endsection