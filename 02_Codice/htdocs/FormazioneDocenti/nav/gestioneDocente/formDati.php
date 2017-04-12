<?php 
  // require_once "$__ROOT__/nav/gestioneDocente/formDati.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
?>
<div class="col-8">
  <form 
    action="<?php echo makeUrl("/nav/gestioneDocente/gestioneDocente_action.php"); ?>"
    method="post">
    <table class="leftAlign">
      <tr>
        <th class="center" colspan="2">Quadriennio</th>
      </tr>
      <tr>
        <th class="center">Inizio</th>
        <th class="center">Fine</th>
        <th>Settore</th>
      </tr>
      <tr>
        <td>
          <select  name="inizioQ">
            <?php
              for ($i=2016; $i<=2036; $i++) {
                echo '<option value="'.$i.' "';
                if ($i == (int)sqlToPhpDate($doc->InizioQ, "Y")){
                  echo 'selected';
                }
                echo '>'.$i.'</option>';
              }
              ?>
          </select> 
        </td>
        <td>
          <select  name="fineQ">
            <?php
              for ($i=2020; $i<=2040; $i++) {
                echo '<option value="'.$i.' "';
                if ($i == (int)sqlToPhpDate($doc->FineQ, "Y")){
                  echo 'selected';
                }
                echo '>'.$i.'</option>';
              }
              ?>
          </select> 
        </td>
        <td><input type="text" name="settore" value="<?php echo '' ?>" size="50"></td>
      </tr>
    </table>

    <hr>
    
    <?php require_once "$__ROOT__/helpers/datiDocente.php" ?>

    <hr>

    <button type="submit" name="action" value="update">Aggiorna</button>
    <!-- button type="submit" name="action" value="freeze">Blocca</button>
    <button type="submit" name="action" value="archive">Archivia</button -->
    <input type="hidden" name="idDocente" value="<?php echo $doc->Id ?>">
  </form>
</div>