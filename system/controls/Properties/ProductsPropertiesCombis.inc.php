<?php
/* --------------------------------------------------------------
   ProductsPropertiesCombis.inc.php 2011-10-14 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class ProductsPropertiesCombis
{
  /*
   * params
   */
	var $v_products_properties_combis_id = 0;
	var $v_products_id = 0;
	var $v_sort_order = 0;
	var $v_combi_model = 0;
	var $v_combi_quantity_type = '';
	var $v_combi_quantity = 0;
	var $v_combi_price_type = '';
	var $v_combi_price = 0.0;
	var $v_combi_image = '';
	var $v_allowed_price_type = array();
	var $v_default_combi_price_type = 'plus';


	/*
	* constructor
	*/
	function ProductsPropertiesCombis(){
	}

	/*
	* set_allowed_price_types
	* @return bool
	*/
	function set_allowed_price_types(){
		$this->v_allowed_price_type = array('plus', 'minus', 'fix');
		return true;
	}

	/*
	* get_allowed_price_types
	* @return array  all allowed price types
	*/
	function get_allowed_price_types(){
		return $this->v_allowed_price_type;
	}

	/*
	* set_products_properties_combis_id
	* @param int $p_products_properties_combis_id
	* @return bool
	*/
	function set_products_properties_combis_id($p_products_properties_combis_id){
		$this->v_products_properties_combis_id = (int) $p_products_properties_combis_id;
		return true;
	}

	/*
	* get_products_properties_combis_id
	* @return int  products_properties_combis_id
	*/
	function get_products_properties_combis_id(){
		return (int) $this->v_products_properties_combis_id;
	}
	
	/*
	* set_products_id
	* @param int $p_products_id
	* @return bool
	*/
	function set_products_id($p_products_id)
	{
		$this->v_products_id = (int) $p_products_id;
		return true;
	}

	/*
	* get_products_id
	* @return int  products_id
	*/
	function get_products_id()
	{
		return (int) $this->v_products_id;
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
	* set_combi_model
	* @param int $p_combi_model
	* @return bool
	*/
	function set_combi_model($p_combi_model)
	{
		$this->v_combi_model = (int) $p_combi_model;
		return true;
	}

	/*
	* get_combi_model
	* @return int  combi_model
	*/
	function get_combi_model()
	{
		return (int) $this->v_combi_model;
	}
	
	/*
	* set_combi_quantity_type
	* @param int $p_combi_quantity_type
	* @return bool
	*/
	function set_combi_quantity_type($p_combi_quantity_type)
	{
		$this->v_combi_quantity_type = (string) $p_combi_quantity_type;
		return true;
	}

	/*
	* get_combi_quantity_type
	* @return int combi_quantity_type
	*/
	function get_combi_quantity_type()
	{
		return (string) $this->v_combi_quantity_type;
	}
	
	/*
	* set_combi_quantity
	* @param int $p_combi_quantity
	* @return bool
	*/
	function set_combi_quantity($p_combi_quantity)
	{
		$this->v_combi_quantity = (int) $p_combi_quantity;
		return true;
	}

	/*
	* get_combi_quantity
	* @return int combi_quantity
	*/
	function get_combi_quantity()
	{
		return (int) $this->v_combi_quantity;
	}

	/*
	* set_combi_price_type
	* @return bool
	*/
	function set_combi_price_type($p_combi_price_type)
	{
		$this->set_allowed_price_types();

		# type not allowed -> use default
		$t_combi_price_type = (string) $p_combi_price_type;
		if (!in_array($t_combi_price_type, $this->v_allowed_price_type)) {
			$t_combi_price_type = (string) $this->v_default_combi_price_type;
		};

		$this->v_combi_price_type = $t_combi_price_type;
		return true;
	}

	/*
	* get_combi_price_type
	* @return string combi_price_type
	*/
	function get_combi_price_type()
	{
		return (string) $this->v_combi_price_type;
	}

	/*
	* set_combi_price
	* @param double $p_combi_price
	* @return bool
	*/
	function set_combi_price($p_combi_price)
	{
		$this->v_combi_price = (double) $p_combi_price;
		return true;
	}

	/*
	* get_combi_price
	* @return double combi_price
	*/
	function get_combi_price()
	{
		return (double) $this->v_combi_price;
	}

	/*
	* set_combi_image
	* @param string $p_combi_image
	* @return bool
	*/
	function set_combi_image($p_combi_image)
	{
		$this->v_combi_image = (string) $p_combi_image;
		return true;
	}

	/*
	* get_combi_image
	* @return combi_image
	*/
	function get_combi_image()
	{
		return (string) $this->v_combi_image;
	}

	/*
	* save
	* @return int  latest id after saving (0:error)
	*/
	function save()
	{
		# insert mode?
		$t_insert_mode = true;
		if (!empty($this->v_products_properties_combis_id)) $t_insert_mode = false;

		$coo_products_properties_combis = MainFactory::create_object('GMDataObject', array('products_properties_combis'));

		# insert or update?
		if($t_insert_mode) {
			$coo_products_properties_combis->set_keys(array('products_properties_combis_id' => false));
		} else {
			$coo_products_properties_combis->set_keys(array('products_properties_combis_id' => $this->v_products_properties_combis_id));
		}

		# save basic IMAGE data
		$coo_products_properties_combis->set_data_value('products_properties_combis_id', $this->v_products_properties_combis_id);
		$coo_products_properties_combis->set_data_value('products_id', $this->v_products_id);
		$coo_products_properties_combis->set_data_value('sort_order', $this->v_sort_order);
		$coo_products_properties_combis->set_data_value('combi_model', $this->v_combi_model);
		$coo_products_properties_combis->set_data_value('combi_quantity_type', $this->v_combi_quantity_type);
		$coo_products_properties_combis->set_data_value('combi_quantity', $this->v_combi_quantity);
		$coo_products_properties_combis->set_data_value('combi_price_type', $this->v_combi_price_type);
		$coo_products_properties_combis->set_data_value('combi_price', $this->v_combi_price);
		$coo_products_properties_combis->set_data_value('combi_image', $this->v_combi_image);

		$t_products_properties_combis_id = (int) $coo_products_properties_combis->save_body_data();

		# get new id
		if (empty($t_products_properties_combis_id) && !empty($this->v_products_properties_combis_id)) {
			$t_products_properties_combis_id = $this->v_products_properties_combis_id;
		}

		$coo_products_properties_combis = NULL;

		# set and return new id
		if ($t_products_properties_combis_id != $this->v_products_properties_combis_id) {
			$this->set_products_properties_combis_id($t_products_properties_combis_id);
		}

		return $t_products_properties_combis_id;
	}

	/*
	* load
	* @return bool true:ok | false:error
	*/
	function load($p_products_properties_combis_id)
	{
		$this->reset();

		$c_products_properties_combis_id = (int) $p_products_properties_combis_id;

		$t_param_array = array('products_properties_combis_id' => $c_products_properties_combis_id);
		$coo_data_object = MainFactory::create_object('GMDataObject', array('products_properties_combis', $t_param_array));
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
		$this->set_products_properties_combis_id( $p_coo_data_object->get_data_value('products_properties_combis_id') );
		$this->set_products_id( $p_coo_data_object->get_data_value('products_id') );
		$this->set_sort_order( $p_coo_data_object->get_data_value('sort_order') );
		$this->set_combi_model( $p_coo_data_object->get_data_value('combi_model') );
		$this->set_combi_quantity_type( $p_coo_data_object->get_data_value('combi_quantity_type') );
		$this->set_combi_quantity( $p_coo_data_object->get_data_value('combi_quantity') );
		$this->set_combi_price_type( $p_coo_data_object->get_data_value('combi_price_type') );
		$this->set_combi_price( $p_coo_data_object->get_data_value('combi_price') );
		$this->set_combi_image( $p_coo_data_object->get_data_value('combi_image') );

		return true;
	}

	/*
	* delete
	* delete produtcs properties combis
	* @return bool
	*/
	function delete()
	{
		$coo_properties = MainFactory::create_object('GMDataObject', array('properties_values'));
		$coo_properties->set_keys(array('products_properties_combis_id' => $this->v_products_properties_combis_id));
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
		$this->v_products_properties_combis_id = 0;
		$this->v_products_id = 0;
		$this->v_sort_order = 0;
		$this->v_combi_model = 0;
		$this->v_combi_quantity_type = '';
		$this->v_combi_quantity = 0;
		$this->v_combi_price_type = '';
		$this->v_combi_price = 0.0;
		$this->v_combi_image = '';
		$this->v_allowed_price_type = array();
		# done
		return true;
	}
}
?>