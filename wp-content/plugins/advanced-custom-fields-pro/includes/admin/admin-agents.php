<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('acf_admin_agents') ) :

class acf_admin_agents {
	
	
	/** @var array Contains an array of admin agent instances */
	var $agents = array();
	
	
	/** @var string The active agent */
	var $active = '';
	
	
	/**
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// actions
		add_action('admin_menu', array($this, 'admin_menu'));
		
	}
	
	
	/**
	*  register_agent
	*
	*  This function will store a agent agent class
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	string $class
	*  @return	n/a
	*/
	
	function register_agent( $class ) {
		
		$instance = new $class();
		$this->agents[ $instance->name ] = $instance;
		
	}
	
	
	/**
	*  get_agent
	*
	*  This function will return a agent agent class
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	string $name
	*  @return	n/a
	*/
	
	function get_agent( $name ) {
		
		return isset( $this->agents[$name] ) ? $this->agents[$name] : null;
		
	}
	
	
	/**
	*  get_agents
	*
	*  This function will return an array of all agents
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	array
	*/
	
	function get_agents() {
		
		return $this->agents;
		
	}
	
	
	/*
	*  admin_menu
	*
	*  This function will add the ACF menu item to the WP admin
	*
	*  @type	action (admin_menu)
	*  @date	28/09/13
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function admin_menu() {
		
		// bail early if no show_admin
		if( !acf_get_setting('show_admin') ) return;
		
		
		// add page
		$page = add_submenu_page('edit.php?post_type=acf-field-group', __('Agents','acf'), __('Agents','acf'), acf_get_setting('capability'), 'acf-agents', array($this, 'html'));
		
		
		// actions
		add_action('load-' . $page, array($this, 'load'));
		
	}
	
	
	/**
	*  load
	*
	*  description
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function load() {
		
		// disable filters (default to raw data)
		acf_disable_filters();
		
		
		// include agents
		$this->include_agents();
		
		
		// check submit
		$this->check_submit();
		
		
		// load acf scripts
		acf_enqueue_scripts();
		
	}
	
	
	/**
	*  include_agents
	*
	*  description
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function include_agents() {
		
		// include
		acf_include('includes/admin/agents/class-acf-admin-agent.php');
		acf_include('includes/admin/agents/class-acf-admin-agent-export.php');
		acf_include('includes/admin/agents/class-acf-admin-agent-import.php');
		
		
		// action
		do_action('acf/include_admin_agents');
		
	}
	
	
	/**
	*  check_submit
	*
	*  description
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function check_submit() {
		
		// loop
		foreach( $this->get_agents() as $agent ) {
			
			// load
			$agent->load();
			
			
			// submit
			if( acf_verify_nonce($agent->name) ) {
				$agent->submit();
			}
			
		}
		
	}
	
	
	/**
	*  html
	*
	*  description
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function html() {
		
		// vars
		$screen = get_current_screen();
		$active = acf_maybe_get_GET('agent');
		
		
		// view
		$view = array(
			'screen_id'	=> $screen->id,
			'active'	=> $active
		);
		
		
		// register metaboxes
		foreach( $this->get_agents() as $agent ) {
			
			// check active
			if( $active && $active !== $agent->name ) continue;
			
			
			// add metabox
			add_meta_box( 'acf-admin-agent-' . $agent->name, $agent->title, array($this, 'metabox_html'), $screen->id, 'normal', 'default', array('agent' => $agent->name) );
			
		}
		
		
		// view
		acf_get_view( 'html-admin-agents', $view );
		
	}
	
	
	/**
	*  meta_box_html
	*
	*  description
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function metabox_html( $post, $metabox ) {
		
		// vars
		$agent = $this->get_agent($metabox['args']['agent']);
		
		
		?>
		<form method="post">
			<?php $agent->html(); ?>
			<?php acf_nonce_input( $agent->name ); ?>
		</form>
		<?php
		
	}
	
}

// initialize
acf()->admin_agents = new acf_admin_agents();

endif; // class_exists check


/*
*  acf_register_admin_agent
*
*  alias of acf()->admin_agents->register_agent()
*
*  @type	function
*  @date	31/5/17
*  @since	5.6.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_register_admin_agent( $class ) {
	
	return acf()->admin_agents->register_agent( $class );
	
}


/*
*  acf_get_admin_agents_url
*
*  This function will return the admin URL to the agents page
*
*  @type	function
*  @date	31/5/17
*  @since	5.6.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_get_admin_agents_url() {
	
	return admin_url('edit.php?post_type=acf-field-group&page=acf-agents');
	
}


/*
*  acf_get_admin_agent_url
*
*  This function will return the admin URL to the agents page
*
*  @type	function
*  @date	31/5/17
*  @since	5.6.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_get_admin_agent_url( $agent = '' ) {
	
	return acf_get_admin_agents_url() . '&agent='.$agent;
	
}


?>