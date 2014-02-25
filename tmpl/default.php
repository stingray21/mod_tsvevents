<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );


$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hbsponsor/css/default.css');

//echo "<p>".JText::_('DESC_MODULE')."</p>";

echo "<div class=\"sponsorBox\">";

$randomSponsor = rand(0,count($sponsors)-1);

echo '<img src="./hbdata/images/sponsors/'.$sponsors[$randomSponsor]->logo.'" alt="'.$sponsors[$randomSponsor]->name.'" />';

if (!empty($info)) {
	echo '<p>'.$info.'</p';
}

echo "</div>";