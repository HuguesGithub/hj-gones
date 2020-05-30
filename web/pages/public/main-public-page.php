<!--
<!DOCTYPE html>
<html lang="fr">
  <head>
-->
<?php
wp_head();
$commonUrl = 'http://gones.jhugues.fr/wp-content/plugins/mycommon/';
$pluginUrl = 'http://gones.jhugues.fr/wp-content/plugins/hj-gones/';
?>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css"
  integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo $commonUrl; ?>web/rsc/css/jquery-ui.min.css" media="all" />
<link rel="stylesheet" href="<?php echo $commonUrl; ?>web/rsc/css/bootstrap-4.min.css" media="all" />
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo $pluginUrl; ?>web/rsc/gones.css" media="all" />
<!--
  </head>
  <body>
-->
<?php $PageBean = WpPageBean::getPageBean(); ?>
<div id="page">
  <!-- Start Main -->
  <div id="main">
    <!-- Start Header -->
<?php echo $PageBean->getPublicHeader(); ?>
    <!-- Finish Header -->
    <!-- Start Middle -->
<?php echo $PageBean->getContentPage(); ?>
    <!-- Finish Middle -->
  </div>
  <!-- Finish Main -->
  <!-- Start Footer -->
<?php echo $PageBean->getPublicFooter(); ?>
  <!-- Finish Footer -->
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src='<?php echo $pluginUrl; ?>web/rsc/gones.js'></script>
<?php wp_footer(); ?>
<!--
  </body>
</html>
-->
