<?php
session_start();
require __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Handle add option
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = (int)($_POST['category_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $prompt_value = trim($_POST['prompt_value'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_path = null;
    if (!empty($_FILES['image']['name'])) {
        $filename = time() . '_' . basename($_FILES['image']['name']);
        $target = __DIR__ . '/../uploads/' . $filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $image_path = $filename;
        }
    }
    if ($category_id && $name && $prompt_value) {
        $stmt = $pdo->prepare('INSERT INTO options (category_id, name, prompt_value, description, image_path) VALUES (?,?,?,?,?)');
        $stmt->execute([$category_id, $name, $prompt_value, $description, $image_path]);
    }
}
// Delete option
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM options WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
}
// Categories for select
$cats = $pdo->query('SELECT * FROM categories ORDER BY name')->fetchAll(PDO::FETCH_ASSOC);
$filter = (int)($_GET['cat'] ?? 0);
if ($filter) {
    $stmt = $pdo->prepare('SELECT o.*, c.name AS cname FROM options o JOIN categories c ON o.category_id=c.id WHERE category_id=? ORDER BY o.id');
    $stmt->execute([$filter]);
} else {
    $stmt = $pdo->query('SELECT o.*, c.name AS cname FROM options o JOIN categories c ON o.category_id=c.id ORDER BY o.id');
}
$options = $stmt->fetchAll(PDO::FETCH_ASSOC);
$page_title = 'Opções';
include __DIR__ . '/../includes/header.php';
?>
<div class="p-6 w-full">
    <h1 class="text-2xl mb-4">Opções</h1>
    <form method="post" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
        <select name="category_id" class="p-2 bg-gray-700" required>
            <option value="">Categoria</option>
            <?php foreach ($cats as $c): ?>
            <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="name" placeholder="Nome" class="p-2 bg-gray-700" required />
        <input type="text" name="prompt_value" placeholder="Valor do Prompt" class="p-2 bg-gray-700" required />
        <input type="file" name="image" class="p-2 bg-gray-700" />
        <textarea name="description" placeholder="Descrição" class="p-2 bg-gray-700 col-span-full"></textarea>
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 col-span-full">Adicionar</button>
    </form>
    <div class="mb-4">
        <form method="get">
            <select name="cat" onchange="this.form.submit()" class="p-2 bg-gray-700">
                <option value="0">-- Todas Categorias --</option>
                <?php foreach ($cats as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $filter==$c['id']?'selected':'' ?>><?= htmlspecialchars($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <table class="w-full text-left">
        <tr><th class="p-2">ID</th><th class="p-2">Categoria</th><th class="p-2">Nome</th><th class="p-2">Prompt</th><th></th></tr>
        <?php foreach ($options as $o): ?>
        <tr class="border-t border-gray-700"><td class="p-2"><?= $o['id'] ?></td><td class="p-2"><?= htmlspecialchars($o['cname']) ?></td><td class="p-2"><?= htmlspecialchars($o['name']) ?></td><td class="p-2"><?= htmlspecialchars($o['prompt_value']) ?></td><td class="p-2"><a href="?delete=<?= $o['id'] ?>" class="text-red-400" onclick="return confirm('Excluir?')">Excluir</a></td></tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
