<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class StockController extends Controller
{
    //
    public function index()
    {
        //
        if(Auth::check()) {
        $stocks=\App\Stock::all();
        return view('stocks.index',compact('stocks'));
        }
        else{
            return redirect('/');
        }

    }

    public function show($id)
    {
        if(Auth::check()) {
        $stock = \App\Stock::findOrFail($id);

        return view('stocks.show',compact('stock'));
        }
        else{
            return redirect('/');
        }
    }


    public function create()
    {
        if(Auth::check()) {


        $customers = \App\Customer::pluck('name','id');
        return view('stocks.create', compact('customers'));
        }
        else{
            return redirect('/');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if(Auth::check()) {
        $stock= new \App\Stock($request->all());
        $stock->save();

        return redirect('stocks');
        }
        else{
            return redirect('/');
        }
    }

    public function edit($id)
    {
        if(Auth::check()) {

        $stock=\App\Stock::find($id);
        return view('stocks.edit',compact('stock'));
        }
        else{
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {
        //
        if(Auth::check()) {
        $stock= new \App\Stock($request->all());
        $stock=\App\Stock::find($id);
        $stock->update($request->all());
        return redirect('stocks');
        }
        else{
            return redirect('/');
        }
    }

    public function destroy($id)
    {
        if(Auth::check()) {

        \App\Stock::find($id)->delete();
        return redirect('stocks');
        }
        else{
            return redirect('/');
        }

    }


}
