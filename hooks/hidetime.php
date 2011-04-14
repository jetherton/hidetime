<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Actionable Hook - Load All Events
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author	   Ushahidi Team <team@ushahidi.com> 
 * @package	   Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license	   http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class hidetime {
	
	/**
	 * Registers the main event add method
	 */
	public function __construct()
	{
		$this->post_data = null; //initialize this for later use	
		// Hook into routing
		Event::add('system.pre_controller', array($this, 'add'));
	}
	
	/**
	 * Adds all the events to the main Ushahidi application
	 */
	public function add()
	{
	
		//check if we're doing a reports/edit or reports/view
		if (Router::$controller == 'reports')
		{
			
			
			switch (Router::$method)
			{
				
				// Hook into the Report Add/Edit Form in Admin
				case 'edit':
					//makes sure the user can turn on and off the time
					plugin::add_javascript("hidetime/javascript/hidetime.js");
					//gets the report id, if one exists
					$report_id = "";
					if(isset(Router::$arguments[0]))
					{
						$report_id = Router::$arguments[0];
					}
					//checks if the report ID is valid
					if($report_id != null && $report_id != "")
					{
						//checks to see if that report ID should be hidden
						$hide_time = ORM::factory("hidetime")->where("incident_id", $report_id)->find();
						
						if($hide_time->loaded)
						{
							plugin::add_javascript("hidetime/javascript/hidetime_hide.js");
						}
					}
					//draws the UI
					Event::add('ushahidi_action.report_form_admin_after_time', array($this, '_report_form'));
					
					// hook in to get the data in the the form
					Event::add('ushahidi_action.report_submit_admin', array($this, '_get_post_data'));
					
					// Hook into the report_edit (post_SAVE) event
					Event::add('ushahidi_action.report_edit', array($this, '_incident_save_data'));
				break;
				
				case 'view':
					$report_id = Router::$arguments[0];
					//checks if the report ID is valid
					if($report_id != null && $report_id != "")
					{
						//checks to see if that report ID should be hidden
						$hide_time = ORM::factory("hidetime")->where("incident_id", $report_id)->find();
						
						if($hide_time->loaded)
						{
							plugin::add_javascript("hidetime/javascript/hidetime_view_hide.js");
							Event::add('ushahidi_action.report_meta_after_time', array($this, '_make_date'));
						}
					}
					
				break;
			}
		}
				
	}
	
	
	public function _make_date()
	{
		$report_id = Event::$data;
		$report = ORM::factory("incident")->where("id", $report_id)->find();
		
		$view = View::factory('hidetime/hidetime_maketime');
		$view->date = date('M j Y', strtotime($report->incident_date));
		$view->render(TRUE);
	}
	
	/**
	 * Add Actionable Form input to the Report Submit Form
	 */
	public function _report_form()
	{
		
		// Load the View
		$view = View::factory('hidetime/hidetime_form');
		// Get the ID of the Incident (Report)
		$report_id = Event::$data;
		$hide_time = ORM::factory("hidetime")->where("incident_id", $report_id)->find();
		if($hide_time->loaded)
		{
			$view->hide = true;
		}
		else
		{
			$view->hide = false;
		}
		
		$view->report_id = $report_id;
		$view->render(TRUE);
	}
	
	/**
	* Gets the post data from the form
	*/
	public function _get_post_data()
	{
		$this->post_data = Event::$data;
	}

	public function _incident_save_data()
	{
		$post = $this->post_data;
		$incident = Event::$data;
		$report_id = $incident->id;
			
		if(isset($post['hidetime']))
		{
			$hidetime = ORM::factory("hidetime");
			$hidetime->incident_id = $report_id;
			$hidetime->save();
		}
		else
		{
			$hidetime = ORM::factory("hidetime")->where("incident_id", $report_id)->delete_all();
		}
		
	}

}//end method

new hidetime;