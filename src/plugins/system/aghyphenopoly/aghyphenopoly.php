<?php
/**
 * @package     Joomla.Site
 * @subpackage  pkg_aghyphenopoly
 *
 * @copyright   Copyright (C) 2005 - 2019 Astrid Günther, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later;
 * @link        astrid-guenther.de
 */

defined('_JEXEC') or die;

/**
 * Fields Aggpxtrack Plugin
 *
 * @since  0.0.1
 */
class PlgSystemAghyphenopoly extends JPlugin {

    protected $app;
    protected $execute = 1;

    /**
     * Constructor
     *
     * @param   object  &$subject  The object to observe
     * @param   array   $config    An array that holds the plugin configuration
     *
     * @since   0.0.1
     */
    function __construct(&$subject, $config = array()) {

	parent::__construct($subject, $config);

	if (JFactory::getDocument()->getType() !== 'html' ||
		$this->app->isAdmin() ||
		($this->app->client->robot)) {
	    $this->execute = 0;
	    return;
	}
    }

    /**
     * This event is triggered before the framework creates the Head section of the Document.
     *
     * @return  void
     *
     * @since   0.0.1
     */
    public function onBeforeCompileHead() {
	if (!$this->execute)
	    return;
	
	$file = JUri::root(true) . '/media/plg_system_aghyphenopoly/hyphenopoly/' . 'aghyphenopoly.js';
	JFactory::getDocument()->addScript($file);

	$file = JUri::root(true) . '/media/plg_system_aghyphenopoly/hyphenopoly/' . 'Hyphenopoly_Loader.js';
	JFactory::getDocument()->addScript($file);

	JFactory::getDocument()->addStyleDeclaration('	
	html {
		hyphens: auto;
		-ms-hyphens: auto;
		-moz-hyphens: auto;
		-webkit-hyphens: auto;
	     }'
	);	

	return true;
    }

}
