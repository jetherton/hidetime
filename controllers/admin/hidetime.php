<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SMS Automate Administrative Controller
 *
 * @author	   John Etherton
 * @package	   SMS Automate
 */

class Hidetime_Controller extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->template->this_page = 'settings';

		// If this is not a super-user account, redirect to dashboard
		if(!$this->auth->logged_in('user') && !$this->auth->logged_in('superadmin') && !$this->auth->logged_in('simplegroups'))
		{
			url::redirect('admin/dashboard');
		}
	}
	
	public function hidetime($report_id , $value)
	{
		$this->auto_render = FALSE;
		$this->template = "";
		
		if($value == "true") //hide the time
		{
			$hidetime = ORM::factory("hidetime");
			$hidetime->incident_id = $report_id;
			$hidetime->save();
		}
		else //dont' hide time
		{
			$hidetime = ORM::factory("hidetime")->where("incident_id", $report_id)->delete_all();			
		}
		
	}//end index method
	
}