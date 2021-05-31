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
}
