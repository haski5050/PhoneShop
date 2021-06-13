<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function adminLogin()
    {
        return view('auth.adminLogin');
    }

    public function adminLoginPost(Request $request)
    {
        $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required|min:8'
        ]);

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)){
            return redirect()->route('homePage');
        }

        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->route('homePage');
    }

    public function index(){
        return view('homeAdmin');
    }
    public function feedback_correct(){
        $feedbacks = DB::select("SELECT * FROM product_feedback WHERE is_correct = false AND message IS NOT NULL");
        return view('feedback',['feedback'=>$feedbacks]);
    }
    public function deleteFeedback($id){
        DB::delete("DELETE FROM product_feedback WHERE id = ?",[$id]);
        return redirect()->route('feedbackCheckPage');
    }
    public function updateFeedback($id){
        DB::update("UPDATE product_feedback SET is_correct = true WHERE id = ?",[$id]);
        return redirect()->route('feedbackCheckPage');
    }
    public function feedbackAnswer(Request $request){
        DB::insert("INSERT INTO feedback_answer(feedback_id,message,send_at) VALUES(?,?,?)",[$request->input('id'),$request->input('message'),now()]);
        return redirect()->back();
    }
    public function ordersPage(){
        $buyers = DB::select("SELECT * FROM buyers as b");
        $arr = [];
        foreach($buyers as $b){
            $tmp = DB::select("SELECT *,purchases.id AS pid FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id INNER JOIN products ON products.id = basket.product_id WHERE buyer_id = ? AND delivered=false",[$b->id]);
            if(count($tmp)>0) {
                $arr[$b->id] = $tmp;
                $barr[$b->id] = DB::selectOne("SELECT * FROM buyers WHERE id = ?",[$b->id]);
            }
        }
        return view('orders',['buyers'=>$barr, 'orders' =>$arr]);
    }
    public function ordersUpdate($id, Request $request){
        if($request->input('submit')=='on')$Submit = true;
        else $Submit = false;
        if($request->input('send')=='on')$Send = true;
        else $Send = false;
        if($request->input('delivered')=='on')$Delivered = true;
        else $Delivered = false;
        DB::update("UPDATE purchases SET submit = ?, send = ?, delivered = ? WHERE id = ? ",[$Submit,$Send,$Delivered,$id]);
        return redirect()->back();
    }
    public function purchasesReport($id){
        switch ($id){
            case 1:$info = DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Смартфон' WHERE delivered = true GROUP BY basket.product_id ORDER BY pmax DESC");
                $tmp = DB::select("SELECT products.id FROM products LEFT JOIN basket ON basket.product_id = products.id INNER JOIN purchases ON purchases.basket_id = basket.id WHERE products.type = 'Смартфон' GROUP BY products.id");
                $arr = [];
                foreach ($tmp as $t){
                    $arr[] = $t->id;
                }
                if (count($arr)>0) {
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->whereNotIn('id', $arr, 'AND')
                        ->where('type', '=', 'Смартфон')
                        ->get();
                }
                else{
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->where('id','<>',$tmp,'AND')
                        ->where('type', '=', 'Смартфон')
                        ->get();
                }

            break;
            case 2:$info = DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Чохол' WHERE delivered = true GROUP BY basket.product_id ORDER BY pmax DESC");
            $tmp = DB::select("SELECT products.id FROM products LEFT JOIN basket ON basket.product_id = products.id INNER JOIN purchases ON purchases.basket_id = basket.id WHERE products.type = 'Чохол' GROUP BY products.id");
                $arr = [];
                foreach ($tmp as $t){
                    $arr[] = $t->id;
                }
                if (count($arr)>0) {
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->whereIn('id', $arr, 'AND')
                        ->where('type', '=', 'Чохол')
                        ->get();
                }
                else{
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->where('id', '<>',$tmp, 'AND')
                        ->where('type', '=', 'Чохол')
                        ->get();
                }
                break;
            case 3:$info =  DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Зарядка' WHERE delivered = true GROUP BY basket.product_id ORDER BY pmax DESC");
                $tmp = DB::select("SELECT products.id FROM products LEFT JOIN basket ON basket.product_id = products.id INNER JOIN purchases ON purchases.basket_id = basket.id WHERE products.type = 'Зарядка' GROUP BY products.id");
                $arr = [];
                foreach ($tmp as $t){
                    $arr[] = $t->id;
                }
                if (count($arr)>0) {
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->whereNotIn('id', $arr, 'AND')
                        ->where('type', '=', 'Зарядка')
                        ->get();
                }
                else{
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->where('id', '<>',$tmp, 'AND')
                        ->where('type', '=', 'Зарядка')
                        ->get();
                }
            break;
            case 4:$info = DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Портативна батарея' WHERE delivered = true GROUP BY basket.product_id ORDER BY pmax DESC");
                $tmp = DB::select("SELECT products.id FROM products LEFT JOIN basket ON basket.product_id = products.id INNER JOIN purchases ON purchases.basket_id = basket.id WHERE products.type = 'Портативна батарея' GROUP BY products.id");
                $arr = [];
                foreach ($tmp as $t){
                    $arr[] = $t->id;
                }
                if (count($arr)>0) {
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->whereNotIn('id', $arr, 'AND')
                        ->where('type', '=', 'Портативна батарея')
                        ->get();
                }
                else{
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->where('id', '<>',$tmp, 'AND')
                        ->where('type', '=', 'Портативна батарея')
                        ->get();
                }
            break;
            case 5:$info = DB::select('SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = "Карти пам\'яті" WHERE delivered = true GROUP BY basket.product_id ORDER BY pmax DESC');
                $tmp = DB::select('SELECT products.id FROM products LEFT JOIN basket ON basket.product_id = products.id INNER JOIN purchases ON purchases.basket_id = basket.id WHERE products.type = "Карти пам\'яті" GROUP BY products.id');
                $arr = [];
                foreach ($tmp as $t){
                    $arr[] = $t->id;
                }
                if (count($arr)>0) {
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->whereNotIn('id', $arr, 'AND')
                        ->where('type', '=', 'Карти пам\'яті')
                        ->get();
                }
                else{
                    $last = DB::table('products')
                        ->select('name', 'id')
                        ->where('id', '<>',$tmp, 'AND')
                        ->where('type', '=', 'Карти пам\'яті')
                        ->get();
                }
            break;
        }
        return view('reports_layout',['in'=>$info,'ls'=>$last,'id'=>$id]);
    }
    public function reportsDate($id, Request $request){
        switch ($id){
            case 1:$info = DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Смартфон' WHERE delivered = true AND basket.add_at BETWEEN ? AND ? GROUP BY basket.product_id ORDER BY pmax DESC",[$request->input('frst'),$request->input('scnd')]);
                break;
            case 2:$info = DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Чохол' WHERE delivered = true AND basket.add_at BETWEEN ? AND ? GROUP BY basket.product_id ORDER BY pmax DESC",[$request->input('frst'),$request->input('scnd')]);

                break;
            case 3:$info =  DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Зарядка' WHERE delivered = true AND basket.add_at BETWEEN ? AND ? GROUP BY basket.product_id ORDER BY pmax DESC",[$request->input('frst'),$request->input('scnd')]);

                break;
            case 4:$info = DB::select("SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = 'Портативна батарея' WHERE delivered = true AND basket.add_at BETWEEN ? AND ? GROUP BY basket.product_id ORDER BY pmax DESC",[$request->input('frst'),$request->input('scnd')]);

                break;
            case 5:$info = DB::select('SELECT basket.product_id,products.name,products.price, max(basket.add_at) AS dt, SUM(products.price) AS money, COUNT(basket.product_id) AS pmax FROM purchases INNER JOIN basket ON purchases.basket_id = basket.id
                    INNER JOIN products ON basket.product_id = products.id AND products.type = "Карти пам\'яті" WHERE delivered = true AND basket.add_at BETWEEN ? AND ? GROUP BY basket.product_id ORDER BY pmax DESC',[$request->input('frst'),$request->input('scnd')]);

                break;
        }
        return view('reports_layout',['in'=>$info,'ls'=>NULL,'id'=>$id]);
    }
}
