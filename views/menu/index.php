<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="fade-in">Menu restauracji</h1>
    <a href="<?= BASE_URL ?>?controller=menu&action=add" class="btn btn-primary fade-in">
        <i class="bi bi-plus-lg"></i> Dodaj danie
    </a>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="dashboard-card fade-in">
            <h3 class="mb-3">Kategorie</h3>
            <div class="list-group">
                <a href="<?= BASE_URL ?>?controller=menu" 
                   class="list-group-item list-group-item-action <?= !$selectedCategory ? 'active' : '' ?>">
                    Wszystkie kategorie
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="<?= BASE_URL ?>?controller=menu&category_id=<?= $category['id'] ?>" 
                       class="list-group-item list-group-item-action <?= $selectedCategory == $category['id'] ? 'active' : '' ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="row">
            <?php foreach ($items as $item): ?>
                <div class="col-md-6 mb-4 fade-in">
                    <div class="menu-item-card">
                        <div class="menu-item-info">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h3><?= htmlspecialchars($item['name']) ?></h3>
                                <span class="table-status status-<?= $item['is_available'] ? 'free' : 'occupied' ?>">
                                    <?= $item['is_available'] ? 'Dostępne' : 'Niedostępne' ?>
                                </span>
                            </div>
                            <h6 class="text-muted mb-3"><?= htmlspecialchars($item['category_name']) ?></h6>
                            <p class="mb-3"><?= htmlspecialchars($item['description']) ?></p>
                            <div class="menu-item-price">
                                <?= number_format($item['price'], 2) ?> zł
                            </div>
                            
                            <div class="d-flex gap-2 mt-3">
                                <a href="<?= BASE_URL ?>?controller=menu&action=edit&id=<?= $item['id'] ?>" 
                                   class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Edytuj
                                </a>
                                <form action="<?= BASE_URL ?>?controller=menu&action=toggleAvailability" 
                                      method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-<?= $item['is_available'] ? 'warning' : 'success' ?>">
                                        <i class="bi bi-toggle-<?= $item['is_available'] ? 'on' : 'off' ?>"></i>
                                        <?= $item['is_available'] ? 'Ustaw jako niedostępne' : 'Ustaw jako dostępne' ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($items)): ?>
                <div class="col-12">
                    <div class="alert alert-info fade-in">
                        Nie znaleziono dań. <?php if ($selectedCategory): ?>Spróbuj wybrać inną kategorię.<?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 