<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ChargersController extends Controller
{
    public function returnChargers(){
        $chargers = DB::select("SELECT *,chargers.id AS cid FROM chargers LEFT JOIN products ON products.id = chargers.product_id ORDER BY chargers.id DESC");
        $images = [];
        for($i = 0;$i<count($chargers);$i++) {
            $directory = 'images/chargers/'.$chargers[$i]->cid.'/';
            $img = Storage::allFiles($directory);
            if (count($img) > 0) {
                $images[$chargers[$i]->cid] = $img[0];
            }
        }
        return view('chargers',['chargers' => $chargers, 'image'=>$images]);
    }
    public function addChargerPage(){
        return view('add.addCharger');
    }
    public function addChargerSubmit(Request  $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'output' => 'required|max:100',
            'output_count' => 'required',
            'power' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->route('addChargerPage')
                ->withErrors($validator)
                ->withInput();
        }
        $product_id = DB::table('products')->insertGetId([
            'type' => "Зарядка",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        $charger_id = DB::table('chargers')->insertGetId([
            'name' => $request->input('name'),
            'output' => $request->input('output'),
            'output_count' => $request->input('output_count'),
            'power' => $request->input('power'),
            'product_id' => $product_id,
            'category_id' => 3
        ]);
        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/chargers/'.$charger_id.'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/chargers/'.$charger_id.'/'.$fileName, $img, 'public');
        }

        return redirect()->route('chargersPage');
    }
    public function updateChargersPage($id){
        $charger = DB::select("SELECT * FROM chargers LEFT JOIN products ON products.id = chargers.product_id WHERE chargers.id=?",[$id]);
        $first = $charger[0];
        return view('change.updateCharger',['charger' => $first]);
    }
    public function updateCharge(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'output' => 'required|max:100',
            'output_count' => 'required',
            'power' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->route('updateChargerPage')
                ->withErrors($validator)
                ->withInput();
        }
        DB::table('products')->where('id',$request->input('product_id'))->update([
            'type' => "Зарядка",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        DB::table('chargers')->where('id',$request->input('id'))->update([
            'name' => $request->input('name'),
            'output' => $request->input('output'),
            'output_count' => $request->input('output_count'),
            'power' => $request->input('power'),
            'product_id' => $request->input('product_id'),
            'category_id' => 3
        ]);

        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/chargers/'.$request->input('id').'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/chargers/'.$request->input('id').'/'.$fileName, $img, 'public');
        }

        if($request->input('Check1') == true)Storage::delete('images/chargers/'.$request->input('id').'/1.png');
        if($request->input('Check1') == true)Storage::delete('images/chargers/'.$request->input('id').'/1.png');

        return redirect()->route('chargersPage');
    }
    public function deleteCharger($id){
        DB::delete("DELETE FROM products WHERE id=?",[$id]);

        return redirect()->route('chargersPage');
    }
    public function aboutCharger($id){
        $charger = DB::select("SELECT *,chargers.id AS cid FROM chargers LEFT JOIN products ON products.id = chargers.product_id WHERE chargers.id=?",[$id]);
        $directory = 'images/chargers/'.$id.'/';
        $images = Storage::allFiles($directory);
        return view('about.aboutCharger',['charger'=>$charger[0], 'image'=>$images]);
    }
}
