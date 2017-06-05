<?php

namespace App\Http\Controllers;

use Request;
use Auth;

use App\Http\Requests;

class CustomerController extends Controller
{
    //
    public function index()
    {
        //
        if(Auth::check()) {
            $customers = \App\Customer::all();
            return view('customers.index', compact('customers'));
        }
        else{
            return redirect('/');
        }
    }

    public function show($id)
    {
        if(Auth::check()) {
            $customer = \App\Customer::find($id);
            return view('customers.show', compact('customer'));
        }
        else{
                return redirect('/');
            }
    }


    public function create()
    {
        if(Auth::check()) {

            return view('customers.create');
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
    public function store()
    {
        if(Auth::check()) {

            $customer = Request::all();
            \App\Customer::create($customer);
            //$customer->save();
            //return redirect('customers');

            //$customer=Request::all();
            //\App\Customer::create($customer);
            return redirect('customers');
        }else{
            return redirect('/');
        }

    }

    public function edit($id)
    {
        if(Auth::check()) {

            /// $customer=\App\Customer::find($cust_number);
            // return view('customers.edit',compact('customer'));
            $customer = \App\Customer::find($id);
            return view('customers.edit', compact('customer'));
        }else{
            return redirect('/');
        }
    }


    public function update($id)
    {
        //
        if(Auth::check()) {
            $customerUpdate = Request::all();
            $customer = \App\Customer::find($id);
            $customer->update($customerUpdate);
            return redirect('customers');
        }
        else{
            return redirect('/');
        }
    }

    public function destroy($id)
    {
        if(Auth::check()) {
            \App\Stock::where('customer_id', $id)->delete();
            \App\Investment::where('customer_id', $id)->delete();
            \App\Customer::find($id)->delete();
            return redirect('customers');
        }else{
            return redirect('/');
        }
    }


    public function stringify($id)
    {
        // $customer=Customer::where('id', $id)->select('customer_id','name','address','city','state','zip','home_phone','cell_phone')->first();
        $customer = \App\Customer::where('id', $id)->select('cust_number','name','address','city','state','zip','home_phone','cell_phone')->first();
        $investment = \App\Investment::where('customer_id',$id)->select('category','description','acquired_value','acquired_date','recent_value','recent_date')->get();
        $stock = \App\Stock::where('customer_id',$id)->select('symbol','name','purchase_price','purchase_date')->get();
        $r = [];
        if($customer != null)
        {
            $customer = $customer->toArray();
            $investment = $investment->toArray();
            $stock = $stock->toArray();
            $r = [$customer, $stock, $investment];
            return $r;
        }
        else
        {
            return 0;
        }
    }


}
