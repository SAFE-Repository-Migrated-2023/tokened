<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function index()
    {
        $first = Contact::first();
        $contacts = Contact::where('id', '!=', $first->id ?? null)->get();

        return view('contact.index', compact('contacts', 'first'));
    }

    public function contacts()
    {
        $first = Contact::first();
        $contacts = Contact::where('id', '!=', $first->id ?? null)->get();

        return view('contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('contact.manage');
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::with(['jobs', 'educations'])->findOrFail($id);

        return view('contact.show', compact('contact'));
    }

    public function edit(Request $request, $id)
    {
        $entry = Contact::findOrFail($id);
        return view('contact.manage', compact('entry'));
    }

    public function store(ContactRequest $request)
    {
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->title = $request->title;
        // $contact->company = $request->company;
        // $contact->education = $request->education;
        $contact->certificate = $request->certificate;
        $contact->save();


        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $filename = strtolower($request->upload->getClientOriginalName());
            $path = $request->upload->storeAs(
                'images', $contact->id.'_'.$filename
            );
            $contact->img = $path ?? null;
            $contact->save();
        }

        return redirect()->route('contacts.index')->with('success', 'Created!');
    }

    public function update(ContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $old_img = $contact->img;
        $contact->name = $request->name;
        $contact->title = $request->title;
        // $contact->company = $request->company;
        // $contact->education = $request->education;
        $contact->share = $request->share;

        if($request->filled('delete-image')){
            if (!empty($old_img)) {
                Storage::delete($old_img);
            }
            $contact->img = null;
        }
        
        $contact->save();

        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $filename = strtolower($request->upload->getClientOriginalName());
            $path = $request->upload->storeAs(
                'images', $contact->id.'_'.$filename
            );
            $contact->img = $path ?? null;
            $contact->save();
        }

        return redirect()->back()->with('success', 'Updated!');
    }

    //ajax
    public function connect(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->share = $request->share ?? 0;
        $contact->save();

        return response()->json($contact->share, 200);
    }

    public function destroy(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        Storage::delete($contact->img);

        return $contact->delete();
    }

}
