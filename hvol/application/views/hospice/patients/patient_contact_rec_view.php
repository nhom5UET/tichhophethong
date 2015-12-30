<?php
   global $gbVolMgr;

   $params = array('enumStyle' => 'terse', 'clsRpt');
   $clsRpt = new generic_rpt($params);
   $clsRpt->strWidthLabel = '130pt';

   $strLinkRem =
           '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'
          .strLinkRem_PCon($lPConID, 'Remove', true,  true).'&nbsp;'
          .strLinkRem_PCon($lPConID, 'Remove', false, true);
   $strLinkEdit =
              strLinkEdit_PCon($lPConID, $lPatientID, 'Edit record', true,  ' id="editPCon" ').'&nbsp;'
             .strLinkEdit_PCon($lPConID, $lPatientID, 'Edit record', false, ' id="editPCon1" ');

   openBlock('Patient Contact', $strLinkEdit.$strLinkRem);

   echoT(
       $clsRpt->openReport());

      // name
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Name:')
      .$clsRpt->writeCell (htmlspecialchars($pCon->strPConLName.', '.$pCon->strPConFName.' '.$pCon->strPConMName))
      .$clsRpt->closeRow  ());

      // relationship
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Relationship:')
      .$clsRpt->writeCell (htmlspecialchars($pCon->strRelationship))
      .$clsRpt->closeRow  ());

      // address 1
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Address 1:')
      .$clsRpt->writeCell (htmlspecialchars($pCon->strAddr1))
      .$clsRpt->closeRow  ());

      // address 2
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Address 2:')
      .$clsRpt->writeCell (htmlspecialchars($pCon->strAddr2))
      .$clsRpt->closeRow  ());

      // city/state/zip/country
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('City/State/Zip/Country:')
      .$clsRpt->writeCell (htmlspecialchars($pCon->strCity.', '.$pCon->strState.' '.$pCon->strZip.' '.$pCon->strCountry))
      .$clsRpt->closeRow  ());

      // phone
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Phone:')
      .$clsRpt->writeCell (htmlspecialchars($pCon->strPhone))
      .$clsRpt->closeRow  ());

      // cell
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Cell:')
      .$clsRpt->writeCell (htmlspecialchars($pCon->strCell))
      .$clsRpt->closeRow  ());

      // email
   if ($pCon->strEmail == ''){
      $strEMail = '';
   }else {
      $strEMail = '<a href="mailto:'.$pCon->strEmail.'">'.$pCon->strEmail.'</a>';
   }
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('EMail:')
      .$clsRpt->writeCell ($strEMail)
      .$clsRpt->closeRow  ());

      // notes
   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Notes:')
      .$clsRpt->writeCell (nl2br(htmlspecialchars($pCon->strNotes)))
      .$clsRpt->closeRow  ());
   echoT(
       $clsRpt->closeReport());

   closeBlock();

