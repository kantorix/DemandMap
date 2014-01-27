<?php defined('SYSPATH') or die('No direct script access.');
 
class File_Model extends ORM
{
	/**
	 * Database table name
	 * @var string
	 */
	protected $table_name = 'files';
	protected $_primary_key = 'id';
}