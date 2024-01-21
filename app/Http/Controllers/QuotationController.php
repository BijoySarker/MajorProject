<?php

namespace App\Http\Controllers;

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
            'quotation_number' => 'required|unique:quotations',
            'product_id' => 'required|array',
            'quantity' => 'required|array',
            'unit_price' => 'required|array',
            'quotation_type' => 'required',
            'company_name' => 'required|string',
            'company_address' => 'required|string',
            'quotation_subject' => 'required|string',
            // 'created_user' => 'required|integer', // Assuming it's an integer, adjust as needed
            'company_persons' => 'required|string',
            'attention_quot' => 'required|string',
            'dear_sir' => 'required|string',
            'quotation_body' => 'required|string',
            'terms_and_condition' => 'required|string',
        ]);

        $quantityJson = json_encode($request->input('quantity'));
        $unitPriceJson = json_encode($request->input('unit_price'));

        $totalPrice = array_sum(array_map(function ($quantity, $unitPrice) {
            return $quantity * $unitPrice;
        }, $request->input('quantity'), $request->input('unit_price')));

        $quotation = new Quotation([
            'quotation_number' => $request->input('quotation_number'),
            'terms_and_condition' => $request->input('terms_and_condition'),
            'quantity' => $quantityJson,
            'unit_price' => $unitPriceJson,
            'quotation_type' => $request->input('quotation_type'),
            'company_name' => $request->input('company_name'),
            'company_address' => $request->input('company_address'),
            'quotation_subject' => $request->input('quotation_subject'),
            'created_user' => Auth::id(),
            'company_persons' => $request->input('company_persons'),
            'attention_quot' => $request->input('attention_quot'),
            'dear_sir' => $request->input('dear_sir'),
            'quotation_body' => $request->input('quotation_body'),
            'product_price' => $totalPrice,
        ]);

        $quotation = new Quotation;
        $quotation->product_id = json_encode([26, 21]);
        $quotation->save();

        return redirect()->route('quotation.index')->with('success', 'Quotation created successfully!');
    }


    public function getProductDetails(Request $request)
    {
        $productId = $request->input('productId');
        $product = Product::find($productId);

        return response()->json([
            'product_specification' => $product->product_specifications,
            'image' => $product->product_image,
            'price' => $product->price,
        ]);
    }

    public function index()
    {
        $quotations = Quotation::paginate(20);

        return view('quotation.index', compact('quotations'));
    }

    public function show(Quotation $quotation)
    {
        return view('quotation.show', compact('quotation'));
        // dd($quotation);
    }

    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()->route('quotation.index')->with('success', 'Quotation deleted successfully');
    }
}
