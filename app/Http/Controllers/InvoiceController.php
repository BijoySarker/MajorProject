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
        $invoices = Invoice::orderBy('created_at', 'desc')->get();

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

        // Retrieve pay, due, and total price from form inputs
        $pay = $request->input('pay');
        $due = $request->input('due');
        $totalPrice = $request->input('total_price');

        // Encode product_ids as JSON
        $productIds = $request->input('product_ids');
        $encodedProductIds = json_encode($productIds);

        // Include pay, due, and total price in the $invoiceData array
        $invoiceData = [
            'invoice_number' => $request->input('invoice_number'),
            'date' => $request->input('date'),
            'customer_id' => $request->input('customer_id'),
            'paid' => $due == 0 ? 1 : 0,
            'due' => $due,
            'total_price' => $totalPrice,
            'terms_and_conditions' => $request->input('terms_and_conditions'),
            'quantity' => is_array($request->input('quantity')) ? json_encode($request->input('quantity')) : $request->input('quantity'),
            'product_ids' => $encodedProductIds,
            'pay' => $pay,
        ];

        $invoice = Invoice::create($invoiceData);

        // Associate products with the invoice
        $products = $this->prepareProducts($request);
        foreach ($products as $product) {
            $invoice->products()->create([
                'id' => $product['id'],
                'quantity' => $product['quantity'],
            ]);
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully');

        // dd($invoiceData);
    }

    private function validateInvoiceRequest(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required',
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',           
            'paid' => 'boolean',
            'due' => 'numeric',
            'total_price' => 'numeric',
            'terms_and_conditions' => 'nullable|string',
        ]);
    }

    private function prepareProducts(Request $request)
    {
        $products = [];
        $productIds = $request->input('product_ids');
        $quantities = $request->input('quantity');

        // Check if both product_ids and quantity are arrays and have the same length
        if (is_array($productIds) && is_array($quantities) && count($productIds) === count($quantities)) {
            foreach ($productIds as $index => $productId) {
                $products[] = [
                    'id' => $productId,
                    'quantity' => $quantities[$index],
                ];
            }
        } else {
            // Handle the case where product_ids or quantity is not an array or has different lengths
            // You can log an error, throw an exception, or handle it based on your application's logic
            // For example:
            // throw new InvalidArgumentException('Invalid product data provided');
            // Log::error('Invalid product data provided: ' . json_encode($request->all()));
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

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        
        // Decode product_ids and quantity fields
        $invoice->product_ids = json_decode($invoice->product_ids, true) ?? [];
        $invoice->quantity = json_decode($invoice->quantity, true) ?? [];
    
        // Fetch products based on the product IDs stored in the invoice
        $productIds = json_decode($invoice->product_ids);
        $products = Product::whereIn('id', $productIds)->get();
    
        return view('invoice.show', compact('invoice', 'products'));
    }
    
    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::all();
        $products = Product::all();
        
        // Decode product_ids and quantity fields
        $invoice->product_ids = json_decode($invoice->product_ids, true) ?? [];
        $invoice->quantity = json_decode($invoice->quantity, true) ?? [];
        
        // Fetch products based on the product IDs stored in the invoice
        $productIds = json_decode($invoice->product_ids);
        $selectedProducts = Product::whereIn('id', $productIds)->get();
        
        return view('invoice.edit', compact('invoice', 'customers', 'products', 'selectedProducts'));
    }

    public function update(Request $request, $id)
    {
        $this->validateInvoiceRequest($request);

        $invoice = Invoice::findOrFail($id);

        // Update invoice data
        $invoice->invoice_number = $request->input('invoice_number');
        $invoice->date = $request->input('date');
        // Update other fields as needed...

        $invoice->save();

        return redirect()->route('invoice.index')->with('success', 'Invoice updated successfully');
    }

    public function destroy(Invoice $invoice)
    {        
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice deleted successfully');
    }

    public function print($id)
    {
        $invoice = Invoice::findOrFail($id);
        
        // Decode product_ids and quantity fields
        $invoice->product_ids = json_decode($invoice->product_ids, true) ?? [];
        $invoice->quantity = json_decode($invoice->quantity, true) ?? [];
    
        // Fetch products based on the product IDs stored in the invoice
        $productIds = json_decode($invoice->product_ids);
        $products = Product::whereIn('id', $productIds)->get();

        return view('invoice.print', compact('invoice', 'products')); // Pass the invoice and products data to the print view

        // dd($products);
    }
}