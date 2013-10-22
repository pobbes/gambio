<?php
/* --------------------------------------------------------------
   Properties.inc.php 2011-10-14 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class Properties
{
	/*
	* params
	*/
	var $v_properties_id = 0;
	var $v_sort_order = 0;
	var $v_properties_name_array = array();

	/*
	* constructor
	*/
	function Properties()
	{
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
	* set_properties_name
	* @param int $p_language_id  the language_id
	* @param string $p_properties_name  the description properties_name string
	* @return bool
	*/
	function set_properties_name($p_language_id, $p_properties_name)
	{
		$c_language_id = (int) $p_language_id;
		$this->v_properties_name_array[ $c_language_id ] = (string) $p_properties_name;
		return true;
	}

	/*
	* get_properties_name
	* @return int  string with description properties_name
	*/
	function get_properties_name($p_language_id)
	{
		$c_language_id = (int) $p_language_id;
		if (!isset($this->v_properties_name_array[ $c_language_id ])) {
			return false;
		}
		return (string) $this->v_properties_name_array[ $c_language_id ];
	}

	/*
	* save
	* @return int  latest id after saving (0:error)
	*/
	function save()
	{
		# insert mode?
		$t_insert_mode = true;
		if (!empty($this->v_properties_id)) $t_insert_mode = false;

		$coo_properties = MainFactory::create_object('GMDataObject', array('properties'));

		# insert or update?
		if($t_insert_mode) {
			$coo_properties->set_keys(array('properties_id' => false));
		} else {
			$coo_properties->set_keys(array('properties_id' => $this->v_properties_id));
		}

		# save basic IMAGE data
		$coo_properties->set_data_value('properties_id', $this->v_properties_id);
		$coo_properties->set_data_value('sort_order', $this->v_sort_order);

		$t_properties_id = (int) $coo_properties->save_body_data();

		# get new id
		if (empty($t_properties_id) && !empty($this->v_properties_id)) {
			$t_properties_id = $this->v_properties_id;
		}

		$coo_properties = NULL;

		# save PROPERTIES description
		foreach ($this->v_properties_name_array as $t_language_id => $t_properties_name) {

			$c_language_id = (int) $t_language_id;

			$coo_properties_desc = MainFactory::create_object('GMDataObjectGroup', array('properties_description'));

			# insert or update?
			$t_insert_mode = $this->has_description($t_language_id);

			if($t_insert_mode) {
				$coo_properties_desc->set_keys(array('properties_id' => false,
						 'language_id'     => false));
			} else {
				$coo_properties_desc->set_keys(array('properties_id' => $t_properties_id,
						 'language_id'     => $c_language_id));
			}

			$t_properties_name = '';
			if (!empty($this->v_properties_name_array[$c_language_id])) {
				$t_properties_name = $this->v_properties_name_array[$c_language_id];
			}

			# save description data
			$coo_properties_desc->set_data_value('properties_id', $t_properties_id);
			$coo_properties_desc->set_data_value('language_id', $c_language_id);
			$coo_properties_desc->set_data_value('properties_name', $t_properties_name);

			$coo_properties_desc->save_body_data();

			$coo_properties_desc = NULL;
		}

		# set and return new id
		if ($t_properties_id != $this->v_properties_id) {
		$this->set_properties_id($t_properties_id);
		}

		return $t_properties_id;
	}

	/*
	* has_description
	* @param int $p_language_id  language_id for the searched entry
	* @return bool false:UPDATE | true:INSERT
	*/
	function has_description($p_language_id)
	{
		$c_language_id = (int) $p_language_id;

		$t_data_array = array('properties_id'=>$this->v_properties_id, 'language_id'=>$c_language_id);

		$coo_data_object = MainFactory::create_object('GMDataObject', array('properties_description', $t_data_array));

		if (is_array($coo_data_object->v_table_content)) return false;
		return true;
	}

	/*
	* load
	* @return bool true:ok | false:error
	*/
	function load($p_properties_id)
	{
		$this->reset();

		$c_properties_id = (int) $p_properties_id;

		$t_param_array = array('properties_id' => $c_properties_id);
		$coo_data_object = MainFactory::create_object('GMDataObject', array('properties', $t_param_array));
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
		$this->set_properties_id( $p_coo_data_object->get_data_value('properties_id') );
		$this->set_sort_order( $p_coo_data_object->get_data_value('sort_order') );

		# descriptions (properties_name)
		$t_param_array = array('properties_id' => $this->v_properties_id);
		$coo_data_object_group = MainFactory::create_object('GMDataObjectGroup', array('properties_description', $t_param_array));
		$t_data_object_array = $coo_data_object_group->get_data_objects_array();
		$coo_data_object_group = NULL;

		foreach($t_data_object_array as $t_data_object_item) {		
			$t_language_id = (int) $t_data_object_item->get_data_value('language_id');
			$t_properties_name = $t_data_object_item->get_data_value('properties_name');
			$this->set_properties_name($t_language_id, $t_properties_name);
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
		$coo_properties = MainFactory::create_object('GMDataObject', array('properties'));
		$coo_properties->set_keys(array('properties_id' => $this->v_properties_id));
		$coo_properties->delete();
		$coo_properties = NULL;

		$coo_properties = MainFactory::create_object('GMDataObject', array('properties_description'));
		$coo_properties->set_keys(array('properties_id' => $this->v_properties_id));
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
		$this->v_properties_id = 0;
		$this->v_sort_order = 0;
		$this->v_properties_name_array = array();
		# done
		return true;
	}
}
?>