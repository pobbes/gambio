<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/
require ('includes/application_top.php');

$base = GM_HTTP_SERVER.DIR_WS_CATALOG;
$debug = false;
if ($debug) echo '<pre>'.print_r($_SESSION, 1).'</pre>';
  
if (!empty($_SESSION['hpLastPost'])){
  $_POST = $_SESSION['hpLastPost'];
  $_SESSION['hpUniqueID'] = $_GET['uniqueId'];
  $next = 'checkout_confirmation.php?hp_go=1';
  if (empty($_GET['payment_error']) && $_SESSION['hpModuleMode'] == 'AFTER') {
    $next = 'checkout_success.php?hp_go=1';
    $_SESSION['cart']->reset(true);
    // unregister session variables used during checkout
    unset ($_SESSION['sendto']);
    unset ($_SESSION['billto']);
    unset ($_SESSION['shipping']);
    unset ($_SESSION['payment']);
    unset ($_SESSION['comments']);
    unset ($_SESSION['last_order']);
    unset ($_SESSION['tmp_oID']);
    unset ($_SESSION['cc']);
    if (isset ($_SESSION['credit_covers'])) unset ($_SESSION['credit_covers']);
  }

  if ($_GET['pcode'] == 'PP.PA'){
    $repl = array(
      '{AMOUNT}'        => $_GET['PRESENTATION_AMOUNT'], 
      '{CURRENCY}'      => $_GET['PRESENTATION_CURRENCY'], 
      '{ACC_COUNTRY}'   => $_GET['CONNECTOR_ACCOUNT_COUNTRY'], 
      '{ACC_OWNER}'     => $_GET['CONNECTOR_ACCOUNT_HOLDER'], 
      '{ACC_NUMBER}'    => $_GET['CONNECTOR_ACCOUNT_NUMBER'], 
      '{ACC_BANKCODE}'  => $_GET['CONNECTOR_ACCOUNT_BANK'],
      '{ACC_BIC}'       => $_GET['CONNECTOR_ACCOUNT_BIC'], 
      '{ACC_IBAN}'      => $_GET['CONNECTOR_ACCOUNT_IBAN'], 
      '{SHORTID}'       => $_GET['IDENTIFICATION_SHORTID'],
    );
    $_SESSION['hpPrepaidData'] = $repl;
    $next = 'heidelpay_success.php?hp_go=1';
  } else {
    $_SESSION['hpPrepaidData'] = false;
  }
  if (!empty($_GET['payment_error'])) $next = 'checkout_payment.php?payment_error='.$_GET['payment_error'].'&error='.$_GET['error'];
  #echo '<pre>'.print_r($_SESSION, 1).'</pre>';
  if ($debug) echo $next; 
  if ($debug) exit();
?><html><head><title>Heidelpay Redirect</title></head>
<body onLoad="document.forms[0].submit()"><center>
<br><br><br><br><br>
<h2>Ihre Daten werden &uuml;bertragen...</h2><br>
<img src="<?php echo $base?>images/ladebalken.gif">
<form action="<?php echo $base.$next.'&'.session_name().'='.session_id();?>" method="post" style="display: none" target="_top">
<?php foreach($_POST AS $k => $v){?>
  <?php if (is_array($v)){?>
    <input type="text" name="<?php echo $k?>[<?php echo key($v)?>]" value="<?php echo current($v)?>">
  <?php } else {?>
    <input type="text" name="<?php echo $k?>" value="<?php echo $v?>">
  <?php }?>
<?php }?>
</form>
</center>
</body>
</html>
<?php }?>