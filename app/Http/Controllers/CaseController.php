<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CaseController extends Controller
{
    public function returnCases(){
        $cases = DB::select("SELECT *,cases.id AS cid FROM cases LEFT JOIN products ON products.id = cases.product_id ORDER BY cases.id DESC");
        $images = [];
        for($i = 0;$i<count($cases);$i++) {
            $directory = 'images/cases/'.$cases[$i]->cid.'/';
            $img = Storage::allFiles($directory);
            if (count($img) > 0) {
                $images[$cases[$i]->cid] = $img[0];
            }
        }
        return view('cases',['cases' => $cases, 'image'=>$images]);
    }
    public function addCasePage(){
        return view('add.addCase');
    }
    public function addCaseSubmit(Request  $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'material' => 'required|max:100',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $product_id = DB::table('products')->insertGetId([
            'type' => "Чохол",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        $case_id = DB::table('cases')->insertGetId([
            'name' => $request->input('name'),
            'material' => $request->input('material'),
            'product_id' => $product_id,
            'category_id' => 2
        ]);
        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/cases/'.$case_id.'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/cases/'.$case_id.'/'.$fileName, $img, 'public');
        }

        return redirect()->route('casesPage');
    }
    public function updateCasePage($id){
        $case = DB::select("SELECT * FROM cases LEFT JOIN products ON products.id = cases.product_id WHERE cases.id=?",[$id]);
        $first = $case[0];
        return view('change.updateCase',['case' => $first]);
    }
    public function updateCase(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100',
            'material' => 'required|max:100',
            'Image1' => 'nullable',
            'Image2' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        DB::table('products')->where('id',$request->input('product_id'))->update([
            'type' => "Чохол",
            'name' => $request->input('name'),
            'count' => $request->input('count'),
            'price' => $request->input('price')
        ]);
        DB::table('cases')->where('id',$request->input('id'))->update([
            'name' => $request->input('name'),
            'material' => $request->input('material'),
            'product_id' => $request->input('product_id'),
            'category_id' => 2
        ]);

        if ($request->hasFile('Image1')) {
            $image      = $request->file('Image1');
            $fileName   = "1" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/cases/'.$request->input('id').'/'.$fileName, $img, 'public');
        }
        if ($request->hasFile('Image2')) {
            $image      = $request->file('Image2');
            $fileName   = "2" . '.' . $image->getClientOriginalExtension();
            $img = $image->openFile()->fread($image->getSize());
            Storage::put('images/cases/'.$request->input('id').'/'.$fileName, $img, 'public');
        }

        if($request->input('Check1') == true)Storage::delete('images/cases/'.$request->input('id').'/1.png');
        if($request->input('Check1') == true)Storage::delete('images/cases/'.$request->input('id').'/1.png');

        return redirect()->route('casesPage');
    }
    public function deleteCase($id){
        DB::delete("DELETE FROM products WHERE id=?",[$id]);

        return redirect()->route('casesPage');
    }
    public function aboutCase($id){
        $case = DB::select("SELECT *,cases.id AS cid FROM cases LEFT JOIN products ON products.id = cases.product_id WHERE cases.id=?",[$id]);
        $directory = 'images/cases/'.$id.'/';
        $images = Storage::allFiles($directory);
        $feedback_count = DB::select("SELECT * FROM product_feedback WHERE product_id = ?",[$case[0]->product_id]);
        $feedbacks = DB::select("SELECT * FROM product_feedback WHERE product_id = ? AND message IS NOT NULL AND is_correct = true",[$case[0]->product_id]);
        $rat = DB::select('select avg(rating) as a from product_feedback where product_id=?', [$case[0]->product_id]);
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

        return view('about.aboutCase',['case'=>$case[0], 'image'=>$images,
            'feedback'=>$feedback_count ,'feedbacks'=>$feedbacks, 'data'=>$arr,'rating'=>$rat,'feedback_answer'=>$feedback_answer]);

    }
}
