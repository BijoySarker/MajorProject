<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('invoice.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $this->validateInvoiceRequest($request);

        $products = $this->prepareProducts($request);

        $totalPrice = array_sum(array_map(function ($product) {
            return $product['quantity'] * Product::find($product['id'])->price;
        }, $products));

        $invoice = Invoice::create([
            'invoice_number' => $request->input('invoice_number'),
            'date' => $request->input('date'),
            'customer_id' => $request->input('customer_id'),
            'product_ids' => $request->input('products_ids'), // Change to 'products_ids'
            'quantity' => $request->input('quantity'),
            'paid' => $request->input('paid'),
            'due' => $totalPrice - ($request->input('pay') ?? 0),
            'terms_and_conditions' => $request->input('terms_and_conditions'),
            // Add other fields as needed
        ]);
        
        $invoice->products()->attach($request->input('products_ids'));

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully');
    }

    private function validateInvoiceRequest(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required',
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'product_ids' => 'required|array',
            'quantity' => 'required|array',
            'paid' => 'boolean',
            'due' => 'numeric',
            'terms_and_conditions' => 'nullable|string',
            // Add other validation rules as needed
        ]);
    }

    private function prepareProducts(Request $request)
        {
            $products = [];
            foreach ($request->input('products_id') as $index => $productId) {
                $products[] = [
                    'id' => $productId,
                    'quantity' => $request->input('quantity')[$index],
                    // Add other product details as needed
                ];
            }
            return $products;
        }


    public function searchCustomers(Request $request)
    {
        $query = $request->input('query');
        $customers = Customer::where('customer_name', 'LIKE', "%{$query}%")->get();
        return view('search.search_customers', compact('customers'));
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
}
