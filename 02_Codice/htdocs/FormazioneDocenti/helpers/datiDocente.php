      <table class="leftAlign" style="padding-bottom: 0">
        <tr>
          <th>CID</th><th>Sigla</th><th>Nome</th><th>Cognome</th>
        </tr>
        <tr>
          <td><input type="text" name="cid" value="<?php echo $doc->Cid ?>" size="8"></td>
          <td><input type="text" name="sigla" value="<?php echo $doc->Sigla ?>" size="8"></td>
          <td><input type="text" name="nome" value="<?php echo $doc->Nome ?>" size="29"></td>
          <td><input type="text" name="cognome" value="<?php echo $doc->Cognome ?>" size="30"></td>
        </tr>
      </table>
      <table class="leftAlign" style="padding-top: 0">
        <tr>
          <th>No</th><th>Via</th><th>
        </tr>
        <tr>
          <td><input type="text" name="viaNo" value="<?php echo $doc->Indirizzo->ViaNo ?>" size="15"></td>
          <td><input type="text" name="via" value="<?php echo $doc->Indirizzo->Via ?>" size="75"></td>
          <td>
        </tr>
        <tr>
          <th>NAP</th><th>Luogo</th><th>
        </tr>
        <tr>
          <td><input type="text" name="nap" value="<?php echo $doc->Indirizzo->Nap ?>" size="15"></td>
          <td><input type="text" name="localita" value="<?php echo $doc->Indirizzo->Localita ?>" size="75"></td>
          <td>
        </tr>
           <th>Telefono</th><th>E-mail</th><th>
        </tr>
        <tr>
          <td><input type="text" name="telefono" value="<?php echo $doc->Contatto->Tel ?>" size="15"></td>
          <td><input type="text" name="email" value="<?php echo $doc->Contatto->Email ?>" size="75"></td>
          <td>
        </tr>
      </table>
