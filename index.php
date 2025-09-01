<?php
require __DIR__ . '/config/database.php';

// Fetch categories and options
$stmt = $pdo->query("SELECT c.id AS cid, c.name AS cname, o.id AS oid, o.name AS oname, o.prompt_value, o.image_path FROM categories c LEFT JOIN options o ON o.category_id = c.id AND o.active=1 WHERE c.active=1 ORDER BY c.id, o.sort_order, o.name");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$categories = [];
foreach ($rows as $r) {
    if (!isset($categories[$r['cid']])) {
        $categories[$r['cid']] = ['name' => $r['cname'], 'options' => []];
    }
    if ($r['oid']) {
        $categories[$r['cid']]['options'][] = $r;
    }
}
$page_title = 'Gerador de Prompt';
include __DIR__ . '/includes/header.php';
?>
<div class="w-1/4 bg-gray-800 overflow-y-auto">
    <ul>
        <?php foreach ($categories as $cid => $cat): ?>
            <li class="border-b border-gray-700">
                <button class="w-full text-left p-3 hover:bg-gray-700" onclick="showCategory('cat<?= $cid ?>')">
                    <?= htmlspecialchars($cat['name']) ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="flex-1 p-4">
    <div class="mb-4">
        <label class="block mb-1">Descrição da Cena</label>
        <textarea id="scene" class="w-full p-2 bg-gray-700" rows="3" placeholder="Descreva a cena..."></textarea>
    </div>
    <?php foreach ($categories as $cid => $cat): ?>
        <div id="cat<?= $cid ?>" class="category hidden">
            <h2 class="text-xl mb-2"><?= htmlspecialchars($cat['name']) ?></h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($cat['options'] as $opt): ?>
                    <button class="option border border-gray-600 p-2 flex flex-col items-center" data-category="<?= $cid ?>" data-value="<?= htmlspecialchars($opt['prompt_value']) ?>" onclick="toggleOption(this)">
                        <?php if ($opt['image_path']): ?>
                            <img src="uploads/<?= htmlspecialchars($opt['image_path']) ?>" alt="<?= htmlspecialchars($opt['oname']) ?>" class="mb-2 h-16 object-cover"/>
                        <?php endif; ?>
                        <span><?= htmlspecialchars($opt['oname']) ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="mt-4">
        <label class="block mb-1">Prompt Gerado</label>
        <textarea id="promptOutput" class="w-full p-2 bg-gray-700" rows="3" readonly></textarea>
        <div class="mt-2 flex gap-2">
            <button onclick="copyPrompt()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2">Copiar</button>
            <button onclick="clearAll()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2">Limpar</button>
        </div>
    </div>
</div>
<script>
const selections = {};
function showCategory(id){
    document.querySelectorAll('.category').forEach(c=>c.classList.add('hidden'));
    document.getElementById(id).classList.remove('hidden');
}
function toggleOption(btn){
    const cat = btn.dataset.category;
    const value = btn.dataset.value;
    if(selections[cat] === value){
        delete selections[cat];
        btn.classList.remove('bg-blue-600');
    } else {
        // clear previous selection in this category
        document.querySelectorAll('.option[data-category="'+cat+'"]').forEach(o=>o.classList.remove('bg-blue-600'));
        selections[cat] = value;
        btn.classList.add('bg-blue-600');
    }
    generatePrompt();
}
function generatePrompt(){
    const scene = document.getElementById('scene').value.trim();
    const values = Object.values(selections);
    const prompt = (scene? scene + ', ' : '') + values.join(', ');
    document.getElementById('promptOutput').value = prompt;
}
function copyPrompt(){
    const txt = document.getElementById('promptOutput');
    txt.select();
    document.execCommand('copy');
}
function clearAll(){
    Object.keys(selections).forEach(k=>delete selections[k]);
    document.querySelectorAll('.option').forEach(o=>o.classList.remove('bg-blue-600'));
    document.getElementById('scene').value = '';
    document.getElementById('promptOutput').value = '';
}
// show first category
<?php if ($categories): $first = array_key_first($categories); ?>
showCategory('cat<?= $first ?>');
<?php endif; ?>
</script>
<?php
include __DIR__ . '/includes/footer.php';
?>
