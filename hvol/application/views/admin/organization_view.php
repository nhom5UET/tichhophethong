<?php
   global $glChapterID;

   $params = array('enumStyle' => 'terse');
   $clsRpt = new generic_rpt($params);

   $strLabWidth = 120;
   chapterInfo      ($clsRpt, $strLabWidth, $chapterRec);
/*
   showImageInfo    (CENUM_CONTEXT_ORGANIZATION, $glChapterID, ' Images',
                     $images, $lNumImages, $lNumImagesTot);
   showDocumentInfo (CENUM_CONTEXT_ORGANIZATION, $glChapterID, ' Documents',
                     $docs, $lNumDocs, $lNumDocsTot);
*/
   showUserENPStats ($clsRpt, $strLabWidth, $chapterRec);

function chapterInfo($clsRpt, $strLabWidth, $chapterRec){
//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
   $bUSDateFormat = $chapterRec->bUS_DateFormat;
   if ($bUSDateFormat){
      $strDateFormat = 'US (m/d/Y)';
   }else {
      $strDateFormat = 'Europe/India (d/m/Y)';
   }

   openBlock('Your Organization',
                strLinkEdit_Chapter($chapterRec->lKeyID, 'Edit organization record', true).'&nbsp;'
               .strLinkEdit_Chapter($chapterRec->lKeyID, 'Edit organization record', false)
                );

   echoT(
       $clsRpt->openReport()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Name:', $strLabWidth)
      .$clsRpt->writeCell(htmlspecialchars($chapterRec->strChapterName))
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Banner Tag:', $strLabWidth)
      .$clsRpt->writeCell(htmlspecialchars($chapterRec->strBannerTagLine))
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Address:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strAddress)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Phone:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strPhone)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Fax:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strFax)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Email:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strEmail)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Web Site:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strWebSite)
      .$clsRpt->closeRow  ()

/*
      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Default Area Code:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strDefAreaCode)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Default State:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strDefState)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Default Country:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strDefCountry)
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Default Date Format:', $strLabWidth)
      .$clsRpt->writeCell($strDateFormat)
      .$clsRpt->closeRow  ()
      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Time Zone:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strTimeZone, '', '', 1, 1, ' id="orgTZ" ')
      .$clsRpt->closeRow  ()

      .$clsRpt->openRow   ()
      .$clsRpt->writeLabel('Default Accounting Country:', $strLabWidth)
      .$clsRpt->writeCell($chapterRec->strCountryName.' '.$chapterRec->strFlagImg)
      .$clsRpt->closeRow  ()
*/
      .$clsRpt->closeReport());

   $attributes = new stdClass;
   $attributes->strExtraText   = '<br>';
   closeBlock($attributes);
}

function showUserENPStats($clsRpt, $strLabWidth, $chapterRec){
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
      $clsRpt->showRecordStats($chapterRec->dteOrigin,
                            $chapterRec->strStaffCFName. ' '.$chapterRec->strStaffCLName,
                            $chapterRec->dteLastUpdate,
                            $chapterRec->strStaffLFName. ' '.$chapterRec->strStaffLLName,
                            $strLabWidth));

   $attributes = new stdClass;
   $attributes->bCloseDiv = true;
   closeBlock($attributes);
}

?>