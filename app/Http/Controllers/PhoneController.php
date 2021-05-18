<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhoneController extends Controller
{
    public function returnPhones(){
        $phones = DB::select("SELECT *,phones.id AS cid FROM phones LEFT JOIN products ON products.id = phones.product_id ORDER BY phones.id DESC");
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
    public function addPhonePage(){
        $category = DB::select("SELECT * FROM phone_categories");

        return view('add.addPhone',['category' =>$category]);
    }
    public function addCategoryPage(){
        $category = DB::select("SELECT * FROM phone_categories");

        return view('add.addCategory',['categories' =>$category]);
    }
    public function updateCategory(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        DB::update("UPDATE phone_categories SET name=? WHERE id=?",[$name,$id]);
        return redirect()->route('addCategoryPage');
    }
    public function deleteCategory(Request $request){
        $id = $request->input('id');
        DB::delete('DELETE FROM phone_categories WHERE id=?',[$id]);
        return redirect()->route('addCategoryPage');
    }
    public function addCategorySubmit(Request $request){
        $name = $request->input('name');
        DB::insert("INSERT INTO phone_categories(name) VALUES(?) ",[$name]);
        return redirect()->route('addCategoryPage');
    }
    public function addPhoneSubmit(Request $request){
        $validator = Validator::make($request->all(),[
            'mark' => 'required|max:100',
            'model' => 'required|max:100',
            'display' => 'required|max:100',
            'screen_resolution' => 'required|max:100',
            'screen_type' => 'required|max:100',
            'communication' => 'required|max:100',
            'sim' => 'required',
            'cpu' => 'nullable|max:100',
            'cores' => 'nullable',
            'cpu_frequency' => 'nullable',
            'gpu' => 'nullable|max:100',
            'ram' => 'required',
            'rom' => 'required',
            'back_camera' => 'required',
            'back_video' => 'required|max:100',
            'front_camera' => 'required',
            'flash' => 'required|max:100',
            'battery' => 'required|max:100',
            'description' => 'nullable',
            'price' => 'required',
            'count' => 'required',
            'phone_category' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->route('addPhonePage')
                ->withErrors($validator)
                ->withInput();
        }
        $product_id = DB::table('products')->insertGetId([
            'type' => "Смартфон",
            'name' => $request->input('mark').$request->input('model'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        $phone_id = DB::table('phones')->insertGetId([
            'mark' => $request->input('mark'),
            'model' => $request->input('model'),
            'display' => $request->input('display'),
            'screen_resolution' => $request->input('screen_resolution'),
            'screen_type' => $request->input('screen_type'),
            'communication' => $request->input('communication'),
            'sim' => $request->input('sim'),
            'cpu' => $request->input('cpu'),
            'cores' => $request->input('cores'),
            'cpu_frequency' => $request->input('cpu_frequency'),
            'gpu' => $request->input('gpu'),
            'ram' => $request->input('ram'),
            'rom' => $request->input('rom'),
            'back_camera' => $request->input('back_camera'),
            'back_video' => $request->input('back_video'),
            'front_camera' => $request->input('front_camera'),
            'flash' => $request->input('flash'),
            'battery' => $request->input('battery'),
            'description' => $request->input('description'),
            'phone_category' => $request->input('phone_category'),
            'product_id' => $product_id,
            'category_id' => 1
        ]);
        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/'.$phone_id.'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/'.$phone_id.'/'.$fileName, $img, 'public');
        }

        return redirect()->route('homePage');
    }
    public function updatePhone(Request $request){
        $validator = Validator::make($request->all(),[
            'mark' => 'required|max:100',
            'model' => 'required|max:100',
            'display' => 'required|max:100',
            'screen_resolution' => 'required|max:100',
            'screen_type' => 'required|max:100',
            'communication' => 'required|max:100',
            'sim' => 'required',
            'cpu' => 'nullable|max:100',
            'cores' => 'nullable',
            'cpu_frequency' => 'nullable',
            'gpu' => 'nullable|max:100',
            'ram' => 'required',
            'rom' => 'required',
            'back_camera' => 'required',
            'back_video' => 'required|max:100',
            'front_camera' => 'required',
            'flash' => 'required|max:100',
            'battery' => 'required|max:100',
            'description' => 'nullable',
            'price' => 'required',
            'count' => 'required',
            'phone_category' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->route('updatePhonePage')
                ->withErrors($validator)
                ->withInput();
        }

        DB::table('products')->where('id',$request->input('product_id'))->update([
            'type' => "Смартфон",
            'name' => $request->input('mark').$request->input('model'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        DB::table('phones')->where('id',$request->input('id'))->update([
            'mark' => $request->input('mark'),
            'model' => $request->input('model'),
            'display' => $request->input('display'),
            'screen_resolution' => $request->input('screen_resolution'),
            'screen_type' => $request->input('screen_type'),
            'communication' => $request->input('communication'),
            'sim' => $request->input('sim'),
            'cpu' => $request->input('cpu'),
            'cores' => $request->input('cores'),
            'cpu_frequency' => $request->input('cpu_frequency'),
            'gpu' => $request->input('gpu'),
            'ram' => $request->input('ram'),
            'rom' => $request->input('rom'),
            'back_camera' => $request->input('back_camera'),
            'back_video' => $request->input('back_video'),
            'front_camera' => $request->input('front_camera'),
            'flash' => $request->input('flash'),
            'battery' => $request->input('battery'),
            'description' => $request->input('description'),
            'phone_category' => $request->input('phone_category'),
            'product_id' => $request->input('product_id'),
            'category_id' => 1
        ]);

        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/'.$request->input('id').'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/'.$request->input('id').'/'.$fileName, $img, 'public');
        }

        if($request->input('Check1') == true)Storage::delete('images/'.$request->input('id').'/1.png');
        if($request->input('Check1') == true)Storage::delete('images/'.$request->input('id').'/1.png');

        return redirect()->route('homePage');
    }
    public function updatePhonePage($id){
        $phone = DB::select("SELECT * FROM phones LEFT JOIN products ON products.id = phones.product_id WHERE phones.id=?",[$id]);
        $first = $phone[0];
        $category = DB::select("SELECT * FROM phone_categories");
        return view('change.updatePhone',['phone' => $first,'category' =>$category]);
    }
    public function deletePhone($id){
        DB::delete("DELETE FROM products WHERE id=?",[$id]);

        return redirect()->route('homePage');
    }
    public function aboutPhone($id){
        $phone = DB::select("SELECT *,phones.id AS cid FROM phones LEFT JOIN products ON products.id = phones.product_id WHERE phones.id=?",[$id]);
        $directory = 'images/'.$id.'/';
        $images = Storage::allFiles($directory);
        $category = DB::select("SELECT * FROM phone_categories WHERE id = ?",[$phone[0]->phone_category]);
        return view('about.aboutPhone',['phone'=>$phone[0], 'image'=>$images, 'category'=>$category[0]]);
    }
}
