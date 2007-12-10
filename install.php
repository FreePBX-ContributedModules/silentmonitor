<?php

global $engineinfo;
$version = $engineinfo['version'];

// voicecall
$fcc = new featurecode('silentmonitor', 'in');
$fcc->setDescription('Silent Monitor');
$fcc->setDefault('*87');
$fcc->update();
unset($fcc);

if (version_compare($version, "1.4", "ge")) {

	$fcc = new featurecode('silentmonitor', 'whisper');
	$fcc->setDescription('Silent Monitor Whisper Mode');
	$fcc->setDefault('*88');
	$fcc->update();
	unset($fcc);

	$fcc = new featurecode('silentmonitor', 'whisperpv');
	$fcc->setDescription('Silent Monitor Private Whisper Mode');
	$fcc->setDefault('*89');
	$fcc->update();
	unset($fcc); 
}
?>

