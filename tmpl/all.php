<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );


$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_hbsponsor/css/default.css');

//echo "<p>".JText::_('DESC_MODULE')."</p>";

echo "<div class=\"sponsorBox allSponsors\">";

foreach ($sponsors as $sponsor)
{
	echo '<img src="./hbdata/images/sponsors/'.$sponsor->logo.'" alt="'.$sponsor->name.'" />';
}

echo "</div>";