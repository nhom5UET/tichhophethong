<?php
/*
      $this->load->helper('dl_util/verify_id');
      verifyID($glChapterID, $varID, 'image ID');
      verifyIDsViaType($glChapterID, CENUM_CONTEXT_PEOPLE, $lFID, false);
*/

function verifyID($lChapterID, $varID, $enumVerifyType, $bRedirectOnFail=true){
   /*---------------------------------------------------------------------
      another way... Note that get_instance is a CI function, defined in
      system/core/CodeIgniter.php

      from http://stackoverflow.com/questions/4740430/explain-ci-get-instance

      $CI =& get_instance(); // use get_instance, it is less prone to failure in this context.
   ---------------------------------------------------------------------*/
   $CI =& get_instance();
   $bValid = true;
   switch ($enumVerifyType){
//      case 'account ID':
//         $bValid = vid_bGenericRecExists($lChapterID, $varID, 'gifts_accounts', 'ga_lKeyID', 'ga_lChapterID', 'ga_bRetired');
//         break;

      case 'attributed to ID':
         $bValid = vid_bAttributedToIDExists($lChapterID, $varID);
         break;

      case 'patient ID':
         $bValid = vid_bGenericRecExists($lChapterID, $varID, 'patient_records', 'cr_lKeyID', 'cr_lChapterID', 'cr_bRetired');
         break;

      case 'patientContact ID':
         $bValid = vid_bGenericRecExists(null, $varID, 'patient_contacts', 'cc_lKeyID', null, 'cc_bRetired');
         break;

      case 'patientVisit ID':
         $bValid = vid_bGenericRecExists($lChapterID, $varID, 'patient_visit', 'pv_lKeyID', 'pv_lChapterID', 'pv_bRetired');
         break;

      case 'vpAssoc ID':
         $bValid = vid_bVPAssocRecExists($lChapterID, $varID);
         break;

      case 'image/document ID':
         $bValid = vid_bGenericRecExists($lChapterID, $varID, 'docs_images', 'di_lKeyID', 'di_lChapterID', 'di_bRetired');
         break;

      case 'organization ID':
         $bValid = vid_bGenericRecExists(null, $varID, 'admin_chapters', 'ch_lKeyID', null, 'ch_bRetired');
         break;

      case 'people ID':
         $bValid = vid_bPBRecExists($lChapterID, $varID, false, false);
         break;

      case 'user ID':
         $bValid = vid_bGenericRecExists($lChapterID, $varID, 'admin_users', 'us_lKeyID', 'us_lChapterID', null);
         break;

      case 'volunteer ID':
         $bValid = vid_bVolRecExists($lChapterID, $varID, 'vol_lChapterID');
         break;

      case 'vol training ID':
         $bValid = vid_bGenericRecExists($lChapterID, $varID, 'vol_training', 'vt_lKeyID', 'vt_lChapterID', 'vt_bRetired');
         break;

      default:
         screamForHelp($enumVerifyType.': invalid verify type<br>error on line <b> -- '.__LINE__.' --</b>,<br>file '.__FILE__.',<br>function '.__FUNCTION__);
         break;
   }
   if ($bRedirectOnFail){
      vid_bTestFail($bValid, $enumVerifyType, $varID);
   }
   return($bValid);
}

function vid_bTestFail($bValid, $enumVerifyType, $varID){
   if (!$bValid){
      $CI =& get_instance();
      $CI->session->set_flashdata('error', '<b>ERROR:</b> The '.$enumVerifyType.' <b>'.htmlspecialchars($varID).'</b> is not valid.</font>');
      redirect('main/menu/home');
   }
}

