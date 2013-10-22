<?php
/* --------------------------------------------------------------
   ProductsPropertiesCombisValues.inc.php 2011-10-14 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class ProductsPropertiesCombisValues
{
	/*
	* params
	*/
	var $v_products_properties_combis_values_id = 0;
	var $v_products_properties_combis_id = 0;
	var $v_properties_values_id = 0;

	/*
	* constructor
	*/
	function ProductsPropertiesCombisValues()
	{
	}

	/*
	* set_products_properties_combis_values_id
	* @param int $p_products_properties_combis_values_id  the products properties combis values id
	* @return bool
	*/
	function set_products_properties_combis_values_id($p_products_properties_combis_values_id)
	{
		$this->v_products_properties_combis_values_id = (int) $p_products_properties_combis_values_id;
		return true;
	}

	/*
	* get_products_properties_combis_values_id
	* @return int products_properties_combis_values_id
	*/
	function get_products_properties_combis_values_id()
	{
		return (int) $this->v_products_properties_combis_values_id;
	}

	/*
	* set_products_properties_combis_id
	* @param int $p_products_properties_combis_id  the products properties combis id
	* @return bool
	*/
	function set_products_properties_combis_id($p_products_properties_combis_id)
	{
		$this->v_products_properties_combis_id = (int) $p_products_properties_combis_id;
		return true;
	}

	/*
	* get_products_properties_combis_id
	* @return int products_properties_combis_id
	*/
	function get_products_properties_combis_id()
	{
		return (int) $this->v_products_properties_combis_id;
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
	* @return int properties_values_id
	*/
	function get_properties_values_id()
	{
		return (int) $this->v_properties_values_id;
	}

	/*
	* save
	* @return int  latest id after saving (0:error)
	*/
	function save()
	{
		# insert mode?
		$t_insert_mode = true;
		if (!empty($this->v_products_properties_combis_values_id)) $t_insert_mode = false;

		$coo_products_properties_combis_values = MainFactory::create_object('GMDataObject', array('products_properties_combis_values'));

		# insert or update?
		if($t_insert_mode) {
			$coo_products_properties_combis_values->set_keys(array('products_properties_combis_values_id' => false));
		} else {
			$coo_products_properties_combis_values->set_keys(array('products_properties_combis_values_id' => $this->v_products_properties_combis_values_id));
		}

		# save basic IMAGE data
		$coo_products_properties_combis_values->set_data_value('products_properties_combis_values_id', $this->v_products_properties_combis_values_id);
		$coo_products_properties_combis_values->set_data_value('products_properties_combis_id', $this->v_products_properties_combis_id);
		$coo_products_properties_combis_values->set_data_value('properties_values_id', $this->v_properties_values_id);

		$t_products_properties_combis_values_id = (int) $coo_products_properties_combis_values->save_body_data();

		# get new id
		if (empty($t_products_properties_combis_values_id) && !empty($this->v_products_properties_combis_values_id)) {
			$t_products_properties_combis_values_id = $this->v_products_properties_combis_values_id;
		}

		$coo_products_properties_combis_values = NULL;

		# set and return new id
		if ($t_products_properties_combis_values_id != $this->v_products_properties_combis_values_id) {
			$this->set_products_properties_combis_values_id($t_products_properties_combis_values_id);
		}

		return $t_products_properties_combis_values_id;
	}

	/*
	* load
	* @return bool true:ok | false:error
	*/
	function load($p_products_properties_combis_values_id)
	{
		$this->reset();

		$c_products_properties_combis_values_id = (int) $p_products_properties_combis_values_id;

		$t_param_array = array('products_properties_combis_values_id' => $c_products_properties_combis_values_id);
		$coo_data_object = MainFactory::create_object('GMDataObject', array('products_properties_combis_values', $t_param_array));
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
		$this->set_products_properties_combis_values_id( $p_coo_data_object->get_data_value('products_properties_combis_values_id') );
		$this->set_products_properties_combis_id( $p_coo_data_object->get_data_value('products_properties_combis_id') );
		$this->set_properties_values_id( $p_coo_data_object->get_data_value('properties_values_id') );

		return true;
	}

	/*
	* delete
	* delete product properties combis value
	* @return bool
	*/
	function delete()
	{
		$coo_products_properties_combis_values = MainFactory::create_object('GMDataObject', array('products_properties_combis_values'));
		$coo_products_properties_combis_values->set_keys(array('products_properties_combis_values_id' => $this->v_products_properties_combis_values_id));
		$coo_products_properties_combis_values->delete();
		$coo_products_properties_combis_values = NULL;

		return true;
	}

	/*
	* reset
	* @return bool
	*/
	function reset()
	{
		# clear all
		$this->v_products_properties_combis_values_id = 0;
		$this->v_products_properties_combis_id = 0;
		$this->v_properties_values_id = 0;
		# done
		return true;
	}
}
?>