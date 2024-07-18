<?php

namespace App\Http\Controllers;

use App\Mail\ContactMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('contacts.index');
    }

    public function store(Request $request)
    {
        // return $request->file;
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:500',
        ]);

        Mail::to('anderson9daza6@gmail.com')->send(new ContactMailable($request->all()));
        // Mail::to('')->queue()

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Gracias por contactarnos! el mensaje se envio correctamente 😉",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 3000
        ]);

        return back();
    }
}
