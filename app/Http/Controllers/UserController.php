<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function Sodium\add;

class UserController extends Controller
{
    public function aboutUser(){
        $user_id = auth()->user()->getAuthIdentifier();
        $user = DB::selectOne("SELECT buyer_id FROM users WHERE id = ?",[$user_id]);
        $buyer = DB::select("SELECT * FROM buyers WHERE id = ?",[$user->buyer_id]);

        return view('about.aboutUser',['info'=>$buyer[0]]);
    }
    public function aboutUserUpdate(Request $request){
        $validator = Validator::make($request->all(),[
            'pib' => 'required|max:255',
            'age' => 'required',
            'phone_number' => 'required',
            'address' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('aboutUserPage')
                ->withErrors($validator)
                ->withInput();
        }
        DB::table('buyers')->where('id',$request->input('id'))->update([
            'pib' => $request->input('pib'),
            'age' => $request->input('age'),
            'phone_number' => $request->input('phone_number'),
            'address' => $request->input('address')
        ]);

        return redirect()->route('aboutUserPage');
    }
    public function addFavorite($id){
        $pid = DB::select("SELECT product_id FROM user_favorites WHERE user_id =?",[auth()->user()->getAuthIdentifier()]);
        $b=false;
        foreach ($pid as $p){
            if($p->product_id == $id){
                $b = true;
            }
        }
        if(!$b)DB::insert("INSERT INTO user_favorites(user_id,product_id) VALUES (?,?)",[auth()->user()->getAuthIdentifier(),$id]);

        return redirect()->route('favoritePage');
    }
    public function getFavorite(){
        $favorite = DB::select("SELECT * FROM user_favorites WHERE user_id = ?",[auth()->user()->getAuthIdentifier()]);
        $arr = ["Смартфони" => [],"Чохли" =>[],"Зарядки"=>[],"Батареї"=>[],"Пам'ять"=>[]];
        foreach ($favorite as $f){
            $product = DB::select("SELECT * FROM products WHERE id = ?",[$f->product_id]);
            foreach ($product as $p){
                switch ($p->type){
                    case 'Смартфон':
                        $tmp = collect(DB::select("SELECT *,phones.id AS cid FROM phones LEFT JOIN products ON products.id = phones.product_id WHERE phones.product_id = ?",[$p->id]))->first();
                        $arr["Смартфони"][]=$tmp;
                        break;
                    case 'Чохол':
                        $tmp = collect(DB::select("SELECT *,cases.id AS cid FROM cases LEFT JOIN products ON products.id = cases.product_id WHERE cases.product_id = ?",[$p->id]))->first();
                        $arr["Чохли"][]=$tmp;
                        break;
                    case 'Зарядка':
                        $tmp = collect(DB::select("SELECT *,chargers.id AS cid FROM chargers LEFT JOIN products ON products.id = chargers.product_id WHERE chargers.product_id = ?",[$p->id]))->first();
                        $arr["Зарядки"][]=$tmp;
                        break;
                    case 'Портативна батарея':
                        $tmp = collect(DB::select("SELECT *,power_banks.id AS cid FROM power_banks LEFT JOIN products ON products.id = power_banks.product_id WHERE power_banks.product_id = ?",[$p->id]))->first();
                        $arr["Батареї"][]=$tmp;
                        break;
                    case 'Карти пам\'яті':
                        $tmp = collect(DB::select("SELECT *,memory_cards.id AS cid FROM memory_cards LEFT JOIN products ON products.id = memory_cards.product_id WHERE memory_cards.product_id = ?",[$p->id]))->first();
                        $arr["Пам'ять"][]=$tmp;
                        break;
                }
            }
        }
        return view('favorite',['data'=>$arr]);
    }
    public function deleteFavorite($id){
        DB::delete("DELETE FROM user_favorites WHERE product_id = ?",[$id]);
        return redirect()->route('favoritePage');
    }
    public function addToBasket($id, Request $request){
        $tmp = (new \DateTime())->format('Hismd');
        if($request->cookie('id') == NULL){
            DB::insert("INSERT INTO basket(id,product_id,count,add_at) VALUES(?,?,?,?)",[$tmp,$id,$request->input('count'),now()]);
            return redirect()->route('homePage')->withCookie(cookie('id',$tmp,60));
        }
        else {
            $basket = DB::select("SELECT * FROM basket WHERE id = ?",[$request->cookie('id')]);
            $add = true;
            foreach ($basket as $el){
                if($el->product_id == $id){
                    DB::update("UPDATE basket SET count = count + ? WHERE id = ? AND product_id = ?",[$request->input('count'),$request->cookie('id'),$id]);
                    $add = false;
                    break;
                }

            }
            if($add)DB::insert("INSERT INTO basket(id,product_id,count,add_at) VALUES(?,?,?,?)", [$request->cookie('id'), $id,$request->input('count'),now()]);
            return redirect()->route('homePage');
        }


    }
    public function basket(Request $request){
        $products = DB::select("SELECT *,basket.id AS basket_id FROM basket LEFT JOIN products ON basket.product_id = products.id WHERE basket.id = ? ",[$request->cookie('id')]);
        $arr = ["Смартфони" => [],"Чохли" =>[],"Зарядки"=>[],"Батареї"=>[],"Пам'ять"=>[]];
        $tmp = (count($products)>0)?true:false;
        foreach ($products as $p){
            switch ($p->type){
                case 'Смартфон':
                    $tmp = collect(DB::select("SELECT *,phones.id AS cid FROM phones LEFT JOIN products ON products.id = phones.product_id INNER JOIN basket ON basket.id = ? WHERE phones.product_id = ?",[$p->basket_id,$p->id]))->first();
                    $arr["Смартфони"][]=$tmp;
                    break;
                case 'Чохол':
                    $tmp = collect(DB::select("SELECT *,cases.id AS cid FROM cases LEFT JOIN products ON products.id = cases.product_id INNER JOIN basket ON basket.id = ? WHERE cases.product_id = ?",[$p->basket_id,$p->id]))->first();
                    $arr["Чохли"][]=$tmp;
                    break;
                case 'Зарядка':
                    $tmp = collect(DB::select("SELECT *,chargers.id AS cid FROM chargers LEFT JOIN products ON products.id = chargers.product_id INNER JOIN basket ON basket.id = ? WHERE chargers.product_id = ?",[$p->basket_id,$p->id]))->first();
                    $arr["Зарядки"][]=$tmp;
                    break;
                case 'Портативна батарея':
                    $tmp = collect(DB::select("SELECT *,power_banks.id AS cid FROM power_banks LEFT JOIN products ON products.id = power_banks.product_id INNER JOIN basket ON basket.id = ? WHERE power_banks.product_id = ?",[$p->basket_id,$p->id]))->first();
                    $arr["Батареї"][]=$tmp;
                    break;
                case 'Карти пам\'яті':
                    $tmp = collect(DB::select("SELECT *,memory_cards.id AS cid FROM memory_cards LEFT JOIN products ON products.id = memory_cards.product_id INNER JOIN basket ON basket.id = ? WHERE memory_cards.product_id = ?",[$p->basket_id,$p->id]))->first();
                    $arr["Пам'ять"][]=$tmp;
                    break;
            }
        }
//        dd($arr);
        return view('basket',['data'=>$arr,'isProducts'=>$tmp]);
    }
}
