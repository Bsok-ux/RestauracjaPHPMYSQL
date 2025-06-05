<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Zamówienie #<?= $order['id'] ?></h2>
                    <span class="badge bg-<?= getOrderStatusColor($order['status']) ?> fs-6">
                        <?= getOrderStatusText($order['status']) ?>
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Informacje o zamówieniu</h5>
                        <dl class="row">
                            <dt class="col-sm-4">Stolik:</dt>
                            <dd class="col-sm-8">№<?= $order['table_number'] ?> (<?= $order['table_capacity'] ?> miejsc)</dd>
                            
                            <dt class="col-sm-4">Utworzono:</dt>
                            <dd class="col-sm-8"><?= date('d.m.Y H:i', strtotime($order['created_at'])) ?></dd>
                            
                            <dt class="col-sm-4">Zaktualizowano:</dt>
                            <dd class="col-sm-8"><?= date('d.m.Y H:i', strtotime($order['updated_at'])) ?></dd>
                            
                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-<?= getOrderStatusColor($order['status']) ?>">
                                    <?= getOrderStatusText($order['status']) ?>
                                </span>
                            </dd>
                        </dl>
                    </div>
                    
                    <div class="col-md-6">
                        <h5>Zarządzanie zamówieniem</h5>
                        <?php if (!in_array($order['status'], ['completed', 'cancelled'])): ?>
                            <form action="<?= BASE_URL ?>?controller=orders&action=updateStatus" method="post" class="mb-3">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <div class="input-group">
                                    <select name="status" class="form-select">
                                        <?php if ($order['status'] === 'new'): ?>
                                            <option value="in_progress">Rozpocznij przygotowanie</option>
                                        <?php endif; ?>
                                        
                                        <?php if ($order['status'] === 'in_progress'): ?>
                                            <option value="ready">Gotowe do podania</option>
                                        <?php endif; ?>
                                        
                                        <?php if (in_array($order['status'], ['new', 'in_progress', 'ready'])): ?>
                                            <option value="completed">Zakończ zamówienie</option>
                                            <option value="cancelled">Anuluj zamówienie</option>
                                        <?php endif; ?>
                                    </select>
                                    <button type="submit" class="btn btn-primary">
                                        Aktualizuj status
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>
                        
                        <?php if (!in_array($order['status'], ['completed', 'cancelled'])): ?>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                <i class="bi bi-plus-lg"></i> Dodaj pozycję
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <h5>Pozycje zamówienia</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nazwa</th>
                                <th>Kategoria</th>
                                <th>Ilość</th>
                                <th>Cena</th>
                                <th>Suma</th>
                                <?php if (!in_array($order['status'], ['completed', 'cancelled'])): ?>
                                    <th></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= htmlspecialchars($item['category_name']) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= number_format($item['price'], 2) ?> zł</td>
                                    <td><?= number_format($item['price'] * $item['quantity'], 2) ?> zł</td>
                                    <?php if (!in_array($order['status'], ['completed', 'cancelled'])): ?>
                                        <td>
                                            <form action="<?= BASE_URL ?>?controller=orders&action=removeItem" 
                                                  method="post" class="d-inline">
                                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('Czy na pewno usunąć pozycję z zamówienia?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                            
                            <?php if (empty($items)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">W zamówieniu nie ma pozycji</td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Razem:</strong></td>
                                    <td><strong><?= number_format($order['total_amount'], 2) ?> zł</strong></td>
                                    <?php if (!in_array($order['status'], ['completed', 'cancelled'])): ?>
                                        <td></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Historia zmian</h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Zamówienie utworzone</h6>
                            <p class="timeline-text">
                                <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                    
                    <?php if ($order['status'] !== 'new'): ?>
                        <div class="timeline-item">
                            <div class="timeline-marker bg-<?= getOrderStatusColor($order['status']) ?>"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Status zmieniony na "<?= getOrderStatusText($order['status']) ?>"</h6>
                                <p class="timeline-text">
                                    <?= date('d.m.Y H:i', strtotime($order['updated_at'])) ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding items -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Dodaj pozycję do zamówienia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= BASE_URL ?>?controller=orders&action=addItem" method="post">
                <div class="modal-body">
                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                    
                    <div class="mb-3">
                        <label for="menu_item_id" class="form-label">Danie</label>
                        <select class="form-select" id="menu_item_id" name="menu_item_id" required>
                            <option value="">Wybierz danie</option>
                            <?php foreach ($menuItems as $item): ?>
                                <?php if ($item['is_available']): ?>
                                    <option value="<?= $item['id'] ?>">
                                        <?= htmlspecialchars($item['name']) ?> 
                                        (<?= htmlspecialchars($item['category_name']) ?>) - 
                                        <?= number_format($item['price'], 2) ?> zł
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Ilość</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" 
                               value="1" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
}

.timeline-content {
    padding-bottom: 20px;
    border-bottom: 1px solid #e9ecef;
}

.timeline-title {
    margin-bottom: 5px;
}

.timeline-text {
    color: #6c757d;
    margin-bottom: 0;
}
</style>

<?php
function getOrderStatusColor($status) {
    switch ($status) {
        case 'new':
            return 'primary';
        case 'in_progress':
            return 'info';
        case 'ready':
            return 'success';
        case 'completed':
            return 'secondary';
        case 'cancelled':
            return 'danger';
        default:
            return 'secondary';
    }
}

function getOrderStatusText($status) {
    switch ($status) {
        case 'new':
            return 'Nowe';
        case 'in_progress':
            return 'W realizacji';
        case 'ready':
            return 'Gotowe';
        case 'completed':
            return 'Zrealizowane';
        case 'cancelled':
            return 'Anulowane';
        default:
            return 'Nieznany';
    }
}
?> 