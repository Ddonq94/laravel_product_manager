<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return file_get_contents(public_path('data.json'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);

        // return $response = response($request->only(['name', 'quantity', 'unit_price']), 200);


        try {

            $save_path = public_path('data.json');

            $products = [];
            if (!file_exists($save_path)) {
                file_put_contents(public_path('data.json'), stripslashes(json_encode([],JSON_PRETTY_PRINT)));
            }

            else{

                $products = json_decode(file_get_contents(public_path('data.json')), true) ? json_decode(file_get_contents(public_path('data.json')), true): [];
            }


            // $products = json_decode(public_path('data.json'));
            
            $newInput = $request->only(['name', 'quantity', 'unit_price']);
            
            $newInput['created_at'] = date('Y-m-d H:i:s');
            $newInput['id'] = (string) Str::uuid();
            
            array_push($products,$newInput);
            
            file_put_contents(public_path('data.json'), stripslashes(json_encode($products,JSON_PRETTY_PRINT)));
            
            

            $response = response($newInput, 200);
		    return $response;
 
        } catch(Exception $e) {
 
            $res =  ['error' => true, 'message' => $e->getMessage()];
            $response = response($res, 500);
		    return $response;
 
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        
        $products = json_decode(file_get_contents(public_path('data.json')), true) ? json_decode(file_get_contents(public_path('data.json')), true): [];
        
        $product = array_values(array_filter($products, function ($var) use ($id) {
            return ($var['id'] == $id);
        }))[0];

        
        // dd($product);
        
        return view('edit')->with('product',$product);
        
    }


   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        try {


            $products = json_decode(file_get_contents(public_path('data.json')), true) ? json_decode(file_get_contents(public_path('data.json')), true): [];

            $current = array_values(array_filter($products, function ($var) use ($id) {
                return ($var['id'] == $id);
            }))[0];

            $currentKey =  array_search($id, array_column($products, 'id'));

            $newInput = $request->only(['name', 'quantity', 'unit_price']);
            
            $newInput['created_at'] = $current['created_at'];
            $newInput['id'] = $id;

            $products[$currentKey] = $newInput;
            
            
            file_put_contents(public_path('data.json'), stripslashes(json_encode($products,JSON_PRETTY_PRINT)));
            
            // return $newInput;
        return redirect('/')->with('success', 'Product Edited Successfully');

 
        } catch(Exception $e) {
 
            return ['error' => true, 'message' => $e->getMessage()];
 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
