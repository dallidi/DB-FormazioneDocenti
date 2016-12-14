<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>

<script>
  function rowClick(idDocente){
    exit;
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("pageHtml").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("POST", "rapporto.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("idDocente="+idDocente);
  }
 </script>

<body>
<div>
  <?php require "$__ROOT__/intestazione.php" ?>
  <div class="row centro col-12">
    <?php
       $classOption["all"] = "enable";  // all -> entire list
       $classOption["rapporto"] = "selected";
       require "$__ROOT__/navigation.php" 
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CODE HERE ----------------------------------------------------->
      <table class="rowSelection">
        <thead>
          <tr>
            <th>IdDocente</th>
            <th>Sigla</th>
            <th>Nome</th>
            <th>In [g]</th>
            <th>Non [g]</th>
          </tr>
        </thead>
        <tbody>
        <?php
          require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
          $sql = "SELECT Docenti.idDocente, Docenti.sigla, Docenti.nome, 
                         Docenti.cognome, 
                         ROUND(SUM(Frequenze.mgInContingente)/2, 1) AS sumMgIn,
                         ROUND(SUM(Frequenze.mgNonContingente)/2, 1) AS sumMgNon
                  FROM Frequenze
                  INNER JOIN Docenti
                  ON Docenti.idDocente=Frequenze.Docenti_idDocente
                  GROUP BY Frequenze.Docenti_idDocente
                  ORDER BY Docenti.sigla";
          $rows = $db->query($sql);
          while ($r = $rows->fetch())
          {
            echo '<tr onclick="rowClick('.$r["idDocente"].')">';
              echo '<td>'.$r["idDocente"].'</td>
              <td>'.$r["sigla"].'</td>
              <td>'.$r["nome"].' '. $r["cognome"].'</td>
              <td>'.$r["sumMgIn"].'</td>
              <td>'.$r["sumMgNon"].'</td>
            </tr>';
          }
        ?>
        </tbody>
      </table>

    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
