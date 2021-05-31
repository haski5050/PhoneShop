<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MemoryController extends Controller
{
    public function returnMemory(){
        $memory = DB::select("SELECT *,memory_cards.id AS cid FROM memory_cards LEFT JOIN products ON products.id = memory_cards.product_id ORDER BY memory_cards.id DESC");
        $images = [];
        for($i = 0;$i<count($memory);$i++) {
            $directory = 'images/memory/'.$memory[$i]->cid.'/';
            $img = Storage::allFiles($directory);
            if (count($img) > 0) {
                $images[$memory[$i]->cid] = $img[0];
            }
        }
        return view('memory',['memory' => $memory, 'image'=>$images]);
    }
    public function addMemoryPage(){
        return view('add.addMemory');
    }
    public function addMemorySubmit(Request  $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'memory' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product_id = DB::table('products')->insertGetId([
            'type' => "Карти пам'яті",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        $memory_id = DB::table('memory_cards')->insertGetId([
            'name' => $request->input('name'),
            'memory' => $request->input('memory'),
            'product_id' => $product_id,
            'category_id' => 5
        ]);
        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/memory/'.$memory_id.'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/memory/'.$memory_id.'/'.$fileName, $img, 'public');
        }

        return redirect()->route('memoryPage');
    }
    public function updateMemoryPage($id){
        $memory = DB::select("SELECT * FROM memory_cards LEFT JOIN products ON products.id = memory_cards.product_id WHERE memory_cards.id=?",[$id]);
        $first = $memory[0];
        return view('change.updateMemory',['memory' => $first]);
    }
    public function updateMemory(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'memory' => 'required',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::table('products')->where('id',$request->input('product_id'))->update([
            'type' => "Карти пам'яті",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        DB::table('memory_cards')->where('id',$request->input('id'))->update([
            'name' => $request->input('name'),
            'memory' => $request->input('memory'),
            'product_id' => $request->input('product_id'),
            'category_id' => 5
        ]);

        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/memory/'.$request->input('id').'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/memory/'.$request->input('id').'/'.$fileName, $img, 'public');
        }

        if($request->input('Check1') == true)Storage::delete('images/memory/'.$request->input('id').'/1.png');
        if($request->input('Check1') == true)Storage::delete('images/memory/'.$request->input('id').'/1.png');

        return redirect()->route('memoryPage');
    }
    public function deleteMemory($id){
        DB::delete("DELETE FROM products WHERE id=?",[$id]);

        return redirect()->route('memoryPage');
    }
    public function aboutMemory($id){
        $memory = DB::select("SELECT *,memory_cards.id AS cid FROM memory_cards LEFT JOIN products ON products.id = memory_cards.product_id WHERE memory_cards.id=?",[$id]);
        $directory = 'images/memory/'.$id.'/';
        $images = Storage::allFiles($directory);
        $feedback_count = DB::select("SELECT * FROM product_feedback WHERE product_id = ?",[$memory[0]->product_id]);
        $feedbacks = DB::select("SELECT * FROM product_feedback WHERE product_id = ? AND message IS NOT NULL AND is_correct = true",[$memory[0]->product_id]);
        $rat = DB::select('select avg(rating) as a from product_feedback where product_id=?', [$memory[0]->product_id]);
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

        return view('about.aboutMemory',['memory'=>$memory[0], 'image'=>$images,
            'feedback'=>$feedback_count ,'feedbacks'=>$feedbacks, 'data'=>$arr,'rating'=>$rat,'feedback_answer'=>$feedback_answer]);

    }
}
