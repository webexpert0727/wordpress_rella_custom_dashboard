<?php
/**
* Themerella Theme Framework
* The dashbaord class
*/

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rella_Admin_Import extends Rella_Admin_Page {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		$this->id = 'rella-import-demos';
		$this->page_title = 'Rella Import Demos';
		$this->menu_title = 'Import Demos';
		$this->parent = 'rella';

		parent::__construct();
	}

	/**
	 * [display description]
	 * @method display
	 * @return [type]  [description]
	 */
	public function display() {
		include_once 'views/rella-demos.php';
	}

	/**
	 * [save description]
	 * @method save
	 * @return [type] [description]
	 */
	public function save() {

	}
}
new Rella_Admin_Import;
