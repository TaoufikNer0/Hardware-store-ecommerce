document.addEventListener('DOMContentLoaded', function () {
    // Cart quantity update (if you add <input class="quantity-input" data-price="..."> in cart.php)
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('input', function() {
            let quantity = parseInt(this.value);
            const price = parseFloat(this.dataset.price);
            if (quantity < 1 || isNaN(quantity)) {
                quantity = 1;
                this.value = 1;
            }
            const subtotalCell = this.closest('tr').querySelector('.subtotal');
            if (subtotalCell) subtotalCell.textContent = (price * quantity).toFixed(2);  // Update subtotal
            // Recalculate total (simplified)
            let total = 0;
            quantityInputs.forEach(qtyInput => {
                const qty = parseInt(qtyInput.value) || 1;
                const itemPrice = parseFloat(qtyInput.dataset.price);
                if (!isNaN(itemPrice)) total += qty * itemPrice;
            });
            const totalElement = document.getElementById('cart-total');
            if (totalElement) totalElement.textContent = total.toFixed(2);
        });
    });
});