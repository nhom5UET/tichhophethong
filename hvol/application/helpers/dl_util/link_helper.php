<?php
/*---------------------------------------------------------------------
   Hospice Volunteer Solutions
   copyright (c) 2015 Database Austin
  
   author: John Zimmerman 
  
   This software is provided under the GPL.
   Please see http://www.gnu.org/copyleft/gpl.html for details.
---------------------------------------------------------------------*/

define ('IMGLINK_ACTIVATE',        'activate.png');
define ('IMGLINK_ADDNEW',          'recordAdd.gif');
define ('IMGLINK_ADDNEWPERSON',    'newPerson.png');
define ('IMGLINK_APPLYCHARGES',    'applyCharges01.png');
define ('IMGLINK_ASSESSMENTS',     'assessment01.png');
define ('IMGLINK_CICO_CHECKIN',    'cico_check_in.png');
define ('IMGLINK_CICO_CHECKOUT',   'cico_check_out.png');
define ('IMGLINK_CLONE',           'clone01.gif');
define ('IMGLINK_CONFIG',          'configIcon.png');
define ('IMGLINK_DEBUG',           'debug.gif');
define ('IMGLINK_DEACTIVATE',      'inactive03.gif');
define ('IMGLINK_NODELETE',        'cantDelete.gif');   
define ('IMGLINK_DELETE',          'delete02.gif');      
define ('IMGLINK_DELETESMALL',     'deleteSmall01.gif'); 
define ('IMGLINK_EDIT',            'edit.png');
define ('IMGLINK_EXPORT',          'export1.png');
define ('IMGLINK_EXPORTSMALL',     'exportSmall.png');
define ('IMGLINK_MAKE_HOH',        'makeHOH.gif');
define ('IMGLINK_LOSTFOUND',       'lostFound01.png');
define ('IMGLINK_LOCKSET',         'lock.png');
define ('IMGLINK_LOCKUNSET',       'lock_open.png');
define ('IMGLINK_REPORTLARGE',     'report02a.gif');
define ('IMGLINK_REPORTMED',       'reportMR02a.gif');
define ('IMGLINK_RETURN',          'return.gif');
define ('IMGLINK_RUNREPORT',       'runReport.png');
define ('IMGLINK_SELECT',          'select.png');
define ('IMGLINK_SEARCH',          'search04.png');
define ('IMGLINK_TIMESTAMP',       'timeStampSmall.png');
define ('IMGLINK_XFER',            'transfer01.gif');
define ('IMGLINK_VIEW',            'viewIcon.gif');
define ('IMGLINK_VIEWGIFTHISTORY', 'iconDonationHistory.png');
define ('IMGLINK_VIEWALLUSERS',    'viewAllUsers.png');

define ('IMGLINK_GIFTACK',         'giftAck03.png');

define ('IMGLINK_UP',              'arrowUpGreen01.png');
define ('IMGLINK_DOWN',            'arrowDownGreen01.png');
define ('IMGLINK_TOP',             'arrowTopGreen01.png');
define ('IMGLINK_BOTTOM',          'arrowBottomGreen01.png');
define ('IMGLINK_ARROWBLANK',      'arrowBlank.png');

define ('IMGLINK_HIDE',            'zoomHide.png');
define ('IMGLINK_UNHIDE',          'zoomShow.png');

define ('IMGLINK_JOOMLA',          'joomla_small.png');

define ('IMGLINK_WINNER',          'winner_icon.gif');
define ('IMGLINK_FULFILL',         'fulfill.gif');
define ('IMGLINK_PDFSMALL',        'pdfIiconSmall.gif');
define ('IMGLINK_DOLLAR',          base_url().'images/misc/dollar.gif');

define ('IMGLINK_CHECKON',         base_url().'images/misc/checkBoxOn.gif');
define ('IMGLINK_CHECKOFF',        base_url().'images/misc/checkBoxOff.gif');

function strImageLink($strAnchor, $strAnchorExtra, $bShowImage,
                      $bShowText, $enumImage,      $strLinkText,
                      $strHeight=null){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   $strLink = '';

   if ($bShowImage){
      if (is_null($strHeight)){
         $strHeight = '';
      }else {
         $strHeight = ' height="'.$strHeight.'" ';
      }
      $strLink .= anchor($strAnchor, '<img src="'.base_url().'images/misc/'.$enumImage.'" '.$strHeight
                                   .' title="'.$strLinkText.'" border="0" alt="link" />', $strAnchorExtra);
   }
   if ($bShowImage && $bShowText) $strLink .= '&nbsp;';
   if ($bShowText){
      $strLink .= anchor($strAnchor, $strLinkText, $strAnchorExtra);
   }
   return($strLink);
}



