<?php
defined('JPATH_BASE') or die;

class PlgAghyphenopolyHelper
{
	public static function prepareLanguages($languages, $fallbacklanguages)
	{
		$require = array();
		if (is_object($languages))
		{
			foreach ($languages as $language)
			{
				$language = new Joomla\Registry\Registry($language);

				if ($language->get('active', 0) 
					&& ($lang = trim($language->get('lang', ''))) 
					&& ($langtext = str_replace(' ', '', $language->get('langtext', ''))))
				{
					$require[$lang] = $langtext;
				}
			}
		}

		if (is_object($fallbacklanguages))
		{
			foreach ($fallbacklanguages as $fallbacklanguage)
			{
				$fallbacklanguage = new Joomla\Registry\Registry($fallbacklanguage);

				if ($fallbacklanguage->get('active', 0) 
					&& ($fallbacktext = str_replace(' ', '', $fallbacklanguage->get('fallbacktext', ''))) 
					&& ($fallbackstring = str_replace(' ', '', $fallbacklanguage->get('fallbackstring', ''))))
				{
					$require[$fallbacktext] = $fallbackstring;
				}
			}
		}
		
		return json_encode($require);
	}

	public static function prepareFallback($fallbacklanguages)
	{
		$fallback = array();

		if (is_object($fallbacklanguages))
		{
			foreach ($fallbacklanguages as $fallbacklanguage)
			{
				$fallbacklanguage = new Joomla\Registry\Registry($fallbacklanguage);

				if ($fallbacklanguage->get('active', 0) 
					&& ($fallbacklang = trim($fallbacklanguage->get('fallbacklang', ''))) 
					&& ($fallbacktext = str_replace(' ', '', $fallbacklanguage->get('fallbacktext', ''))))
				{
					$fallback[$fallbacktext] = $fallbacklang;
				}
			}
		}

		return json_encode($fallback);
	}

	public static function prepareSelectors($selectors)
	{

		$selectorsarray = array();

		if (is_object($selectors))
		{
			foreach ($selectors as $selector)
			{
				$selector = new Joomla\Registry\Registry($selector);

				if ($selector->get('active', 0) 
					&& ($selectorname = trim($selector->get('selectorname', ''))))
				{
					$selectoritemsarray = array();
					$selectoritemsarray['compound'] = $selector->get('compound', "all");
					$selectoritemsarray['hyphen'] = json_decode('"' . $selector->get('hyphen', "\u00AD") . '"');
					$selectoritemsarray['minWordLength'] = $selector->get('minWordLength', 6);
					$selectoritemsarray['leftmin'] = $selector->get('leftmin', 3);
					$selectoritemsarray['rightmin'] = $selector->get('rightmin', 3);
					$selectoritemsarray['orphanControl'] = $selector->get('orphanControl', 1);

					$selectorsarray[$selectorname] = $selectoritemsarray;
				}
			}
		}

		return json_encode($selectorsarray);
	}
	
	public static function prepareExceptions($exceptions)
	{

		$exceptionsarray = array();

		if (is_object($exceptions))
		{
			foreach ($exceptions as $exception)
			{
				$exception = new Joomla\Registry\Registry($exception);

				if ($exception->get('active', 0) 
					&& ($exceptionlang = trim($exception->get('exceptionlang', ''))) 
					&& ($exceptiontext = $exception->get('exceptiontext', '')))
				{
					$exceptionsarray[$exceptionlang] = $exceptiontext;
					
					// I am not happy with this hack
					if ($exceptionlang === "de")
					{
					    $exceptionsarray["de-de"] = $exceptiontext;
					    $exceptionsarray["de-at"] = $exceptiontext;
					    $exceptionsarray["de-ch"] = $exceptiontext;
					}
				}
			}
		}

		return json_encode($exceptionsarray);
	}
}
