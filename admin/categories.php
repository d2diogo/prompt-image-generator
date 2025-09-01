<?php
session_start();
require __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
// Add category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if ($name) {
        $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->execute([$name]);
    }
}
// Delete category
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    $stmt->execute([$_GET['delete']]);
}
$cats = $pdo->query('SELECT * FROM categories ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
$page_title = 'Categorias';
include __DIR__ . '/../includes/header.php';
?>
<div class="p-6 w-full">
    <h1 class="text-2xl mb-4">Categorias</h1>
    <form method="post" class="mb-4 flex gap-2">
        <input type="text" name="name" placeholder="Nome" class="p-2 bg-gray-700" required />
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4">Adicionar</button>
    </form>
    <table class="w-full text-left">
        <tr><th class="p-2">ID</th><th class="p-2">Nome</th><th></th></tr>
        <?php foreach ($cats as $c): ?>
        <tr class="border-t border-gray-700"><td class="p-2"><?= $c['id'] ?></td><td class="p-2"><?= htmlspecialchars($c['name']) ?></td><td class="p-2"><a href="?delete=<?= $c['id'] ?>" class="text-red-400" onclick="return confirm('Excluir?')">Excluir</a></td></tr>
        <?php endforeach; ?>
    </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
