<?php

namespace App\Http\Controllers;
use Input;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{
    public function __contruct(){
        // echo "Got yeah!";
    }

    public function index(){
        return view("index");
    }

    public function ajaxSave() {
        try {
            $data = \Storage::disk('local')->exists('products.json') ? json_decode(\Storage::disk('local')->get('products.json')) : [];
            $inputData['p_name'] = Input::get('p_name');
            $inputData['p_qty'] = Input::get('p_qty');
            $inputData['amount'] = Input::get('amount');
            $inputData['total_amount'] = Input::get('p_qty') * Input::get('amount');
            $inputData['created_at'] = date('Y-m-d H:i:s');
 
            array_push($data, $inputData);
            \Storage::disk('local')->put('products.json', json_encode($data));
            $data = \Storage::disk('local')->exists('products.json') ? json_decode(\Storage::disk('local')->get('products.json')) : [];
            
            $res = [
                "code"=>"E00",
                "message"=>"Operation Successful",
                "data"=>$data
            ];
        } catch(Exception $e) {
            $res = [
                "code"=>"E09",
                "message"=>$e->getMessage()
            ];
        }
        return \Response::json($res);
    }

    public function ajaxEdit() {
        try {
            $index = Input::get('index');
            
            $data = \Storage::disk('local')->exists('products.json') ? json_decode(\Storage::disk('local')->get('products.json')) : [];
            $inputData['p_name'] = Input::get('p_name');
            $inputData['p_qty'] = Input::get('p_qty');
            $inputData['amount'] = Input::get('amount');
            $inputData['total_amount'] = Input::get('p_qty') * Input::get('amount');
            $inputData['created_at'] = $data[$index]->created_at;

            // REPLACE INDEX WITH THE UPDATED DATA
            $data[$index] = $inputData;

            \Storage::disk('local')->put('products.json', json_encode($data));
            $data = \Storage::disk('local')->exists('products.json') ? json_decode(\Storage::disk('local')->get('products.json')) : [];
            
            $res = [
                "code"=>"E00",
                "message"=>"Operation Successful",
                "data"=>$data
            ];
        } catch(Exception $e) {
            $res = [
                "code"=>"E09",
                "message"=>$e->getMessage()
            ];
        }
        return \Response::json($res);
    }

    public function ajaxDelete($index) {
        try {
            $data = \Storage::disk('local')->exists('products.json') ? json_decode(\Storage::disk('local')->get('products.json')) : [];

            // DELETE INDEX FROM THE JSON
            array_splice($data, $index, 1);

            \Storage::disk('local')->put('products.json', json_encode($data));
            $data = \Storage::disk('local')->exists('products.json') ? json_decode(\Storage::disk('local')->get('products.json')) : [];
            
            $res = [
                "code"=>"E00",
                "message"=>"Operation Successful",
                "data"=>$data
            ];
        } catch(Exception $e) {
            $res = [
                "code"=>"E09",
                "message"=>$e->getMessage()
            ];
        }
        return \Response::json($res);
    }

    public function ajaxGet() {
        try {
            $data = \Storage::disk('local')->exists('products.json') ? json_decode(\Storage::disk('local')->get('products.json')) : [];
            
            $res = [
                "code"=>"E00",
                "message"=>"Operation Successful",
                "data"=>$data
            ];
        } catch(Exception $e) {
            $res = [
                "code"=>"E09",
                "message"=>$e->getMessage()
            ];
        }
        return \Response::json($res);
    }
}
