<?php defined('SYSPATH') or die('No direct script access.');
 
class Talk_Model extends ORM {
	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'talks';
	protected $_primary_key = 'id';

	//protected $belongs_to = array('material');
}