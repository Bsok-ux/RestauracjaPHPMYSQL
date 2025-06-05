<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fade-in">Zarządzanie stolikami</h1>
    <a href="<?= BASE_URL ?>?controller=tables&action=add" class="btn btn-primary fade-in">
        <i class="bi bi-plus-lg"></i> Dodaj stolik
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="row">
    <?php foreach ($tables as $table): ?>
        <div class="col-md-4 mb-4 fade-in">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h3>Stolik №<?= $table['number'] ?></h3>
                    <span class="table-status status-<?= $table['status'] ?>">
                        <?= getStatusText($table['status']) ?>
                    </span>
                </div>
                
                <p class="mb-4">
                    <strong>Pojemność:</strong> <?= $table['capacity'] ?> os.
                </p>
                
                <div class="d-flex gap-2">
                    <a href="<?= BASE_URL ?>?controller=tables&action=view&id=<?= $table['id'] ?>" 
                       class="btn btn-info">
                        <i class="bi bi-eye"></i> Podgląd
                    </a>
                    <a href="<?= BASE_URL ?>?controller=tables&action=edit&id=<?= $table['id'] ?>" 
                       class="btn btn-primary">
                        <i class="bi bi-pencil"></i> Edytuj
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown">
                            Status
                        </button>
                        <ul class="dropdown-menu">
                            <?php if ($table['status'] !== 'free'): ?>
                                <li>
                                    <form action="<?= BASE_URL ?>?controller=tables&action=updateStatus" 
                                          method="post" class="dropdown-item">
                                        <input type="hidden" name="id" value="<?= $table['id'] ?>">
                                        <input type="hidden" name="status" value="free">
                                        <button type="submit" class="btn btn-link text-success p-0">
                                            <i class="bi bi-check-circle"></i> Zwolnij
                                        </button>
                                    </form>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ($table['status'] !== 'reserved'): ?>
                                <li>
                                    <form action="<?= BASE_URL ?>?controller=tables&action=updateStatus" 
                                          method="post" class="dropdown-item">
                                        <input type="hidden" name="id" value="<?= $table['id'] ?>">
                                        <input type="hidden" name="status" value="reserved">
                                        <button type="submit" class="btn btn-link text-warning p-0">
                                            <i class="bi bi-clock"></i> Zarezerwuj
                                        </button>
                                    </form>
                                </li>
                            <?php endif; ?>
                            
                            <?php if ($table['status'] !== 'occupied'): ?>
                                <li>
                                    <form action="<?= BASE_URL ?>?controller=tables&action=updateStatus" 
                                          method="post" class="dropdown-item">
                                        <input type="hidden" name="id" value="<?= $table['id'] ?>">
                                        <input type="hidden" name="status" value="occupied">
                                        <button type="submit" class="btn btn-link text-danger p-0">
                                            <i class="bi bi-person-fill"></i> Zajmij
                                        </button>
                                    </form>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php
function getStatusColor($status) {
    switch ($status) {
        case 'free':
            return 'success';
        case 'reserved':
            return 'warning';
        case 'occupied':
            return 'danger';
        default:
            return 'secondary';
    }
}

function getStatusText($status) {
    switch ($status) {
        case 'free':
            return 'Wolny';
        case 'reserved':
            return 'Zarezerwowany';
        case 'occupied':
            return 'Zajęty';
        default:
            return 'Nieznany';
    }
}
?> 