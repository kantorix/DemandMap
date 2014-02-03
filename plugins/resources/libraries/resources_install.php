<?php

class Resources_Install {

  /**
   * Constructor to load the shared database library
   */
  public function __construct() {
    $this->db = new Database();
  }

  /**
   * Creates the required database tables for resources
   */
  public function run_install() {
    // Create the database tables

    // add `files` table
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . Kohana::config('database.default.table_prefix') . "files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `filetitle` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `filename` varchar(255) CHARACTER SET utf8 NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0");

    // add `materials` table
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . Kohana::config('database.default.table_prefix') . "materials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `content` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0");

    // add `topics` table
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . Kohana::config('database.default.table_prefix') . "topics` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;");

    // add `materials_topics` table
    $this->db->query("CREATE TABLE IF NOT EXISTS `" . Kohana::config('database.default.table_prefix') . "materials_topics` (
  `material_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`material_id`,`topic_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

    // add `talks` table
    $this->db->query("CREATE TABLE  IF NOT EXISTS `" . Kohana::config('database.default.table_prefix') . "talks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `material_id` int(11) NOT NULL,
  `nickname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `material_id` (`material_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;");
  }

  /**
   * Deletes the database tables for resources
   */
  public function uninstall() {
    $this->db->query("DROP TABLE " . Kohana::config('database.default.table_prefix') . "files;");
    $this->db->query("DROP TABLE " . Kohana::config('database.default.table_prefix') . "materials;");
    $this->db->query("DROP TABLE " . Kohana::config('database.default.table_prefix') . "topics;");
    $this->db->query("DROP TABLE " . Kohana::config('database.default.table_prefix') . "materials_topics;");
    $this->db->query("DROP TABLE " . Kohana::config('database.default.table_prefix') . "talks;");
  }
}