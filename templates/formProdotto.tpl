<?php
/** @var $base_path
 * @var $prodotti
 */
?>
<?php $this->layout('home', ['title' => 'Negozio']) ?>
    <h1>Pannello di amministrazione</h1>
    <h2>Nuovo prodotto</h2>
<form enctype="multipart/form-data" class="form-horizontal" action="<?=$base_path?>/admin/prodotto<?=isset($prodotto['id'])?'/'.$prodotto['id']:''?>" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    <div class="form-group">
        <div class="col-3 col-sm-12">
            <label class="form-label" for="nome">Nome</label>
        </div>
        <div class="col-9 col-sm-12">
            <input class="form-input" type="text" id="nome" placeholder="Nome" name ="nome" required
                   value = "<?=$prodotto['nome']??''?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-3 col-sm-12">
            <label class="form-label" for="descrizione">Descrizione</label>
        </div>
        <div class="col-9 col-sm-12">
            <input class="form-input" type="text" id="descrizione" placeholder="Descrizione" name="descrizione" required
            value = "<?=$prodotto['descrizione']??''?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-3 col-sm-12">
            <label class="form-label" for="prezzo">Prezzo</label>
        </div>
        <div class="col-9 col-sm-12">
            <input class="form-input" type="number" step="0.01" id="prezzo" placeholder="Prezzo" name="prezzo" required
                   value = "<?=$prodotto['prezzo']??''?>">
        </div>
    </div>
    <div class="form-group">
        <div class="col-3 col-sm-12">
            <label class="form-label" for="genere">Genere</label>
        </div>
        <div class="col-9 col-sm-12">
        <select class="form-select" name="genere">
            <?php if(!isset($prodotto['genere'])):?>
                <option>Donna</option>
                <option>Uomo</option>
            <?php else: ?>
                <option <?=($prodotto['genere'] == 'Donna')?'selected':''?> >Donna</option>
                <option <?=($prodotto['genere'] == 'Uomo')?'selected':''?> >Uomo</option>
            <?php endif; ?>
        </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-3 col-sm-12">
            <label class="form-label" for="immagine"></label>
        </div>
        <div class="col-9 col-sm-12">
            <input class="form-input" type="file"
                   id="immagine" name="immagine">
        </div>

    </div>
    <div class="form-group">
        <div class="col-2 col-ml-auto">
        <button class="btn btn-primary" style="width:100%" type="submit">Invia</button>
        </div>
    </div>
</form>
