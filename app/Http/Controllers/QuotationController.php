<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Quotation;
use Auth;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function create()
    {
        return view('quotation.create');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            // Add your validation rules here based on your requirements
            'quotation_number' => 'required|unique:quotations',
            'product_id' => 'required',
            // Add other fields and validation rules as needed
        ]);

        // Create a new quotation
        $quotation = new Quotation([
            'quotation_number' => $request->input('quotation_number'),
            'product_id' => $request->input('product_id'),
            'terms_and_condition' => $request->input('terms_and_condition'),
            'quantity' => $request->input('quantity'),
            'product_price' => $request->input('product_price'),
            'quotation_type' => $request->input('quotation_type'),
            'company_name' => $request->input('company_name'),
            'company_address' => $request->input('company_address'),
            'quotation_subject' => $request->input('quotation_subject'),
            'created_user' => Auth::id(),
            'company_persons' => $request->input('company_persons'),
            'attention_quot' => $request->input('attention_quot'),
            'dear_sir' => $request->input('dear_sir'),
            'quotation_body' => $request->input('quotation_body'),
        ]);

        // Save the quotation
        $quotation->save();

        // Redirect to a success page or do whatever is appropriate for your application
        return redirect()->route('quotation.create')->with('success', 'Quotation created successfully!');
    }
}
