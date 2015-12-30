<?php
   global $glChapterID;

   $params = array('enumStyle' => 'terse');
   $clsRpt = new generic_rpt($params);

   $strLabWidth = 120;
   chapterInfo      ($clsRpt, $strLabWidth, $locRec);
   
   showUserENPStats ($clsRpt, $strLabWidth, $locRec);

function chapterInfo($clsRpt, $strLabWidth, $locRec){
//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
   openBlock('Your Location',
                strLinkEdit_Location($locRec->lKeyID, 'Edit location record', true).'&nbsp;'
               .strLinkEdit_Location($locRec->lKeyID, 'Edit location record', false)
                );

   echoT(
       $clsRpt->openReport()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Name:', $strLabWidth)
      .$clsRpt->writeCell(htmlspecialchars($locRec->strLocationName))
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Banner Tag:', $strLabWidth)
      .$clsRpt->writeCell(htmlspecialchars($locRec->strBannerTagLine))
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Status:', $strLabWidth)
      .$clsRpt->writeCell(($locRec->bActive ? 'Active' : 'Inactive'))
      .$clsRpt->closeRow  ());

   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Address:', $strLabWidth)
      .$clsRpt->writeCell($locRec->strAddress)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Phone:', $strLabWidth)
      .$clsRpt->writeCell($locRec->strPhone)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Fax:', $strLabWidth)
      .$clsRpt->writeCell($locRec->strFax)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Email:', $strLabWidth)
      .$clsRpt->writeCell($locRec->strEmail)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Web Site:', $strLabWidth)
      .$clsRpt->writeCell($locRec->strWebSite)
      .$clsRpt->closeRow  ());

   echoT(
       $clsRpt->openRow   ()
      .$clsRpt->writeLabel('Notes:', $strLabWidth)
      .$clsRpt->writeCell(nl2br(htmlspecialchars($locRec->strNotes)))
      .$clsRpt->closeRow  ()

      .$clsRpt->closeReport());

   $attributes = new stdClass;
   $attributes->strExtraText   = '<br>';
   closeBlock($attributes);
}

function showUserENPStats($clsRpt, $strLabWidth, $locRec){
//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
   $clsForm = new generic_form;
   $clsForm->strLabelClass = $clsForm->strLabelRowLabelClass = $clsForm->strLabelClassRequired = 'enpViewLabel';
   $clsForm->strEntryClass = 'enpView';

   $attributes = new stdClass;
   $attributes->lTableWidth  = 900;
   $attributes->divID        = 'orgENP';
   $attributes->divImageID   = 'orgENPDivImg';
   openBlock('Record Information', '', $attributes);

   echoT(
      $clsRpt->showRecordStats($locRec->dteOrigin,
                            $locRec->strStaffCFName. ' '.$locRec->strStaffCLName,
                            $locRec->dteLastUpdate,
                            $locRec->strStaffLFName. ' '.$locRec->strStaffLLName,
                            $strLabWidth));

   $attributes = new stdClass;
   $attributes->bCloseDiv = true;
   closeBlock($attributes);
}

?>