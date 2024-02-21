<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()
            ->paginate(10, ['name', 'email', 'message']);

        return Inertia::render('Contact', [
            'contacts' => $contacts,
        ]);
    }

    public function store(ContactRequest $request)
    {
        Contact::create($request->validated());

        return to_route('contact.us');
    }
}
