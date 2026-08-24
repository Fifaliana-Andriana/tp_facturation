<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoice->number }}</title>
    <style>
        /* ===== BASE POUR PDF ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', 'Inter', Arial, sans-serif;
            font-size: 12px;
            color: #1a1a2e;
            background: #ffffff;
            padding: 40px 48px;
        }

        .invoice-container {
            max-width: 820px;
            margin: 0 auto;
        }

        /* ===== EN-TÊTE ===== */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            padding-bottom: 20px;
            margin-bottom: 28px;
            border-bottom: 2px solid #e8eaed;
        }

        .invoice-header .left h1 {
            font-size: 28px;
            font-weight: 800;
            color: #1a1a2e;
        }

        .invoice-header .left .number {
            font-size: 14px;
            color: #6b7280;
            margin-top: 2px;
        }

        .invoice-header .left .number strong {
            color: #1a1a2e;
        }

        .invoice-header .left .date {
            font-size: 13px;
            color: #6b7280;
        }

        .invoice-header .right {
            text-align: right;
        }

        .invoice-header .right h2 {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .invoice-header .right p {
            font-size: 12px;
            color: #6b7280;
            line-height: 1.5;
        }

        /* ===== CLIENT ===== */
        .client-box {
            background: #f7f8fa;
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            border: 1px solid #e8eaed;
        }

        .client-box h3 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 6px;
        }

        .client-box .name {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .client-box .detail {
            font-size: 13px;
            color: #4a4a6a;
        }

        /* ===== TABLEAU ===== */
        table.invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.invoice-table thead th {
            padding: 10px 14px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #6b7280;
            background: #f3f4f6;
            border-bottom: 2px solid #e8eaed;
        }

        table.invoice-table thead th.text-right {
            text-align: right;
        }

        table.invoice-table thead th.text-center {
            text-align: center;
        }

        table.invoice-table tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid #e8eaed;
            font-size: 13px;
            color: #1a1a2e;
        }

        table.invoice-table tbody td.text-right {
            text-align: right;
        }

        table.invoice-table tbody td.text-center {
            text-align: center;
        }

        /* ===== TOTAUX ===== */
        .totals {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 16px;
        }

        .totals table {
            width: 40%;
            min-width: 220px;
            border-collapse: collapse;
        }

        .totals table td {
            padding: 4px 8px;
            font-size: 13px;
        }

        .totals table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .totals .total-ttc td {
            font-size: 16px;
            font-weight: 800;
            border-top: 2px solid #1a1a2e;
            padding-top: 10px;
        }

        /* ===== STATUT ===== */
        .status-badge {
            display: inline-block;
            padding: 3px 14px;
            border-radius: 16px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.paid {
            background: #e6f7f5;
            color: #03847d;
        }

        .status-badge.unpaid {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ===== PIED ===== */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #aab0b9;
            margin-top: 32px;
            padding-top: 16px;
            border-top: 1px solid #f0f2f5;
        }

        /* ===== PRINT ===== */
        @media print {
            body { padding: 20px 32px; }
        }
    </style>
</head>
<body>

    <div class="invoice-container">

        <!-- ===== EN-TÊTE ===== -->
        <div class="invoice-header">
            <div class="left">
                <h1>FACTURE</h1>
                <p class="number">N° : <strong>{{ $invoice->number }}</strong></p>
                <p class="date">Date : {{ $invoice->invoice_date->format('d/m/Y') }}</p>
            </div>
            <div class="right">
                <h2>VOTRE ENTREPRISE</h2>
                <p>NIF: 123456789</p>
                <p>Antananarivo, Madagascar</p>
            </div>
        </div>

        <!-- ===== CLIENT ===== -->
        <div class="client-box">
            <h3>Facturé à :</h3>
            <p class="name">{{ $invoice->client->name }}</p>
            <p class="detail">{{ $invoice->client->email }}</p>
            @if($invoice->client->address)
                <p class="detail">{{ $invoice->client->address }}</p>
            @endif
            @if($invoice->client->nif)
                <p class="detail">NIF: {{ $invoice->client->nif }}</p>
            @endif
        </div>

        <!-- ===== TABLEAU ===== -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Désignation</th>
                    <th class="text-center">Qté</th>
                    <th class="text-right">P.U HT</th>
                    <th class="text-right">Total HT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->unit_price, 2, ',', ' ') }} Ar</td>
                    <td class="text-right">{{ number_format($item->total, 2, ',', ' ') }} Ar</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- ===== TOTAUX ===== -->
        <div class="totals">
            <table>
                <tr>
                    <td>Total HT :</td>
                    <td>{{ number_format($invoice->total_ht, 2, ',', ' ') }} Ar</td>
                </tr>
                <tr>
                    <td>TVA 20% :</td>
                    <td>{{ number_format($invoice->total_ttc - $invoice->total_ht, 2, ',', ' ') }} Ar</td>
                </tr>
                <tr class="total-ttc">
                    <td>Total TTC :</td>
                    <td>{{ number_format($invoice->total_ttc, 2, ',', ' ') }} Ar</td>
                </tr>
            </table>
        </div>

        <!-- ===== STATUT ===== -->
        <div>
            <span class="status-badge {{ $invoice->status == 'paid' ? 'paid' : 'unpaid' }}">
                Statut : {{ $invoice->status == 'paid' ? 'Payée' : 'Impayée' }}
            </span>
        </div>

        <!-- ===== PIED ===== -->
        <div class="footer">Merci pour votre confiance.</div>

    </div>

</body>
</html>