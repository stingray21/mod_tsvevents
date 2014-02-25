<?php
//No access
defined( '_JEXEC' ) or die;

//Add database instance
$db = JFactory::getDBO();
$jAp = JFactory::getApplication();


// getting training information
$query = $db->getQuery(true);
//$query->select('*');
$query->select('*');
$query->from($db->qn('hb_sponsor'));
//$query->where($db->qn('sponsorID').' = '.$db->q($selectedSponsors));
$db->setQuery($query);
$sponsors = $db->loadObjectList ();
//echo "Sponsors<pre>"; print_r($sponsors); echo "</pre>";


//display and convert to HTML when SQL error
if (is_null($posts=$db->loadRowList()))
{
	$jAp->enqueueMessage(nl2br($db->getErrorMsg()),'error');
	return;
}

