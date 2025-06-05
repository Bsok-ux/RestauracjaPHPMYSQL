<div class="jumbotron">
    <h1 class="display-4"><?= $title ?></h1>
    <p class="lead"><?= $description ?></p>
    <hr class="my-4">
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Menu</h5>
                <p class="card-text">Zarządzanie menu restauracji, dodawanie i edycja dań.</p>
                <a href="<?= BASE_URL ?>?controller=menu" class="btn btn-primary">Przejdź do menu</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Zamówienia</h5>
                <p class="card-text">Zarządzanie zamówieniami, śledzenie statusu i historia zamówień.</p>
                <a href="<?= BASE_URL ?>?controller=orders" class="btn btn-primary">Zarządzaj zamówieniami</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Stoliki</h5>
                <p class="card-text">Zarządzanie stolikami, rezerwacja i status zajętości.</p>
                <a href="<?= BASE_URL ?>?controller=tables" class="btn btn-primary">Zarządzaj stolikami</a>
            </div>
        </div>
    </div>
</div> 