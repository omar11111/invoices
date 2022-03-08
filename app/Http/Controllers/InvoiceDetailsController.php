<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\invoice_attatchments;
use App\invoice_details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($invoiceId)
    {
        $invoices = Invoice::where('id',$invoiceId)->first();
        $details  = invoice_details::where('invoice_id',$invoiceId)->get();
        $attachments  = invoice_attatchments::where('invoice_id',$invoiceId)->get();
        return view('pages.invoices.details_invoices',compact('invoices',"details",'attachments'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function show($invoiceId)
    {
        $invoices = Invoice::where('id',$invoiceId)->first();
        $details  = invoice_details::where('id_Invoice',$invoiceId)->get();
        $attachments  = invoice_attatchments::where('invoice_id',$invoiceId)->get();

        // return $attachments;
        return view('pages.invoices.details_invoices',compact('invoices',"details",'attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoice_details $invoice_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoice_details $invoice_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoice_details  $invoice_details
     * @return \Illuminate\Http\Response
     */
    

    public function destroy(Request $request)
    {
        $invoices = invoice_attatchments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();
    }

     public function get_file($invoice_number,$file_name)

    {
        $contents= Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->download( $contents);
    }



    public function open_file($invoice_number,$file_name)

    {
        $files = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($files);
    }
}
