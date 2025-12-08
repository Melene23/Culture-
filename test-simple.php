<?php
// test-simple.php - À la racine
echo "<h1>Test Simple</h1>";

// Test 1: PHP fonctionne
echo "<p>✅ PHP fonctionne</p>";

// Test 2: Session
session_start();
echo "<p>✅ Session ID: " . session_id() . "</p>";

// Test 3: Formulaire simple
echo '
<form method="POST" action="test-post.php">
    <input type="text" name="test" value="hello">
    <button>Test POST</button>
</form>
';