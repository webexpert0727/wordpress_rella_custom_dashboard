<?php
/**
* Themerella Theme Framework
* The dashbaord class
*/

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rella_Admin_Plugins extends Rella_Admin_Page {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		$this->id = 'rella-plugins';
		$this->page_title = 'Rella Plugins';
		$this->menu_title = 'Plugins';
		$this->parent = 'rella';

		parent::__construct();
	}

	/**
	 * [display description]
	 * @method display
	 * @return [type]  [description]
	 */
	public function display() {
		include_once 'views/rella-plugins.php';
	}

	/**
	 * [save description]
	 * @method save
	 * @return [type] [description]
	 */
	public function save() {

	}
}
new Rella_Admin_Plugins;
