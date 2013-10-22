<?php
/* --------------------------------------------------------------
   TrustedWidgetContentView.inc.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.14 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (languages.php,v 1.8 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: languages.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class TrustedWidgetContentView extends ContentView
{
	function TrustedWidgetContentView()
	{
		$this->set_content_template('boxes/box_gm_trusted_shops_widget.html');
		$this->set_caching_enabled(false);
	}

	function get_html()
	{
		$t_html_output = '';

		if(gm_get_content('GM_TRUSTED_SHOPS_WIDGET_USE', $_SESSION['languages_id']) == '1' || $_SESSION['style_edit_mode'] == 'edit')
		{
			if(gm_get_content('GM_TRUSTED_SHOPS_WIDGET_USE', $_SESSION['languages_id'])  == '1')
			{
				$obj_widget = MainFactory::create_object('GMTSWidget', array($_SESSION['languages_id']));
				$t_box_content = $obj_widget->get_profile_link();
				unset($obj_widget);
			}
			else
			{
				$t_box_content = '&nbsp;';
			}

			$this->set_content_data('CONTENT', $t_box_content);
			$t_html_output = $this->build_html();
		}
		
		return $t_html_output;
	}
}

?>