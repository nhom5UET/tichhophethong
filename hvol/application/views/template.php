<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title><?php echo $title; ?></title>
<link href="<?php 
   global $gbSuperUser, $gbVolMgr;
   
   if ($gbSuperUser){
      echo(base_url().'css/su.css" rel="stylesheet" type="text/css" />'."\n");
   }elseif ($gbVolMgr){
      echo(base_url().'css/volmgr.css" rel="stylesheet" type="text/css" />'."\n");
   }else{
      echo(base_url().'css/default.css" rel="stylesheet" type="text/css" />'."\n");
   }
?>
<!-- thanks to Tomas Bagdanavicius, http://www.lwis.net/free-css-drop-down-menu/ for navigation css -->
<link href="<?php echo base_url();?>css/dropdown/dropdown.css"                rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/dropdown/dropdown.vertical.rtl.css"   rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>css/dropdown/themes/default/default.css"  rel="stylesheet" type="text/css" />

<link type="text/css"          href="<?php echo(base_url()); ?>css/shady/jquery-ui-1.8.2.custom.css" rel="stylesheet" />

<noscript>
Javascript is not enabled! Please turn on Javascript to use this site.
</noscript>


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery.ui.all.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.23/jquery-ui.min.js"></script>
<!--
-->

<script type="text/javascript">
//<![CDATA[
base_url = '<?php echo base_url();?>';
//]]>
</script>
<?php
   if (isset($js)){
      echoT($js);
   }
?>
</head>

<body>

<div id="wrapper">

   <div id="pageBanner">
      <?php echo(htmlspecialchars(@$_SESSION[CS_NAMESPACE.'_chapter']->strBanner)); ?>
   </div>
   <?php $this->load->view('navigation'); ?>

   <div id="pageTitle">
      <?php echo($pageTitle); ?>
   </div>

<?php
       if ($this->session->flashdata('error')){
         echo('<div class="error">'.$this->session->flashdata('error').'</div>');
      }
       if ($this->session->flashdata('msg')){
         echo('<div class="message">'.$this->session->flashdata('msg').'</div>');
      }
      if (isset($strFormDataEntryAlert)){
         if ($strFormDataEntryAlert != ''){
            echo('<div class="error">'.strip_tags($strFormDataEntryAlert,'<b><i><br><font>').'</div>');
         }
      }
      if (isset($strErrOnForm)){
         echo('<div class="error">'.$strErrOnForm.'</div>');
      }
      if (isset($info)){
         echo('<div class="info">'.$info.'</div><br>');
      }
      echoT('   <div id="main">');
      if (isset($contextSummary)){
         echoT($contextSummary);
      }

      if (!is_null($mainTemplate)){
         if (is_array($mainTemplate)){
            foreach ($mainTemplate as $singleTemplate){
               $this->load->view($singleTemplate);
            }
         }else {
            $this->load->view($mainTemplate);
         }
      }
?>

   </div>

   <div id="footer">
      <?php $this->load->view('footer'); ?>
   </div>
</div>

</body>
</html>


