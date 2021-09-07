<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ContactjobRequest;
use App\Models\Contact;
use App\Models\Contactjob;
use Illuminate\Support\Facades\Storage;

class ContactjobController extends Controller
{
    public function create(Request $request, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        return view('contactjob.manage', compact('contact'));
    }

    public function edit(Request $request, $contact_id, $id)
    {
        $contact = Contact::findOrFail($contact_id);
        $entry = Contactjob::where('contact_id', $contact->id)->findOrFail($id);

        return view('contactjob.manage', compact('entry', 'contact'));
    }

    public function store(ContactjobRequest $request)
    {
        $contact = Contact::findOrFail($request->contact_id);
        $job = $contact->jobs()->create($request->only(['certificate', 'c_cat', 'c_share', 'company', 'title', 'dates', 'description']));

        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $filename = strtolower($request->upload->getClientOriginalName());
            $path = $request->upload->storeAs(
                'images', $job->contact_id.'_cert_job_'.$filename
            );
            $job->c_img = $path ?? null;
            $job->save();
        }

        return redirect()->route('contacts.show', $contact->id)->with('success', 'Employment record created');
    }

    public function update(ContactjobRequest $request, $id)
    {
        $job = Contactjob::where('contact_id', $request->contact_id)->findOrFail($id);
        $old_cert_img = $job->c_img;
        if($request->filled('delete-cert-image')){
            if (!empty($old_cert_img)) {
                Storage::delete($old_cert_img);
            }
            $job->c_img = null;
        }
        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $filename = strtolower($request->upload->getClientOriginalName());
            $path = $request->upload->storeAs(
                'images', $job->contact_id.'_cert_job_'.$filename
            );
            $job->c_img = $path ?? null;
            $job->save();
        }
        $job->update($request->only(['certificate', 'c_cat', 'c_share', 'company', 'title', 'dates', 'description']));

        return redirect()->route('contacts.index')->with('success', 'Employment record updated');
    }

    public function destroy(Request $request, $id)
    {
        $job = Contactjob::findOrFail($id);
        Storage::delete($job->c_img);
        $job->delete();

        return redirect()->route('contacts.index')->with('info', 'Employment record deleted');
    }

}
