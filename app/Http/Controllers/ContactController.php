<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

    public function store(Request $request)
    {
        $attributes = Validator::validate($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'message' => 'required|max:1000',
        ]);

        Contact::create($attributes);

        return to_route('contact.us');
    }
}
