<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= isset($table) ? 'Edytuj stolik' : 'Dodaj stolik' ?></h2>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="number" class="form-label">Numer stolika</label>
                        <input type="number" class="form-control" id="number" name="number" 
                               value="<?= isset($table) ? $table['number'] : '' ?>" 
                               min="1" required>
                        <div class="invalid-feedback">
                            Proszę wprowadzić numer stolika.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="capacity" class="form-label">Pojemność (liczba miejsc)</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" 
                               value="<?= isset($table) ? $table['capacity'] : '' ?>" 
                               min="1" required>
                        <div class="invalid-feedback">
                            Proszę podać pojemność stolika.
                        </div>
                    </div>

                    <?php if (isset($table)): ?>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="free" <?= $table['status'] === 'free' ? 'selected' : '' ?>>
                                    Wolny
                                </option>
                                <option value="reserved" <?= $table['status'] === 'reserved' ? 'selected' : '' ?>>
                                    Zarezerwowany
                                </option>
                                <option value="occupied" <?= $table['status'] === 'occupied' ? 'selected' : '' ?>>
                                    Zajęty
                                </option>
                            </select>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between">
                        <a href="<?= BASE_URL ?>?controller=tables" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Powrót
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <?= isset($table) ? 'Zapisz zmiany' : 'Dodaj stolik' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Form validation
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            form.classList.add('was-validated')
        }, false)
    })
})()
</script> 