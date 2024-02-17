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

        $invoiceData = [
            'invoice_number' => $request->input('invoice_number'),
            'date' => $request->input('date'),
            'customer_id' => $request->input('customer_id'),
            'paid' => $request->input('paid'),
            'due' => $totalPrice - ($request->input('pay') ?? 0),
            'terms_and_conditions' => $request->input('terms_and_conditions'),
        ];

        // Check if 'quantity' is an array and encode it as JSON
        if (is_array($request->input('quantity'))) {
            $invoiceData['quantity'] = json_encode($request->input('quantity'));
        } else {
            $invoiceData['quantity'] = $request->input('quantity');
        }

        $invoice = Invoice::create($invoiceData);

        // Associate products with the invoice
        foreach ($products as $product) {
            $invoice->products()->create([
                'id' => $product['id'],
                'quantity' => $product['quantity'],
                // Add other product details as needed
            ]);
        }

        return redirect()->route('invoice.index')->with('success', 'Invoice created successfully');
    }
    // Validate invoice request
    private function validateInvoiceRequest(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required',
            'date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            // 'product_ids' => 'required|array',
            // 'quantity' => 'required|array',
            'paid' => 'boolean',
            'due' => 'numeric',
            'terms_and_conditions' => 'nullable|string',
            // Add other validation rules as needed
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
                    // Add other product details as needed
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
}
