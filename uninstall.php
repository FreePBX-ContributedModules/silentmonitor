<?php

echo "removing featurecode silentmonitor-in..";
$fcc = new featurecode('silentmonitor', 'in');
$fcc->delete();
unset($fcc);
echo "done<br>\n";

echo "removing featurecode silentmonitor-whisper..";
$fcc = new featurecode('silentmonitor', 'whisper');
$fcc->delete();
unset($fcc);
echo "done<br>\n";

echo "removing featurecode silentmonitor-whisperpv..";
$fcc = new featurecode('silentmonitor', 'whisperpv');
$fcc->delete();
unset($fcc);
echo "done<br>\n";

?>

