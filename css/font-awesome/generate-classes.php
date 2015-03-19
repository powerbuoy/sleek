<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

header('Content-type: text/plain');

$vars = file('fa-variables.scss');

foreach ($vars as $var) {
	preg_match('/\$fa\-var\-(.*?): (.*?);/', $var, $matches);
	echo ".icon-{$matches[1]}:before, .icon-{$matches[1]}.after:after {content: {$matches[2]}}\n";
}
