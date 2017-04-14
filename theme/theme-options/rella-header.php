<?php
/*
 * Header Section
*/
$this->sections[] = array(
	'title'  => esc_html__('Header', 'boo'),
	'icon'   => 'el-icon-photo'
);

include_once 'rella-header-layout.php';
include_once 'rella-header-menu.php';
include_once 'rella-header-title-wrapper.php';
