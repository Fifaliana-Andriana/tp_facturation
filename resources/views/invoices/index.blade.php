<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Factures</title>
    <style>
        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            padding: 40px 24px;
            color: #1a1a2e;
        }

        /* ===== CONTENEUR ===== */
        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        /* ===== EN-TÊTE ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -0.3px;
        }

        .header .btn-new {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #04a59d;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            font-family: inherit;
            transition: all 0.25s ease;
        }

        .header .btn-new:hover {
            background: #03847d;
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(4, 165, 157, 0.25);
        }

        /* ===== ALERTE SUCCÈS ===== */
        .alert-success {
            background: #e6f7f5;
            color: #03847d;
            padding: 14px 20px;
            border-radius: 10px;
            border-left: 4px solid #04a59d;
            margin-bottom: 24px;
            font-weight: 500;
        }

        /* ===== TABLEAU ===== */
        .table-wrapper {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead th {
            padding: 16px 20px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            background: #f3f4f6;
            border-bottom: 2px solid #e8eaed;
        }

        table thead th.text-right {
            text-align: right;
        }

        table thead th.text-center {
            text-align: center;
        }

        table tbody td {
            padding: 16px 20px;
            border-bottom: 1px solid #e8eaed;
            font-size: 14px;
            color: #1a1a2e;
            vertical-align: middle;
        }

        table tbody tr:hover {
            background: #fafbfc;
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        table tbody td.text-right {
            text-align: right;
        }

        table tbody td.text-center {
            text-align: center;
        }

        table tbody .invoice-number {
            font-weight: 700;
            color: #1a1a2e;
        }

        table tbody .client-name {
            font-weight: 500;
        }

        /* ===== STATUT ===== */
        .status-badge {
            display: inline-block;
            padding: 4px 16px;
            border-radius: 20px;
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

        /* ===== ACTIONS ===== */
        .actions-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .actions-cell a {
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .actions-cell .action-view {
            color: #04a59d;
        }

        .actions-cell .action-view:hover {
            color: #03847d;
        }

        .actions-cell .action-pdf {
            color: #6b7280;
        }

        .actions-cell .action-pdf:hover {
            color: #1a1a2e;
        }

        /* ===== EMPTY STATE ===== */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #aab0b9;
        }

        .empty-state .icon {
            font-size: 48px;
            margin-bottom: 12px;
        }

        .empty-state p {
            font-size: 16px;
        }

        /* ===== PAGINATION ===== */
        .pagination {
            margin-top: 24px;
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            color: #4a4a6a;
            background: #ffffff;
            border: 1px solid #e8eaed;
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background: #f0f2f5;
            border-color: #d1d5db;
        }

        .pagination .active {
            background: #04a59d;
            color: #ffffff;
            border-color: #04a59d;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            body { padding: 24px 16px; }
            .header { flex-direction: column; align-items: stretch; }
            .header .btn-new { justify-content: center; }
            table thead th,
            table tbody td { padding: 12px 14px; font-size: 13px; }
            .actions-cell { flex-direction: column; gap: 4px; }
        }

        @media (max-width: 600px) {
            table thead th,
            table tbody td { padding: 10px 10px; font-size: 12px; }
            table thead th { font-size: 10px; }
            .status-badge { font-size: 10px; padding: 2px 10px; }
            .actions-cell a { font-size: 11px; }
        }
    </style>
</head>
<body>

    <div class="container">

        <!-- ===== EN-TÊTE ===== -->
        <div class="header">
            <h1>📋 Liste des Factures</h1>
            <a href="{{ route('invoices.create') }}" class="btn-new">+ Nouvelle Facture</a>
        </div>

        <!-- ===== ALERTE SUCCÈS ===== -->
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <!-- ===== TABLEAU ===== -->
        <div class="table-wrapper">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>N° Facture</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th class="text-right">Total TTC</th>
                            <th class="text-center">Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td class="invoice-number">{{ $invoice->number }}</td>
                            <td class="client-name">{{ $invoice->client->name }}</td>
                            <td>{{ $invoice->invoice_date->format('d/m/Y') }}</td>
                            <td class="text-right">{{ number_format($invoice->total_ttc, 2, ',', ' ') }} Ar</td>
                            <td class="text-center">
                                <span class="status-badge {{ $invoice->status == 'paid' ? 'paid' : 'unpaid' }}">
                                    {{ $invoice->status == 'paid' ? 'Payée' : 'Impayée' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="actions-cell">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="action-view">Voir</a>
                                    <a href="{{ route('invoices.download', $invoice) }}" class="action-pdf">PDF</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="icon">📭</div>
                                    <p>Aucune facture pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== PAGINATION ===== -->
        @if($invoices->hasPages())
            <div class="pagination">
                {{ $invoices->links() }}
            </div>
        @endif

    </div>

</body>
</html>