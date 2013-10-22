<?php
/* --------------------------------------------------------------
   FeatureControl.inc.php 2010-12-14 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class FeatureControl
{
  /*
   * constructor
   */
  function FeatureControl()
  {

  }


  /*
   * get data for filter on 'feature' table
   * @param array $p_filter_array  assoc array with filter data
   * @param array $p_sort_by  assoc array with sorting options
   * @return array $t_feature_result_array  result array with object data
   */
  function get_feature_array($p_filter_array = array(), $p_sort_by = array())
  {
    $t_feature_result_array = $this->get_data('Feature', 'feature', $p_filter_array, $p_sort_by);
    return $t_feature_result_array;
  }

  /*
   * get data for filter on 'feature_value' table
   * @param array $p_filter_array  assoc array with filter data
   * @param array $p_sort_by  assoc array with sorting options
   * @return array $t_feature_result_array  result array with object data
   */
  function get_feature_value_array($p_filter_array = array(), $p_sort_by = array())
  {
    $t_feature_result_array = $this->get_data('FeatureValue', 'feature_value', $p_filter_array, $p_sort_by);
    return $t_feature_result_array;
  }

  /*
   * get data for filter on 'categories_filter' table
   * @param array $p_filter_array  assoc array with filter data
   * @param array $p_sort_by  assoc array with sorting options
   * @return array $t_feature_result_array  result array with object data
   */
  function get_categories_filter_array($p_filter_array = array(), $p_sort_by = array())
  {
    $t_feature_result_array = $this->get_data('CategoriesFilter', 'categories_filter', $p_filter_array, $p_sort_by);
    return $t_feature_result_array;
  }

  /*
   * get data from table using class and return object data array
   * @param string $p_class  class to be used
   * @param string $p_table  table matching the class
   * @param array $p_filter_array  assoc array with filter data
   * @return array $t_result_array  result array with object data
   */
  function get_data($p_class, $p_table, $p_filter_array, $p_sort_by)
  {
    $t_result_array = array();
    $coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array($p_table, $p_filter_array, $p_sort_by));
    $t_data_object_array = $coo_data_object_group->get_data_objects_array();

    foreach ($t_data_object_array as $t_data_object_item) {
      $coo_class = MainFactory::create_object($p_class);
      $coo_class->load_data_object($t_data_object_item);
      $t_result_array[] = $coo_class;
      $coo_class = NULL;
    }

    return $t_result_array;
  }

  /*
   * create a 'Feature' object and return this object
   * @return object $coo_feature  feature object
   */
  function create_feature()
  {
    $coo_feature = MainFactory::create_object('Feature');
    return $coo_feature;
  }

  /*
   * create a 'FeatureValue' object and return this object
   * @return object $coo_feature_value  feature object
   */
  function create_feature_value()
  {
    $coo_feature_value = MainFactory::create_object('FeatureValue');
    return $coo_feature_value;
  }

  /*
   * create a 'CategoriesFilter' object and return this object
   * @return object $coo_categories_filter  feature object
   */
  function create_categories_filter()
  {
    $coo_categories_filter = MainFactory::create_object('CategoriesFilter');
    return $coo_categories_filter;
  }
}
?>