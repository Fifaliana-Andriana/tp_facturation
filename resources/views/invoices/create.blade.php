<input type="text" name="client_name" placeholder="Nom" required>
<input type="email" name="client_email" placeholder="Email" required>

<div id="items">
    <div class="item-row">
        <input type="text" name="items[0][name]" placeholder="produit">
        <input type="number" name="items[0][quantity]" class="qty">
        <input type="number" name="items[0][unit_price]" step="0.01" class="price">
        <span class="line-total">0</span>
    </div>
</div>
<button type="button" onclick="addRow()">Ajouter</button>