function verifyIDsViaType(&$local, $enumContext, $lFID, $bTestForZero){
//---------------------------------------------------------------------
//
//---------------------------------------------------------------------
echo(__FILE__.' '.__LINE__.'<br>'."\n"); die;
   if (!$bTestForZero || ($lFID.'' != '0')){
      switch ($enumContext){
         case CENUM_CONTEXT_ACCOUNT:          verifyID($local, $lFID, 'account ID');          break;
         case CENUM_CONTEXT_AUCTION:          verifyID($local, $lFID, 'auction ID');          break;
         case CENUM_CONTEXT_AUCTIONITEM:      verifyID($local, $lFID, 'auction item ID');     break;
         case CENUM_CONTEXT_AUCTIONPACKAGE:   verifyID($local, $lFID, 'package ID');          break;
         case CENUM_CONTEXT_BIZ:              verifyID($local, $lFID, 'business ID');         break;
         case CENUM_CONTEXT_BIZCONTACT:       verifyID($local, $lFID, 'business contact ID'); break;
         case CENUM_CONTEXT_CAMPAIGN:         verifyID($local, $lFID, 'campaign ID');         break;

         case CENUM_CONTEXT_CLIENT:
         case CENUM_CONTEXT_CPROGRAM:
         case CENUM_CONTEXT_CPROGENROLL:
         case CENUM_CONTEXT_CPROGATTEND:      verifyID($local, $lFID, 'client ID');           break;

         case CENUM_CONTEXT_CUSTOMREPORT:     verifyID($local, $lFID, 'custom report ID');    break;
         case CENUM_CONTEXT_CUSTOMREPORTTERM: verifyID($local, $lFID, 'search term ID');      break;
         case CENUM_CONTEXT_GIFT:             verifyID($local, $lFID, 'donation ID');         break;
         case CENUM_CONTEXT_GIFTHON:          verifyID($local, $lFID, 'honorarium ID');       break;
         case CENUM_CONTEXT_GIFTMEM:          verifyID($local, $lFID, 'memorial ID');         break;

         case CENUM_CONTEXT_GRANTS:           verifyID($local, $lFID, 'grant ID');            break;
         case CENUM_CONTEXT_GRANTPROVIDER:    verifyID($local, $lFID, 'provider ID');         break;

         case CENUM_CONTEXT_HOUSEHOLD:        verifyID($local, $lFID, 'household ID');        break;
         case CENUM_CONTEXT_LOCATION:         verifyID($local, $lFID, 'client location ID');  break;
         case CENUM_CONTEXT_ORGANIZATION:     verifyID($local, $lFID, 'organization ID');     break;
         case CENUM_CONTEXT_PEOPLE:           verifyID($local, $lFID, 'people ID');           break;
         case CENUM_CONTEXT_REMINDER:         verifyID($local, $lFID, 'reminder ID');         break;
         case CENUM_CONTEXT_SPONSORPAY:       verifyID($local, $lFID, 'sponsor payment ID');  break;

         case CENUM_CONTEXT_SPONSORSHIP:      verifyID($local, $lFID, 'sponsor ID');          break;
         case CENUM_CONTEXT_STATUSCAT:        verifyID($local, $lFID, 'status category ID');  break;
         case CENUM_CONTEXT_STAFF:
         case CENUM_CONTEXT_USER:             verifyID($local, $lFID, 'user ID');             break;
         case CENUM_CONTEXT_VOLUNTEER:        verifyID($local, $lFID, 'volunteer ID');        break;

         case CENUM_CONTEXT_INVITEM:          verifyID($local, $lFID, 'inventory item ID');   break;
         default:
            screamForHelp($enumContext.': invalid context type<br>error on line <b> -- '.__LINE__.' --</b>,<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            break;
      }
   }
}

/*
function vid_bPeopleRecExists (&$local, $lPID){
  return(vid_bPBRecExists($local, $lPID, false));
}
*/
function vid_bBizRecExists($lChapterID, $lBID){
  return(vid_bPBRecExists($lChapterID, $lBID, true));
}

function vid_bVPAssocRecExists($lChapterID, $lAssocID){
   if (!is_numeric($lAssocID)) return(false);
   $CI =& get_instance();
   $sqlStr =
       "SELECT vca_lKeyID
        FROM vol_client_association
           INNER JOIN volunteers ON vca_lVolID=vol_lKeyID
        WHERE NOT vca_bRetired
           AND vol_lChapterID=$lChapterID
           AND NOT vol_bRetired
           AND vca_lKeyID=$lAssocID;";
   $query = $CI->db->query($sqlStr);
   return($query->num_rows() > 0);
}
/*
function vid_bPBRecExists(&$lChapterID, $lPBID, $bBiz, $bTestBiz=true){
   if (!is_numeric($lPBID)) return(false);
   $CI =& get_instance();
   $sqlStr =
       "SELECT pe_lKeyID FROM people_names
        WHERE pe_lKeyID=".(integer)$lPBID
         ." AND pe_lChapterID = $lChapterID
            AND NOT pe_bRetired ".($bTestBiz ? ' AND '.($bBiz ? '' : ' NOT ')." pe_bBiz " : '') .';';
   $query = $CI->db->query($sqlStr);
   return($query->num_rows() > 0);
}
*/
function vid_bVolRecExists($lChapterID, $lVolID){
   if (!is_numeric($lVolID)) return(false);
   $CI =& get_instance();
   $sqlStr =
      "SELECT vol_lKeyID
       FROM volunteers
          -- INNER JOIN people_names ON pe_lKeyID=vol_lPeopleID
       WHERE vol_lKeyID=$lVolID
          AND NOT vol_bRetired
          AND vol_lChapterID=$lChapterID;";
   $query = $CI->db->query($sqlStr);
   return($query->num_rows() > 0);
}

function vid_bVolViaPIDExists(&$local, $lPID, &$lVolID){
   if (!is_numeric($lPID)) return(false);
   $sqlStr =
      "SELECT vol_lKeyID
       FROM volunteers
          INNER JOIN people_names ON pe_lKeyID=vol_lPeopleID
       WHERE pe_lKeyID=$lPID
          AND NOT vol_bRetired
          AND NOT pe_bRetired;";
   $query = $local->db->query($sqlStr);

   if($query->num_rows() > 0){
      $row = $query->row();
      $lVolID = $row->vol_lKeyID;
      return(true);
   }else {
      return(false);
   }
}
/*
function vid_bUserTableIDExists(&$local, $lUFID, &$enumTabType){
   if (!is_numeric($lUFID)) return(false);
   $sqlStr =
      "SELECT pft_lKeyID, pft_enumAttachType
       FROM uf_tables
       WHERE pft_lKeyID=$lUFID AND NOT pft_bRetired;";
   $query = $local->db->query($sqlStr);

   if($query->num_rows() > 0){
      $row = $query->row();
      $enumTabType = $row->pft_enumAttachType;
      return(true);
   }else {
      return(false);
   }
}
*/

function vid_bGenericRecExists($lChapterID, $varID, $strTable, $strKeyIDFN, $strChapterIDFN, $strRetFN){
   if (!is_numeric($varID)) return(false);
   if (is_null($lChapterID)){
      $strChapterTest = '';
   }else {
      $strChapterTest = " AND  $strChapterIDFN = $lChapterID ";
   }
   $CI =& get_instance();
   $sqlStr = "SELECT $strKeyIDFN FROM $strTable
              WHERE
                $strKeyIDFN=".(integer)$varID.' '.$strChapterTest
              .(is_null($strRetFN) ? '' : " AND NOT $strRetFN ").';';
   $query = $CI->db->query($sqlStr);
   return($query->num_rows() > 0);
}

function vid_bAttributedToIDExists(&$local, $varID){
echo(__FILE__.' '.__LINE__.'<br>'."\n"); die;
   if (!is_numeric($varID)) return(false);
   $sqlStr = 'SELECT lgen_lKeyID FROM lists_generic
              WHERE NOT lgen_bRetired AND lgen_lKeyID='.(integer)$varID.' AND lgen_enumListType="attrib";';
   $query = $local->db->query($sqlStr);
   return($query->num_rows() > 0);
}

