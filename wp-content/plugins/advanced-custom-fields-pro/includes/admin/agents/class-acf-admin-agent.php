<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('ACF_Admin_Agent') ) :

class ACF_Admin_Agent {
	
	
	/** @var string Agent name */
	var $name = '';
	

	/** @var string Agent title */
	var $title = '';
	
	
	/** @var string Dashicon slug */
	//var $icon = '';
	
	
	/** @var boolean Redirect form to single */
	//var $redirect = false;
	
	
	/**
	*  get_name
	*
	*  This function will return the Agent's name
	*
	*  @date	19/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function get_name() {
		return $this->name;
	}
	
	
	/**
	*  get_title
	*
	*  This function will return the Agent's title
	*
	*  @date	19/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function get_title() {
		return $this->title;
	}
	
	
	/**
	*  get_url
	*
	*  This function will return the Agent's title
	*
	*  @date	19/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function get_url() {
		return acf_get_admin_agent_url( $this->name );
	}
	
	
	/**
	*  is_active
	*
	*  This function will return true if the agent is active
	*
	*  @date	19/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	bool
	*/
	
	function is_active() {
		return acf_maybe_get_GET('agent') === $this->name;
	}
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	27/6/17
	*  @since	5.6.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// initialize
		$this->initialize();
		
	}
	
	
	/**
	*  initialize
	*
	*  This function will initialize the admin agent
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function initialize() {
		
		/* do nothing */
			
	}
	
	
	
	/**
	*  load
	*
	*  This function is called during the admin page load
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function load() {
		
		/* do nothing */
			
	}
	
	
	/**
	*  html
	*
	*  This function will output the metabox HTML
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function html() {
		
		
		
	}
	
	
	/**
	*  submit
	*
	*  This function will run when the agent's form has been submit
	*
	*  @date	10/10/17
	*  @since	5.6.3
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function submit() {
		
		
	}
	
	
}

endif; // class_exists check

?>