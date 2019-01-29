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
 * System Plugin Aghypenopoly Plugin
 *
 * @since  0.0.1
 */
class PlgSystemAghyphenopoly extends JPlugin
{
	/**
	 * Application object.
	 *
	 * @var    JApplicationCms
	 * @since  3.9.0
	 */
	protected $app;

	/**
	 * Database object.
	 *
	 * @var    JDatabaseDriver
	 * @since  3.9.0
	 */
	protected $db;

	/**
	 * Load plugin language file automatically so that it can be used inside component
	 *
	 * @var    boolean
	 * @since  3.9.0
	 */
	protected $autoloadLanguage = true;

	/**
	 * Determines if we need to execute
	 *
	 * @var    boolean
	 * @since  3.9.0
	 */
	protected $execute = 1;

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An array that holds the plugin configuration
	 *
	 * @since   0.0.1
	 */
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);

		if (JFactory::getDocument()->getType() !== 'html' 
			|| $this->app->isAdmin() 
			|| ($this->app->client->robot))
		{
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
	public function onBeforeCompileHead()
	{
		if (!$this->execute)
		{
			return;
		}

		JLoader::register('PlgAghyphenopolyHelper', __DIR__ . '/helper.php');

		$maindir = $this->params->get('maindir', '/media/plg_system_aghyphenopoly/hyphenopoly/');
		$patterndir = $this->params->get('patterndir', '/media/plg_system_aghyphenopoly/hyphenopoly/patterns');

		$defaultLanguage = $this->params->get('defaultLanguage', 'en-gb');
		$dontHyphenateClass = $this->params->get('dontHyphenateClass', 'donthyphenate');

		$normalize = $this->params->get('normalize', false);
		$safeCopy = $this->params->get('safeCopy', true);
		$timeout = $this->params->get('timeout', 1000);

		$require = PlgAghyphenopolyHelper::prepareLanguages($this->params->get('languages', null), $this->params->get('fallbacklanguages', null));

		$fallback = PlgAghyphenopolyHelper::prepareFallback($this->params->get('fallbacklanguages', null));

		$selectors = PlgAghyphenopolyHelper::prepareSelectors($this->params->get('selectors', null));

		$exceptions = PlgAghyphenopolyHelper::prepareSelectors($this->params->get('exceptions', null));

		$js[] = ';var Hyphenopoly = {';
		$js[] = 'require: ';
		$js[] = $require;
		$js[] = ',';
		$js[] = 'fallbacks:';
		$js[] = $fallback;
		$js[] = ',';
		$js[] = 'paths: {';
		$js[] = 'patterndir: "' . $patterndir . '",';
		$js[] = 'maindir: "' . $maindir . '"';
		$js[] = '},';
		$js[] = 'setup: {';
		$js[] = 'defaultLanguage: "' . $defaultLanguage . '",';
		$js[] = 'timeout: ' . $timeout . ',';
		$js[] = 'normalize: ' . $normalize . ',';
		$js[] = 'safeCopy: ' . $safeCopy . ',';
		$js[] = 'dontHyphenateClass: "' . $dontHyphenateClass . '",';
		$js[] = 'exceptions: ';
		$js[] = $exceptions;
		$js[] = ',';
		$js[] = 'selectors: ';
		$js[] = $selectors;
		$js[] = '}';
		$js[] = '};';

		$js = implode('', $js);
		$oldjs = $this->params->get('oldjs', '');
		
		if ($oldjs !== $js)
		{
			$this->params->set('oldjs', $js);

			$db = $this->db;
			$query = $db->getQuery(true)
				->update($db->qn('#__extensions'))
				->set($db->qn('params') . ' = ' . $db->q($this->params->toString('JSON')))
				->where($db->qn('type') . ' = ' . $db->q('plugin'))
				->where($db->qn('folder') . ' = ' . $db->q('system'))
				->where($db->qn('element') . ' = ' . $db->q('aghyphenopoly'));

			try
			{
				// Lock the tables to prevent multiple plugin executions causing a race condition
				$db->lockTable('#__extensions');
			}
			catch (Exception $e)
			{
				// If we can't lock the tables it's too risky to continue execution
				return;
			}

			try
			{
				// Update the plugin parameters
				$result = $db->setQuery($query)->execute();

				// Do I need this $this->clearCacheGroups(array('com_plugins'), array(0, 1));
			}
			catch (Exception $exc)
			{
				// If we failed to execite
				$db->unlockTables();
				$result = false;
			}

			try
			{
				// Unlock the tables after writing
				$db->unlockTables();
			}
			catch (Exception $e)
			{
				// If we can't lock the tables assume we have somehow failed
				$result = false;
			}

			// Abort on failure
			if (!$result)
			{
				return;
			}

			file_put_contents(JPATH_ROOT . '/media/plg_system_aghyphenopoly/hyphenopoly/' . 'aghyphenopoly.js', $js);
		}

		$file = JUri::root(true) . '/media/plg_system_aghyphenopoly/hyphenopoly/' . 'aghyphenopoly.js';
		JFactory::getDocument()->addScript($file);

		$file = JUri::root(true) . '/media/plg_system_aghyphenopoly/hyphenopoly/' . 'Hyphenopoly_Loader.js';
		JFactory::getDocument()->addScript($file);
		
		if ($this->params->get('addCSS', 0))
		{

			JFactory::getDocument()->addStyleDeclaration('	
			  body {
			  hyphens: auto;
			  -ms-hyphens: auto;
			  -moz-hyphens: auto;
			  -webkit-hyphens: auto;
			  }'
			  );
		}

		return true;
	}

}
