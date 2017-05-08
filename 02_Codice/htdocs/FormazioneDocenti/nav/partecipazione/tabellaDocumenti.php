<?php 
  // require_once "$__ROOT__/nav/gestioneDocente/formTrova.php";
  require_once $_SERVER['DOCUMENT_ROOT']."/FormazioneDocenti/baseUrl.php";
  require_once "$__ROOT__/head.php";
  require_once "$__ROOT__/tierData/dbInterface/DbFile.php";
?>

<div class="col-12">
  <table class="leftAlign">
    <thead>
      <tr>
        <th>Documenti</th>
      <tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <tr>
            <th> <!-- ?php $dbFiles = $frequenza->Corso->Doc; require "$__ROOT__/tierData/dbInterface/listaDbFiles.php"? -->
              Richiesta
            </th>
            <td>
              dummyRichiesta.pdf
            </td>
          <tr>
          <tr>
            <th>
              Approvazione
            </th>
            <td>
              dummyApprovazione.pdf
            </td>
          <tr>
          <tr>
            <th>
              Iscrizione
            </th>
            <td>
              dummyIscrizione.pdf
            </td>
          <tr>
          <tr>
            <th>
              Conferma
            </th>
            <td>
              dummyConferma.pdf
            </td>
          <tr>
          <tr>
            <th>
              Certificato
            </th>
            <td>
              dummyCertificato.pdf
            </td>
          <tr>
          <tr>
            <th>
              Giustificazione
            </th>
            <td>
              dummyGiustificazione.pdf
            </td>
          <tr>
        </td>
      </tr>
    </tbody>
  </table>
</div>
