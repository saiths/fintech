<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;

class MailController extends Controller
{
    
	public function home() {
        return view('mail.home');
	}

    public function sendmail(Request $request) {
			
		$email = $request->input('email');
		$subject = $request->input('subject');
        $messages = $request->input('messages');
       	Mail::to($email)->send(new SendMailable($subject,$messages));
    
    }

}
