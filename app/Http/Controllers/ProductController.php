<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(){
        $products = [];
        $total = 0;
        if(Storage::disk('public')->exists('products.json')){
            $products = Storage::disk('public')->get('products.json');

            if($products){
                $products = json_decode((string) $products, true);
                $total = array_sum(array_map(fn($product) => floatval($product['total']), $products));
            }
            $products = array_reverse($products);
        }

        return view('index', compact('products', 'total'));
    }

    public function store(Request $request){
        $data = $request->except('_token');
        $data['created_at'] = date('Y-m-d h:i:s');
        $data['total'] = $data['product_quantity'] * $data['product_price'];

        $products = [];
        $total = 0;
        if(Storage::disk('public')->exists('products.json')){
            $products = Storage::disk('public')->get('products.json');
            
            if($products){
                $products = json_decode((string) $products, true);
                $total = array_sum(array_map(fn($product) => floatval($product['total']), $products));
            }
        }
        $products[] = $data;
        Storage::disk('public')->put('products.json', json_encode($products));

        $products = array_reverse($products);
        return ['message'=>'Stored successfully!', 'products'=>$products, 'total'=>number_format((float) $total)];
    }

    public function edit(Request $request, int $id){
        $data = $request->except('_token');
        $data['created_at'] = date('Y-m-d h:i:s');
        $data['total'] = $data['product_quantity'] * $data['product_price'];

        $products = [];
        $total = 0;
        if(Storage::disk('public')->exists('products.json')){
            $products = Storage::disk('public')->get('products.json');
            
            if($products){
                $products = json_decode((string) $products, true);
                $products = array_reverse($products);
                $products[$id] = $data;

                $total = array_sum(array_map(fn($product) => floatval($product['total']), $products));
            }
        }
        Storage::disk('public')->put('products.json', json_encode($products));

        $products = array_reverse($products);
        return ['message'=>'Updated successfully!', 'products'=>$products, 'total'=>number_format((float) $total)];
    }

    public function delete(Request $request, int $id){
        $products = [];
        $total = 0;
        if(Storage::disk('public')->exists('products.json')){
            $products = Storage::disk('public')->get('products.json');
            
            if($products){
                $products = json_decode((string) $products, true);
                $products = array_reverse($products);
                unset($products[$id]);
                $products = array_values($products);

                $total = array_sum(array_map(fn($product) => floatval($product['total']), $products));
            }
        }
        $products = array_reverse($products);
        Storage::disk('public')->put('products.json', json_encode($products));

        $products = array_reverse($products);
        return ['message'=>'Deleted successfully!', 'products'=>$products, 'total'=>number_format((float) $total)];
    }
}
