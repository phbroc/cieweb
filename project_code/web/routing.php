<?php
// web/routing.php
// this solution replace the .htaccess rewrite rules for php built-in server in developpement mode
if (preg_match('/\.(?:png|jpg|css)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    include __DIR__.'/app.php';
}
