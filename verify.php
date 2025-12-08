<?php
// verify.php - À créer à la racine du projet
echo "<h1>Vérification rapide</h1>";

// 1. Vérifier si Laravel est chargé
try {
    require __DIR__.'/vendor/autoload.php';
    $app = require_once __DIR__.'/bootstrap/app.php';
    echo "<p style='color: green;'>✅ Laravel chargé</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erreur Laravel: " . $e->getMessage() . "</p>";
    exit;
}

// 2. Vérifier Kernel
$kernelPath = __DIR__.'/app/Http/Kernel.php';
if (file_exists($kernelPath)) {
    echo "<p style='color: green;'>✅ Kernel.php existe</p>";
} else {
    echo "<p style='color: red;'>❌ Kernel.php manquant</p>";
}

// 3. Vérifier Admin.php
$adminPath = __DIR__.'/app/Http/Middleware/Admin.php';
if (file_exists($adminPath)) {
    echo "<p style='color: green;'>✅ Admin.php existe</p>";
    
    // Lire le contenu
    $content = file_get_contents($adminPath);
    if (strpos($content, 'class Admin') !== false) {
        echo "<p style='color: green;'>✅ Classe Admin trouvée</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Admin.php manquant</p>";
}

// 4. Vérifier la configuration dans Kernel
if (file_exists($kernelPath)) {
    $content = file_get_contents($kernelPath);
    if (strpos($content, "'admin' =>") !== false) {
        echo "<p style='color: green;'>✅ 'admin' trouvé dans Kernel</p>";
    }
    if (strpos($content, "Admin::class") !== false) {
        echo "<p style='color: green;'>✅ Admin::class trouvé</p>";
    }
}

echo "<hr><h2>Test des routes:</h2>";
echo '<a href="/test-ultra-simple" target="_blank">Test ultra simple</a>';