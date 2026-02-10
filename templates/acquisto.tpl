<?php
 /**   @var $totale **/
?>

<?php $this->layout('home', ['title' => 'Acquisto']) ?>



<?php 
    if($totale == 0){
        echo "<h1>Bravissimo! Sei riuscito ad acquistare i prodotti alla modica cifra di $totale euro.</h1>";
    }
    else {
        echo "<h1>Hai acquistato i prodotti del carrello al prezzo di $totale euro.</h1>";
    }
?>
