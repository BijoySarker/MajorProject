<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('search');

        $customers = Customer::when($query, function ($q) use ($query) {
            $q->where('customer_name', 'like', '%' . $query . '%');
        })->latest()->paginate(20);

        return view('customer.index', compact('customers'))->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $users = User::all(); // Assuming you have a User model
        return view('customer.create', compact('users'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_type' => 'required|in:General,Dealer,Corporate',
            'registered_by' => 'required',
            'customer_phone' => 'required',
            'customer_address' => 'nullable',
            'customer_email' => 'nullable|email',
            'customer_postal_code' => 'nullable',
            'customer_city' => 'required',
        ]);

        $requestData = $request->all();

        Customer::create($requestData);

        return redirect()->route('customer.index')->with('success', 'Customer profile created successfully.');
    }


    public function show(Customer $customer)
    {
        return view('customer.show',compact('customer'));
    }


    public function edit(Customer $customer)
    {
        $users = User::all(); // Assuming you have a User model
        return view('customer.edit', compact('customer', 'users'));
    }


    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'customer_name' => 'sometimes|required',
            'customer_type' => 'sometimes|in:General,Dealer,Corporate',
            'registered_by' => 'sometimes',
            'customer_phone' => 'sometimes',
            'customer_address' => 'nullable',
            'customer_email' => 'nullable|email',
            'customer_postal_code' => 'nullable',
            'customer_city' => 'sometimes',
        ]);

        $customer->update([
            'customer_name' => $request->input('customer_name'),
            'customer_type' => $request->input('customer_type'),
            'registered_by' => $request->input('registered_by'),
            'customer_phone' => $request->input('customer_phone'),
            'customer_address' => $request->input('customer_address'),
            'customer_email' => $request->input('customer_email'),
            'customer_postal_code' => $request->input('customer_postal_code'),
            'customer_city' => $request->input('customer_city'),
        ]);

        return redirect()->route('customer.index')->with('success', 'Customer profile updated successfully');
    }

    
    public function destroy(Customer $customer)
    {
        $customer->delete();
  
        return redirect()->route('customer.index')->with('success','Customer profile deleted successfully');
    }
}
