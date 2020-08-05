<?php 
    include __DIR__ . '/template/header.php';
    include __DIR__ . '/auth.php'; 
    include __DIR__ . '/template/footer.php';
    unset($_SESSION[$config['app']['session_id']]);
    redirectTo('index.php');
?>