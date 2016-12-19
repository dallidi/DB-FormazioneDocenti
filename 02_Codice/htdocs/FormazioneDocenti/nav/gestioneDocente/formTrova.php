<?php 
  // require_once "$__ROOT__/nav/gestioneDocente/formTrova.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
?>
<script>
  function rowClick(idDocente){
    var url;
    url = "<?php echo makeUrl("/nav/gestioneDocente/gestioneDocente.php"); ?>";
    document.location = url + "?ID=" + idDocente;
  }
 </script>

<div class="col-4">
  <form 
    action="<?php echo makeUrl("/nav/gestioneDocente/gestioneDocente.php"); ?>"
    method="post">
    <?php require_once "$__ROOT__/helpers/datiDocente.php" ?>
    <hr>
    <button type="submit" name="action" value="find">Trova</button>
    <input type="text" name="findQuery" placeholder="termine di ricerca">
    <input type="hidden" name="idDocente" value="<?php echo $doc->Id ?>">
  </form>
  <table class="rowSelection leftAlign verticalScroll500">
    <tr>
      <th>Cognome</th>
      <th>Nome</th>
      <th>Sigla</th>
      <th>Cid</th>
    </tr>
    <?php 
      foreach ($docenti as $docente){
        echo "<tr onclick='rowClick(".$docente->Id.")'>
                <td>" . $docente->Cognome . "</td>
                <td>" . $docente->Nome . "</td>
                <td>" . $docente->Sigla . "</td>
                <td>" . $docente->Cid . "</td>
              </tr>";
      }
    ?>
  </table>
</div>