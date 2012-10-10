<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * upgrade original bookymark to 2.0
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file 002_upgrade_2_0.php
 */

/**
 * Migration_testing class.
 *
 * @extends MY_Migration
 */
class Migration_Testing extends MY_Migration
{
	// --------------------------------------------------------------------------
	
	/**
	 * up function.
	 *
	 * @access public
	 * @return void
	 */
	public function up()
	{
		// add user_id, created_at, updated_at
		$fields = array(
			'user_id' => array(
				'type' => 'int',
				'constraint' => '5',
				'null' => true
			),
			'created_at' => array(
				'type' => 'DATETIME',
				'null' => true
			),
			'updated_at' => array(
				'type' => 'DATETIME',
				'null' => true
			)
		);
		$this->dbforge->add_column('bookmarks', $fields);
		
		// migrations table
		$query = "DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `version` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`version`)
VALUES
	(2);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;";
		$this->db->query($query);
		
		// api clients table
		$query = "DROP TABLE IF EXISTS `api_clients`;

CREATE TABLE `api_clients` (
  `access_token` varchar(40) DEFAULT NULL,
  `shared_secret` varchar(40) DEFAULT NULL,
  `throttle_count` int(11) DEFAULT NULL,
  `throttled_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `api_clients` WRITE;
/*!40000 ALTER TABLE `api_clients` DISABLE KEYS */;

INSERT INTO `api_clients` (`access_token`, `shared_secret`, `throttle_count`, `throttled_at`)
VALUES
	('4395dd07a3cfe84d9655bb2542907f3acd0024fe','3c697e1314808f56bd44bc5ccb4765607b433715',51,'2012-10-09 20:50:24');

/*!40000 ALTER TABLE `api_clients` ENABLE KEYS */;
UNLOCK TABLES;";
		$this->db->query($query);
	}
	
	// --------------------------------------------------------------------------

	/**
	 * down function.
	 *
	 * @access public
	 * @return void
	 */
	public function down()
	{
		$this->dbforge->drop_column('bookmarks', 'user_id');
		$this->dbforge->drop_column('bookmarks', 'created_at');
		$this->dbforge->drop_column('bookmarks', 'updated_at');
		
		$this->dbforge->drop_table('migrations');
		$this->dbforge->drop_table('api_clients');
	}
	
	// --------------------------------------------------------------------------
}
/* End of file 002_upgrade_2_0.php */
/* Location: ./application/migrations/002_upgrade_2_0.php */