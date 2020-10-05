<?php


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;


class AbcController extends Controller
{
    /*public function mail()
    {
        $name = 'Hello';
        Mail::to('satishchaauhan041@gmail.com')->send(new SendMailable($name));
        return 'Email was sent';
    }*/

    public function home() {
        return ["Satish Chauhan"];

    }

}
