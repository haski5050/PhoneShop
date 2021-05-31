<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PowerController extends Controller
{
    public function returnPower(){
        $power = DB::select("SELECT *,power_banks.id AS cid FROM power_banks LEFT JOIN products ON products.id = power_banks.product_id ORDER BY power_banks.id DESC");
        $images = [];
        for($i = 0;$i<count($power);$i++) {
            $directory = 'images/powers/'.$power[$i]->cid.'/';
            $img = Storage::allFiles($directory);
            if (count($img) > 0) {
                $images[$power[$i]->cid] = $img[0];
            }
        }
        return view('power',['power' => $power, 'image'=>$images]);
    }
    public function addPowerPage(){
        return view('add.addPower');
    }
    public function addPowerSubmit(Request  $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'output' => 'required|max:100',
            'energy' => 'required',
            'power' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product_id = DB::table('products')->insertGetId([
            'type' => "Портативна батарея",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        $power_id = DB::table('power_banks')->insertGetId([
            'name' => $request->input('name'),
            'output' => $request->input('output'),
            'energy' => $request->input('energy'),
            'power' => $request->input('power'),
            'product_id' => $product_id,
            'category_id' => 4
        ]);
        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/powers/'.$power_id.'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/powers/'.$power_id.'/'.$fileName, $img, 'public');
        }

        return redirect()->route('powerPage');
    }
    public function updatePowerPage($id){
        $case = DB::select("SELECT * FROM power_banks LEFT JOIN products ON products.id = power_banks.product_id WHERE power_banks.id=?",[$id]);
        $first = $case[0];
        return view('change.updatePower',['power' => $first]);
    }
    public function updatePower(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'output' => 'required|max:100',
            'energy' => 'required',
            'power' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::table('products')->where('id',$request->input('product_id'))->update([
            'type' => "Портативна батарея",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        DB::table('power_banks')->where('id',$request->input('id'))->update([
            'name' => $request->input('name'),
            'output' => $request->input('output'),
            'energy' => $request->input('energy'),
            'power' => $request->input('power'),
            'product_id' => $request->input('product_id'),
            'category_id' => 4
        ]);

        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/powers/'.$request->input('id').'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/powers/'.$request->input('id').'/'.$fileName, $img, 'public');
        }

        if($request->input('Check1') == true)Storage::delete('images/powers/'.$request->input('id').'/1.png');
        if($request->input('Check1') == true)Storage::delete('images/powers/'.$request->input('id').'/1.png');

        return redirect()->route('powerPage');
    }
    public function deletePower($id){
        DB::delete("DELETE FROM products WHERE id=?",[$id]);

        return redirect()->route('powerPage');
    }
    public function aboutPower($id){
        $power = DB::select("SELECT *,power_banks.id AS cid FROM power_banks LEFT JOIN products ON products.id = power_banks.product_id WHERE power_banks.id=?",[$id]);
        $directory = 'images/powers/'.$id.'/';
        $images = Storage::allFiles($directory);
        $feedback_count = DB::select("SELECT * FROM product_feedback WHERE product_id = ?",[$power[0]->product_id]);
        $feedbacks = DB::select("SELECT * FROM product_feedback WHERE product_id = ? AND message IS NOT NULL AND is_correct = true",[$power[0]->product_id]);
        $rat = DB::select('select avg(rating) as a from product_feedback where product_id=?', [$power[0]->product_id]);
        $feedback_answer = DB::select("SELECT * FROM feedback_answer");
        if(count($rat) > 0){
            $rat = round((float)$rat[0]->a,1) ;
        }

        $arr = ["1" => 0,"2" =>0,"3"=>0,"4"=>0,"5"=>0];
        foreach ($feedback_count as $f){
            switch ($f->rating){
                case 1:$arr['1']++;break;
                case 2:$arr['2']++;break;
                case 3:$arr['3']++;break;
                case 4:$arr['4']++;break;
                case 5:$arr['5']++;break;

            }
        }
        if(count($feedback_count)>0) {
            $arr['1'] = round($arr['1'] * 100 / count($feedback_count),0);
            $arr['2'] = round($arr['2'] * 100 / count($feedback_count),0);;
            $arr['3'] = round($arr['3'] * 100 / count($feedback_count),0);;
            $arr['4'] = round($arr['4'] * 100 / count($feedback_count),0);;
            $arr['5'] = round($arr['5'] * 100 / count($feedback_count),0);;
        }

        return view('about.aboutPower',['power'=>$power[0], 'image'=>$images,
            'feedback'=>$feedback_count ,'feedbacks'=>$feedbacks, 'data'=>$arr,'rating'=>$rat,'feedback_answer'=>$feedback_answer]);

    }
}
