<?php

namespace App\Http\Controllers;

use App\Product;
use App\sections;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
        $getAllSections = sections::all();
        $getAllProducts = Product::all();
        return view('pages.products.product',compact('getAllSections','getAllProducts'));
        
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
       
       $validateData=$request->validate([
           'product_name'=>'required|unique:products',
            'section_id'=>'required'
       ],
        [
            'product_name.required'=>'من فضلك ادخل اسم المنتج',
            'product_name.unique'=>'اسم المنتج موجود مسبقا'
        ]);


        Product::create([
            'product_name' => $request->product_name,
            'section_id' =>$request ->section_id,
            'description'  => $request->description
        ]);

        session()->flash('success','تم إضافة المنتج بنجاح');
        return redirect("/products");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      
        $id = sections::where('section_name', $request->section_name)->first()->id;

        $product = Product::find($request->id);

        if(!$product){
           session()->flash('error','لم يتم التعديل ');
           return redirect("/products");
        }

       $product->update([
       'Product_name' => $request->Product_name,
       'description' => $request->description,
       'section_id' => $id,
       ]);

       session()->flash('success', 'تم تعديل المنتج بنجاح');
       return redirect("/products");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
      
        $product = Product::find($request->id);
        if(!$product){
            session()->flash('error','لم يتم الحذف ');
            return redirect("/products");
         }
        $product->delete();
        session()->flash('success', 'تم حذف المنتج بنجاح');
        return back();
    }
}
