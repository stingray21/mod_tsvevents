<?php 
//No access
defined( '_JEXEC' ) or die;
/**
 * Helper class for Hello World! module
 * 
 * @package    Joomla.Tutorials
 * @subpackage Modules
 * @link http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
 * @license        GNU/GPL, see LICENSE.php
 * mod_helloworld is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
class modTsvEventsHelper
{
    
    public static function getEvents($option = 'future')
    {
        // getting further Information of the team
        //$db = JFactory::getDBO();
		$db = self::getExternalDB();
        $query = $db->getQuery(true);
        $query->select('*, IF(datum < NOW(),1,0) as vorbei');
        $query->from($db->qn('tsv_events'));
		$query->where($db->qn('published').' = 1'.self::getDepartmentWhereClause()
				.self::getTimeframeWhereClause());
		$query->order($db->qn('datum'), $db->qn('zeit'));
		//echo __FILE__.'('.__LINE__.'):<pre>'.$query.'</pre>';
        $db->setQuery($query);
        $events = $db->loadObjectList();
		//echo __FILE__.'('.__LINE__.'):<pre>'; print_r($events); echo '</pre>';
        //display and convert to HTML when SQL error
        if (is_null($posts=$db->loadRowList())) 
        {
            $jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
            return;
        }
		return $events;
    }
    
	private static function getExternalDB() 
	{
		$comParams = JComponentHelper::getParams('com_tsvevents');
		// External database info
		$option = array(); //prevent problems

		$option['driver']   = 'mysql';            // Database driver name
		$option['host']     = $comParams->get('host', 'localhost');    // Database host name
		$option['user']     = $comParams->get('user', 'root');       // User for database authentication
		$option['password'] = $comParams->get('password', '');;   // Password for database authentication
		$option['database'] = $comParams->get('database', '');      // Database name
		$option['prefix']   = '';             // Database prefix (may be empty)

		$dbExt = JDatabaseDriver::getInstance( $option );
		//echo __FILE__.' ('.__LINE__.')<pre>';print_r($dbExt);echo'</pre>';
		return $dbExt;
	}
	
    private static function getDepartmentWhereClause() 
	{
		$db = JFactory::getDBO();
		$comParams = JComponentHelper::getParams('com_tsvevents');
//		echo __FILE__.' ('.__LINE__.')<pre>';print_r($comParams);echo'</pre>';
		$department = $comParams->get('department', 'tsv');  	  
		$option = $comParams->get('option', 'all'); 
		
		$where = '';
		switch ($option) {
			case 'only':
				$where = ' AND '.$db->qn('abteilung').' = '.$db->q($department);
				break;
			case 'onlyplus':
				$where = ' AND '.$db->qn('abteilung').' IN ('.$db->q('tsv').','.$db->q($department).' )';
				break;
			case 'all':
			default:
				break;
		}
		
//		echo __FILE__.' ('.__LINE__.')<pre>';print_r($where);echo'</pre>';
		return $where;
	}
	
	private static function getTimeframeWhereClause() 
	{
		$db = JFactory::getDBO();
		$comParams = JComponentHelper::getParams('com_tsvevents');
		$timeframe = $comParams->get('timeframe', 'future');  
		switch ($timeframe) {
			case 'future':
				$where = ' AND '.$db->qn('datum').' >= DATE(NOW())';
				break;
			case 'futureplus':
				$where = ' AND '.$db->qn('datum').' >= DATE(NOW() - INTERVAL 1 WEEK)';
				break;
			case 'all':
			default:
				$where = '';
				break;
		}
		
		//echo __FILE__.' ('.__LINE__.')<pre>';print_r($where);echo'</pre>';
		return $where;
	}
}














