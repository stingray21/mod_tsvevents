<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );


JHtml::stylesheet('mod_tsvevents/default.css', array(), true);


//echo "<p>".JText::_('DESC_MODULE')."</p>";
?>
<h3 class="page-header"><?php echo JText::_('MOD_TSVEVENTS_HEADLINE_'.strtoupper($timeFrame));?></h3>

<div id="tsvEventBox">
<?php
//echo __FILE__.'('.__LINE__.'):<pre>'; print_r($events); echo '</pre>';
foreach ($events as $event) {
	//echo __FILE__.'('.__LINE__.'):<pre>'; print_r($event); echo '</pre>';
	echo '<a class="tsvevent" href="'.$link.'" alt="'.JText::_('MOD_TSVEVENTS_LINK_GOTO').'">';
	echo '<div class="mod_tsvevent';
	echo ($event->vorbei == 1) ? ' vorbei' : '';
	echo '">';
	echo '<div class="topbanner">';
	echo '<span class="'.$event->abteilung.'">';
	echo JText::_('MOD_TSVEVENTS_DIVISION_'.strtoupper($event->abteilung)).'</span>';
	echo '<span class="date"> '.JHtml::_('date', $event->datum, 'D, d.m.y', $timezone).'</span>';
	if ($event->mit_zeit == 1 &&!is_null($event->zeit)) {
		// TODO show time but with correct time zone (how to save in DB?)
		echo '<span class="time"> '.JText::_('MOD_TSVEVENTS_TIME_SEPARATOR').' ';
			// .JHtml::_('date',, 'H:i', $timezone).JText::_('MOD_TSVEVENTS_TIME_UNIT').'</span>';
		$pattern = '/(\d{2}):(\d{2})(:\d{2})/i';
		$replacement = '$1:$2';
		echo preg_replace($pattern, $replacement, $event->zeit).JText::_('MOD_TSVEVENTS_TIME_UNIT');
		echo '</span>';
	}
	echo '</div>';
	echo '<h4>';
	echo ' '.$event->titel;
	echo '</h4>';
	echo '<p>'.$event->inhalt_kurz.'</p>';
	if (!is_null($event->link) && strcmp($event->link,'')) {
		echo '<p><a href="'.$event->link.'" alt="'.JText::_('MOD_TSVEVENTS_LINK_HOMEPAGE').'" target="_BLANK">'.JText::_('MOD_TSVEVENTS_LINK_HOMEPAGE').'</a></p>';
	}
	echo '</div>';
	echo '</a>';
}
?>
</div>