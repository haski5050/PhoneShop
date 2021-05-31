<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            return redirect()->route('basketPage')->withCookie(cookie('id',$tmp,60));
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
        $basket = DB::select("SELECT * FROM basket WHERE id = ?",[$request->cookie('id')]);
        $arr = ["Смартфони" => [],"Чохли" =>[],"Зарядки"=>[],"Батареї"=>[],"Пам'ять"=>[]];
        $tmp = (count($basket)>0)?true:false;
        foreach ($basket as $b){
            $products = DB::select("SELECT * FROM products WHERE id = ?",[$b->product_id]);
            foreach ($products as $p){
                switch ($p->type){
                case 'Смартфон':
                    $tmp = collect(DB::select("SELECT phones.*,basket.id AS bid,products.price,basket.count FROM phones INNER JOIN products ON products.id = phones.product_id INNER JOIN basket ON basket.product_id = products.id WHERE basket.id = ?",[$b->id]))->first();
                    $arr["Смартфони"][]=$tmp;
                    break;
                case 'Чохол':
                    $tmp = collect(DB::select("SELECT cases.*,basket.id AS bid,products.price,basket.count FROM cases INNER JOIN products ON products.id = cases.product_id INNER JOIN basket ON basket.product_id = products.id WHERE basket.id = ?",[$b->id]))->first();
                    $arr["Чохли"][]=$tmp;
                    break;
                case 'Зарядка':
                    $tmp = collect(DB::select("SELECT chargers.*,basket.id AS bid,products.price,basket.count FROM chargers INNER JOIN products ON products.id = chargers.product_id INNER JOIN basket ON basket.product_id = products.id WHERE basket.id = ?",[$b->id]))->first();
                    $arr["Зарядки"][]=$tmp;
                    break;
                case 'Портативна батарея':
                    $tmp = collect(DB::select("SELECT power_banks.*,basket.id AS bid,products.price,basket.count FROM power_banks INNER JOIN products ON products.id = power_banks.product_id INNER JOIN basket ON basket.product_id = products.id WHERE basket.id = ?",[$b->id]))->first();
                    $arr["Батареї"][]=$tmp;
                    break;
                case 'Карти пам\'яті':
                    $tmp = collect(DB::select("SELECT memory_cards.*,basket.id AS bid,products.price,basket.count FROM memory_cards INNER JOIN products ON products.id = memory_cards.product_id INNER JOIN basket ON basket.product_id = products.id WHERE basket.id = ?",[$b->id]))->first();
                    $arr["Пам'ять"][]=$tmp;
                    break;
            }
            }
        }
        return view('basket',['data'=>$arr,'isProducts'=>$tmp]);
    }
    public function deleteFromBasket($id, Request $request){
        DB::delete("DELETE FROM basket WHERE id = ? AND product_id = ?",[$request->cookie('id'),$id]);


        return redirect()->route('basketPage');
    }
    public function addFeedback(Request $request){
        DB::insert("INSERT INTO product_feedback(product_id,user_id,rating,message,send_at,is_correct) VALUES(?,?,?,?,?,false)",[$request->input('pid'),
            auth()->user()->getAuthIdentifier(),$request->input('inputRating'),$request->input('inputDescription'),now()]);
        return redirect()->back();
    }
    public function orderPage(Request $request){
        $products = DB::select("SELECT * FROM basket WHERE id = ?",[$request->cookie('id')]);
        if(Auth::check()){
            $user = DB::select("SELECT * FROM users WHERE id = ?",[auth()->user()->getAuthIdentifier()]);
            $buyer = DB::select("SELECT * FROM buyers WHERE id = ?",[$user[0]->buyer_id]);
        }
        if(!empty($buyer)){
            return view('order',['products'=>$products, 'buyer' => $buyer[0]]);
        }
        else
            return view('order',['products'=>$products]);
    }
    public function addOrder(Request $request){
        $basket = DB::select("SELECT basket.*,basket.count AS bcount,products.count AS pcount,products.price AS price FROM basket INNER JOIN products ON
        basket.product_id = products.id WHERE basket.id = ?",[$request->cookie('id')]);
        $tmp = true;

        foreach ($basket as $el){
            if($el->bcount <= $el->pcount){
                DB::update("UPDATE products SET count = count - ? WHERE id = ?",[$el->bcount,$el->product_id]);
                $tmp = false;
            }
        }
        if($tmp){
            return redirect()->route('basketPage',['problem'=>$tmp]);
        }
        else{
            $validator = Validator::make($request->all(), [
                'pib' => 'required|max:50',
                'age' => 'required',
                'phone_number' => 'required|max:10',
                'address' => 'required|max:50',
            ]);
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
            switch ($request->input('check')){
                case 0:
                $bid = DB::select("SELECT buyer_id FROM users WHERE id = ?",[auth()->user()->getAuthIdentifier()]);
                $b = DB::select("SELECT * FROM buyers WHERE id = ?",[$bid[0]->buyer_id])[0];
                if($b->age==null)DB::update("UPDATE buyers SET age = ? WHERE id =?",[$request->input('age'),$bid[0]->buyer_id]);
                if($b->phone_number==null)DB::insert("UPDATE buyers SET phone_number = ? WHERE id =?",[$request->input('phone_number'),$bid[0]->buyer_id]);
                if($b->address==null)DB::insert("UPDATE buyers SET address = ? WHERE id =?",[$request->input('address'),$bid[0]->buyer_id]);
                foreach ($basket as $b){
                    for($i=0;$i<$b->bcount;$i++)DB::insert("INSERT INTO purchases(buyer_id, basket_id, total, submit, send, delivered) VALUES(?,?,?, false, false, false)"
                    ,[$bid[0]->buyer_id,$request->cookie('id'),$b->price]);
                }
                    break;
                case 1:
                $bid = DB::select("SELECT buyer_id FROM users WHERE id = ?",[auth()->user()->getAuthIdentifier()]);
                DB::insert("INSERT INTO buyers(pib,age,phone_number,address) VALUES(?,?,?,?) WHERE id = ?",[$request->input('pib'),
                    $request->input('age'),$request->input('phone_number'),$request->input('address'),$bid[0]->buyer_id]);
                foreach ($basket as $b){
                        for($i=0;$i<$b->bcount;$i++)DB::insert("INSERT INTO purchases(buyer_id, basket_id, total, submit, send, delivered) VALUES(?,?,?,false ,false ,false )"
                            ,[$bid[0]->buyer_id,$request->cookie('id'),$b->price]);
                    }
                    break;
                case 2:
                    $buyers = DB::select("SELECT * FROM buyers");
                    $z = false;
                    foreach ($buyers as $b){
                        if($b->pib == $request->input('pib') && $b->age == $request->input('age') && $b->phone_number == $request->input('phone_number') && $b->address == $request->input('address'))
                        $z = true;
                    }
                    if(!$z){
                        DB::insert("INSERT INTO buyers(pib, age, phone_number, address) VALUES(?,?,?,?)", [$request->input('pib'), $request->input('age'), $request->input('phone_number'), $request->input('address')]);
                    }
                    $bid = DB::select("SELECT id FROM buyers WHERE pib = ? AND age = ? AND phone_number = ? AND address = ?", [$request->input('pib'), $request->input('age'), $request->input('phone_number'), $request->input('address')])[0]->id;
                    foreach ($basket as $b){
                        for($i=0;$i<$b->bcount;$i++)DB::insert("INSERT INTO purchases(buyer_id, basket_id, total, submit, send, delivered) VALUES(?,?,?,false,false,false)"
                            ,[$bid,$request->cookie('id'),$b->price]);
                    }
                    break;
                default: dd($request->input('check'));
            }
            return redirect()->route('homePage')->withCookies((array)Cookie::queue(Cookie::forget('id')));
        }
    }

}
