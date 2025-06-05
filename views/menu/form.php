<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= isset($item) ? 'Edytuj danie' : 'Dodaj nowe danie' ?></h2>
            </div>
            <div class="card-body">
                <form method="post" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Kategoria</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Wybierz kategorię</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" 
                                    <?= (isset($item) && $item['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Proszę wybrać kategorię.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Nazwa dania</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= isset($item) ? htmlspecialchars($item['name']) : '' ?>" required>
                        <div class="invalid-feedback">
                            Proszę wprowadzić nazwę dania.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Opis</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?= isset($item) ? htmlspecialchars($item['description']) : '' ?></textarea>
                        <div class="invalid-feedback">
                            Proszę wprowadzić opis dania.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Cena</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="price" name="price" 
                                   value="<?= isset($item) ? $item['price'] : '' ?>" 
                                   step="0.01" min="0" required>
                            <span class="input-group-text">zł</span>
                            <div class="invalid-feedback">
                                Proszę wprowadzić poprawną cenę.
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_available" name="is_available" 
                               <?= (!isset($item) || $item['is_available']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="is_available">Dostępne</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="<?= BASE_URL ?>?controller=menu" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <?= isset($item) ? 'Zapisz zmiany' : 'Dodaj danie' ?>
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