<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $emails = Email::all();
        return View::make('emails.email_listing', ['emails' => $emails]);
    }

    public function show(Request $request, Email $email)
    {
        return View::make('emails.email', ['email' => $email]);
    }
}
