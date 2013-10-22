<?php
/* --------------------------------------------------------------
   test.php 2013-04-17
   ---------------------------------------------------------------------------------------*/

$coo_test = MainFactory::create_object('TestContentView');
$coo_test->set_content_template('boxes/box_test.html');
$t_test_html = $coo_test->get_html();
$smarty->assign('TEST', $t_test_html);

?>