<?php
/* --------------------------------------------------------------
   ProductFeatureHandler.inc.php 2010-11-16 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class ProductFeatureHandler
{

  /*
   * constructor
   */
	function ProductFeatureHandler( )
	{
		
	}

  /*
   * insert new entry with feature_value_id and for products_id
   * @param int $p_feature_value_id  feature value id
   * @param int $p_products_id  products id
   * @return bool
   */
	function add_feature_value($p_feature_value_id, $p_products_id)
	{
		$coo_data_object = MainFactory::create_object('GMDataObject', array('products_feature_value'));
		$coo_data_object->set_keys(array(
									'feature_value_id' => false,
									'products_id' => false
								));

		$coo_data_object->set_data_value('feature_value_id', $p_feature_value_id);
		$coo_data_object->set_data_value('products_id', $p_products_id);

		$coo_data_object->save_body_data();
		return true;
	}

  /*
   * remove entry with feature_value_id and for products_id
   * @param int $p_feature_value_id  feature value id
   * @param int $p_products_id  products id
   * @return bool
   */
  function remove_feature_value($p_feature_value_id, $p_products_id)
	{
		$coo_data_object = MainFactory::create_object('GMDataObject', array('products_feature_value'));
		$coo_data_object->set_keys(array(
									'feature_value_id' => $p_feature_value_id,
									'products_id' => $p_products_id
								));
		$coo_data_object->delete();
		return true;
	}

  /*
   * remove all entries for products_id
   * @param int $p_products_id  products id
   * @return bool
   */
  function clear_feature_value($p_products_id)
  {
		$coo_data_object = MainFactory::create_object('GMDataObject', array('products_feature_value'));
		$coo_data_object->set_keys(array('products_id' => $p_products_id));
		$coo_data_object->delete();
		return true;
  }

  /*
   * get all feature values for a given products_id
   * @param int $p_products_id  products id
   * @return array $t_result_array  array with all feature value ids
   */
  function get_product_feature_value_array($p_products_id)
  {
		$coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array('products_feature_value', array('products_id' => $p_products_id)));
		$t_data_object_array = $coo_data_object_group->get_data_objects_array();

    $t_result_array = array();
    foreach($t_data_object_array as $t_data_object_item) {
      $t_feature_value_id = $t_data_object_item->get_data_value('feature_value_id');
      $t_result_array[] = $t_feature_value_id;
    }

    return $t_result_array;
  }

  /*
   * get all feature_ids for given category tree to product
   * @param string $p_category_path  category tree ("1_12_3_10")
   * @return array $t_feature_id_array  all feature_ids for all categories
   */
  function get_product_feature_array($p_category_path)
  {
    $t_feature_id_array  = array();
    $t_category_id_array = explode("_", $p_category_path);

    foreach ($t_category_id_array as $t_cat_key => $t_category_id) {
      $t_coo_control     = MainFactory::create_object('FeatureControl');
      $t_coo_cat_filter  = $t_coo_control->get_categories_filter_array(array('categories_id'=>$t_category_id), array('sort_order'));

      foreach ($t_coo_cat_filter as $t_coo_key => $t_coo_filter) {
        $t_feature_id = $t_coo_filter->v_feature_id;
        if (!in_array($t_feature_id, $t_feature_id_array)) {
          $t_feature_id_array[] = $t_feature_id;
        }
      }

    }

    return $t_feature_id_array;
  }

 	function build_categories_index($p_products_id)
	{
		# get categories_ids the products_id is linked to
		$coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array('products_to_categories', array('products_id' => $p_products_id), false));
		$t_data_object_array = $coo_data_object_group->get_data_objects_array();
		
		$t_categories_id_array = array();

		# collect category's parent_ids from parent tree
		for($i=0; $i<sizeof($t_data_object_array); $i++)
		{
			$t_categories_id = $t_data_object_array[$i]->get_data_value('categories_id');
			$t_parent_id_array = $this->get_categories_parents_array($t_categories_id);

			if($t_parent_id_array !== false)
			{
				$t_categories_id_array[] = $t_categories_id;
				$t_categories_id_array = array_merge($t_categories_id_array, $t_parent_id_array);
			}
		}

		sort($t_categories_id_array); # sort array for cleaning
		$t_categories_id_array = array_unique($t_categories_id_array); # delete doubled categories_ids
		$t_categories_id_array = array_values($t_categories_id_array); # close key gaps after deleting duplicates
		
		
		# build index string
		$t_index_field = '';
		for($i=0; $i<sizeof($t_categories_id_array); $i++)
		{
			$t_index_field .= '-'.$t_categories_id_array[$i].'-';
		}

		# declare data_object for saving
		$coo_index_data_object = false;

		# check for existing index
		$coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array('feature_index', array('products_id' => $p_products_id)));
		$t_data_object_array = $coo_data_object_group->get_data_objects_array();

		if(sizeof($t_data_object_array) > 0)
		{
			# existing index found
			$coo_index_data_object = $t_data_object_array[0];
		}
		else
		{
			# no index found. create new data object
			$coo_index_data_object = MainFactory::create_object('GMDataObject', array('feature_index'));
			$coo_index_data_object->set_keys(array('products_id' => false));
			$coo_index_data_object->set_data_value('products_id', $p_products_id);
		}

		# save built index
		$coo_index_data_object->set_data_value('categories_index', $t_index_field);
		$coo_index_data_object->save_body_data();
	}

	function get_categories_parents_array($p_categories_id)
	{
		$t_output_array = array();

		if($p_categories_id == 0)
		{
			# categories_id is root and has no parents. return empty array.
			return $t_output_array;
		}

		# get category's status and parent_id
		$coo_data_object = MainFactory::create_object('GMDataObject', array('categories', array('categories_id' => $p_categories_id)));

		if($coo_data_object->get_data_value('categories_status') == '0')
		{
			# cancel recursion with false on inactive category
			return false;
		}

		$t_parent_id = $coo_data_object->get_data_value('parent_id');
		$t_output_array[] = $t_parent_id;

		if($t_parent_id != 0)
		{
			# get more parents, if category is not root
			$t_parent_id_array = $this->get_categories_parents_array($t_parent_id);
			if($t_parent_id_array === false)
			{
				# cancel recursion with false on inactive category
				return false;
			}
			# merge category's parent tree to categories_id
			$t_output_array = array_merge($t_output_array, $t_parent_id_array);
		}
		return $t_output_array;
	}


  /*
   * create new index entries for products_id
   * @param int $p_products_id  products id
   * @return bool
   */
	function build_feature_index($p_products_id)
	{
		# collect product's feature_ids for indexing
		$coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array('products_feature_value', array('products_id' => $p_products_id), false));
		$t_data_object_array = $coo_data_object_group->get_data_objects_array();

		# sort feature_value_ids
		$t_feature_value_id_array = array();
		for($i=0; $i<sizeof($t_data_object_array); $i++)
		{
			$t_feature_value_id_array[] = $t_data_object_array[$i]->get_data_value('feature_value_id');
		}
		sort($t_feature_value_id_array);

		# build index string
		$t_index_field = '';
		for($i=0; $i<sizeof($t_feature_value_id_array); $i++)
		{
			$t_index_field .= '-'.$t_feature_value_id_array[$i].'-';
		}

		# declare data_object for saving
		$coo_index_data_object = false;

		# check for existing index
		$coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array('feature_index', array('products_id' => $p_products_id)));
		$t_data_object_array = $coo_data_object_group->get_data_objects_array();

		if(sizeof($t_data_object_array) > 0)
		{
			# existing index found
			$coo_index_data_object = $t_data_object_array[0];
		}
		else
		{
			# no index found. create new data object
			$coo_index_data_object = MainFactory::create_object('GMDataObject', array('feature_index'));
			$coo_index_data_object->set_keys(array('products_id' => false));
			$coo_index_data_object->set_data_value('products_id', $p_products_id);
		}

		# save built index
		$coo_index_data_object->set_data_value('feature_value_index', $t_index_field);
		$coo_index_data_object->save_body_data();
	} 
}
?>