//===============================
//    A D D   N E W
//===============================

function strLinkAdd_Client($strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/client_rec_add_edit/addNewS1', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_GenericListItem($strListType, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('admin/alists_generic/addEdit/'.$strListType.'/0', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

/*
function strLinkAdd_ImageDoc($enumContext, $enumEntryType, $lFID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editImagesDocs', $enumContext)) return('');
   return(strImageLink('img_docs/upload_image_doc/add/'.$enumContext.'/'.$enumEntryType.'/'.$lFID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}
*/


function strLinkAdd_VolEvent($strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   return(strImageLink('volunteers/events_add_edit/addEditEvent/0', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_VolEventDate($lEventID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   return(strImageLink('volunteers/event_dates_add_edit/addEditDate/'.$lEventID.'/0', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_VolEventDateShift($lEventDateID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   return(strImageLink('volunteers/event_date_shifts_add_edit/addEditShift/'.$lEventDateID.'/0', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_VolEventDateShiftVol($lEventDateID, $lShiftID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('volunteers/event_date_shift_vols_add_edit/addEditVolsForShift/'
                  .$lEventDateID.'/'.$lShiftID, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_VolUnschedHrs($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   return(strImageLink('volunteers/unscheduled/addEditActivity/'.$lVolID.'/0', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}

function strLinkAdd_VolUnschedHrsAsVol($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volEditHours')) return('');
   return(strImageLink('volunteers/unscheduled/addEditActivityAsVol/'.$lVolID.'/0', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ADDNEW, $strTitle));
}




//===============================
//    E D I T
//===============================

/*
function strLinkEdit_Chapter($lChapterID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('volMgr')) return('');
   return(strImageLink('admin/org/addEdit/'.$lChapterID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

function strLinkEdit_Client($lCID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/client_rec_add_edit/addEdit/'.$lCID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}


function strLinkEdit_ClientLocation($lCLID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/locations/addEdit/'.$lCLID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}
*/

function strLinkEdit_GenericListItem($lListID, $strListType, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('admin/alists_generic/addEdit/'.$strListType.'/'.$lListID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}

/*
function strLinkEdit_ImageDoc($enumTType, $lImageDocID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editImagesDocs', $enumTType)) return('');
   return(strImageLink('img_docs/upload_image_doc/edit/'.$lImageDocID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}
function strLinkEdit_PeopleContact($lPeopleID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
//   if (!(bAllowAccess('editPeopleBizVol') || bAllowAccess('volEditContact'))) return('');
   return(strImageLink('people/people_add_edit/contact/'.$lPeopleID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_EDIT, $strTitle));
}
*/


/*
function strLinkRem_ImageDoc($enumTType, $lImageDocID, $bImage, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editImagesDocs', $enumTType)) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this '.($bImage ? 'image' : 'document').'?\');" ';
   }
   return(strImageLink('img_docs/upload_image_doc/remove/'.$lImageDocID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}
function strLinkRem_PeopleRelItem($lKeyID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this relationship entry?\');" ';
   }
   return(strImageLink('admin/admin_special_lists/people_lists/remove/'.$lKeyID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_People($lPID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra='', 
             $strReturnPath=null, $lReturnPathID=null){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');

   if (is_null($strReturnPath)){
      $strLinkExtra = '';
   }else {
      $strLinkExtra = '/'.$strReturnPath.'/'.$lReturnPathID;
   }
   
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(\'Are you sure you want to remove this person\\\'s record?\n\n'
                 .'This will also remove the person\\\'s associated gifts and sponsorships.\n\n'
                 .'This can not be undone.'
                 .'\');" ';
   }
   return(strImageLink('people/people_add_edit/remove/'.$lPID.$strLinkExtra, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_PersonFromHousehold($lPID, $lHouseholdID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(\'Are you sure you want to remove this person from the household?\n\n'
                 .'They will become the head of their own household.\');" ';
   }
   return(strImageLink('people/household/removePfromH/'.$lPID.'/'.$lHouseholdID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}


function strLinkRem_Relationship($lRelationshipID, $lBasePID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(\'Are you sure you want to remove this relationship?\');" ';
   }
   return(strImageLink('people/relationships/remove/'.$lRelationshipID.'/'.$lBasePID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}
*/


function strLinkRem_GenericListItem($lListID, $strListType, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to retire this list item?\');" ';
   }
   return(strImageLink('admin/alists_generic/remove/'.$strListType.'/'.$lListID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_User($lUserID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this user?\');" ';
   }
   return(strImageLink('admin/accts/remove/'.$lUserID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}


function strLinkRem_VolEvent($lEventID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this event? \');" ';
   }
   return(strImageLink('volunteers/events_add_edit/remove/'.$lEventID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_VolEventDate($lEventID, $lEventDateID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra='', $bSmallIcon=false){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this event date? \');" ';
   }
   return(strImageLink('volunteers/event_dates_add_edit/remove/'.$lEventID.'/'.$lEventDateID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bSmallIcon ? IMGLINK_DELETESMALL : IMGLINK_DELETE), $strTitle));
}

function strLinkRem_VolEventDateShift($lEventDateID, $lShiftID, $strTitle, $bShowIcon, $bJSRemoveCheck, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this event shift? \');" ';
   }
   return(strImageLink('volunteers/event_date_shifts_add_edit/remove/'.$lEventDateID.'/'.$lShiftID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_VolEventDateShiftVol(
                       $lVolAssignID, $lEventDateID, $lShiftID, 
                       $strTitle,     $bShowIcon,    $bJSRemoveCheck, 
                       $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this volunteer from this shift? \');" ';
   }
   return(strImageLink('volunteers/event_date_shift_vols_add_edit/removeVolsFromShift/'
                         .$lVolAssignID.'/'.$lEventDateID.'/'.$lShiftID, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}

function strLinkRem_VolUnschedHrs($lVolID, $lActivityID, 
                       $strTitle,     $bShowIcon,    $bJSRemoveCheck, 
                       $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to remove this volunteer activity? \');" ';
   }
   return(strImageLink('volunteers/unscheduled/removeUnscheduled/'.$lVolID.'/'.$lActivityID, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DELETE, $strTitle));
}



//===============================
//    V I E W
//===============================
/*
function strLinkView_ClientAssessmentViaCID($lCID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('client_intake/client_forms/viewViaCID/'.$lCID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ASSESSMENTS, $strTitle));
}

function strLinkView_ClientLocation($lCLID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('adminOnly')) return('');
   return(strImageLink('clients/locations/view/'.$lCLID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientDirByName($bIncludeInactive, $strLetter, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/client_dir/name/'.($bIncludeInactive ? 'Y' : 'N').'/'.$strLetter,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientRecord($lClientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/client_record/view/'.$lClientID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientStatEntries($lSCID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('admin/admin_special_lists/clients/statCatEntries/'.$lSCID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientStatusHistory($lClientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/client_rec_stat/viewStatusHistory/'.$lClientID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientsViaLocation($lLocID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/client_dir/view/'.$lLocID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientsViaSponProg($lSponProgID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/clients_via_prog/view/'.$lSponProgID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientViaStatID($lStatID, $bActive, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('reports/pre_clients/clientViaStatusID/'.$lStatID.'/'.($bActive ? 'true' : 'false'), 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_ClientViaStatCatID($lStatCatID, $bActive, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('reports/pre_clients/clientViaStatCatID/'.$lStatCatID.'/'.($bActive ? 'true' : 'false'), 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}
*/


function strLinkView_GroupMembership($lGID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('groups/groups_view/viewMembers/'.$lGID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}


/*
function strLinkView_ImageDocs($enumContext, $enumEntryType, $lFID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('img_docs/image_doc_view/view/'.$enumContext.'/'.$enumEntryType.'/'.$lFID,
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}
*/
function strLinkView_ImportEntries($lLogID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('admin/import/logDetails/'.$lLogID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}


function strLinkView_RptAttrib($enumContextType, $lAttribID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('reports/pre_attrib/attribList/'.$enumContextType.'/'.$lAttribID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_RptDetailGeneric($reportID, $fIDs, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   $strLink = '/reports/reports/run/'.$reportID.'/0/50';
   if (!is_null($fIDs)){
      foreach ($fIDs as $fID){
         $strLink .= '/'.$fID;
      }
   }
   return(strImageLink($strLink, $strAnchorExtra, $bShowIcon, !$bShowIcon, IMGLINK_VIEW, $strTitle));
}


function strLinkView_User($lUserID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('adminOnly')) return('');
   return(strImageLink('admin/accts/view/'.$lUserID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_UsersAll($strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('adminOnly')) return('');
   return(strImageLink('admin/accts/userAcctDir/showAll', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_UserLogins($lUserID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('adminOnly')) return('');
   return(strImageLink('reports/pre_admin/loginLog/'.$lUserID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}


function strLinkView_Volunteer($lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showPeople')) return('');
   return(strImageLink('volunteers/vol_record/volRecordView/'.$lVolID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolEventAssignments($lEventID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showPeople')) return('');
   return(strImageLink('volunteers/events_cal/viewVolAssignViaEvent/'.$lEventID, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolEvent($lEventID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showPeople')) return('');
   return(strImageLink('volunteers/events_record/viewEvent/'.$lEventID, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolEventDate($lEdateID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showPeople')) return('');
   return(strImageLink('volunteers/event_dates_view/viewDates/'.$lEdateID, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolEventHrs($lEventID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showPeople')) return('');
   return(strImageLink('volunteers/vol_event_hours/viewHoursViaEvent/true/'.$lEventID, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolEventsList($bShowPast, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('volunteers/events_schedule/viewEventsList/'.($bShowPast ? 'true' : 'false'), 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolHrsViaVolID($lVolID, $bScheduled, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('reports/pre_vol_hours/viaVolID/'.$lVolID.'/'.($bScheduled ? 'true' : 'false'), 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolHrsViaYrMon($lYear, $lMon, $strSort, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('reports/pre_vol_hours/viaYrMon/'.$lYear.'/'.$lMon.'/'.$strSort, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolSumHrsViaYrMon($lYear, $lMon, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('reports/pre_vol_hours/volSumYrMon/'.$lYear.(is_null($lMon) ? '' : '/'.$lMon), 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolDetailHrsViaYrMon($lYear, $lMon, $lVolID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('reports/pre_vol_hours/volDetYrMonVID/'
                    .(is_null($lYear)  ? 'null' : $lYear).'/'
                    .(is_null($lMon)   ? 'null' : $lMon) .'/'
                    .(is_null($lVolID) ? 'null' : $lVolID), 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolHrsPVA($lVolID, $dteStart, $dteEnd, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('reports/pre_vol_hours/pvaViaVolID/'.$lVolID.'/'.$dteStart.'/'.$dteEnd, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}

function strLinkView_VolScheduleViaVolID($lVolID, $bShowAll, $bShowPast, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bShowAll){
      $strRptType = 'all';
   }elseif ($bShowPast){
      $strRptType = 'past';
   }else {
      $strRptType = 'cur';
   }
   return(strImageLink('reports/pre_vol_schedule/volSchedule/'.$lVolID.'/'.$strRptType, 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_VIEW, $strTitle));
}




//===============================
//    S P E C I A L S
//===============================

function strLinkDebug_Fields($lTableID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('admin/uf_debug/ufFieldDump/'.$lTableID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DEBUG, $strTitle));
}

function strLinkClone_VolShift($lEventDateID, $lShiftID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('volunteers/event_date_shifts_add_edit/cloneShiftOpts/'.$lEventDateID.'/'.$lShiftID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_CLONE, $strTitle));
}

function strLinkClone_PTable($lTableID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('admin/uf_special/cloneTable/'.$lTableID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_CLONE, $strTitle));
}

function strLinkHideUnhide_HonMem($lHMID, $bHide, $bHon, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('donations/hon_mem/'.($bHide ? 'hide' : 'unhide').'/'.$lHMID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bHide ? IMGLINK_HIDE : IMGLINK_UNHIDE), $strTitle));
}

function strLinkSearchSelect($strAncorBase, $lKeyID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink($strAncorBase.'/'.$lKeyID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_SELECT, $strTitle));
}
/*
function strLinkView_ViaRecType($enumSearchType, $lFKey01=null, $lFKey02=null){
//-----------------------------------------------------------------
//
//-----------------------------------------------------------------
   switch ($enumSearchType){
      case CENUM_CONTEXT_HOUSEHOLD:
         return(strLinkView_Household($lFKey01, $lFKey02, 'View household', true));
         break;
      case CENUM_CONTEXT_PEOPLE:
         return(strLinkView_PeopleRecord($lFKey01, 'View people record', true));
         break;
      case CENUM_CONTEXT_BIZ:
         return(strLinkView_BizRecord($lFKey01, 'View business/prganization record', true));
         break;
      case CENUM_CONTEXT_CLIENT:
         return(strLinkView_ClientRecord($lFKey01, 'View client record', true));
         break;
      case CENUM_CONTEXT_SPONSORSHIP:
         return(strLinkView_Sponsorship($lFKey01, 'View sponsor record', true));
         break;
      default:
         screamForHelp($enumSearchType.': invalid link type<br>error on <b>line:</b> '.__LINE__.'<br><b>file: </b>'.__FILE__.'<br><b>function: </b>'.__FUNCTION__);
         break;
   }
}
*/

function strLinkSpecial_Export($strReportID, $strTitle){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('allowExports')) return('');
   return(anchor('reports/exports/run/'.$strReportID, $strTitle));
}


function strLinkSpecial_SearchAgain($strPath, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink($strPath, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_RETURN, $strTitle));
}

function strLinkSpecial_SearchClient($strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink('clients/client_search/searchOpts', $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_SEARCH, $strTitle));
}

function strLinkSpecial_SearchSelect($strPath, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   return(strImageLink($strPath, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_SELECT, $strTitle));
}

function strLinkSpecial_UserDeactivate($lUserID, $strTitle, $bShowIcon, $bJSRemoveCheck=true, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to deactivate this user? \');" ';
   }
   return(strImageLink('admin/accts/deactivate/'.$lUserID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_DEACTIVATE, $strTitle));
}

function strLinkSpecial_UserActivate($lUserID, $strTitle, $bShowIcon, $bJSRemoveCheck=true, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to Activate this user? \');" ';
   }
   return(strImageLink('admin/accts/activate/'.$lUserID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_ACTIVATE, $strTitle));
}

function strLinkSpecial_VolActiveInactive($lVolID, $bSetActive, $strTitle, $bShowIcon, $bJSRemoveCheck=true, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('editPeopleBizVol')) return('');
   $strLabel = ($bSetActive ? 'activate' : 'deactivate');
   if ($bJSRemoveCheck){
      $strAnchorExtra .=
             ' onClick="javascript:return confirm(
                       \'Are you sure you want to '.$strLabel.' this volunteer? '
                       .($bSetActive ? '' : 'It will NOT remove the volunteer\\\'s record.').' \');" ';
   }

   return(strImageLink('volunteers/vol_add_edit/actDeact/'.$lVolID.'/'.($bSetActive ? 'true' : 'false'), 
                  $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, ($bSetActive ? IMGLINK_ACTIVATE : IMGLINK_DEACTIVATE), $strTitle));
}

function strLinkSpecial_XferClient($lClientID, $strTitle, $bShowIcon, $strAnchorExtra=''){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (!bAllowAccess('showClients')) return('');
   return(strImageLink('clients/client_record/xfer1/'.$lClientID, $strAnchorExtra, $bShowIcon,
                  !$bShowIcon, IMGLINK_XFER, $strTitle));
}

function strCantDelete($strTitle, $strHeight=null){
//---------------------------------------------------------------
//
//---------------------------------------------------------------
   if (is_null($strHeight)){
      $strHeight = '';
   }else {
      $strHeight = ' height="'.$strHeight.'" ';
   }
   $strOut = '<img src="'.base_url().'images/misc/'.IMGLINK_NODELETE.'" '.$strHeight
                                .' title="'.$strTitle.'" border="0" />';
   return($strOut);
}



//===============================
//   R E D I R E C T S
//===============================

function redirect_Client($lClientID){
   redirect('clients/client_record/view/'.$lClientID);
}

function redirect_ClientIntakeForms(){
   redirect('client_intake/intake_add_edit/view');
}

function redirect_ClientLocRec($lLocID){
   redirect('clients/locations/view/'.$lLocID);
}


function redirect_ImportLog($lImportLogID){
   redirect('admin/import/logDetails/'.$lImportLogID);
}

function redirect_More(){
   redirect('main/menu/more');
}

function redirect_Organization($lChapterID){
   redirect('admin/org/orgView/'.$lChapterID);
}

function redirect_Reports(){
   redirect('main/menu/reports');
}

function redirect_userAcct(){
   global $glUserID;
  redirect('more/user_acct/view/'.$glUserID);
}

function redirect_Vol($lVolID){
   redirect('volunteers/vol_record/volRecordView/'.$lVolID);
}

function redirect_VolEvent($lEventID){
   redirect('volunteers/events_record/viewEvent/'.$lEventID);
}

function redirect_VolEventDate($lEventDateID){
   redirect('volunteers/event_dates_view/viewDates/'.$lEventDateID);
}

function redirect_VolEventHours($lEventID){
   redirect('volunteers/vol_event_hours/viewHoursViaEvent/true/'.$lEventID);
}

function redirect_VolLoginGeneric(){
   redirect('vol_reg/user/landing');
}

function redirect_VolRec($lVolID){
   redirect('volunteers/vol_record/volRecordView/'.$lVolID);
}

function redirect_VolEventList(){
   redirect('volunteers/events_schedule/viewEventsList');
}

function redirect_User($lUserID){
   redirect('admin/accts/view/'.$lUserID);
}
 



