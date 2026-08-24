<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $invoices =  Invoice::with('client')->latest()->paginate(15);
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $clients = client::all();
        return view('invoices.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string',
            'client_email' => 'required|email',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        // 1. Créer ou récupérer le client avec son email
        $client = Client::firstOrCreate(
            ['email' => $request->client_email],
            ['name' => $request->client_name]
        );

        $invoice = Invoice::create([
            'client_id' => $client->id,
            'number' => Invoice::generateNumber(),
            'invoice_date' => now(),
        ]);

        $total_ht = 0;
        foreach ($request->items as $item) {
            $lineTotal = $item['quantity'] * $item['unit_price'];
            $total_ht += $lineTotal;
            $invoice->items()->create([
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total' => $lineTotal,
            ]);
        }

        $invoice->update([
            'total_ht' => $total_ht,
            'total_ttc' => $total_ht * 1.20 // TVA 20%
        ]);

        // 2. Générer PDF + Envoi auto
        $pdf = $this->generatePdf($invoice);
        Mail::to($client->email)->send(new InvoiceMail($invoice, $pdf));

        return redirect()->route('invoices.show', $invoice)->with('success', 'Facture créée et envoyée à ' . $client->email);
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
        $invoice->load('client', 'items');
        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function download(Invoice $invoice)
    {
        $pdf = $this->generatePdf($invoice);
        return $pdf->download($invoice->number . '.pdf');//pour le téléchargement
    }

    private function generatePdf(Invoice $invoice)
    {
        $invoice->load('client', 'items');
        return Pdf::loadView('invoices.pdf', compact('invoice'));
    }
}
