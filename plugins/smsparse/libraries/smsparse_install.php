<?php
/**
 * Performs install/uninstall methods for the SMSSync plugin
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module	   SMSSync Installer
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Smsparse_Install {

	/**
	 * Constructor to load the shared database library
	 */
	public function __construct()
	{
		$this->db = Database::instance();
	}

	/**
	 * Creates the required database tables for the smssync plugin
	 */
	public function run_install()
	{
		// Create the database tables.
		// Also include table_prefix in name
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."reporter_types` (
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				type varchar(100) DEFAULT NULL,
				PRIMARY KEY (`id`)
			);
		");
		
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."reporters_types` (
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				reporter_id int(11) unsigned NOT NULL,
				type_id int(11) unsigned NOT NULL,
				PRIMARY KEY (`reporter_id`, `type_id`),
				CONSTRAINT reporters_types_fk_reporters FOREIGN KEY(reporter_id) REFERENCES reporter(id),
				CONSTRAINT reporters_types_fk_reporter_types FOREIGN KEY(type_id) REFERENCES reporter_types(id)
			);
		");
		
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."incident_types` (
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				type varchar(100) DEFAULT NULL,
				PRIMARY KEY (`id`)
			);
		");
		
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."incidents_types` (
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				incident_id int(20) unsigned NOT NULL,
				type_id int(11) unsigned NOT NULL,
				PRIMARY KEY (`incident_id`, `type_id`),
				CONSTRAINT incidents_types_fk_incident FOREIGN KEY(incident_id) REFERENCES incident(id),
				CONSTRAINT incidents_types_fk_incident_types FOREIGN KEY(type_id) REFERENCES incidents_types(id)
			);
		");
		
		$this->db->query("
			CREATE TABLE IF NOT EXISTS `".Kohana::config('database.default.table_prefix')."reporters_incidents` (
				id int(11) unsigned NOT NULL AUTO_INCREMENT,
				incident_id int(20) unsigned NOT NULL,
				reporter_id int(11) unsigned NOT NULL,
				PRIMARY KEY (`incident_id`, `reporter_id`)
			);
		");
		
		$this->db->query("
			INSERT INTO `".Kohana::config('database.default.table_prefix')."reporter_types` VALUES
				(1, 'educator'),
				(2, 'employer');
		");
		
		$this->db->query("
			INSERT INTO `".Kohana::config('database.default.table_prefix')."incident_types` VALUES
				(1,'ressource_request'),
				(2,'skill_request'),
				(3,'ressource_upload');
		");
	}

	/**
	 * Deletes the database tables for the actionable module
	 */
	public function uninstall()
	{
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'reporter_types`');
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'reporters_types`');
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'incident_types`');
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'incidents_types`');
		$this->db->query('DROP TABLE `'.Kohana::config('database.default.table_prefix').'reporters_incidents`');
	}
}