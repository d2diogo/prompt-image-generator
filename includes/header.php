<?php
if (!isset($page_title)) {
    $page_title = 'Prompt Image Generator';
}
?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-gray-900 text-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col">
<header class="bg-gray-800 p-4 flex items-center justify-between">
    <div class="flex items-center">
        <img src="https://nexp.com.br/wp-content/uploads/2025/07/logo_nexp.png" alt="Agência NEXP" class="h-8 mr-2"/>
        <span class="font-semibold">Prompt Image Generator</span>
    </div>
    <nav>
        <a href="<?= $base_url ?>/admin/login.php" class="text-sm text-gray-400 hover:text-white">Admin</a>
    </nav>
</header>
<main class="flex-1 flex">
