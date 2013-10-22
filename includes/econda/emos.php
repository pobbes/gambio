<?php


/*******************************************************************************
* EMOS PHP Bib 2
* $Id: emos.php,v 1.14 2009/02/19 09:52:56 unaegele Exp $
********************************************************************************

Released under the GNU General Public License


Copyright (c) 2004 - 2007 ECONDA GmbH Karlsruhe
All rights reserved.

ECONDA GmbH
Eisenlohrstr. 43
76135 Karlsruhe
Tel. +49 (721) 6630350
Fax +49 (721) 66303510
info@econda.de
www.econda.de

Changes:

$Log: emos.php,v $
Revision 1.14  2009/02/19 09:52:56  unaegele
if function not exists fix

Revision 1.13  2007/08/17 08:40:33  unaegele
added function addEMOSCustomPageArray
added function getEMOSCustomPageArray

Revision 1.12  2007/05/16 08:24:09  unaegele
fix wrong reference to htmlspecialchars_decodephp4()

Revision 1.11  2007/05/11 07:52:42  unaegele
Update ECONDA Tel Number, prepare Release 20070510

Revision 1.10  2007/05/11 07:45:53  unaegele
added \n to addSid

Revision 1.9  2007/05/10 12:19:04  unaegele
Fix php 4 compatibility for the call to htmlspecialchars_decode()
Replace traslated &nbsp;=chr(0xa0) with real spaces

Revision 1.8  2007/05/04 10:17:31  unaegele
several bugfixes

Revision 1.7  2007/05/04 09:59:01  unaegele
source code formating

Revision 1.6  2007/05/04 09:55:12  unaegele
*** empty log message ***

Revision 1.5  2007/05/04 09:49:08  unaegele
*** empty log message ***

Revision 1.4  2007/05/04 09:43:48  unaegele
Added methods addSiteID($siteid), addLangID($langid), addPageID($pageID), addCountryID($countryid)

Revision 1.2 added URL Encoding, Dataformat

Revision 1.1 added 1st party session tracking


*/

/** PHP Helper Class to construct a ECONDA Monitor statement for the later
 * inclusion in a HTML/PHP Page.
 */
