<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * extends migration to separate out the table
 *
 * @author Mike Funk
 * @email mfunk@christianpublishing.com
 *
 * @file MY_Migration.php
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
	protected $_migration_table = 'migrations';

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
		// Load migration language
		$this->lang->load('migration');

		// Only run this constructor on main library load
		if (get_parent_class($this) !== 'CI_Migration')
		{
			return;
		}

		if (!isset($config['migration_table']) || $config['migration_table'] == '')
		{
			$config['migration_table'] = 'migrations';
		}

		foreach ($config as $key => $val)
		{
			$this->{'_' . $key} = $val;
		}

		// Are they trying to use migrations while it is disabled?
		if ($this->_migration_enabled !== TRUE)
		{
			show_error('Migrations has been loaded but is disabled or set up incorrectly.');
		}

		// If not set, set it
		$this->_migration_path == '' OR $this->_migration_path = APPPATH . 'migrations/';

		// Add trailing slash if not set
		$this->_migration_path = rtrim($this->_migration_path, '/').'/';

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

	// --------------------------------------------------------------------

	/**
	 * Set's the schema to the latest migration
	 *
	 * @access	public
	 * @return	mixed	true if already latest, false if failed, int if upgraded
	 */
	public function latest()
	{
		if ( ! $migrations = $this->find_migrations())
		{
			// fix from incorrect $this->line->lang to $this->lang->line
			$this->_error_string = $this->lang->line('migration_none_found');
			return false;
		}
		
		$last_migration = basename(end($migrations));

		// Calculate the last migration step from existing migration
		// filenames and procceed to the standard version migration
		return $this->version((int) substr($last_migration, 0, 3));
	}

	// --------------------------------------------------------------------------
}

/* End of file MY_Migration.php */
/* Location: ./application/libraries/MY_Migration.php */