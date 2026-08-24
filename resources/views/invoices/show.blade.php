<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture {{ $invoice->number }}</title>
    <style>
        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            padding: 40px 24px;
            color: #1a1a2e;
        }

        /* ===== CONTENEUR PRINCIPAL ===== */
        .invoice-container {
            max-width: 880px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            padding: 48px 56px;
        }

        @media print {
            body { background: #ffffff; padding: 0; }
            .invoice-container { box-shadow: none; border-radius: 0; padding: 32px 40px; }
            .no-print { display: none !important; }
        }

        /* ===== BOUTONS ACTIONS ===== */
        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .actions a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
            font-family: inherit;
        }

        .actions .btn-back {
            color: #4a4a6a;
            background: #f0f2f5;
        }

        .actions .btn-back:hover {
            background: #e4e7ec;
            transform: translateY(-1px);
        }

        .actions .btn-pdf {
            color: #ffffff;
            background: #04a59d;
        }

        .actions .btn-pdf:hover {
            background: #03847d;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(4, 165, 157, 0.25);
        }

        /* ===== MESSAGE SUCCÈS ===== */
        .alert-success {
            background: #e6f7f5;
            color: #03847d;
            padding: 14px 20px;
            border-radius: 10px;
            border-left: 4px solid #04a59d;
            margin-bottom: 24px;
            font-weight: 500;
        }

        /* ===== EN-TÊTE ===== */
        .invoice-header {
            display: flex;
            justify-content: space-between;
            padding-bottom: 24px;
            margin-bottom: 32px;
            border-bottom: 2px solid #f0f2f5;
        }

        .invoice-header .left h1 {
            font-size: 32px;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -0.5px;
        }

        .invoice-header .left .number {
            font-size: 15px;
            color: #6b7280;
            margin-top: 4px;
        }

        .invoice-header .left .number strong {
            color: #1a1a2e;
        }

        .invoice-header .left .date {
            font-size: 14px;
            color: #6b7280;
        }

        .invoice-header .right {
            text-align: right;
        }

        .invoice-header .right h2 {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .invoice-header .right p {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.6;
        }

        /* ===== INFOS CLIENT ===== */
        .client-box {
            background: #f7f8fa;
            padding: 20px 24px;
            border-radius: 12px;
            margin-bottom: 32px;
            border: 1px solid #e8eaed;
        }

        .client-box h3 {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .client-box .name {
            font-size: 17px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .client-box .detail {
            font-size: 14px;
            color: #4a4a6a;
            margin-top: 2px;
        }

        /* ===== TABLEAU ===== */
        .table-wrapper {
            overflow-x: auto;
            margin-bottom: 24px;
        }

        table.invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.invoice-table thead th {
            padding: 14px 16px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            background: #f3f4f6;
            border-bottom: 2px solid #e8eaed;
        }

        table.invoice-table thead th:last-child,
        table.invoice-table thead th:nth-child(3) {
            text-align: right;
        }

        table.invoice-table thead th:nth-child(2) {
            text-align: center;
        }

        table.invoice-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #e8eaed;
            font-size: 14px;
            color: #1a1a2e;
        }

        table.invoice-table tbody td:last-child,
        table.invoice-table tbody td:nth-child(3) {
            text-align: right;
        }

        table.invoice-table tbody td:nth-child(2) {
            text-align: center;
        }

        table.invoice-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== TOTAUX ===== */
        .totals {
            display: flex;
            justify-content: flex-end;
        }

        .totals table {
            width: 40%;
            min-width: 240px;
            border-collapse: collapse;
        }

        .totals table td {
            padding: 6px 12px;
            font-size: 14px;
        }

        .totals table td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .totals table .total-ht td {
            color: #4a4a6a;
        }

        .totals table .total-tva td {
            color: #6b7280;
            font-size: 13px;
        }

        .totals table .total-ttc td {
            font-size: 18px;
            font-weight: 800;
            color: #1a1a2e;
            border-top: 2px solid #1a1a2e;
            padding-top: 12px;
        }

        .totals table .total-ttc td:last-child {
            color: #04a59d;
        }

        /* ===== STATUT ===== */
        .status-badge {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 16px;
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
            font-size: 12px;
            color: #aab0b9;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #f0f2f5;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .invoice-container { padding: 24px 20px; }
            .invoice-header { flex-direction: column; gap: 16px; }
            .invoice-header .right { text-align: left; }
            .totals table { width: 100%; }
        }

        @media (max-width: 480px) {
            .invoice-container { padding: 16px 14px; }
            .invoice-header .left h1 { font-size: 24px; }
            .actions { flex-direction: column; align-items: stretch; }
            .actions a { justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="invoice-container">

        <!-- ===== BOUTONS ACTIONS ===== -->
        <div class="actions no-print">
            <a href="{{ route('invoices.create') }}" class="btn-back">← Nouvelle facture</a>
            <a href="{{ route('invoices.download', $invoice) }}" class="btn-pdf">📄 Télécharger PDF</a>
        </div>

        <!-- ===== MESSAGE SUCCÈS ===== -->
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

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

        <!-- ===== INFOS CLIENT ===== -->
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
        <div class="table-wrapper">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Désignation</th>
                        <th>Qté</th>
                        <th>P.U HT</th>
                        <th>Total HT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2, ',', ' ') }} Ar</td>
                        <td>{{ number_format($item->total, 2, ',', ' ') }} Ar</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- ===== TOTAUX ===== -->
        <div class="totals">
            <table>
                <tr class="total-ht">
                    <td>Total HT :</td>
                    <td>{{ number_format($invoice->total_ht, 2, ',', ' ') }} Ar</td>
                </tr>
                <tr class="total-tva">
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