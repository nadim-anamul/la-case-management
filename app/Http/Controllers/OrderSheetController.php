<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderSheet;
use Spatie\Browsershot\Browsershot; // <-- UPDATED: Using Browsershot

class OrderSheetController extends Controller
{
    /**
     * Display a listing of all order sheets.
     */
    public function index()
    {
        $orders = OrderSheet::orderBy('id', 'desc')->get();
        return view('order_list', compact('orders'));
    }

    /**
     * Display the form to create a new order sheet.
     */
    public function create()
    {
        return view('order_form');
    }

    /**
     * Store a newly created order sheet in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validateOrder($request);
        $order = OrderSheet::create($validatedData);
        return redirect()->route('order.index')->with('success', 'Order created successfully. <a href="'.route('order.preview', $order->id).'" target="_blank" class="underline">Preview Page</a> | <a href="'.route('order.pdf', $order->id).'" target="_blank" class="underline">Download PDF</a>');
    }

    /**
     * Show the HTML preview page that looks like the PDF.
     */
    public function showPreview($id)
    {
        $order = OrderSheet::findOrFail($id);
        return view('pdf.pdf_preview', compact('order'));
    }

    /**
     * Generate and stream the PDF for a given order using Browsershot.
     */
    public function generatePdf($id)
    {
        $order = OrderSheet::findOrFail($id);
        
        // Get the full URL to the preview page
        $url = route('order.preview', $order->id);
        
        // Replace 127.0.0.1 with localhost for better compatibility
        $url = str_replace('127.0.0.1', 'localhost', $url);

        try {
            // Use Browsershot to convert the URL to a PDF
            $pdf = Browsershot::url($url)
                ->noSandbox() // Added to fix Puppeteer sandbox error
                ->timeout(60) // Increased timeout to 60 seconds
                ->format('A4')
                ->pdf();
        } catch (\Exception $e) {
            // Fallback: Generate PDF from HTML content directly
            $html = view('pdf.pdf_preview', compact('order'))->render();
            
            $pdf = Browsershot::html($html)
                ->noSandbox()
                ->timeout(60)
                ->format('A4')
                ->pdf();
        }

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="order_sheet_'.$order->id.'.pdf"',
        ]);
    }

    /**
     * Show the form for editing the specified order sheet.
     */
    public function edit($id)
    {
        $order = OrderSheet::findOrFail($id);
        return view('order_edit', compact('order'));
    }

    /**
     * Update the specified order sheet in storage.
     */
    public function update(Request $request, $id)
    {
        $order = OrderSheet::findOrFail($id);
        $validatedData = $this->validateOrder($request);
        $order->update($validatedData);
        return redirect()->route('order.index')->with('success', 'Order updated successfully. <a href="'.route('order.preview', $order->id).'" target="_blank" class="underline">Preview Page</a> | <a href="'.route('order.pdf', $order->id).'" target="_blank" class="underline">Download PDF</a>');
    }

    /**
     * Remove the specified order sheet from storage.
     */
    public function destroy($id)
    {
        $order = OrderSheet::findOrFail($id);
        $order->delete();
        return redirect()->route('order.index')->with('success', 'Order deleted successfully.');
    }

    /**
     * Reusable validation logic.
     */
    private function validateOrder(Request $request)
    {
        return $request->validate([
            'district' => 'required|string|max:255',
            'case_type' => 'required|string|max:255',
            'case_number' => 'required|string|max:255',
            'order_date' => 'required|date',
            'applicant_name' => 'required|string',
            'applicant_details' => 'required|string',
            'roedad_review' => 'required|string',
            'miss_case_details' => 'required|string',
            'sa_record_details' => 'required|string',
            'sa_owner_heir_details' => 'required|string',
            'sa_heir_heir_details' => 'required|string',
            'sa_heir_transfer_details_1' => 'required|string',
            'sa_heir_transfer_details_2' => 'required|string',
            'rs_khatian_details' => 'required|string',
            'rs_owner_heir_details' => 'required|string',
            'tax_review' => 'required|string',
            'no_claim_review' => 'required|string',
            'investigation_review' => 'required|string',
            'applicant_claim' => 'required|string',
            'overall_review' => 'required|string',
            'final_order_summary' => 'required|string',
            'final_payment_order' => 'required|string',
            'compensation_details' => 'required|string',
            'total_compensation_words' => 'required|string',
            'lao_name' => 'required|string',
            'adc_name' => 'required|string',
        ]);
    }
}