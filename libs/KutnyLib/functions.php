<?php

function vd($variable, $label = null) {
	if ($label) {
		echo '<div style="color: blue">' . $label . ':</div>';
	}

	echo '<pre>';
	var_dump($variable);
	echo '</pre>';
}

function vdf($var, $label = null) {
	vd($var, $label);

	if (ob_get_level() > 0) {
		ob_flush();
	}

	flush();
}

function vdx($var, $label = null) {
	vd($var, $label);
	exit;
}
