<?php
// check.php - À la racine
echo "<h1>Vérification Middleware Admin</h1>";

// 1. Vérifier le fichier
$file = __DIR__ . '/app/Http/Middleware/Admin.php';
if (file_exists($file)) {
    echo "<p style='color: green;'>✅ Fichier Admin.php existe</p>";
    
    // Vérifier le contenu
    $content = file_get_contents($file);
    if (strpos($content, 'class Admin') !== false) {
        echo "<p style='color: green;'>✅ Classe 'Admin' trouvée</p>";
    } else {
        echo "<p style='color: red;'>❌ Classe 'Admin' NON trouvée</p>";
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
    }
} else {
    echo "<p style='color: red;'>❌ Fichier Admin.php n'existe pas</p>";
}

// 2. Vérifier Kernel
$kernel = __DIR__ . '/app/Http/Kernel.php';
if (file_exists($kernel)) {
    echo "<p style='color: green;'>✅ Kernel.php existe</p>";
    
    $content = file_get_contents($kernel);
    
    // Chercher la configuration admin
    if (preg_match("/'admin'\s*=>\s*[^,]+/", $content, $matches)) {
        echo "<p style='color: green;'>✅ Configuration 'admin' trouvée</p>";
        echo "<p>Ligne: " . htmlspecialchars($matches[0]) . "</p>";
        
        // Vérifier la casse
        if (strpos($content, 'Admin::class') !== false) {
            echo "<p style='color: green;'>✅ Bon: Admin::class (A majuscule)</p>";
        } elseif (strpos($content, 'admin::class') !== false) {
            echo "<p style='color: red;'>❌ Erreur: admin::class (a minuscule)</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Configuration 'admin' non trouvée</p>";
    }
}

// 3. Test autoload
echo "<h2>Test Autoload:</h2>";
try {
    require __DIR__.'/vendor/autoload.php';
    
    // Essayer de charger la classe
    $className = 'App\Http\Middleware\Admin';
    if (class_exists($className)) {
        echo "<p style='color: green;'>✅ Classe peut être chargée: $className</p>";
    } else {
        echo "<p style='color: red;'>❌ Classe NE peut PAS être chargée: $className</p>";
        
        // Vérifier le namespace
        $content = file_get_contents($file);
        if (strpos($content, 'namespace App\Http\Middleware;') === false) {
            echo "<p style='color: red;'>❌ Mauvais namespace dans Admin.php</p>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Erreur autoload: " . $e->getMessage() . "</p>";
}