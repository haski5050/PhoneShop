<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PhoneController extends Controller
{
    public function returnPhones(){
        $phones = DB::select("SELECT * FROM phones LEFT JOIN products ON products.id = phones.id ORDER BY phones.id DESC");


        return view('home',['phones' => $phones]);
    }
}
