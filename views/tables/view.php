<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="card-title mb-0">Stolik nr <?= isset($table['number']) ? htmlspecialchars($table['number']) : 'N/A' ?></h2>
                    <?php if (isset($table['status'])): ?>
                        <span class="badge bg-<?= getStatusColor($table['status']) ?> fs-6">
                            <?= getStatusText($table['status']) ?>
                        </span>
                    <?php else: ?>
                        <span class="badge bg-secondary fs-6">Status N/A</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Informacje o stoliku</h5>
                        <dl class="row">
                            <dt class="col-sm-4">Pojemność:</dt>
                            <dd class="col-sm-8"><?= isset($table['capacity']) ? htmlspecialchars($table['capacity']) : 'N/A' ?> os.</dd>
                            
                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8">
                                <?php if (isset($table['status'])): ?>
                                    <span class="badge bg-<?= getStatusColor($table['status']) ?>">
                                        <?= getStatusText($table['status']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Status N/A</span>
                                <?php endif; ?>
                            </dd>
                        </dl>
                    </div>
                    
                    <?php if (isset($table['order_id'])): ?>
                        <div class="col-md-6">
                            <h5>Bieżące zamówienie</h5>
                            <dl class="row">
                                <dt class="col-sm-4">Numer zamówienia:</dt>
                                <dd class="col-sm-8">#<?= $table['order_id'] ?></dd>
                                
                                <dt class="col-sm-4">Status zamówienia:</dt>
                                <dd class="col-sm-8">
                                    <span class="badge bg-<?= getOrderStatusColor($table['order_status']) ?>">
                                        <?= getOrderStatusText($table['order_status']) ?>
                                    </span>
                                </dd>
                                
                                <dt class="col-sm-4">Suma:</dt>
                                <dd class="col-sm-8"><?= number_format($table['total_amount'], 2) ?> zł</dd>
                            </dl>
                            
                            <a href="<?= BASE_URL ?>?controller=orders&action=view&id=<?= $table['order_id'] ?>" 
                               class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> Zobacz zamówienie
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="d-flex gap-2">
                    <a href="<?= BASE_URL ?>?controller=tables" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Powrót do listy
                    </a>
                    
                    <a href="<?= BASE_URL ?>?controller=tables&action=edit&id=<?= $table['id'] ?>" 
                       class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edytuj
                    </a>
                    
                    <?php if ($table['status'] === 'free'): ?>
                        <a href="<?= BASE_URL ?>?controller=orders&action=create&table_id=<?= $table['id'] ?>" 
                           class="btn btn-success">
                            <i class="bi bi-plus-lg"></i> Utwórz zamówienie
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($table['status'] !== 'free'): ?>
                        <form action="<?= BASE_URL ?>?controller=tables&action=updateStatus" method="post" class="d-inline">
                            <input type="hidden" name="id" value="<?= $table['id'] ?>">
                            <input type="hidden" name="status" value="free">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle"></i> Zwolnij stolik
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
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
            return 'Nieznany';
    }
}

function getStatusColor($status) {
    switch ($status) {
        case 'free':
            return 'success'; // Зеленый для свободного столика
        case 'occupied':
            return 'danger'; // Красный для занятого
        case 'reserved':
            return 'warning'; // Желтый для зарезервированного
        default:
            return 'secondary'; // Серый по умолчанию
    }
}

function getStatusText($status) {
    switch ($status) {
        case 'free':
            return 'Wolny';
        case 'occupied':
            return 'Zajęty';
        case 'reserved':
            return 'Zarezerwowany';
        default:
            return ucfirst($status); // По умолчанию выводим как есть, с большой буквы
    }
}
?> 