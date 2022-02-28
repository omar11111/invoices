<?php

namespace App\Http\Controllers;

use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAllSections = sections::all();
        return view('pages.sections.section',compact('getAllSections'));
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
       
        // return $request;

        $validatedData= $request->validate(
        [
            'section_name' =>'required|unique:sections|max:255',
            'section_des' => 'required'
        ],
        [
        'section_name.required' =>'من فضلك ادخل اسم القسم',
        'section_name.unique' => 'هذا الحقل موجود مسبقا',
        'section_des.required' => 'من فضلك ادخل الوصف' 
    ]);

        $createdBy= Auth::user()->name;
        sections::create([
            'section_name' => $request->section_name,
            'description'  => $request->section_des,
            'created_by'   =>$createdBy,
        ]);
 
        

        session()->flash('success','تم إضافة القسم بنجاح');
        return redirect("/sections");
    
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       $sectionId = $request -> id;
       
       $request->validate([
        'section_name' =>'required|unique:sections|max:255',
        'description' => 'required'
       ],[
        'section_name.required' =>'من فضلك ادخل اسم القسم',
        'section_name.unique' => 'هذا الحقل موجود مسبقا',
        'description.required' => 'من فضلك ادخل القسم' 
       ]);

       // find the section first then update
       $findSection = sections::find($sectionId);
       if(!$findSection){
           session()->flash('Error','هذا القسم غير موجود');
           return redirect('/sections');
       } 

       $findSection->update([
           'section_name' => $request->section_name,
           'description' => $request->description,

       ]);

       session()->flash('success','تم التعديل بنجاح');
       return redirect('/sections');

      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $deletedSectioId = $request -> id;
       
       $findSectionToDelete = sections::find($deletedSectioId)->delete();

       if(!$findSectionToDelete){
        session()->flash('Error','لم يتم الحذف بنجاح');
        return redirect('/sections');
       }

       session()->flash('success','تم الذف بنجاح');
       return redirect('/sections');   
       
    }

    
}
