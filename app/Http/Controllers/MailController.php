<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\MyCustomMail;

class MailController extends Controller
{
    
    public function mail()
    {
        Mail::to('pig19850813@hotmail.com')->send(new MyCustomMail('John Doe', 'pig19850813@hotmail.com'));
    }
}