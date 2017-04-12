<?php 
  // require_once "$__ROOT__/nav/gestioneDocente/formTrova.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
?>
<script>
  function filtra(inputId) {
    var input, filter, table, tr, td, i, col;
    input = document.getElementById(inputId);
    filter = input.value.toUpperCase();
    table = document.getElementById("docenti");
    tr = table.getElementsByTagName("tr");
    switch (inputId){
      case "filtroCognome":
        col = 1;
        document.getElementById("filtroNome").value = "";
        break;
      case "filtroNome":
        col = 2;
        document.getElementById("filtroCognome").value = "";
        break;
      default:
        col = 0;
        break;
    }
    for (i = 2; i < tr.length; i++) {
      td = tr[i].getElementsByTagName("td")[col];
      if (td) {
        if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }       
    }
  }
  
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
  <table id="docenti" class="rowSelection leftAlign verticalScroll500">
  <thead>
    <tr>
      <td>Hidden col</td>
      <td>
        <input id="filtroCognome" class="searchField" type="text" 
               onkeyup="filtra(this.id)" placeholder="Filtra cognomi.." 
               title="Digita un cognome">
      </td>
      <td>
        <input id="filtroNome" class="searchField" type="text" 
               onkeyup="filtra(this.id)" placeholder="Filtra nomi.." 
               title="Digita un nome">
      </td>
      <td colspan="2">
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Hidden col</th>
      <th>Cognome</th>
      <th>Nome</th>
      <th>Sigla</th>
      <th>Cid</th>
    </tr>
    <?php 
      foreach ($docenti as $docente){
        echo "<tr onclick='rowClick(".$docente->Id.")'>
                <td>Hidden col</td>
                <td>" . $docente->Cognome . "</td>
                <td>" . $docente->Nome . "</td>
                <td>" . $docente->Sigla . "</td>
                <td>" . $docente->Cid . "</td>
              </tr>";
      }
    ?>
  </tbody>
  </table>
</div>