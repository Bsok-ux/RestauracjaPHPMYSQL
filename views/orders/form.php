<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Nowe zamówienie - Stolik nr <?= $table['number'] ?></h2>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Kategorie</h5>
                                </div>
                                <div class="list-group list-group-flush" id="categoryList">
                                    <a href="#" class="list-group-item list-group-item-action active" 
                                       data-category="all">
                                        Wszystkie kategorie
                                    </a>
                                    <?php foreach ($categories as $category): ?>
                                        <a href="#" class="list-group-item list-group-item-action" 
                                           data-category="<?= $category['id'] ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="card-title mb-0">Menu</h5>
                                        <div class="input-group" style="width: 300px;">
                                            <input type="text" class="form-control" id="menuSearch" 
                                                   placeholder="Szukaj dań...">
                                            <span class="input-group-text">
                                                <i class="bi bi-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row" id="menuItems">
                                        <?php foreach ($menuItems as $item): ?>
                                            <?php if ($item['is_available']): ?>
                                                <div class="col-md-6 mb-3 menu-item" 
                                                     data-category="<?= $item['category_id'] ?>"
                                                     data-name="<?= strtolower(htmlspecialchars($item['name'])) ?>">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <h6 class="card-title">
                                                                <?= htmlspecialchars($item['name']) ?>
                                                            </h6>
                                                            <p class="card-text small text-muted mb-2">
                                                                <?= htmlspecialchars($item['category_name']) ?>
                                                            </p>
                                                            <p class="card-text">
                                                                <small><?= htmlspecialchars($item['description']) ?></small>
                                                            </p>
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <span class="h6 mb-0">
                                                                    <?= number_format($item['price'], 2) ?> zł
                                                                </span>
                                                                <div class="input-group input-group-sm" style="width: 120px;">
                                                                    <button type="button" class="btn btn-outline-secondary decrease-qty"
                                                                            data-item-id="<?= $item['id'] ?>">-</button>
                                                                    <input type="number" class="form-control text-center item-qty"
                                                                           name="items[<?= $item['id'] ?>]" value="0" min="0"
                                                                           data-item-id="<?= $item['id'] ?>">
                                                                    <button type="button" class="btn btn-outline-secondary increase-qty"
                                                                            data-item-id="<?= $item['id'] ?>">+</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Zamówienie</h5>
                                </div>
                                <div class="card-body">
                                    <div id="orderSummary">
                                        <p class="text-muted text-center" id="emptyOrder">
                                            Dodaj pozycje do zamówienia
                                        </p>
                                        <div id="orderItems" class="d-none">
                                            <div class="list-group mb-3" id="orderItemsList"></div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <strong>Razem:</strong>
                                                <strong id="orderTotal">0.00 zł</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary w-100" id="submitOrder" disabled>
                                        Utwórz zamówienie
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filter
    document.querySelectorAll('#categoryList a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('#categoryList a').forEach(a => a.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.dataset.category;
            document.querySelectorAll('.menu-item').forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Search functionality
    document.getElementById('menuSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        document.querySelectorAll('.menu-item').forEach(item => {
            const name = item.dataset.name;
            if (name.includes(searchTerm)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // Quantity controls
    document.querySelectorAll('.decrease-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`input[data-item-id="${itemId}"]`);
            if (input.value > 0) {
                input.value = parseInt(input.value) - 1;
                input.dispatchEvent(new Event('change'));
            }
        });
    });
    
    document.querySelectorAll('.increase-qty').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`input[data-item-id="${itemId}"]`);
            input.value = parseInt(input.value) + 1;
            input.dispatchEvent(new Event('change'));
        });
    });
    
    // Order summary update
    const menuItems = <?= json_encode($menuItems) ?>;
    const itemsMap = new Map(menuItems.map(item => [item.id, item]));
    
    document.querySelectorAll('.item-qty').forEach(input => {
        input.addEventListener('change', updateOrderSummary);
    });
    
    function updateOrderSummary() {
        const orderItems = [];
        let total = 0;
        
        document.querySelectorAll('.item-qty').forEach(input => {
            const quantity = parseInt(input.value);
            if (quantity > 0) {
                const itemId = input.dataset.itemId;
                const item = itemsMap.get(parseInt(itemId));
                const subtotal = quantity * item.price;
                total += subtotal;
                
                orderItems.push({
                    id: itemId,
                    name: item.name,
                    quantity: quantity,
                    price: item.price,
                    subtotal: subtotal
                });
            }
        });
        
        const orderItemsList = document.getElementById('orderItemsList');
        const emptyOrder = document.getElementById('emptyOrder');
        const orderItemsDiv = document.getElementById('orderItems');
        const submitBtn = document.getElementById('submitOrder');
        
        if (orderItems.length > 0) {
            emptyOrder.classList.add('d-none');
            orderItemsDiv.classList.remove('d-none');
            submitBtn.disabled = false;
            
            orderItemsList.innerHTML = orderItems.map(item => `
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1">${item.name}</h6>
                        <small>${item.quantity} × ${item.price.toFixed(2)} zł</small>
                    </div>
                    <p class="mb-1 text-end">
                        <strong>${item.subtotal.toFixed(2)} zł</strong>
                    </p>
                </div>
            `).join('');
            
            document.getElementById('orderTotal').textContent = total.toFixed(2) + ' zł';
        } else {
            emptyOrder.classList.remove('d-none');
            orderItemsDiv.classList.add('d-none');
            submitBtn.disabled = true;
            orderItemsList.innerHTML = '';
            document.getElementById('orderTotal').textContent = '0.00 zł';
        }
    }
});
</script> 