<?php defined('SYSPATH') or die('No direct script access.');

class Material_Model extends ORM {
  /**
   * Database table name
   * @var string
   */
  protected $table_name = 'materials';
  protected $_primary_key = 'id';

  /**
   * one-to-many relationship definition child
   * @var array
   */
  protected $belongs_to = array('category', 'user');
  /**
   * one-to-many relationship definition
   * @var array
   */
  protected $has_many = array('talks', 'files');
  /**
   * many-to-many relationship definition
   * @var array
   */
  protected $has_and_belongs_to_many = array('topics');
}