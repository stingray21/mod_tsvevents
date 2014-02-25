<?php
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

//This is the parameter we get from our xml file above
$displayMode = $params->get('displayMode');

// get parameter from component menu item
$menuitemid = JRequest::getInt('Itemid');
if ($menuitemid)
{
	$menu = JFactory::getApplication()->getMenu();
	$menuparams = $menu->getParams( $menuitemid );
}
//$displayMode = $menuparams->get('displayMode');
//print_r($menuparams);

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

//Returns the path of the layout file
switch ($displayMode)
{
	case 'all':
		$layout = 'all';
		break;
	case 'random':
	default:
		$layout = 'default';
		break;
}
require JModuleHelper::getLayoutPath('mod_hbsponsor', $params->get('layout', $layout));

