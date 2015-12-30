<?php

//      $attributes = array('name' => 'frmEditClient', 'id' => 'frmAddEdit');
   $strLinkBase = 'hospice/patient_visit/addEditPVSelected/';
      
   echoT('<br><span style="font-size: 11pt;">Please select the patient you visited:</span><br>');
   openWrapperTable();
   
   foreach ($volClient as $vc){
      $lPatientID = $vc->lPatientID;
      echoT('<tr><td>'."\n");
      echoT(strLinkSpecial_SearchSelect($strLinkBase.$lPatientID, 'Select', true, 'id="sel'.$lPatientID.'"')
                 .'&nbsp;'.htmlspecialchars($vc->patient->strLName.', '.$vc->patient->strFName).'<br><br>');
      echoT('</td></tr>'."\n");
   }
   closeWrapperTable();
      
      
