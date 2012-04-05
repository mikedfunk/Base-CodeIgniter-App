<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * MY_Migration
 * 
 * Extends migrations to separate out the table.
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		MY_Migration.php
 * @version		1.0.0
 * @date		03/18/2012
 */

// --------------------------------------------------------------------------

/**
 * MY_Migration class.
 * 
 * @extends CI_Migration
 */
class MY_Migration extends CI_Migration
{	
	// --------------------------------------------------------------------------
	
	/**
	 * _migration_table
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $_migration_table;
	
	// --------------------------------------------------------------------------
	
	/**
	 * _ci
	 * 
	 * @var mixed
	 * @access protected
	 */
	protected $_ci;
	
	// --------------------------------------------------------------------------
	
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @param array $config (default: array())
	 * @return void
	 */
	public function __construct($config = array())
	{
		# Only run this constructor on main library load
		// if (get_parent_class($this) !== FALSE)
		// {
		// 	return;
		// }
		
		if (!isset($config['migration_table']) || $config['migration_table'] == '')
		{
			$config['migration_table'] = 'migrations';
		}

		foreach ($config as $key => $val)
		{
			$this->{'_' . $key} = $val;
		}

		log_message('debug', 'Migrations class initialized');

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE)
		{
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path == '' OR $this->_migration_path = APPPATH . 'migrations/';

		// Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, '/').'/';

		// Load migration language
		$this->lang->load('migration');

		// They'll probably be using dbforge
		$this->load->dbforge();

		// If the migrations table is missing, make it
		if ( ! $this->db->table_exists($this->_migration_table))
		{
			$this->dbforge->add_field(array(
				'version' => array('type' => 'INT', 'constraint' => 3),
			));

			$this->dbforge->create_table($this->_migration_table, TRUE);

			$this->db->insert($this->_migration_table, array('version' => 0));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Retrieves current schema version
	 *
	 * @access	protected
	 * @return	integer	Current Migration
	 */
	protected function _get_version()
	{
		$row = $this->db->get($this->_migration_table)->row();
		return $row ? $row->version : 0;
	}

	// --------------------------------------------------------------------

	/**
	 * Stores the current schema version
	 *
	 * @access	protected
	 * @param $migrations integer	Migration reached
	 * @return	void					Outputs a report of the migration
	 */
	protected function _update_version($migrations)
	{
		return $this->db->update($this->_migration_table, array(
			'version' => $migrations
		));
	}
	
	// --------------------------------------------------------------------------
}

/* End of file MY_Migration.php */
/* Location: ./xpress/application/libraries/MY_Migration.php */