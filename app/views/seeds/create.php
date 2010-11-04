<h2>Create Seed</h2>

<?= render_partial('update', null, array('seed' => (object)$_POST, 'categories' => $categories, 'errors' => $errors, 'button' => 'create')) ?>
