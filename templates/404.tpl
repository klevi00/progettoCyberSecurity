<?php
/** @var $base_path
 * @var $error
 */
?>
<?php $this->layout('home', ['title' => 'Negozio']) ?>

    <h1>Oops, qualcosa è andato storto :-/</h1>

    <div class="columns">
        <div class="col-4 col-mx-auto"><img src="<?=$base_path?>/assets/404.png" class="img-responsive" alt="404 not found">
        </div>
    </div>
<div class="code"><h2><?=$error?></h2></div>

