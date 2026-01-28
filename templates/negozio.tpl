<?php
/** @var $genere
 * @var $prodotti
 */
?>
<?php $this->layout('home', ['title' => 'Negozio']) ?>

    <h1>Esempio negozio con pattern MVC</h1>
    <h2>Lista dei prodotti: <?=$genere?></h2>

    <div class="columns">
    <?php foreach ($prodotti as $prodotto): ?>
        <div class="column col-3 col-xs-12">
            <div class="card">
            <div class="card-image">
                <img src="<?php echo '/'. $immagini . '/'. $prodotto['image'];?>" class="img-responsive">
            </div>
            <div class="card-header">
                <div class="card-title h5"><?=$prodotto['nome']?></div>
                <div class="card-subtitle text-gray"><a href="<?=$base_path?>/negozio/prodotto/<?=$prodotto['id']?>"> Vai alla pagina del prodotto</a></div>
            </div>
            <div class="card-body">
                <?=$prodotto['descrizione']?>
            </div>
            </div>
        </div>
    <?php endforeach;?>
    </div>

