<?php

defined('_JEXEC') or die;

class PlgContentAghyphenopoly extends JPlugin {

    public function onBeforeRender() {
	$document = JFactory::getDocument();

	$params_array = $this->params->toArray();
	$params_string = "";

	foreach ($params_array as $param_key => $param_value) {
	    if ($param_value != '') {
		if (
			$param_key == 'classname' ||
			$param_key == 'donthyphenateclassname' ||
			$param_key == 'hyphenchar' ||
			$param_key == 'urlhyphenchar' ||
			$param_key == 'intermediatestate' ||
			$param_key == 'storagetype' ||
			$param_key == 'defaultlanguage' ||
			$param_key == 'unhide'
		) {
		    $params_string = $params_string . $param_key . ': \'' . $param_value . '\',';
		} else {
		    $params_string = $params_string . $param_key . ': ' . $param_value . ',';
		}
	    }
	}

	$document->addScript(JURI::root() . 'media/plg_content_aghyphenopoly/js/Hyphenopoly_Loader.js');

	return true;
    }

}
