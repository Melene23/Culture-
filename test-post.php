<?php
// test-post.php
echo "<h1>POST reçu</h1>";
echo "<p>Données: " . print_r($_POST, true) . "</p>";
echo '<a href="test-simple.php">Retour</a>';