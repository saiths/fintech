<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function create()
    {
        return view('captchacreate');
    }
    
    public function captchaValidate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'captcha' => 'required|captcha'
        ]);
    }
    
    public function refreshCaptcha()
    {
        return captcha_img('math');
        //return response()->json(['captcha'=> captcha_img()]);
    }
}
