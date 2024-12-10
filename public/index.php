<?php
session_start();

$html_string = file_get_contents('index.html');
if (array_key_exists('username', $_SESSION) && $_SESSION['username']) {
    $pers = "<p>Buongiorno " . htmlspecialchars($_SESSION['username']) . "</p></li>";
} elseif (array_key_exists('role', $_SESSION) && $_SESSION['role'] === 'admin')
    $pers = "<li><a href=\"admin.php\">Admin</a>";
else
    $pers = "<a href=\"html/registrazione.html\">Registrazione</a></li>
    <li><a href=\"html/login.html\">Accedi</a>";
echo str_replace('personalizza', $pers, $html_string);
?>