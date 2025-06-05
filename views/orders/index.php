<div class="row mb-4">
    <div class="col-md-12">
        <div class="dashboard-card fade-in">
            <h3 class="mb-4">Statystyki zamówień</h3>
            <div class="row">
                <div class="col-md-3">
                    <div class="dashboard-card bg-primary text-white">
                        <h6 class="mb-3">Wszystkie zamówienia</h6>
                        <div class="value"><?= $stats['total_orders'] ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card bg-success text-white">
                        <h6 class="mb-3">Zrealizowane</h6>
                        <div class="value"><?= $stats['completed_orders'] ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card bg-danger text-white">
                        <h6 class="mb-3">Anulowane</h6>
                        <div class="value"><?= $stats['cancelled_orders'] ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="dashboard-card bg-info text-white">
                        <h6 class="mb-3">Przychód</h6>
                        <div class="value"><?= number_format($stats['total_revenue'], 2) ?> zł</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="dashboard-card fade-in">
            <h3 class="mb-4">Zamówienia</h3>
            <div class="btn-group mb-4">
                <a href="<?= BASE_URL ?>?controller=orders" 
                   class="btn <?= !$currentStatus ? 'btn-primary' : 'btn-secondary' ?>">
                    Wszystkie
                </a>
                <a href="<?= BASE_URL ?>?controller=orders&status=new" 
                   class="btn <?= $currentStatus === 'new' ? 'btn-primary' : 'btn-secondary' ?>">
                    Nowe
                </a>
                <a href="<?= BASE_URL ?>?controller=orders&status=in_progress" 
                   class="btn <?= $currentStatus === 'in_progress' ? 'btn-primary' : 'btn-secondary' ?>">
                    W realizacji
                </a>
                <a href="<?= BASE_URL ?>?controller=orders&status=ready" 
                   class="btn <?= $currentStatus === 'ready' ? 'btn-primary' : 'btn-secondary' ?>">
                    Gotowe
                </a>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Stolik</th>
                            <th>Status</th>
                            <th>Pozycje</th>
                            <th>Kwota</th>
                            <th>Czas</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= $order['id'] ?></td>
                                <td>Stolik №<?= $order['table_number'] ?></td>
                                <td>
                                    <span class="order-status status-<?= $order['status'] ?>">
                                        <?= getOrderStatusText($order['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <small><?= $order['items_list'] ?></small>
                                </td>
                                <td><?= number_format($order['total_amount'], 2) ?> zł</td>
                                <td>
                                    <small>
                                        <?= date('d.m.Y H:i', strtotime($order['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>?controller=orders&action=view&id=<?= $order['id'] ?>" 
                                       class="btn btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($orders)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Nie znaleziono zamówień</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="dashboard-card fade-in">
            <h3 class="mb-4">Popularne dania</h3>
            <div class="list-group">
                <?php foreach ($popularItems as $item): ?>
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1"><?= htmlspecialchars($item['name']) ?></h6>
                                <small class="text-muted">
                                    <?= htmlspecialchars($item['category_name']) ?> • 
                                    <?= $item['order_count'] ?> zamówień
                                </small>
                            </div>
                            <span class="badge bg-primary rounded-pill">
                                <?= $item['total_quantity'] ?> szt.
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

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
            return 'Nieznane';
    }
}
?> 