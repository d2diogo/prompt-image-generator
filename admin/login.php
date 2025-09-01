<?php
session_start();
require __DIR__ . '/../config/database.php';

if (isset($_SESSION['admin'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && hash('sha256', $password) === $user['password']) {
        $_SESSION['admin'] = $user['username'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Login inválido';
    }
}
$page_title = 'Login Admin';
include __DIR__ . '/../includes/header.php';
?>
<div class="flex-1 flex items-center justify-center">
    <form method="post" class="bg-gray-800 p-6 rounded w-full max-w-sm">
        <h1 class="text-xl mb-4">Admin</h1>
        <?php if ($error): ?><p class="mb-2 text-red-500"><?= $error ?></p><?php endif; ?>
        <input type="text" name="username" placeholder="Usuário" class="w-full mb-2 p-2 bg-gray-700" required />
        <input type="password" name="password" placeholder="Senha" class="w-full mb-4 p-2 bg-gray-700" required />
        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2">Entrar</button>
    </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