if ( !class_exists( 'EMOS')){
        class EMOS {

                /**
                 * the EMOS statement consists of 3 parts
                 * 1.   the inScript :<code><script type="text/javascript" src="emos2.js"></script>
                 * 2,3. a part before and after this inScript (preScript/postScript)</code>
                 */
                var $preScript = "";

                /**
                 * Here we store the call to the js bib
                 */
                var $inScript = "";

                /**
                 * if we must put something behind the call to the js bin we put it here
                 */
                var $postScript = "";

                /** path to the emos2.js script-file */
                var $pathToFile = "includes/econda/";

                /** Name of the script-file */
                var $scriptFileName = "emos2.js";

                /** if we use pretty print, we will set the lineseparator or tab here */
                var $br = "\n";
                var $tab = "\t";

                /* session id for 1st party sessions*/
                var $emsid = "";

                /* visitor id for 1st partyx visitors */
                var $emvid = "";

                /**
                 * add compatibility function for php < 5.1
                 */
                function htmlspecialchars_decode_php4($str) {
                        return strtr($str, array_flip(get_html_translation_table(HTML_SPECIALCHARS)));
                }

                /** Constructor
                 * Sets the path to the emos2.js js-bib and prepares the later calls
                 *
                 * @param $pathToFile The path to the js-bib (/opt/myjs)
                 * @param $scriptFileName If we want to have annother Filename than
                 *          emos2.js you can set it here
                 */
                function EMOS($pathToFile = "includes/econda/", $scriptFileName = "emos2.js") {
                        $this->pathToFile = $pathToFile;
                        $this->scriptFileName = $scriptFileName;
                        $this->prepareInScript();

                }

                /* formats data/values/params by eliminating named entities and xml-entities */
                function emos_ItemFormat($item) {
                        $item->productID = $this->emos_DataFormat($item->productID);
                        $item->productName = $this->emos_DataFormat($item->productName);
                        $item->productGroup = $this->emos_DataFormat($item->productGroup);
                        $item->variant1 = $this->emos_DataFormat($item->variant1);
                        $item->variant2 = $this->emos_DataFormat($item->variant2);
                        $item->variant3 = $this->emos_DataFormat($item->variant3);
                        return $item;
                }

                /* formats data/values/params by eliminating named entities and xml-entities */
                function emos_DataFormat($str) {
                        $str = urldecode($str);
                        //2007-05-10 Fix incompatibility with php4
                        if (function_exists('htmlspecialchars_decode')) {
                                $str = htmlspecialchars_decode($str, ENT_QUOTES);
                        } else {
                                $str = $this->htmlspecialchars_decode_php4($str);
                        }
                        $str = html_entity_decode($str);
                        $str = strip_tags($str);
                        $str = trim($str);

                        //2007-05-10 replace translated &nbsp; with spaces
                        $nbsp = chr(0xa0);
                        $str = str_replace($nbsp, " ", $str);
                        $str = str_replace("\"", "", $str);
                        $str = str_replace("'", "", $str);
                        $str = str_replace("%", "", $str);
                        $str = str_replace(",", "", $str);
                        $str = str_replace(";", "", $str);
                        /* remove unnecessary white spaces*/
                        while (true) {
                                $str_temp = $str;
                                $str = str_replace("  ", " ", $str);

                                if ($str == $str_temp) {
                                        break;
                                }
                        }
                        $str = str_replace(" / ", "/", $str);
                        $str = str_replace(" /", "/", $str);
                        $str = str_replace("/ ", "/", $str);

                        $str = substr($str, 0, 254);
                        $str = rawurlencode($str);
                        return $str;
                }

                /**
                 * sets the 1st party session id
                 */
                function setSid($sid = "") {
                        if ($sid) {
                                $this->emsid = $sid;
                                $this->appendPreScript("<a name=\"emos_sid\" title=\"$sid\"></a>\n");
                        }
                }

                /**
                 * set 1st party visitor id
                 */
                function setVid($vid = "") {
                        if ($vid) {
                                $this->emvid = $vid;
                                $this->appendPreScript("<a name=\"emos_vid\" title=\"$vid\"></a>");
                        }
                }

                /** switch on pretty printing of generated code. If not called, the output
                 * will be in one line of html.
                 */
                function prettyPrint() {
                        $this->br .= "\n";
                        $this->tab .= "\t";
                }

                /** Concatenates the current command and the $inScript */
                function appendInScript($stringToAppend) {
                        $this->inScript .= $stringToAppend;
                }

                /** Concatenates the current command and the $proScript */
                function appendPreScript($stringToAppend) {
                        $this->preScript .= $stringToAppend;
                }

                /** Concatenates the current command and the $postScript */
                function appendPostScript($stringToAppend) {
                        $this->postScript .= $stringToAppend;
                }

                /** sets up the inScript Part with Initialisation Params */
                function prepareInScript() {
                        $this->inScript .= "<script type=\"text/javascript\" " .
                "src=\"" . $this->pathToFile . $this->scriptFileName . "\">" .
                "</script>" . $this->br;
                }

                /** returns the whole statement */
                function toString() {
                        return $this->preScript . $this->inScript . $this->postScript;
                }

                /** constructs a emos anchor tag */
                function getAnchorTag($title = "", $rel = "", $rev = "") {

                        $rel = $this->emos_DataFormat($rel);
                        $rev = $this->emos_DataFormat($rev);
                        $anchor = "<a name=\"emos_name\" " .
                "title=\"$title\" " .
                "rel=\"$rel\" " .
                "rev=\"$rev\"></a>$this->br";
                        return $anchor;
                }

                /** adds a anchor tag for content tracking
                 * <a name="emos_name" title="content" rel="$content" rev=""></a>
                 */
                function addContent($content) {
                        $this->appendPreScript($this->getAnchorTag("content", $content));
                }

                /** adds a anchor tag for orderprocess tracking
                 * <a name="emos_name" title="orderProcess" rel="$processStep" rev=""></a>
                 */
                function addOrderProcess($processStep) {
                        $this->appendPreScript($this->getAnchorTag("orderProcess", $processStep));
                }

                /** adds a anchor tag for siteid tracking
                 * <a name="emos_name" title="siteid" rel="$siteid" rev=""></a>
                 */
                function addSiteID($siteid) {
                        $this->appendPreScript($this->getAnchorTag("siteid", $siteid));
                }

                /** adds a anchor tag for language tracking
                 * <a name="emos_name" title="langid" rel="$langid" rev=""></a>
                 */
                function addLangID($langid) {
                        $this->appendPreScript($this->getAnchorTag("langid", $langid));
                }

                /** adds a anchor tag for country tracking
                 * <a name="emos_name" title="countryid" rel="$countryid" rev=""></a>
                 */
                function addCountryID($countryid) {
                        $this->appendPreScript($this->getAnchorTag("countryid", $countryid));
                }

                /**
                 * adds a Page ID to the current window (window.emosPageId)
                 */
                function addPageID($pageID) {
                        $this->appendPreScript("\n<script type=\"text/javascript\">\n window.emosPageId = '$pageID';\n</script>\n");
                }

                /** adds a anchor tag for search tracking
                 * <a name="emos_name" title="search" rel="$queryString" rev="$numberOfHits"></a>
                 */
                function addSearch($queryString, $numberOfHits) {
                        $this->appendPreScript($this->getAnchorTag("search", $queryString, $numberOfHits));
                }

                /** adds a anchor tag for registration tracking
                 * The userid gets a md5() to fullfilll german datenschutzgesetz
                 * <a name="emos_name" title="register" rel="$userID" rev="$result"></a>
                 */
                function addRegister($userID, $result) {
                        $this->appendPreScript($this->getAnchorTag("register", md5($userID), $result));
                }

                /** adds a anchor tag for login tracking
                 *The userid gets a md5() to fullfilll german datenschutzgesetz
                 * <a name="emos_name" title="login" rel="$userID" rev="$result"></a>
                 */
                function addLogin($userID, $result) {
                        $this->appendPreScript($this->getAnchorTag("login", md5($userID), $result));
                }

                /** adds a anchor tag for contact tracking
                 * <a name="emos_name" title="scontact" rel="$contactType" rev=""></a>
                 */
                function addContact($contactType) {
                        $this->appendPreScript($this->getAnchorTag("scontact", $contactType));
                }

                /** adds a anchor tag for download tracking
                 * <a name="emos_name" title="download" rel="$downloadLabel" rev=""></a>
                 */
                function addDownload($downloadLabel) {
                        $this->appendPreScript($this->getAnchorTag("download", $downloadLabel));
                }

                /** constructs a emosECPageArray of given $event type
                 * @param $item a instance of class EMOS_Item
                 * @param $event Type of this event ("add","c_rmv","c_add")
                 */
                function getEmosECPageArray($item, $event) {

                        $item = $this->emos_ItemFormat($item);

                        $out = "";
                        $out .= "<script type=\"text/javascript\">$this->br" .
                "<!--$this->br" .
                "$this->tab var emosECPageArray = new Array();$this->br" .
                "$this->tab emosECPageArray['event'] = '$event';$this->br" .
                "$this->tab emosECPageArray['id'] = '$item->productID';$this->br" .
                "$this->tab emosECPageArray['name'] = '$item->productName';$this->br" .
                "$this->tab emosECPageArray['preis'] = '$item->price';$this->br" .
                "$this->tab emosECPageArray['group'] = '$item->productGroup';$this->br" .
                "$this->tab emosECPageArray['anzahl'] = '$item->quantity';$this->br" .
                "$this->tab emosECPageArray['var1'] = '$item->variant1';$this->br" .
                "$this->tab emosECPageArray['var2'] = '$item->variant2';$this->br" .
                "$this->tab emosECPageArray['var3'] = '$item->variant3';$this->br" .
                "// -->$this->br" .
                "</script>$this->br";
                        return $out;
                }

                /** constructs a emosBillingPageArray of given $event type */
                function addEmosBillingPageArray($billingID = "", $customerNumber = "", $total = 0, $country = "", $cip = "", $city = "") {
                        $out = $this->getEmosBillingArray($billingID, $customerNumber, $total, $country, $cip, $city, "emosBillingPageArray");
                        $this->appendPreScript($out);
                }

                /** gets a emosBillingArray for a given ArrayName */
                function getEmosBillingArray($billingID = "", $customerNumber = "", $total = 0, $country = "", $cip = "", $city = "", $arrayName = "") {

                        /******************* prepare data *************************************/
                        /* md5 the customer id to fullfill requirements of german datenschutzgeesetz */
                        $customerNumber = md5($customerNumber);

                        $country = $this->emos_DataFormat($country);
                        $cip = $this->emos_DataFormat($cip);
                        $city = $this->emos_DataFormat($city);

                        /* get a / separated location stzring for later drilldown */
                        $ort = "";
                        if ($country) {
                                $ort .= "$country/";
                        }
                        if ($cip) {
                                $ort .= substr($cip, 0, 1) . "/" . substr($cip, 0, 2) . "/";
                        }
                        if ($city) {
                                $ort .= "$city/";
                        }
                        if ($cip) {
                                $ort .= $cip;
                        }

                        /******************* get output** *************************************/
                        /* get the real output of this funktion */
                        $out = "";
                        $out .= "<script type=\"text/javascript\">$this->br" .
                "<!--$this->br" .
                "$this->tab var $arrayName = new Array();$this->br" .
                "$this->tab $arrayName" . "['0'] = '$billingID';$this->br" .
                "$this->tab $arrayName" . "['1'] = '$customerNumber';$this->br" .
                "$this->tab $arrayName" . "['2'] = '$ort';$this->br" .
                "$this->tab $arrayName" . "['3'] = '$total';$this->br" .
                "// -->$this->br" .
                "</script>$this->br";
                        return $out;
                }

                /** adds a emosBasket Page Array to the preScript */
                function addEmosBasketPageArray($basket) {
                        $out = $this->getEmosBasketPageArray($basket, "emosBasketPageArray");
                        $this->appendPreScript($out);
                }

                /** returns a emosBasketArray of given Name */
                function getEmosBasketPageArray($basket, $arrayName) {
                        $out = "";
                        $out .= "<script type=\"text/javascript\">$this->br" .
                "<!--$this->br" .
                "var $arrayName = new Array();$this->br";
                        $count = 0;
                        foreach ($basket as $item) {

                                $item = $this->emos_ItemFormat($item);

                                $out .= $this->br;
                                $out .= "$this->tab $arrayName" . "[$count]=new Array();$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][0]='$item->productID';$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][1]='$item->productName';$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][2]='$item->price';$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][3]='$item->productGroup';$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][4]='$item->quantity';$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][5]='$item->variant1';$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][6]='$item->variant2';$this->br";
                                $out .= "$this->tab $arrayName" . "[$count][7]='$item->variant3';$this->br";
                                $count++;
                        }
                        $out .= "// -->$this->br" .
                "</script>$this->br";

                        return $out;
                }

                /** adds a detailView to the preScript */
                function addDetailView($item) {
                        $this->appendPreScript($this->getEmosECPageArray($item, "view"));
                }

                /** adds a removeFromBasket to the preScript */
                function removeFromBasket($item) {
                        $this->appendPreScript($this->getEmosECPageArray($item, "c_rmv"));
                }

                /** adds a addToBasket to the preScript */
                function addToBasket($item) {
                        $this->appendPreScript($this->getEmosECPageArray($item, "c_add"));
                }

                /**
                 * constructs a generic EmosCustomPageArray from a PHP Array
                 */
                function getEmosCustomPageArray($listOfValues){

                        $out = "";
                        $out .= "<script type=\"text/javascript\">$this->br" .
                "<!--$this->br" .
                "$this->tab var emosCustomPageArray = new Array();$this->br";

                        $counter = 0;
                        foreach ($listOfValues as $value) {

                                $value = $this->emos_DataFormat($value);
                                $out .= "$this->tab emosCustomPageArray[$counter] = '$value';$this->br";
                                $counter ++;
                        }
                        $out .= "// -->$this->br" ."</script>$this->br";
                        return $out;



                }


                /** constructs a emosCustomPageArray with 8 Variables and shortcut
                 * @param $cType Type of this event - shortcut in config
                 * @param $cVar1 first variable of this custom event (optional)
                 * @param $cVar2 second variable of this custom event (optional)
                 * @param $cVar3 third variable of this custom event (optional)
                 * @param $cVar4 fourth variable of this custom event (optional)
                 * @param $cVar5 fifth variable of this custom event (optional)
                 * @param $cVar6 sixth variable of this custom event (optional)
                 * @param $cVar7 seventh variable of this custom event (optional)
                 * @param $cVar8 eighth variable of this custom event (optional)
                 * @param $cVar9 nineth variable of this custom event (optional)
                 * @param $cVar10 tenth variable of this custom event (optional)
                 * @param $cVar11 eleventh variable of this custom event (optional)
                 * @param $cVar12 twelveth variable of this custom event (optional)
                 * @param $cVar13 thirteenth variable of this custom event (optional)
                 */
                function addEmosCustomPageArray($cType=0, $cVar1=0, $cVar2=0, $cVar3=0, $cVar4=0,
                $cVar5=0, $cVar6=0, $cVar7=0, $cVar8=0, $cVar9=0,
                $cVar10=0, $cVar11=0, $cVar12=0, $cVar13=0) {

                        $values[0] = $cType;
                        if($cVar1) $values[1] = $cVar1;
                        if($cVar2) $values[2] = $cVar2;
                        if($cVar3) $values[3] = $cVar3;
                        if($cVar4) $values[4] = $cVar4;
                        if($cVar5) $values[5] = $cVar5;
                        if($cVar6) $values[6] = $cVar6;
                        if($cVar7) $values[7] = $cVar7;
                        if($cVar8) $values[8] = $cVar8;
                        if($cVar9) $values[9] = $cVar9;
                        if($cVar10) $values[10] = $cVar10;
                        if($cVar11) $values[11] = $cVar11;
                        if($cVar12) $values[12] = $cVar12;
                        if($cVar13) $values[13] = $cVar13;

                        $this->appendPreScript($this->getEmosCustomPageArray($values));
                }

        }
}

