<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Facture</title>
    <style>
        /* ===== RESET & BASE ===== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #1a1a2e;
        }

        /* ===== CONTENEUR PRINCIPAL ===== */
        .form-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            max-width: 820px;
            width: 100%;
            padding: 40px 48px;
            transition: box-shadow 0.3s ease;
        }

        .form-container:hover {
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
        }

        /* ===== EN-TÊTE ===== */
        .form-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 24px;
            margin-bottom: 32px;
            border-bottom: 2px solid #f0f2f5;
        }

        .form-header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            letter-spacing: -0.3px;
        }

        .form-header .badge {
            font-size: 12px;
            font-weight: 600;
            color: #ffffff;
            background: #04a59d;
            padding: 6px 14px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ===== CHAMPS CLIENT ===== */
        .client-fields {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 32px;
        }

        @media (max-width: 600px) {
            .client-fields {
                grid-template-columns: 1fr;
            }
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .field-group label {
            font-size: 13px;
            font-weight: 600;
            color: #4a4a6a;
            letter-spacing: 0.3px;
        }

        .field-group label .required {
            color: #e74c3c;
            margin-left: 2px;
        }

        .field-group input {
            padding: 12px 16px;
            border: 2px solid #e8eaed;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            color: #1a1a2e;
            background: #fafbfc;
            transition: all 0.25s ease;
            outline: none;
        }

        .field-group input:focus {
            border-color: #04a59d;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(4, 165, 157, 0.08);
        }

        .field-group input:hover {
            border-color: #c5c8d0;
        }

        .field-group input::placeholder {
            color: #aab0b9;
        }

        /* ===== TABLE DES ARTICLES ===== */
        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title .count {
            font-size: 13px;
            font-weight: 500;
            color: #6b7280;
            background: #f0f2f5;
            padding: 2px 10px;
            border-radius: 12px;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 12px;
            border: 2px solid #e8eaed;
            background: #fafbfc;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 500px;
        }

        .items-table thead th {
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

        .items-table thead th:last-child {
            text-align: right;
        }

        .items-table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #e8eaed;
        }

        .items-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== CHAMPS DANS LE TABLEAU ===== */
        .items-table input {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #e8eaed;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: #1a1a2e;
            background: #ffffff;
            transition: all 0.25s ease;
            outline: none;
        }

        .items-table input:focus {
            border-color: #04a59d;
            box-shadow: 0 0 0 4px rgba(4, 165, 157, 0.08);
        }

        .items-table input:hover {
            border-color: #c5c8d0;
        }

        .items-table input::placeholder {
            color: #aab0b9;
        }

        .items-table .qty,
        .items-table .price {
            max-width: 100px;
        }

        .items-table .line-total {
            font-weight: 700;
            font-size: 15px;
            color: #1a1a2e;
            text-align: right;
            display: block;
            padding: 4px 0;
        }

        .items-table .line-total:empty::before {
            content: '0,00 €';
            color: #aab0b9;
            font-weight: 400;
        }

        /* ===== BOUTONS D'ACTION ===== */
        .actions {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
        }

        .btn svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .btn-primary {
            background: #04a59d;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #03847d;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(4, 165, 157, 0.25);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #f0f2f5;
            color: #4a4a6a;
        }

        .btn-secondary:hover {
            background: #e4e7ec;
            transform: translateY(-1px);
        }

        .btn-secondary:active {
            transform: translateY(0);
        }

        .btn-danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-danger:hover {
            background: #fecaca;
        }

        .btn-danger svg {
            stroke: #dc2626;
        }

        /* ===== PIED DE FORMULAIRE ===== */
        .form-footer {
            margin-top: 32px;
            padding-top: 24px;
            border-top: 2px solid #f0f2f5;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .form-footer .total {
            font-size: 18px;
            font-weight: 700;
            color: #1a1a2e;
        }

        .form-footer .total span {
            color: #04a59d;
            font-size: 22px;
        }

        .form-footer .submit {
            padding: 14px 40px;
            background: #04a59d;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s ease;
            letter-spacing: 0.3px;
        }

        .form-footer .submit:hover {
            background: #03847d;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(4, 165, 157, 0.3);
        }

        .form-footer .submit:active {
            transform: translateY(0);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .form-container {
                padding: 24px 20px;
                border-radius: 12px;
            }

            .form-header h1 {
                font-size: 18px;
            }

            .items-table {
                min-width: 420px;
            }

            .items-table input {
                font-size: 13px;
                padding: 8px 10px;
            }

            .items-table .qty,
            .items-table .price {
                max-width: 70px;
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch;
                text-align: center;
            }

            .form-footer .submit {
                width: 100%;
                justify-content: center;
            }

            .actions {
                flex-direction: column;
            }

            .actions .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .form-container {
                padding: 16px 14px;
            }

            .form-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .items-table {
                min-width: 320px;
                font-size: 13px;
            }

            .items-table thead th {
                padding: 10px 10px;
                font-size: 10px;
            }

            .items-table tbody td {
                padding: 8px 10px;
            }

            .items-table input {
                font-size: 12px;
                padding: 6px 8px;
            }

            .items-table .qty,
            .items-table .price {
                max-width: 60px;
            }
        }

        /* ===== UTILITAIRES ===== */
        .text-muted {
            color: #6b7280;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: 700;
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar {
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f2f5;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #b0b5bd;
        }

        /* ===== ANIMATION LIGNE AJOUTÉE ===== */
        .item-row-new {
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .item-row-removing {
            animation: fadeOut 0.25s ease forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: translateX(-12px);
            }
        }
    </style>
</head>
<body>

    <div class="form-container">

        <!-- ===== EN-TÊTE ===== -->
        <div class="form-header">
            <h1>📄 Nouvelle Facture</h1>
            <span class="badge">#F2024-001</span>
        </div>

        <!-- ===== CHAMPS CLIENT ===== -->
        <div class="client-fields">
            <div class="field-group">
                <label>Nom du client <span class="required">*</span></label>
                <input type="text" name="client_name" placeholder="Ex: Jean Dupont" required>
            </div>
            <div class="field-group">
                <label>Email du client <span class="required">*</span></label>
                <input type="email" name="client_email" placeholder="client@exemple.com" required>
            </div>
        </div>

        <!-- ===== TABLEAU DES ARTICLES ===== -->
        <div class="section-title">
            🛒 Articles
            <span class="count" id="itemCount">1</span>
        </div>

        <div class="table-wrapper">
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width:40%;">Produit / Description</th>
                        <th style="width:15%;">Quantité</th>
                        <th style="width:20%;">Prix unitaire</th>
                        <th style="width:20%;text-align:right;">Total</th>
                        <th style="width:5%;"></th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                    <tr class="item-row" data-index="0">
                        <td>
                            <input type="text" name="items[0][name]" placeholder="Nom du produit" required>
                        </td>
                        <td>
                            <input type="number" name="items[0][quantity]" class="qty" value="1" min="1" step="1">
                        </td>
                        <td>
                            <input type="number" name="items[0][unit_price]" class="price" step="0.01" min="0" value="0.00" placeholder="0,00">
                        </td>
                        <td>
                            <span class="line-total" data-total="0">0,00 €</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-remove" style="padding:6px 10px;border-radius:8px;" title="Supprimer">
                                <svg viewBox="0 0 24 24" width="16" height="16">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- ===== BOUTONS D'ACTION ===== -->
        <div class="actions">
            <button type="button" class="btn btn-secondary" onclick="addRow()">
                <svg viewBox="0 0 24 24">
                    <path d="M12 4v16M4 12h16"/>
                </svg>
                Ajouter une ligne
            </button>
        </div>

        <!-- ===== PIED DE FORMULAIRE ===== -->
        <div class="form-footer">
            <div class="total">
                Total <span id="grandTotal">0,00 €</span>
            </div>
            <button type="submit" class="submit">
                ✅ Créer la facture
            </button>
        </div>

    </div>

    <script>
        let itemIndex = 1;

        function addRow() {
            const tbody = document.getElementById('itemsBody');
            const tr = document.createElement('tr');
            tr.className = 'item-row item-row-new';
            tr.dataset.index = itemIndex;

            tr.innerHTML = `
                <td>
                    <input type="text" name="items[${itemIndex}][name]" placeholder="Nom du produit" required>
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][quantity]" class="qty" value="1" min="1" step="1">
                </td>
                <td>
                    <input type="number" name="items[${itemIndex}][unit_price]" class="price" step="0.01" min="0" value="0.00" placeholder="0,00">
                </td>
                <td>
                    <span class="line-total" data-total="0">0,00 €</span>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-remove" style="padding:6px 10px;border-radius:8px;" title="Supprimer">
                        <svg viewBox="0 0 24 24" width="16" height="16">
                            <path d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
            itemIndex++;

            // Mettre à jour le compteur
            document.getElementById('itemCount').textContent = tbody.children.length;

            // Attacher les événements
            const inputs = tr.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    updateLineTotal(this);
                    updateGrandTotal();
                });
                input.addEventListener('change', function() {
                    updateLineTotal(this);
                    updateGrandTotal();
                });
            });

            // Bouton supprimer
            tr.querySelector('.btn-remove').addEventListener('click', function() {
                removeRow(this);
            });

            // Calculer la ligne
            updateLineTotal(tr.querySelector('input'));
            updateGrandTotal();
        }

        function removeRow(btn) {
            const tr = btn.closest('.item-row');
            const tbody = document.getElementById('itemsBody');

            if (tbody.children.length <= 1) {
                alert('Il doit rester au moins une ligne.');
                return;
            }

            tr.classList.add('item-row-removing');
            setTimeout(() => {
                tr.remove();
                document.getElementById('itemCount').textContent = tbody.children.length;
                updateGrandTotal();
            }, 250);
        }

        function updateLineTotal(input) {
            const tr = input.closest('.item-row');
            const qty = parseFloat(tr.querySelector('.qty').value) || 0;
            const price = parseFloat(tr.querySelector('.price').value) || 0;
            const total = qty * price;
            const span = tr.querySelector('.line-total');
            span.textContent = total.toFixed(2) + ' €';
            span.dataset.total = total.toFixed(2);
        }

        function updateGrandTotal() {
            const totals = document.querySelectorAll('.line-total');
            let grand = 0;
            totals.forEach(span => {
                grand += parseFloat(span.dataset.total) || 0;
            });
            document.getElementById('grandTotal').textContent = grand.toFixed(2) + ' €';
        }

        // ===== INITIALISATION =====
        document.addEventListener('DOMContentLoaded', function() {
            // Événements sur les champs existants
            document.querySelectorAll('.item-row input').forEach(input => {
                input.addEventListener('input', function() {
                    updateLineTotal(this);
                    updateGrandTotal();
                });
                input.addEventListener('change', function() {
                    updateLineTotal(this);
                    updateGrandTotal();
                });
            });

            // Boutons supprimer existants
            document.querySelectorAll('.btn-remove').forEach(btn => {
                btn.addEventListener('click', function() {
                    removeRow(this);
                });
            });

            // Calculer le total initial
            document.querySelectorAll('.item-row input').forEach(input => {
                updateLineTotal(input);
            });
            updateGrandTotal();
        });
    </script>

</body>
</html>