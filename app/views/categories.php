<h1>Categories</h1>

<?php if (empty($categories)) { ?>
<p>No categories found.</p>
<?php } else { ?>
<ul>
<?php foreach ($categories as $category) { ?>
	<li>
		<strong><?= htmlspecialchars((string) ($category['idcategorie'] ?? ''), ENT_QUOTES, 'UTF-8') ?></strong>
		<?= htmlspecialchars((string) ($category['name'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
	</li>
<?php } ?>
</ul>
<?php } ?>
