<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EducationRequest;
use App\Models\Education;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    public function create(Request $request, $contact_id)
    {
        $contact = Contact::findOrFail($contact_id);
        return view('education.manage', compact('contact'));
    }

    public function edit(Request $request, $contact_id, $id)
    {
        $contact = Contact::findOrFail($contact_id);
        $entry = Education::where('contact_id', $contact->id)->findOrFail($id);

        return view('education.manage', compact('entry', 'contact'));
    }

    public function store(EducationRequest $request)
    {
        $contact = Contact::findOrFail($request->contact_id);
        $education = $contact->educations()->create($request->only(['certificate', 'c_cat', 'c_share', 'institution_name', 'degree_name', 'dates', 'description']));

        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $filename = strtolower($request->upload->getClientOriginalName());
            $path = $request->upload->storeAs(
                'images', $education->contact_id.'_cert_edu_'.$filename
            );
            $education->c_img = $path ?? null;
            $education->save();
        }

        return redirect()->route('contacts.show', $contact->id)->with('success', 'Education record created');
    }

    public function update(EducationRequest $request, $id)
    {
        $education = Education::where('contact_id', $request->contact_id)->findOrFail($id);
        $old_cert_img = $education->c_img;
        if($request->filled('delete-cert-image')){
            if (!empty($old_cert_img)) {
                Storage::delete($old_cert_img);
            }
            $education->c_img = null;
        }
        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $filename = strtolower($request->upload->getClientOriginalName());
            $path = $request->upload->storeAs(
                'images', $education->contact_id.'_cert_edu_'.$filename
            );
            $education->c_img = $path ?? null;
            $education->save();
        }
        $education->update($request->only(['certificate', 'c_cat', 'c_share', 'institution_name', 'degree_name', 'dates', 'description']));

        return redirect()->route('contacts.index')->with('success', 'Education record updated');
    }

    public function destroy(Request $request, $id)
    {
        $education = Education::findOrFail($id);
        Storage::delete($education->c_img);
        $education->delete();

        return redirect()->route('contacts.index')->with('info', 'Education record deleted');
    }

}
