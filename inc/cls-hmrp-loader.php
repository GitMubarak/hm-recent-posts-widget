<?php
/**
 * General action, hooks loader
*/
class Hmrpw_Loader {

	protected $hmrpw_actions;
	protected $hmrpw_filters;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->hmrpw_actions = array();
		$this->hmrpw_filters = array();
	}

	function add_action( $hook, $component, $callback ){
		$this->hmrpw_actions = $this->add( $this->hmrpw_actions, $hook, $component, $callback );
	}

	function add_filter( $hook, $component, $callback ){
		$this->hmrpw_filters = $this->add( $this->hmrpw_filters, $hook, $component, $callback );
	}

	private function add( $hooks, $hook, $component, $callback ){
		$hooks[] = array( 'hook' => $hook, 'component' => $component, 'callback' => $callback );
		return $hooks;
	}

	public function hmrpw_run(){
		foreach( $this->hmrpw_filters as $hook ){
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
		foreach( $this->hmrpw_actions as $hook ){
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}
}
?>