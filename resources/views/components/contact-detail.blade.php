<div class="rounded-xl shadow-md p-4 mb-4 flex flex-wrap">
    <div class="my-1">
        <img class="rounded w-56 h-auto mr-6" src="{{$contact->image}}" alt="image">
    </div>
    <div class="mt-2 flex-grow">
        <div>
            <div class="mt-2 text-sm text-gray-600">
                <ul>
                    <li><strong>Name:</strong> {{ $contact->name }}</li>
                    <li><strong>Title:</strong> {{ $contact->title }}</li>
                    {{-- <li><strong>Company:</strong> {{ $contact->company }}</li>
                    <li><strong>Education:</strong> {{ $contact->education }}</li> --}}
                    <li><strong>Share name:</strong> {{ in_array('name', $contact->share ?? []) ? 'YES' : 'NO' }}</li>
                    <li><strong>Share title:</strong> {{ in_array('title', $contact->share ?? []) ? 'YES' : 'NO' }}</li>
                    <li><strong>Share image:</strong> {{ in_array('image', $contact->share ?? []) ? 'YES' : 'NO' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="flex flex-col text-center">
        <a href="{{route('contacts.edit', $contact->id)}}" class="btn btn-primary mt-2">Edit</a>
    </div>
    <div class="bg-gray-50 my-6 p-6 w-full">
        <div class="font-semibold mb-4 text-lg">Employment History <a href="{{route('jobs.create', $contact->id)}}" class="underline sm:ml-6 text-sm inline-block">Add new</a></div>
        @if($contact->jobs->isNotempty())

        @foreach($contact->jobs as $job)
        <div class="bg-white p-2 rounded text-gray-600 text-sm flex flex-wrap justify-between">
            <ul class="my-2 md:w-1/2 w-full">
                <li><strong>Company:</strong> {{ $job->company }}</li>
                <li><strong>Title:</strong> {{ $job->title }}</li>
                <li><strong>Dates:</strong> {{ $job->dates }}</li>
                <li><strong>Description:</strong> {{ $job->description }}</li>
            </ul>
            <div class="my-2 mx-2">
                <img class="rounded w-28 h-auto" src="{{asset('images/not_cert.png')}}" alt="not certified">
            </div>
            <div class="my-2">
                <a href="{{route('jobs.edit', ['contact_id' => $contact->id, 'id' => $job->id])}}" class="btn btn-primary">Edit</a>
                <form method="POST" action="{{route('jobs.destroy', $job->id)}}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn text-red-500 ml-2">Delete</button>
                </form>
            </div>
        </div>
        @endforeach

        @else
        <div>
            No records
        </div>
        @endif
    </div>
    <div class="bg-gray-50 my-6 p-6 w-full">
        <div class="font-semibold mb-4 text-lg">Education <a href="{{route('educations.create', $contact->id)}}" class="underline sm:ml-6 text-sm inline-block">Add new</a></div>
        @if($contact->educations->isNotempty())

        @foreach($contact->educations as $education)
        <div class="bg-white p-2 rounded text-gray-600 text-sm flex flex-wrap justify-between">
            <ul class="my-2 md:w-1/2 w-full">
                <li><strong>Institution name:</strong> {{ $education->institution_name }}</li>
                <li><strong>Degree name:</strong> {{ $education->degree_name }}</li>
                <li><strong>Dates:</strong> {{ $education->dates }}</li>
                <li><strong>Description:</strong> {{ $education->description }}</li>
            </ul>
            <div class="my-2 mx-2">
                <img class="rounded w-28 h-auto" src="{{asset('images/cert.png')}}" alt="certified">
            </div>
            <div class="my-2">
                <a href="{{route('educations.edit', ['contact_id' => $contact->id, 'id' => $education->id])}}" class="btn btn-primary">Edit</a>
                <form method="POST" action="{{route('educations.destroy', $education->id)}}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn text-red-500 ml-2">Delete</button>
                </form>
            </div>
        </div>
        @endforeach

        @else
        <div>
            No records
        </div>
        @endif
    </div>    
</div>