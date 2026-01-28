<?php
/** @var $base_path
 * @var $error
 */
?>
<?php $this->layout('home', ['title' => 'Utente non autorizzzato']) ?>

    <h1>Utente non autorizzato</h1>

    <div class="columns">
        <div class="col-4 col-mx-auto"><img src="<?=$base_path?>/assets/non_autorizzato.png" class="img-responsive" alt="NOn autorizzato">
        </div>
    </div>
<!--<div class="code">Errore: <?=$error?></div>-->

