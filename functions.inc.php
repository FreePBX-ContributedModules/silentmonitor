<?php

function silentmonitor_get_config($engine) {
	$modulename = 'silentmonitor';

	// This generates the dialplan
	global $ext;
	switch($engine) {
		case "asterisk":
			if (is_array($featurelist = featurecodes_getModuleFeatures($modulename))) {
			foreach($featurelist as $item) {
				$featurename = $item['featurename'];
				$fname = $modulename.'_'.$featurename;
				if (function_exists($fname)) {
					$fcc = new featurecode($modulename, $featurename);
					$fc = $fcc->getCodeActive();
					unset($fcc);

					if ($fc != '')
						$fname($fc);
					} else {
						$ext->add('supervisors', 'debug', '', new ext_noop($modulename.": No func $fname"));
						var_dump($item);
					}
				}
			}
			break;
	}
}
function silentmonitor_in($c,$mode) {
	global $ext;
	$id = "app-silentmonitor"; // The context to be included

	$ext->add('supervisors', 'h', '', new ext_hangup());
	$ext->addInclude('supervisors', 'from-internal');
	$ext->addInclude('supervisors', $id); // Add the include from from-internal

	$ext->add($id, $c, '', new ext_answer());
	$ext->add($id, $c, 'st', new ext_playback('please-enter-the&&extension')); // $cmd,1,Answer
	
	$ext->add($id, $c, '', new ext_read('extn', 'then-press-pound')); // $cmd,n,Wait(1)
	$ext->add($id, $c, '', new ext_setvar('usr', '${DB(AMPUSER/${extn}/device)}'));
	$ext->add($id, $c, '', new ext_setvar('devicedial', '${DB(DEVICE/${usr}/dial)}'));
	$ext->add($id, $c, '', new ext_gotoif('$["${devicedial}" = "NONE"]', 'nousr'));
	$ext->add($id, $c, '', new ext_playback('monitored'));
	$ext->add($id, $c, '', new ext_chanspy('${devicedial}', 'q'.$mode));
	$ext->add($id, $c, 'nousr', new ext_playback('spy-agent&&T-is-not-available'));
	$ext->add($id, $c, '', new ext_goto('st'));
	
	$c = "_$c.";
	$ext->add($id, $c, '', new ext_answer());
	$ext->add($id, $c, 'st', new ext_setvar('extn', '${EXTEN:3}'));
	$ext->add($id, $c, '', new ext_setvar('usr', '${DB(AMPUSER/${extn}/device)}'));
	$ext->add($id, $c, '', new ext_setvar('devicedial', '${DB(DEVICE/${usr}/dial)}'));
	$ext->add($id, $c, '', new ext_gotoif('$["${devicedial}" = "NONE"]', 'nousr'));
	$ext->add($id, $c, '', new ext_playback('monitored'));
	$ext->add($id, $c, '', new ext_chanspy('${devicedial}', 'q'.$mode));
	$ext->add($id, $c, 'nousr', new ext_playback('spy-agent&&T-is-not-available'));
	$ext->add($id, $c, '', new ext_goto('st'));

	
 }
function silentmonitor_whisper($c) {
	global $ext;

	$id = "app-silentmonitor"; // The context to be included

	$ext->add($id, $c, '', new ext_answer());
	$ext->add($id, $c, 'st', new ext_playback('please-enter-the&&extension')); // $cmd,1,Answer
	$ext->add($id, $c, '', new ext_read('extn', 'then-press-pound')); // $cmd,n,Wait(1)
	$ext->add($id, $c, '', new ext_setvar('usr', '${DB(AMPUSER/${extn}/device)}'));
	$ext->add($id, $c, '', new ext_setvar('devicedial', '${DB(DEVICE/${usr}/dial)}'));
	$ext->add($id, $c, '', new ext_gotoif('$["${devicedial}" = "NONE"]', 'nousr'));
	$ext->add($id, $c, '', new ext_playback('monitored'));
	$ext->add($id, $c, '', new ext_chanspy('${devicedial}', 'qw'));
	$ext->add($id, $c, 'nousr', new ext_playback('spy-agent&&T-is-not-available'));
	$ext->add($id, $c, '', new ext_goto('st'));
        
	$c = "_$c.";
	$ext->add($id, $c, '', new ext_answer());
	$ext->add($id, $c, 'st', new ext_setvar('extn', '${EXTEN:3}'));
	$ext->add($id, $c, '', new ext_setvar('usr', '${DB(AMPUSER/${extn}/device)}'));
	$ext->add($id, $c, '', new ext_setvar('devicedial', '${DB(DEVICE/${usr}/dial)}'));
	$ext->add($id, $c, '', new ext_gotoif('$["${devicedial}" = "NONE"]', 'nousr'));
	$ext->add($id, $c, '', new ext_playback('monitored'));
	$ext->add($id, $c, '', new ext_chanspy('${devicedial}', 'qw'));
	$ext->add($id, $c, 'nousr', new ext_playback('spy-agent&&T-is-not-available'));
	$ext->add($id, $c, '', new ext_goto('st'));
 }

function silentmonitor_whisperpv($c) {
	global $ext;

	$id = "app-silentmonitor";
	$ext->add($id, $c, '', new ext_answer());
	$ext->add($id, $c, 'st', new ext_playback('please-enter-the&&extension')); // $cmd,1,Answer
	$ext->add($id, $c, '', new ext_read('extn', 'then-press-pound')); // $cmd,n,Wait(1)
	$ext->add($id, $c, '', new ext_setvar('usr', '${DB(AMPUSER/${extn}/device)}'));
	$ext->add($id, $c, '', new ext_setvar('devicedial', '${DB(DEVICE/${usr}/dial)}'));
	$ext->add($id, $c, '', new ext_gotoif('$["${devicedial}" = "NONE"]', 'nousr'));
	$ext->add($id, $c, '', new ext_playback('monitored'));
	$ext->add($id, $c, '', new ext_chanspy('${devicedial}', 'qW'));
	$ext->add($id, $c, 'nousr', new ext_playback('spy-agent&&T-is-not-available'));
	$ext->add($id, $c, '', new ext_goto('st'));

	$c = "_$c.";
	$ext->add($id, $c, '', new ext_answer());
	$ext->add($id, $c, 'st', new ext_setvar('extn', '${EXTEN:3}'));
	$ext->add($id, $c, '', new ext_setvar('usr', '${DB(AMPUSER/${extn}/device)}'));
	$ext->add($id, $c, '', new ext_setvar('devicedial', '${DB(DEVICE/${usr}/dial)}'));
	$ext->add($id, $c, '', new ext_gotoif('$["${devicedial}" = "NONE"]', 'nousr'));
	$ext->add($id, $c, '', new ext_playback('monitored'));
	$ext->add($id, $c, '', new ext_chanspy('${devicedial}', 'qW'));
	$ext->add($id, $c, 'nousr', new ext_playback('spy-agent&&T-is-not-available'));
	$ext->add($id, $c, '', new ext_goto('st'));
 }
?>
