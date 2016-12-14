
<?php 
  function addOpt($opt, $item){
    if (isset($opt[$item])){
      echo $opt[$item];
    }
  }
  
  if(!isset($classOption)){ $classOption = "";}

  $classOption["gestioneDocenti"] = "hidden";
  $classOption["rapporto"] = "hidden";  
  if (isset($_SESSION['userInfo'])){
    if(checkMinAccess(1)){
      $classOption["gestioneDocenti"] = "";
      $classOption["rapporto"] = "";
    }
  }
?>
  <div class="col-2">
    <ul class="verticalMenu <?php addOpt($classOption, "all") ?>">
      <li class="<?php addOpt($classOption, 'gestioneDocenti') ?>">
        <a href="<?php echo makeUrl("/nav/gestioneDocente/gestioneDocente.php");?>">Gestisci docente</a>
      </li>
      <li class="<?php addOpt($classOption, 'profiloDocente') ?>">
        <a href="<?php echo makeUrl("/nav/profiloDocente/profiloDocente.php");?>">Profilo</a>
      </li>
      <li class="<?php addOpt($classOption, 'partecipazione') ?>">
        <a href="<?php echo makeUrl("/nav/partecipazione/partecipazione.php");?>">Mia Partecipazione</a>
      </li>
      <li class="<?php addOpt($classOption, 'listaCorsi') ?>">
        <a href="<?php echo makeUrl("/nav/corsi/listaCorsi.php");?>">Lista corsi</a>
      </li>
      <li class="<?php addOpt($classOption, 'rapporto') ?>">
        <a href="<?php echo makeUrl("/nav/rapporti/rapporto.php");?>">Rapporto</a>
      </li>
      <li class="<?php addOpt($classOption, 'logout') ?>">
        <a href="<?php echo makeUrl("/nav/autenticazione/logout.php");?>">Logout</a>
      </li>
    </ul>     
  </div>