/** global Functions */
if ( !function_exists( 'getEmosECEvent')){
        function getEmosECEvent($item, $event) {
                $item = $this->emos_ItemFormat($item);
                $out = "";
                $out .= "emos_ecEvent('$event'," .
        "'$item->productID'," .
        "'$item->productName'," .
        "'$item->price'," .
        "'$item->productGroup'," .
        "'$item->quantity'," .
        "'$item->variant1'" .
        "'$item->variant2'" .
        "'$item->variant3');";
                return $out;
        }
}
if ( !function_exists( 'getEmosViewEvent')){
        function getEmosViewEvent($item) {
                return getEmosECEvent($item, "view");
        }
}
if ( !function_exists( 'getEmosAddToBasketEvent')){
        function getEmosAddToBasketEvent($item) {
                return getEmosECEvent($item, "c_add");
        }
}
if ( !function_exists( 'getRemoveFromBasketEvent')){
        function getRemoveFromBasketEvent($item) {
                return getEmosECEvent($item, "c_rmv");
        }
}
if ( !function_exists( 'getEmosBillingEventArray')){
        function getEmosBillingEventArray($billingID = "", $customerNumber = "", $total = 0, $country = "", $cip = "", $city = "") {
                $b = new EMOS();
                return $b->getEmosBillingArray($billingID, $customerNumber, $total, $country, $cip, $city, "emosBillingArray");
        }
}
if ( !function_exists( 'getEMOSBasketEventArray')){
        function getEMOSBasketEventArray($basket) {
                $b = new EMOS();
                return $b->getEmosBasketArray($basket, "emosBasketArray");
        }
}
/** A Class to hold products as well a basket items
 * If you want to track a product view, set the quantity to 1.
 * For "real" basket items, the quantity should be given in your
 * shopping systems basket/shopping cart.
 *
 * Purpose of this class:
 * This class provides a common subset of features for most shopping systems
 * products or basket/cart items. So all you have to do is to convert your
 * products/articles/basket items/cart items to a EMOS_Items. And finally use
 * the functionaltiy of the EMOS class.
 * So for each shopping system we only have to do the conversion of the cart/basket
 * and items and we can (hopefully) keep the rest of code.
 *
 * Shopping carts:
 *        A shopping cart / basket is a simple Array[] of EMOS items.
 *        Convert your cart to a Array of EMOS_Items and your job is nearly done.
 */
if ( !class_exists( 'EMOS_Item')){
        class EMOS_Item {
                /** unique Identifier of a product e.g. article number */
                var $productID = "NULL";
                /** the name of a product */
                var $productName = "NULL";
                /** the price of the product, it is your choice wether its gross or net */
                var $price = "NULL";
                /** the product group for this product, this is a drill down dimension
                 * or tree-like structure
                 * so you might want to use it like this:
                 * productgroup/subgroup/subgroup/product
                 */
                var $productGroup = "NULL";
                /* the quantity / number of products viewed/bought etc.. */
                var $quantity = "NULL";
                /** variant of the product e.g. size, color, brand ....
                 * remember to keep the order of theses variants allways the same
                 * decide which variant is which feature and stick to it
                 */
                var $variant1 = "NULL";
                var $variant2 = "NULL";
                var $variant3 = "NULL";
        }
}
?>