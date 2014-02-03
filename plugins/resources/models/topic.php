<?php defined('SYSPATH') or die('No direct script access.');

class Topic_Model extends ORM {
  /**
   * Database table name
   * @var string
   */
  protected $table_name = 'topics';
  protected $_primary_key = 'id';

  /**
   * Many-to-many relationship definition
   * @var array
   */
  protected $has_and_belongs_to_many = array('materials');
  /*
  protected $_has_many = array(
    'materials' => array(
      'model' => 'material',
      'through' => 'materials_topics',
      'foreign_key' => 'topic_id',
            'far_key' => 'material_id'
    ),
  );*/
}