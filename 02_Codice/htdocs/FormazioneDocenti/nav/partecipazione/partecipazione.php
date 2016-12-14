<?php require $_SERVER["DOCUMENT_ROOT"]."/FormazioneDocenti/head.php" ?>

<script>
  function rowClick(idFrequenza){
    document.getElementById("idFrequenza").value = idFrequenza;
    document.getElementById("hiddenForm").submit();
  }
 </script>

<body>
<div>
  <?php require "$__ROOT__/intestazione.php" ?>
  <div class="row centro col-12">
    <?php
       $classOption["all"] = "enable";  // all -> entire list
       $classOption["partecipazione"] = "selected";
       require "$__ROOT__/navigation.php" 
    ?>
    <div id="pageHtml" class="col-8">
    <!-- ADD YOUR CODE HERE ----------------------------------------------------->
      <table class="rowSelection">
        <thead>
          <tr>
            <th>ID</th>
            <th>Inizio</th>
            <th>Fine</th>
            <th>g in</th>
            <th>g non</th>
            <th>Tema</th>
            <th>Sigla</th>
            <th>Titolo</th>
            <th>Aggiornato il</th>
          </tr>
        </thead>
        <tbody>
        <?php
          require_once "$__ROOT__/tierData/DbInterface/CommonDB.php";
          if (isset($_SESSION["userInfo"])){
            $idDocente = $_SESSION["userInfo"]->Docente->Id;
            $sql = "SELECT Frequenze.idFrequenza, Frequenze.inizio, Frequenze.fine, 
                           Frequenze.mgInContingente, Frequenze.mgNonContingente, 
                           Frequenze.lastUpdate, Frequenze.Docenti_idDocente,
                           Corsi.sigla, Corsi.titolo, Corsi.tema, Corsi.ptrDescrizione
                    FROM Frequenze
                    INNER JOIN Corsi
                    ON Frequenze.Corsi_idCorso=Corsi.idCorso
                    WHERE Frequenze.Docenti_idDocente=$idDocente";
            $rows = $db->query($sql);
            while ($r = $rows->fetch())
            {
              $mezzeIn = intval($r["mgInContingente"])/2;
              $mezzeOut = intval($r["mgNonContingente"])/2;
              echo '<tr onclick="rowClick('.$r["idFrequenza"].')">'; 
                echo '<td>'.$r["idFrequenza"].'</td>
                <td>'.convertDateFormat($r["inizio"], "Y-m-d", "d.m.Y").'</td>
                <td>'.convertDateFormat($r["fine"], "Y-m-d", "d.m.Y").'</td>
                <td>'.$mezzeIn.'</td>
                <td>'.$mezzeOut.'</td>
                <td>'.$r["tema"].'</td>
                <td>'.$r["sigla"].'</td>
                <td>';
                if (empty($r["ptrDescrizione"])){
                  echo $r["titolo"];
                }else{
                  echo '<a href="'.$r["ptrDescrizione"],'" target="_blank">'.$r["titolo"].'</a>';
                }
                echo '</td>
                <td>'.convertDateFormat($r["lastUpdate"], "Y-m-d H:i:s", "d.m.Y H:i:s").'</td>
              </tr>';
            }
          }else{
            echo '<tr><td colspan="7">Dati non trovati</td></tr>';
          }
        ?>
        </tbody>
      </table>
      <form id="hiddenForm" action="partecipaCorso.php" method="post" style="display: none;">
        <input id="idFrequenza" type="hidden" name="idFrequenza"/>
      </form>
    <!-- END OF CUSTOM PAGE CODE ------------------------------------------------>
    </div>
  </div>
  <div class="row pie col-12">
    <?php require "$__ROOT__/footer.php" ?>
  </div>
</div>
</body>
</html>
