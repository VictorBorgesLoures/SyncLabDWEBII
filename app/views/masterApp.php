<?php

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title><?=$this->e($title)?></title>
    <link rel="stylesheet" href="/public/assets/styles/style.css" type="text/css">
    <link rel="stylesheet" href="/public/assets/styles/styles.css" type="text/css">
</head>

<body class="d-flex flex-column min-vh-100">

<?= $this->insert('includes/headerApp') ?>

<?= $this->insert('includes/aside') ?>
<main class="flex-grow-1">
    <?= $this->section('content') ?>
</main>

<script src="/public/assets/js/scripts/sideBar.js"></script>
</body>
</html>