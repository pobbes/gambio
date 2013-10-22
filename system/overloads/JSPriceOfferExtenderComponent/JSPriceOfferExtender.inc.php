<?php
/* --------------------------------------------------------------
   JSPriceOfferExtender.inc.php 2012-01-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class JSPriceOfferExtender extends JSPriceOfferExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMAttributesCalculator.js'));
		include_once(get_usermod(DIR_FS_CATALOG . 'gm/javascript/GMTellAFriend.js'));		
	}
}
?>