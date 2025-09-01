<?php
session_start();
require __DIR__ . '/../config/database.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}
$page_title = 'Dashboard';
include __DIR__ . '/../includes/header.php';
?>
<div class="p-6">
    <h1 class="text-2xl mb-4">Dashboard</h1>
    <div class="space-x-4">
        <a href="categories.php" class="underline text-blue-400">Categorias</a>
        <a href="options.php" class="underline text-blue-400">Opções</a>
        <a href="logout.php" class="underline text-blue-400">Sair</a>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
