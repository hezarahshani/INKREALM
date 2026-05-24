<?php
echo "<h3>XAMPP Diagnostic Test</h3>";
echo "<b>Loaded Configuration File:</b> " . php_ini_loaded_file() . "<br><br>";
echo "<b>MySQLi Extension Status:</b> " . (function_exists('mysqli_connect') ? 'ENABLED ✅' : 'DISABLED ❌');
?>