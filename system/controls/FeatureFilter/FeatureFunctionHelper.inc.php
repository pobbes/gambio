<?php
/* --------------------------------------------------------------
   FeatureHelper.inc.php 2011-08-31 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class FeatureFunctionHelper
{
	var $search_template_path;

	function FeatureFunctionHelper()
	{
		$this->search_template_path = DIR_FS_CATALOG.'/templates/'.CURRENT_TEMPLATE.'/module/filter_selection/';
		$this->coo_feature_control  = MainFactory::create_object('FeatureControl');
	}
	
	function generate_feature_select()
	{
		$coo_features = $this->coo_feature_control->get_feature_array();
		$t_lang_shop  = (int)$_SESSION['languages_id'];
		$html         = '<select style="width:300px;" name="featureSelect" size="1"><br>'."\n";
		foreach ($coo_features as $f_key => $coo_feature) {
			$t_feature_id = $coo_feature->v_feature_id;
			$t_feature_name_array = $coo_feature->v_feature_name_array;
			$t_feature_admin_name_array = $coo_feature->v_feature_admin_name_array;
			$t_feature_name = $t_feature_name_array[$t_lang_shop];
			$t_feature_admin_name = $t_feature_admin_name_array[$t_lang_shop];
			if (!empty($t_feature_admin_name)) {
				$t_feature_name .= ' ('.$t_feature_admin_name.')';
			}
			$html .= '<option value="'.$t_feature_id.'">'.$t_feature_name.'</option><br>'."\n";
		}
		$html .= '</select><br>'."\n";
		return $html;
	}

	function generate_template_select($p_feat_id, $p_template)
	{
		$handle = dir($this->search_template_path);
		$html   = '<select name="featureTemplate['.$p_feat_id.']" size="1" style="width:120px;"><br>'."\n";
		while (false !== ($entry = $handle->read() )) {
			if (substr($entry, -4)=='html') {
				$select = ($entry == $p_template) ? ' selected="selected"' : '';
				$html .= '<option value="'.$entry.'"'.$select.'>'.$entry.'</option><br>'."\n";
			}
		}
		$html .= '</select><br>'."\n";
		return $html;
	}

	function get_feature_name($p_feature_id)
	{
		$coo_features   = $this->coo_feature_control->get_feature_array();
		$t_lang_shop    = (int) $_SESSION['languages_id'];
		$t_feature_name = '';
		foreach ($coo_features as $f_key => $coo_feature) {
			$t_feature_id = $coo_feature->v_feature_id;
			if ($p_feature_id == $t_feature_id) {
				$t_feature_name_array = $coo_feature->v_feature_name_array;
				$t_feature_name = $t_feature_name_array[$t_lang_shop];
				break;
			}
		}
		return $t_feature_name;
	}

	function get_feature_admin_name($p_feature_id)
	{
		$coo_features   = $this->coo_feature_control->get_feature_array();
		$t_lang_shop    = (int) $_SESSION['languages_id'];
		$t_feature_name = '';
		foreach ($coo_features as $f_key => $coo_feature) {
			$t_feature_id = $coo_feature->v_feature_id;
			if ($p_feature_id == $t_feature_id) {
				$t_feature_name_array = $coo_feature->v_feature_admin_name_array;
				$t_feature_name = $t_feature_name_array[$t_lang_shop];
				break;
			}
		}
		return $t_feature_name;
	}

	function generate_feature_list($p_categorie_id)
	{
		$cat_id = 0;
		if($p_categorie_id > 0) {
			$cat_id = (int)$p_categorie_id;
		}
		$coo_cat_filter = $this->coo_feature_control->get_categories_filter_array(array('categories_id' => $cat_id), array('sort_order'));
		$count = 1;
		$html  = '
			<tr class="main" style="font-size:10px;">
				<td style="width: 10px;">Nr.</td>
				<td style="width:170px;">Name (Name Intern)</td>
				<td>AND</td>
				<td>Sort</td>
				<td>Vorlage</td>
				<td>Mode</td>
				<td>Delete</td>
			</tr>
			'."\n";
		foreach ($coo_cat_filter as $key => $coo_filter) {
			$feature_id =  $coo_filter->v_feature_id;
			$sort_order =  $coo_filter->v_sort_order;
			$mode       =  $coo_filter->v_selection_preview_mode;
			$template   =  $coo_filter->v_selection_template;
			$use_and    = ($coo_filter->v_value_conjunction != 0) ? ' checked="checked"' : '';
			$feature_name = $this->get_feature_name($feature_id);
			$admin_name   = $this->get_feature_admin_name($feature_id);
			$f_name = $feature_name;
			if (!empty($admin_name)) {
				$f_name = $f_name.' ('.$admin_name.')';
			}
			$html .= '
				<tr class="main" style="font-size:10px;">
					<td>'.$count.')</td>
					<td>'.$f_name.'</td>
					<td><input type="checkbox" name="featureAnd['.$feature_id.']" value="1" style="width:15px;"'.$use_and.'></td>
					<td><input type="text" name="featureSort['.$feature_id.']" value="'.$sort_order.'" style="width:15px;"></td>
					<td>
						'.$this->generate_template_select($feature_id, $template).'
					</td>
					<td><input type="text" name="featureMode['.$feature_id.']" value="'.$mode.'" style="width:40px;"></td>
					<td><input type="checkbox" name="deleteFeature['.$feature_id.']" value="1" style="width:15px;">&nbsp;löschen<br></td>
				</tr>
				'."\n";
			$count++;
		}
		return $html;
	}

	function get_template_names($p_mode = 'all')
	{
		$handle = dir($this->search_template_path);
		$templates_array = array();
		while (false !== ($entry = $handle->read() )) {
			if (substr($entry, -4)=='html') {
				$templates_array[] = $entry;
			}
		}
		sort($templates_array);
		switch ($p_mode)
		{
			case 'first':
				return $templates_array[0];
				break;
			case 'last':
				return $templates_array[ count($templates_array)-1 ];
				break;
			case 'all':
				return $templates_array;
				break;
			default:
				return $templates_array;
				break;
		}
	}

	function new_feature($p_categorie_id, $p_feature_select) {
		$cat_id = 0;
		if($p_categorie_id > 0) {
			$cat_id  = (int)$p_categorie_id;
		}
		$feature_id  = (int)$p_feature_select;
		$coo_filter  = $this->coo_feature_control->create_categories_filter();
		$result      = $this->coo_feature_control->get_categories_filter_array(array('feature_id' => $feature_id, 'categories_id' => $cat_id));
		$has_entry   = (bool) sizeof($result);
		if (!$has_entry) {
			$coo_filter->set_feature_id(xtc_db_input($feature_id));
			$coo_filter->set_categories_id(xtc_db_input($cat_id));
			$template_name = $this->get_template_names('first');
			$coo_filter->set_selection_template($template_name);
			$result = $coo_filter->save(true);
		}
	}

	function save_feature($p_categorie_id)
	{
		$cat_id = 0;
		if($p_categorie_id > 0) {
			$cat_id = (int)$p_categorie_id;
		}
		$filter_data = $this->coo_feature_control->get_categories_filter_array(array('categories_id' => $cat_id), array('sort_order'));
		foreach ($filter_data as $key => $coo_filter) {
			$feat_id = $coo_filter->v_feature_id;
			if (isset($_POST['featureSort'][$feat_id])) {
				$coo_temp = $this->coo_feature_control->create_categories_filter();
				$coo_temp->set_feature_id(xtc_db_input($feat_id));
				$coo_temp->set_categories_id(xtc_db_input($cat_id));
				$coo_temp->set_sort_order(xtc_db_input($_POST['featureSort'][$feat_id]));
				$coo_temp->set_selection_preview_mode(xtc_db_input($_POST['featureMode'][$feat_id]));
				$coo_temp->set_selection_template(xtc_db_input($_POST['featureTemplate'][$feat_id]));
				$coo_temp->set_value_conjunction(xtc_db_input($_POST['featureAnd'][$feat_id]));
				if (strlen($_POST['featureTemplate'][$feat_id])>4) {
					$coo_temp->save();
				}
				$coo_temp = NULL;
			}
			if (isset($_POST['deleteFeature'][$feat_id])) {
				$coo_temp = $this->coo_feature_control->create_categories_filter();
				$coo_temp->set_feature_id(xtc_db_input($feat_id));
				$coo_temp->set_categories_id(xtc_db_input($cat_id));
				$coo_temp->delete();
				$coo_temp = NULL;
			}
		}
	}
}
?>