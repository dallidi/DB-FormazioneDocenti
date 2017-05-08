<?php 
  // require_once "$__ROOT__/nav/gestioneDocente/formTrova.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
  require_once "$__ROOT__/head.php";
  require_once "$__ROOT__/tierData/dbInterface/DbFile.php";
?>
<script>
  function filtra(inputId) {
    var input, filter, table, tr, td, i, col;
    input = document.getElementById(inputId);
    filter = input.value.toUpperCase();
    table = document.getElementById("dbFiles");
    tr = table.getElementsByTagName("tr");
    for (i = 2; i < tr.length; i++) {
      match = false;
      for (ii = 0; ii < tr[i].cells.length; ii++){
        td = tr[i].getElementsByTagName("td")[ii];
        if (td && td.innerHTML.toUpperCase().indexOf(filter) > -1) {
          match = true;
          break;
        }       
      }
      if (match){
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
  
  function rowClick(idFile){
    var url;
    url = "<?php echo makeUrl("/helpers/fileUpload/fileDownload.php"); ?>";
    document.location = url + "?fileId=" + idFile;
  }
 </script>

<div class="col-12">
  <table id="dbFiles" class="rowSelection leftAlign verticalScroll500_ 
                          <?php if(count($dbFiles) == 0) { echo "hidden";} ?>">
  <thead class="<?php if(count($dbFiles) < 10) { echo "hidden";} ?>">
    <tr>
      <td>Hidden col</td>
      <td colspan="3">
        <input id="filtro" class="searchField" type="text" 
               onkeyup="filtra(this.id)" placeholder="Filtra keyword.." 
               title="Digita una parola chiave">
      </td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Hidden col</th>
      <th>Nome</th>
      <th>Titolo</th>
      <th>Descrizione</th>
    </tr>
    <?php 
      foreach ($dbFiles as $dbFile){
        echo '<tr onclick="rowClick('.$dbFile->Id.')">
                <td>Hidden col</td>
                <td>' . $dbFile->Name . "</td>
                <td>" . $dbFile->Title . "</td>
                <td>" . $dbFile->Description . "</td>
              </tr>";
      }
    ?>
  </tbody>
  </table>
</div>