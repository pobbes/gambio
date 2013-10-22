<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');



    
    $sql = sprintf("SELECT * FROM customers WHERE customers_id=%d", $_SESSION['customer_id']);
        
    $resultset = xtc_db_query($sql);

    
    $fwdYoo["source"] = 'gambio';
    $fwdYoo["company"]  = STORE_NAME;
    $fwdYoo["weburl"]   = HTTP_SERVER;
    
    if ($result = xtc_db_fetch_array($resultset)) {

        $fwdYoo["email"]        = $result['customers_email_address'];
        $fwdYoo["firstname"]    = $result['customers_firstname']; 
        $fwdYoo["lastname"]     = $result['customers_lastname'];
        $fwdYoo["phonenumber"]  = $result['customers_telephone'];
        
        $sql = sprintf("SELECT a.*, c.countries_name  FROM address_book a JOIN countries c ON a.entry_country_id = c.countries_id 
            WHERE address_book_id=%d", $result['customers_default_address_id']);
        
        $resultset = xtc_db_query($sql);
        
        if ($result = xtc_db_fetch_array($resultset)) {
	        $fwdYoo["address"]  = $result['entry_street_address'];
	        $fwdYoo["city"]     = $result['entry_city'];
	        $fwdYoo["zipcode"]  = $result['entry_postcode'];
	        $fwdYoo["country"]  = $result['countries_name'];
        }
        
    }
?>

<div style="padding: 20px 40px 40px 40px;" class="yoo-image1-large">

<table style="border-style: none; margin: 0 auto;" cellspacing="0">
<tr><td>

<?php require(DIR_FS_ADMIN . "yoochoose/info_$langXX.php"); ?>

</td><td valign="top">

<form class="yoochoose_prefs" name="yoochoose_prefs" method="POST" target="_blank" action="<?php echo $regpage;?>">
    <div class="one-button" style="width: 220px; margin: 165px 0 25px 3em;">
        <?php 
            foreach ($fwdYoo as $key => $value) {
                echo "<input type='hidden' name='$key' value='".htmlentities($value)."'>";
            }
        ?>
        <?php echo YOOCHOOSE_REGISTER_CONTENT?>
        <input type="submit" class="button" value="<?php echo sprintf(YOOCHOOSE_REGISTER_BTN)?> *" name="btn"/>
    </div>
</form> 

<form class="yoochoose_prefs" name="yoochoose_prefs" method="POST" action="yoochoose.php?page=config">
    <div class="one-button" style="width: 220px; margin: 0 0 3em 3em;">
        <?php echo YOOCHOOSE_ACTIVATE_CONTENT?>
        <input type='hidden' name='YOOCHOOSE_ACTIVE' value='checked'>
        <input type="submit" class="button" value="<?php echo sprintf(YOOCHOOSE_ACTIVATE_BTN)?>" name="btn"/>
    </div>
</form> 

</td></tr>
</table>




 
<table style="border-style: none; width: 540px; margin: 25 auto;" cellspacing="0"><tr><td align="left">
 
   

</td><td>
</td><td>



</td></tr></table>

<p class="asterix-text">

*) <?php printf(YOOCHOOSE_ACTIVATE_POSTINFO, $regpage) ?>

</p>

</div>