<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class InvestmentController extends Controller
{
    //
    public function index()
    {
        if(Auth::check()) {
        $investments=\App\Investment::all();
        return view('investments.index',compact('investments'));
        }
        else{
            return redirect('/');
        }

    }

    public function show($id)
    {
        if(Auth::check()) {
        $investment = \App\Investment::findOrFail($id);

        return view('investments.show',compact('investment'));
        }
        else{
            return redirect('/');
        }
    }


    public function create()
    {
        if(Auth::check()) {
        $customers = \App\Customer::pluck('name','id');
        return view('investments.create', compact('customers'));
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
        $investment= new \App\Investment($request->all());
        $investment->save();

        return redirect('investments');
    }
else{
return redirect('/');
}

}

    public function edit($id)
    {
        if(Auth::check()) {
        $investment=\App\Investment::find($id);
        return view('investments.edit',compact('investment'));
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
        $investment= new \App\Investment($request->all());
        $investment=\App\Investment::find($id);
        $investment->update($request->all());
        return redirect('investments');
    }
else{
return redirect('/');
}
    }

    public function destroy($id)
    {
        if(Auth::check()) {
        \App\Investment::find($id)->delete();
        return redirect('investments');
        }
        else{
            return redirect('/');
        }
    }


}
