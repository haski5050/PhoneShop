<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MainController extends Controller
{
    public function accessoriesPage(){
        return view('accessories');
    }
    public function searchResult(Request $request){
        $phones = DB::select("SELECT *,phones.id AS cid FROM phones LEFT JOIN products ON products.id = phones.product_id
        WHERE CONCAT(phones.mark, ' ', phones.model) LIKE '%".$request->input('search')."%' ORDER BY phones.id DESC");
        $images = [];
        for($i = 0;$i<count($phones);$i++) {
            $directory = 'images/'.$phones[$i]->cid.'/';
            $img = Storage::allFiles($directory);
            if (count($img) > 0) {
                $images[$phones[$i]->cid] = $img[0];
            }
        }
        return view('home',['phones' => $phones, 'image'=>$images]);
    }
}
