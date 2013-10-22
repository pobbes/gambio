<?php
/* --------------------------------------------------------------
   DataObjectContainer.inc.php 2010-11-16 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

*
 * class DataObjectContainer
 * 
 */
/******************************* Abstract Class ****************************
  DataObjectContainer does not have any pure virtual methods, but its author
  defined it as an abstract class, so you should not use it directly.
  Inherit from it instead and create only objects from the derived classes
*****************************************************************************/

class DataObjectContainer
{

		/** Aggregations: */

		/** Compositions: */

		/**
		 * 
		 *
		 * @return bool
		 * @access public
		 */
		function save( )
		{
				
		} // end of member function save

		/**
		 * 
		 *
		 * @param int p_primary_id 
		 * @return bool
		 * @access public
		 */
		function load( $p_primary_id )
		{
				
		} // end of member function load

		/**
		 * 
		 *
		 * @param GMDataObject p_coo_data_object 
		 * @return bool
		 * @access public
		 */
		function load_data_object( $p_coo_data_object )
		{
				
		} // end of member function load_data_object





} // end of DataObjectContainer
?>