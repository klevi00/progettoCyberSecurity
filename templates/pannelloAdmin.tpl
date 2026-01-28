<?php
/** @var $base_path
 * @var $prodotti
 */
?>
<?php $this->layout('home', ['title' => 'Negozio']) ?>

    <h1>Pannello di amministrazione</h1>
    <p>
        <a href="<?=$base_path?>/admin/prodotto" class="btn btn-primary">Aggiungi un nuovo prodotto</a>
    </p>
    <h2>Lista dei prodotti</h2>
<table class="table">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Descrizione</th>
        <th>Prezzo</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($prodotti as $prodotto):?>
        <tr>
            <td><?=$prodotto['nome']?></td>
            <td><?=$prodotto['descrizione']?></td>
            <td><?=$prodotto['prezzo']?></td>
            <td><a href="<?=$base_path?>/admin/prodotto/<?=$prodotto['id']?>" class="icon icon-edit"></a></td>
            <td><a href="<?=$base_path?>/admin/prodotto/<?=$prodotto['id']?>/delete" class="icon icon-delete"></a></td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>