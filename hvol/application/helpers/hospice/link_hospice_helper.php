<?php
/*---------------------------------------------------------------------
   Hospice Volunteer Solutions
   copyright (c) 2015 Database Austin
  
   author: John Zimmerman 
  
   This software is provided under the GPL.
   Please see http://www.gnu.org/copyleft/gpl.html for details.
   
---------------------------------------------------------------------   
      $this->load->helper('hospice/link_hospice');
---------------------------------------------------------------------*/

//===============================
//    A D D   N E W
//===============================
function strLinkAdd_HospicePVist($lVolID, $lPatientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/patient_visit/addEditPatientVisit/'
                            .$lVolID.'/0/'.$lPatientID.'/true', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_VolMgrAddMiscVolActivity($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/vols/hospice_vol/otherActivity/0/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_VolTraining($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/vols/vol_training/addEditVolTraining/0/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_PatientAssociation($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/vols/patient_assoc/addAssoc01/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_PatientContact($lPatientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/patients/patient_contact/addEditContact/0/'.$lPatientID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}


//===============================
//    E D I T
//===============================
function strLinkEdit_Account($lAcctID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('superUser')) return('');
   return(strImageLink('hospice/super/account_rec/addEditAcct/'.$lAcctID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

function strLinkEdit_Location($lLocID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('superUser')) return('');
   return(strImageLink('hospice/super/location_rec/addEditLoc/'.$lLocID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

function strLinkEdit_PVisit($lVolID, $lPVRecID, $lPatientID, $bShowIcon, $strTitle, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/patient_visit/addEditPatientVisit/'.$lVolID.'/'.$lPVRecID.'/'.$lPatientID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

//function strLinkEdit_VMgrResetPWord($lAcctID, $bShowIcon, $strTitle, $strAnchorExtra=''){
function strLinkEdit_ResetPWord($lAcctID, $bShowIcon, $strTitle, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
//   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('more/user_acct/pw/'.$lAcctID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}
/*
function strLinkEdit_SUResetPWord($lAcctID, $bShowIcon, $strTitle, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/super/account_rec/resetPW/'.$lAcctID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}
*/

function strLinkEdit_VolMgrMiscVolActivity($lActivityID, $lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/vols/hospice_vol/otherActivity/'.$lActivityID.'/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

function strLinkEdit_VolTraining($lTrainingID, $lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/vols/vol_training/addEditVolTraining/'.$lTrainingID.'/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

function strLinkEdit_Patient($lPatientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/patients/patient_rec/addEditPRec/'.$lPatientID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

function strLinkEdit_PCon($lPConID, $lPatientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/patients/patient_contact/addEditContact/'.$lPConID.'/'.$lPatientID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

function strLinkEdit_Volunteer($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
//   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('hospice/vols/hospice_vol/addEditVol/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}


/*

//===============================
//    E X P O R T
//===============================
function strLinkExport_Table($enumContext, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('reports/export_tables/run/'.$enumContext, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EXPORTSMALL, $strTitle));
}
*/


//===============================
//    R E M O V E
//===============================
function strLinkRem_Location($lLocID, 
                           $strTitle, $bShowIcon, 
                           $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('superUser')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this Location record? \');" ';
   }
   return(strImageLink('hospice/super/location_rec/removeLocation/'.$lLocID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_PVisit($lVolID, 
                           $lRecID,         $strTitle, $bShowIcon, 
                           $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this Patient Visit record? \');" ';
   }
   return(strImageLink('hospice/patient_visit/removeRecord/'.$lVolID.'/'.$lRecID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_PCon($lPConID, 
                         $strTitle, $bShowIcon, 
                         $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this Patient Contact record? \');" ';
   }
   return(strImageLink('hospice/patients/patient_contact/removeRecord/'.$lPConID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_VolTraining($lTrainingID, 
                         $strTitle, $bShowIcon, 
                         $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this Volunteer Training record? \');" ';
   }
   return(strImageLink('hospice/vols/vol_training/removeRecord/'.$lTrainingID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

//===============================
//    V I E W
//===============================
function strLinkView_Location($lLocID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/super/location_rec/locationRecView/'.$lLocID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_PContact($lPConID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/patients/patient_contact/viewRec/'.$lPConID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_PatientRecord($lPatientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/patients/patient_rec/viewRec/'.$lPatientID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolRecord($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/vols/vol_record/viewRec/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_PVisit($lVisitID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/patient_visit/visitRecView/'.$lVisitID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrViewVolLog($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/review/reviewHours/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrRptVolHrsPVViaMonth($lMonth, $lYear, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/reports/monthly/pVisitDetailViaMonth/'.$lMonth.'/'.$lYear, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrRptVolHrsNonPVViaMonth($lMonth, $lYear, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/reports/monthly/nonPVisitDetailViaMonth/'.$lMonth.'/'.$lYear, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrRptVolCntPVViaMonth($lMonth, $lYear, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/reports/monthly/volCntPVisitDetailViaMonth/'.$lMonth.'/'.$lYear, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrRptVolCntNonPVViaMonth($lMonth, $lYear, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/reports/monthly/volCntNonPVisitDetailViaMonth/'.$lMonth.'/'.$lYear, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrRptPVViaMonth($lMonth, $lYear, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/reports/monthly/pVisitDetailViaMonth/'.$lMonth.'/'.$lYear, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrRptUniquePatientsViaMonth($lMonth, $lYear, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/reports/monthly/uniquePatientsDetailViaMonth/'.$lMonth.'/'.$lYear, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VMgrViewVolTraining($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/vols/vol_training/volTrainingLog/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

//===============================
//    S P E C I A L
//===============================
function strLink_PatientActiveInactive($lPatientID, $bSetActive, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/patients/patient_util/setActiveState/'.$lPatientID.'/'.($bSetActive ? 'true' : 'false'), $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bSetActive ? IMGLINK_ACTIVATE : IMGLINK_DEACTIVATE), $strTitle));
}

function strLink_VolAssocActiveInactive($lVolID, $lAssocID, $bSetActive, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/vols/vol_util/setActiveStateVAssoc/'.$lVolID.'/'.$lAssocID.'/'.($bSetActive ? 'true' : 'false'), $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bSetActive ? IMGLINK_ACTIVATE : IMGLINK_DEACTIVATE), $strTitle));
}

function strLink_VolActiveInactive($lVolID, $bSetActive, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/vols/vol_util/setActiveStateVol/'.$lVolID.'/'.($bSetActive ? 'true' : 'false'), $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bSetActive ? IMGLINK_ACTIVATE : IMGLINK_DEACTIVATE), $strTitle));
}

function strLink_LocActiveInactive($lLocID, $bSetActive, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/super/locations/setActiveStateLoc/'.$lLocID.'/'.($bSetActive ? 'true' : 'false'), $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bSetActive ? IMGLINK_ACTIVATE : IMGLINK_DEACTIVATE), $strTitle));
}

function strLink_AcctActiveInactive($lAcctID, $bSetActive, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('hospice/super/accounts/setActiveStateAcct/'.$lAcctID.'/'.($bSetActive ? 'true' : 'false'), $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bSetActive ? IMGLINK_ACTIVATE : IMGLINK_DEACTIVATE), $strTitle));
}



//===============================
//   R E D I R E C T S
//===============================

/*


function redirect_Auction($lAuctionID){
   redirect('auctions/auctions/viewAuctionRecord/'.$lAuctionID);
}

function redirect_AuctionItem($lItemID){
   redirect('auctions/items/viewItemRecord/'.$lItemID);
}


*/


