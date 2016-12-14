<?php 
  $idCorso = 0;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["idCorso"])){
      $idCorso = $_POST["idCorso"];
    }
  }
  
?>

<div class="question">
  <ul class="verticalMenu">
    <li><a href="partecipaCorso.php?idCorso=<?php echo $idCorso?>">Partecipa</a></li>
    <li><a href="modificaCorso.php?idCorso=<?php echo $idCorso?>">Modifica</a></li>
  </ul>     
</div>
