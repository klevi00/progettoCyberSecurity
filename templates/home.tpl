<?php
/**  @var $title
 *   @var $base_path
 *   @var $user
 */ ?>
<!doctype html>
<html lang="it">
<head>
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
    <link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css">
    <title><?=$this->e($title)?></title>
</head>
<body>

<div class="container grid-lg">
    <header class="navbar">
        <section class="navbar-section">
            <a href="<?=$base_path?>/negozio" class="navbar-brand text-bold mr-2">Tutti i capi</a>
            <a href="<?=$base_path?>/negozio/genere/Uomo" class="btn btn-link">Uomo</a>
            <a href="<?=$base_path?>/negozio/genere/Donna" class="btn btn-link">Donna</a>
            <a href="<?=$base_path?>/negozio/carrello" class="btn btn-link">Carrello</a>
            <?php if ($user !== null):?>
                <a href="<?=$base_path?>/logout" class="btn btn-link">Logout</a>
            <?php else:?>
                <a href="<?=$base_path?>/login" class="btn btn-link">Login</a>
            <?php endif;?>
            <a href="<?=$base_path?>/admin" class="btn btn-link">Vai alla pagina di amministrazione</a>

        </section>
        <!--<section class="navbar-section">
            <div class="input-group input-inline">
                <input class="form-input" type="text" placeholder="search">
                <button class="btn btn-primary input-group-btn">Search</button>
            </div>
        </section>-->
    </header>
<!--Questa parte sarà sempre così e serve a includere
il template che contiene il contenuto vero e proprio-->
<?=$this->section('content')?>
</div>
</body>
</html>
