<?php
//---------------------------------------------------------------------
// Hospice Volunteer Solutions!
//
// copyright (c) 2015 by Database Austin
// Austin, Texas
//
// This software is provided under the GPL.
// Please see http://www.gnu.org/copyleft/gpl.html for details.
//
/*---------------------------------------------------------------------
      $this->load->helper('dl_util/permissions');    // in autoload

      if (!bAllowAccess('')) return('');
      if (bAllowAccess('')){

      $enumRequest:
         adminOnly
         devOnly

         allowExports

         showAuctions
         showClients
         showFinancials
         showGrants
         showGiftHistory
         showImagesDocs
         showPeople
         showReports
         showSponsors
         showSponsorFinancials
         showUTable
         inventoryMgr

         dataEntryPeopleBizVol
         dataEntryGifts

         editPeopleBizVol
         editGifts
         editImagesDocs
         editUTable
         editGroupMembership

         timeSheetAdmin

         viewPeopleBizVol
         viewUTable

         volEditContact
         volResetPassword
         volViewGiftHistory
         volJobSkills
         volViewHours
         volEditHours
         volShiftSignup
         volFeatures

         forceFail
         notVolunteer
         management
         volMgr
---------------------------------------------------------------------*/

   function bAllowAccess($enumRequest, $enumType=''){
   /*---------------------------------------------------------------------

   --------------------------------------------------------------------- */
      global $gbSuperUser, $glUserID, $gbDev, $gbAdmin, $gbStandardUser, $gUserPerms,
         $gVolPerms, $gbVolLogin, $gbUserInMgrGroup, $gbDev, $gbVolMgr;


      if ($enumRequest=='devOnly') return($gbDev);
      if ($enumRequest=='superUser') return($gbSuperUser);
      if ($gbAdmin) return(true);
      if ($enumRequest=='notVolunteer'){
         return(!$gbVolLogin);
      }
      if ($enumRequest=='volMgr') return($gbVolMgr);

      return(false);
/*      
      $bPeopleBizVol = $enumType==CENUM_CONTEXT_BIZ         || $enumType==CENUM_CONTEXT_PEOPLE      || $enumType==CENUM_CONTEXT_VOLUNTEER;
      $bAuction      = $enumType==CENUM_CONTEXT_AUCTION     || $enumType==CENUM_CONTEXT_AUCTIONITEM || $enumType==CENUM_CONTEXT_AUCTIONPACKAGE;
      $bClient       = $enumType==CENUM_CONTEXT_CLIENT      || $enumType==CENUM_CONTEXT_CPROGRAM    ||
                       $enumType==CENUM_CONTEXT_CPROGENROLL || $enumType==CENUM_CONTEXT_CPROGATTEND;
      $bGrants       = $enumType==CENUM_CONTEXT_GRANTS      || $enumType==CENUM_CONTEXT_GRANTPROVIDER;
      $bAllow = false;
      switch ($enumRequest){
         case 'allowExports':
            $bAllow = $gbStandardUser && $gUserPerms->bUserAllowExports;
            break;

         case 'dataEntryGifts':
            $bAllow =
               ($gbStandardUser && ($gUserPerms->bUserDataEntryGifts ||
                                    $gUserPerms->bUserEditGifts
                                    ));
            break;



         default:
            screamForHelp($enumRequest.': invalid access request<br>error on line <b> -- '.__LINE__.' --</b>,<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            break;
      }
      return($bAllow);
*/      
   }

   function bTestForURLHack($enumRequest, $enumType=''){
   /*---------------------------------------------------------------------
      if (!bTestForURLHack('adminOnly')) return;
      if (!bTestForURLHack('devOnly')) return;
      if (!bTestForURLHack('editPeopleBizVol')) return;
      if (!bTestForURLHack('showGrants')) return;
      if (!bTestForURLHack('showFinancials')) return;
      if (!bTestForURLHack('dataEntryPeopleBizVol')) return;
      if (!bTestForURLHack('notVolunteer')) return;
      if (!bTestForURLHack('forceFail')) return;
      if (!bTestForURLHack('volMgr')) return;
   --------------------------------------------------------------------- */
      global $gbDebug;
      if (!bAllowAccess($enumRequest, $enumType)){
         badBoyRedirect('Your account settings do not allow you to access this feature.');
         return(false);
      }else {
         return(true);
      }
   }

   function badBoyRedirect($strErrMsg){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
            //--------------------------
            // breadcrumbs
            //--------------------------
         $CI =& get_instance();
         $displayData = array();
         $displayData['strErr']    = $strErrMsg;
         $displayData['pageTitle'] = 'Permissions Error';

         $displayData['title']          = CS_PROGNAME.' | Error';
         $displayData['nav']            = $CI->mnav_brain_jar->navData();
         $displayData['mainTemplate']   = 'admin/permissions_error_view';
         $CI->load->vars($displayData);
         $CI->load->view('template');
   }

   function bInUserGroup($strUserGroup){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------
      global $gUserPerms, $gbAdmin, $gbStandardUser;
      
      if ($gbAdmin) return(true);
      if (!$gbStandardUser) return(false);
      if ($gUserPerms->lNumUserGroups == 0) return(false);
      return(in_array($strUserGroup, $gUserPerms->strUGroups));
   }
   
   function bPermitViaContext($enumContext){
   //---------------------------------------------------------------------
   //
   //---------------------------------------------------------------------  
      switch ($enumContext){
         case CENUM_CONTEXT_AUCTION:
         case CENUM_CONTEXT_AUCTIONITEM:
         case CENUM_CONTEXT_AUCTIONPACKAGE:
            $bPermit = bAllowAccess('showAuctions');  break;

         case CENUM_CONTEXT_BIZ:
         case CENUM_CONTEXT_PEOPLE:
         case CENUM_CONTEXT_VOLUNTEER:
            $bPermit = bAllowAccess('viewPeopleBizVol');  break;
            
         case CENUM_CONTEXT_GRANTS:
         case CENUM_CONTEXT_GRANTPROVIDER:
            $bPermit = bAllowAccess('showGrants');  break;

         case CENUM_CONTEXT_CLIENT:
         case CENUM_CONTEXT_LOCATION:
            $bPermit = bAllowAccess('showClients');  break;

         case CENUM_CONTEXT_SPONSORSHIP:
            $bPermit = bAllowAccess('showSponsors');  break;

         case CENUM_CONTEXT_ORGANIZATION:
         case CENUM_CONTEXT_STAFF:
            $bPermit = bAllowAccess('adminOnly');  break;
            
         case CENUM_CONTEXT_INVITEM:
            $bPermit = bAllowAccess('inventoryMgr');  break;
            
         default:
            screamForHelp($enumContext.': invalid permissions context<br>error on line  <b> -- '.__LINE__.' --</b>,<br>file '.__FILE__.',<br>function '.__FUNCTION__);
            break;
      }
      return($bPermit);   
   }
   
   

