<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Auth::user()->can('contacts.view')){
            $contacts = Contact::whereNull('deleted_at')->get();
            return view('backend.contacts.index', compact('contacts'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

            Contact::create([
                "adresse_ip"=>null,
                "name"=>$request->name,
                "email"=>$request->email,
                "subject"=>$request->subject,
                "message"=>$request->message,
                "is_read"=>FALSE,
            ]);

            return redirect()->route('frontend.home');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if(Auth::user()->can('contacts.view')){
            $contact = Contact::find($id);
            if(!$contact){
                return redirect()->route('contacts.index')->with('success', 'Ce contact n\'existe pas.');
            }

            if(!$contact->is_read){
                $contact->is_read = true;
                $contact->save();
            }
            return view('backend.contacts.show', compact('contact'));
        }
        return redirect()->route('admin.dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
