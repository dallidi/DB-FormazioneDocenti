<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>

<script>
  function rowClick(idCorso){
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("pageHtml").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("POST", "aggiornaOpartecipaCorso.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("idCorso="+idCorso);
  }
 </script>

<body>
<div>
  <?php require "$__ROOT__/intestazione.php" ?>
  <div class="row centro col-12">
    <?php
       $classOption["all"] = "enable";  // all -> entire list
       $classOption["listaCorsi"] = "selected";
       require "$__ROOT__/navigation.php" 
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CODE HERE ----------------------------------------------------->
      <table class="rowSelection">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tema</th>
            <th>Sigla</th>
            <th>Titolo</th>
            <th>Descrizione</th>
            <th>Aggiornato il</th>
          </tr>
        </thead>
        <tbody>
        <?php
          require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
          $sql = "SELECT * FROM Corsi ORDER BY Titolo";
          $rows = $db->query($sql);
          while ($r = $rows->fetch())
          {
            echo '<tr onclick="rowClick('.$r["idCorso"].')">';
              echo '<td>'.$r["idCorso"].'</td>
              <td>'.$r["tema"].'</td>
              <td>'.$r["sigla"].'</td>
              <td>';
              if (empty($r["ptrDescrizione"])){
                echo $r["titolo"];
              }else{
                echo '<a href="'.$r["ptrDescrizione"],'" target="_blank">'.$r["titolo"].'</a>';
              }
              echo '</td>
              <td>'.$r["descrizione"].'</td>
              <td>'.$r["lastUpdate"].'</td>
            </tr>';
          }
        ?>
        </tbody>
      </table>
      <?php 
        if (checkMinAccess(1)){
          echo '
          <hr>
          <form action="modificaCorso.php">
            <button type="submit" name="action" value="nouvo">Nuovo</button>
          </form>';
        }
      ?>

    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
