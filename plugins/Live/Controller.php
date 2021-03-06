<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: Controller.php 1420 2009-08-22 13:23:16Z vipsoft $
 * 
 * @category Piwik_Plugins
 * @package Piwik_Live
 */

/**
 *
 * @package Piwik_Live
 */
class Piwik_Live_Controller extends Piwik_Controller
{
	function widget()
	{
		$view = Piwik_View::factory('index');		
		$this->setGeneralVariablesView($view);
		$view->visitors = $this->getLastVisits($fetch = true);
		echo $view->render();
	}
	
	function getLastVisits($fetch = false)
	{
		$idSite = Piwik_Common::getRequestVar('idSite', null, 'int');
		$minIdVisit = Piwik_Common::getRequestVar('minIdVisit', 0, 'int');
		$limit = 10;
		$api = new Piwik_API_Request("method=Live.getLastVisits&idSite=$idSite&limit=$limit&minIdVisit=$minIdVisit&format=php&serialize=0&disable_generic_filters=1");
		
		$view = Piwik_View::factory('lastVisits');
		$visitors = $api->process();
		if($minIdVisit == 0)
		{
			$visitors = array_slice($visitors, 3);
		}
		$view->visitors = $visitors;
		$rendered = $view->render($fetch);
		
		if($fetch)
		{
			return $rendered;
		}
		echo $rendered;
	}
	
	function index()
	{
		$view = Piwik_View::factory('structure');
		$this->setGeneralVariablesView($view);
		$view->visitors = $this->getLastVisits($fetch = true);
		echo $view->render();
	}
}
