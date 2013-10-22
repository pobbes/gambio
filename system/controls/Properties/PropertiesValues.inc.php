<?php
/* --------------------------------------------------------------
   PropertiesValues.inc.php 2011-10-14 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class PropertiesValues
{
	/*
	* params
	*/
	var $v_properties_values_id = 0;
	var $v_properties_id = 0;
	var $v_sort_order = 0;
	var $v_value_model = 0;
	var $v_value_price_type = '';
	var $v_value_price = 0.0;
	var $v_values_name_array = array();
	var $v_values_image_array = array();
	var $v_allowed_price_type = array();
	var $v_default_value_price_type = 'plus';


	/*
	* constructor
	*/
	function PropertiesValues()
	{
	}

	/*
	* set_allowed_price_types
	* @return bool
	*/
	function set_allowed_price_types()
	{
		$this->v_allowed_price_type = array('plus', 'minus', 'fix');
		return true;
	}

	/*
	* get_allowed_price_types
	* @return array  all allowed price types
	*/
	function get_allowed_price_types()
	{
		return $this->v_allowed_price_type;
	}

	/*
	* set_properties_values_id
	* @param int $p_properties_values_id  the properties values id
	* @return bool
	*/
	function set_properties_values_id($p_properties_values_id)
	{
		$this->v_properties_values_id = (int) $p_properties_values_id;
		return true;
	}

	/*
	* get_properties_values_id
	* @return int  properties values id
	*/
	function get_properties_values_id()
	{
		return (int) $this->v_properties_values_id;
	}

	/*
	* set_properties_id
	* @param int $p_properties_id  the properties id
	* @return bool
	*/
	function set_properties_id($p_properties_id)
	{
		$this->v_properties_id = (int) $p_properties_id;
		return true;
	}

	/*
	* get_properties_id
	* @return int  properties id
	*/
	function get_properties_id()
	{
		return (int) $this->v_properties_id;
	}

	/*
	* set_sort_order
	* @param int $p_sort_order  the sort order
	* @return bool
	*/
	function set_sort_order($p_sort_order)
	{
		$this->v_sort_order = (int) $p_sort_order;
		return true;
	}

	/*
	* get_sort_order
	* @return int  sort order
	*/
	function get_sort_order()
	{
		return (int) $this->v_sort_order;
	}

	/*
	* set_value_model
	* @param int $p_value_model  the value model
	* @return bool
	*/
	function set_value_model($p_value_model)
	{
		$this->v_value_model = (int) $p_value_model;
		return true;
	}

	/*
	* get_value_model
	* @return int  value model
	*/
	function get_value_model()
	{
		return (int) $this->v_value_model;
	}

	/*
	* set_value_price_type
	* @return bool
	*/
	function set_value_price_type($p_value_price_type)
	{
		$this->set_allowed_price_types();

		# target not allowed -> use default
		$t_value_price_type = (string) $p_value_price_type;
		if (!in_array($t_value_price_type, $this->v_allowed_price_type)) {
			$t_value_price_type = (string) $this->v_default_value_price_type;
		};

		$this->v_value_price_type = $t_value_price_type;
		return true;
	}

	/*
	* get_value_price_type
	* @return int  value price type
	*/
	function get_value_price_type()
	{
		return (string) $this->v_value_price_type;
	}

	/*
	* set_value_price
	* @param double $p_value_price  the value price
	* @return bool
	*/
	function set_value_price($p_value_price)
	{
		$this->v_value_price = (double) $p_value_price;
		return true;
	}

	/*
	* get_value_price
	* @return double  value price
	*/
	function get_value_price()
	{
		return (double) $this->v_value_price;
	}

	/*
	* set_values_name
	* @param int $p_language_id  the language_id
	* @param string $p_values_name  the description values_name string
	* @return bool
	*/
	function set_values_name($p_language_id, $p_values_name)
	{
		$c_language_id = (int) $p_language_id;
		$this->v_values_name_array[ $c_language_id ] = (string) $p_values_name;
		return true;
	}

	/*
	* get_values_name
	* @return int  string with description values_name
	*/
	function get_values_name($p_language_id)
	{
		$c_language_id = (int) $p_language_id;
		if (!isset($this->v_values_name_array[ $c_language_id ])) {
			return false;
		}
		return (string) $this->v_values_name_array[ $c_language_id ];
	}

	/*
	* set_values_image
	* @param int $p_language_id  the language_id
	* @param string $p_values_image  the description values_image
	* @return bool
	*/
	function set_values_image($p_language_id, $p_values_image)
	{
		$c_language_id = (int) $p_language_id;
		$this->v_values_image_array[ $c_language_id ] = (string) $p_values_image;
		return true;
	}

	/*
	* get_values_image
	* @return int  string with description values_image
	*/
	function get_values_image($p_language_id)
	{
		$c_language_id = (int) $p_language_id;
		if (!isset($this->v_values_image_array[ $c_language_id ])) {
			return false;
		}
		return (string) $this->v_values_image_array[ $c_language_id ];
	}

	/*
	* save
	* @return int  latest id after saving (0:error)
	*/
	function save()
	{
		# insert mode?
		$t_insert_mode = true;
		if (!empty($this->v_properties_values_id)) $t_insert_mode = false;

		$coo_properties_values = MainFactory::create_object('GMDataObject', array('properties_values'));

		# insert or update?
		if($t_insert_mode) {
			$coo_properties_values->set_keys(array('properties_values_id' => false));
		} else {
			$coo_properties_values->set_keys(array('properties_values_id' => $this->v_properties_values_id));
		}

		# save basic values_image data
		$coo_properties_values->set_data_value('properties_values_id', $this->v_properties_values_id);
		$coo_properties_values->set_data_value('properties_id', $this->v_properties_id);
		$coo_properties_values->set_data_value('sort_order', $this->v_sort_order);
		$coo_properties_values->set_data_value('value_model', $this->v_value_model);
		$coo_properties_values->set_data_value('value_price_type', $this->v_value_price_type);
		$coo_properties_values->set_data_value('value_price', $this->v_value_price);

		$t_properties_values_id = (int) $coo_properties_values->save_body_data();

		# get new id
		if (empty($t_properties_values_id) && !empty($this->v_properties_values_id)) {
			$t_properties_values_id = $this->v_properties_values_id;
		}

		$coo_properties_values = NULL;

		# save PROPERTIES VALUES description
		foreach ($this->v_values_name_array as $t_language_id => $t_values_name) {
			$c_language_id = (int) $t_language_id;

			$coo_properties_values_desc = MainFactory::create_object('GMDataObjectGroup', array('properties_values_description'));

			# insert or update?
			$t_insert_mode = $this->has_description($t_language_id);

			if($t_insert_mode) {
				$coo_properties_values_desc->set_keys(array('properties_values_id' => false,
					 'language_id'     => false));
			} else {
				$coo_properties_values_desc->set_keys(array('properties_values_id' => $t_properties_values_id,
					 'language_id'     => $c_language_id));
			}

			$t_values_name = '';
			if (!empty($this->v_values_name_array[$c_language_id])) {
				$t_values_name = $this->v_values_name_array[$c_language_id];
			}

			$t_values_image = '';
			if (!empty($this->v_values_image_array[$c_language_id])) {
				$t_values_image = $this->v_values_image_array[$c_language_id];
			}

			# save description data
			$coo_properties_values_desc->set_data_value('properties_values_id', $t_properties_values_id);
			$coo_properties_values_desc->set_data_value('language_id', $c_language_id);
			$coo_properties_values_desc->set_data_value('values_name', $t_values_name);
			$coo_properties_values_desc->set_data_value('values_image', $t_values_image);

			$coo_properties_values_desc->save_body_data();

			$coo_properties_values_desc = NULL;
		}

		# set and return new id
		if ($t_properties_values_id != $this->v_properties_values_id) {
			$this->set_properties_values_id($t_properties_values_id);
		}

		return $t_properties_values_id;
	}

	/*
	* has_description
	* @param int $p_language_id  language_id for the searched entry
	* @return bool false:UPDATE | true:INSERT
	*/
	function has_description($p_language_id)
	{
		$c_language_id = (int) $p_language_id;

		$t_data_array = array('properties_values_id'=>$this->v_properties_values_id, 'language_id'=>$c_language_id);

		$coo_data_object = MainFactory::create_object('GMDataObject', array('properties_values_description', $t_data_array));

		if (is_array($coo_data_object->v_table_content)) return false;
		return true;
	}

	/*
	* load
	* @return bool true:ok | false:error
	*/
	function load($p_properties_values_id)
	{
		$this->reset();

		$c_properties_values_id = (int) $p_properties_values_id;

		$t_param_array = array('properties_values_id' => $c_properties_values_id);
		$coo_data_object = MainFactory::create_object('GMDataObject', array('properties_values', $t_param_array));
		$this->load_data_object($coo_data_object);

		$coo_data_object = NULL;

		return true;
	}

	/*
	* load_data_object
	* @param object $p_coo_data_object  GmDataObject
	* @return true:ok | false:error
	*/
	function load_data_object($p_coo_data_object)
	{
		# basic data
		$this->set_properties_values_id( $p_coo_data_object->get_data_value('properties_values_id') );
		$this->set_properties_id( $p_coo_data_object->get_data_value('properties_id') );
		$this->set_sort_order( $p_coo_data_object->get_data_value('sort_order') );
		$this->set_value_model( $p_coo_data_object->get_data_value('value_model') );
		$this->set_value_price_type( $p_coo_data_object->get_data_value('value_price_type') );
		$this->set_value_price( $p_coo_data_object->get_data_value('value_price') );

		# descriptions (values_name)
		$t_param_array = array('properties_values_id' => $this->v_properties_values_id);
		$coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array('properties_values_description', $t_param_array));
		$t_data_object_array = $coo_data_object_group->get_data_objects_array();
		$coo_data_object_group = NULL;

		foreach($t_data_object_array as $t_data_object_item) {
			$t_language_id = (int) $t_data_object_item->get_data_value('language_id');

			$t_values_name = $t_data_object_item->get_data_value('values_name');
			$this->set_values_name($t_language_id, $t_values_name);

			$t_values_image = $t_data_object_item->get_data_value('values_image');
			$this->set_values_image($t_language_id, $t_values_image);
		}

		return true;
	}

	/*
	* delete
	* delete propertie and all description
	* @return bool
	*/
	function delete()
	{
		$coo_properties = MainFactory::create_object('GMDataObject', array('properties_values'));
		$coo_properties->set_keys(array('properties_values_id' => $this->v_properties_values_id));
		$coo_properties->delete();
		$coo_properties = NULL;

		$coo_properties = MainFactory::create_object('GMDataObject', array('properties_values_description'));
		$coo_properties->set_keys(array('properties_values_id' => $this->v_properties_values_id));
		$coo_properties->delete();
		$coo_properties = NULL;

		return true;
	}

	/*
	* reset
	* @return bool
	*/
	function reset()
	{
		# clear all
		$this->v_properties_values_id = 0;
		$this->v_properties_id = 0;
		$this->v_sort_order = 0;
		$this->v_value_model = 0;
		$this->v_value_price_type = '';
		$this->v_value_price = 0.0;
		$this->v_values_name_array = array();
		$this->v_values_image_array = array();
		$this->v_allowed_price_type = array();
		# done
		return true;
	}
}
?>