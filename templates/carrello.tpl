<?php
/** @var $carrello 
 * @var $totale 
 */
?>
<?php $this->layout('home', ['title' => 'Carrello']) ?>

<h1>Esempio carrello con pattern MVC</h1>
<h2>Carrello</h2>
<ul>
    <?php foreach ($carrello as $prodotto): ?>
        <li>
            <?=$prodotto['nome']?> – €<?=$prodotto['prezzo']?>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Totale: <?=$totale?> </h2>

