<?php
/**
* Themerella Theme Framework
* The Rella_Admin_Page base class
*/

if( !defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Rella_Admin_Dashboard extends Rella_Admin_Page {

	/**
	 * [__construct description]
	 * @method __construct
	 */
	public function __construct() {

		$this->id = 'rella';
		$this->page_title = 'Rella';
		$this->menu_title = 'Rella';
		$this->position = '50';

		parent::__construct();
	}

	/**
	 * [display description]
	 * @method display
	 * @return [type]  [description]
	 */
	public function display() {
		include_once 'views/rella-dashboard.php';
	}

	/**
	 * [save description]
	 * @method save
	 * @return [type] [description]
	 */
	public function save() {

	}
}
new Rella_Admin_Dashboard;
