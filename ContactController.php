<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
<<<<<<< HEAD
    // cria um array e passa as informacoes pra esse array
=======
// cria um array e passa as informacoes pra esse array
>>>>>>> 2dd8a3ceedfef734f3419ea03ce856f46b15d01d
        $details = [
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        Mail::to('recipient@example.com')->send(new ContactMail($details));

        return response()->json(['message' => 'Email sent successfully']);
    }
}