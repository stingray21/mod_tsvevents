<?php 
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

//This is the parameter we get from the xml file
//echo __FILE__.'('.__LINE__.'):<pre>';print_r($params);echo'</pre>';
$timeFrame = $params->get('timeFrame');
$displayMode = $params->get('displayMode');
$link = JURI::Root().'index.php/'.$params->get('link');
//$timezone = (boolean) $params->get('timezone', false); //true: user-time, false:server-time

// get parameter from component menu item
$menuitemid = JRequest::getInt('Itemid');
if ($menuitemid)
{
	$menu = JFactory::getApplication()->getMenu();
	$menuparams = $menu->getParams( $menuitemid );
}
$timezone = (boolean) $menuparams->get('timezone'); //true: user-time, false:server-time

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$events = modTsvEventsHelper::getEvents($timeFrame);

//Returns the path of the layout file
switch ($displayMode)
{
	case 'minimal':
		$layout = 'minimal';
		break;
	case 'normal':
	default:
		$layout = 'default';
		break;
}


require JModuleHelper::getLayoutPath('mod_tsvevents', $params->get('layout', $layout));

