<?php
/**
 * @package   AdminTools
 * @copyright Copyright (c)2010-2018 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\Engine\Filter;

// Protection against direct access
defined('AKEEBAENGINE') or die();

use Akeeba\Engine\Factory;
use Akeeba\Engine\Platform;
use FOF30\Container\Container;

/**
 * Subdirectories exclusion filter. Excludes temporary, cache and backup output
 * directories' contents from being backed up.
 */
class Joomlaskipdirs extends Base
{
	public function __construct()
	{
		$this->object      = 'dir';
		$this->subtype     = 'children';
		$this->method      = 'direct';
		$this->filter_name = 'Joomlaskipdirs';

		// We take advantage of the filter class magic to inject our custom filters
		$configuration = Factory::getConfiguration();
		$container     = Container::getInstance('com_admintools');
		$jreg          = $container->platform->getConfig();

		$tmpdir  = $jreg->get('tmp_path');
		$logsdir = $jreg->get('log_path');

		// Get the site's root
		if ($configuration->get('akeeba.platform.override_root', 0))
		{
			$root = $configuration->get('akeeba.platform.newroot', '[SITEROOT]');
		}
		else
		{
			$root = '[SITEROOT]';
		}

		$this->filter_data[$root] = [
			// Output & temp directory of the component
			$this->treatDirectory($configuration->get('akeeba.basic.output_directory')),
			// Joomla! temporary directory
			$this->treatDirectory($tmpdir),
			// Joomla! logs directory
			$this->treatDirectory($logsdir),
			// default temp directory
			'tmp',
			// Joomla! front- and back-end cache, as reported by Joomla!
			$this->treatDirectory(JPATH_CACHE),
			$this->treatDirectory(JPATH_ADMINISTRATOR . '/cache'),
			$this->treatDirectory(JPATH_ROOT . '/cache'),
			// cache directories fallback
			'cache',
			'administrator/cache',
			// This is not needed except on sites running SVN or beta releases
			$this->treatDirectory(JPATH_ROOT . '/installation'),
			// ...and the fallback
			'installation',
			// Joomla! front- and back-end cache, as calculated by us (redundancy, for funky server setups)
			$this->treatDirectory(Platform::getInstance()->get_site_root() . '/cache'),
			$this->treatDirectory(Platform::getInstance()->get_site_root() . '/administrator/cache'),
			// MyBlog's cache
			$this->treatDirectory(Platform::getInstance()->get_site_root() . '/components/libraries/cmslib/cache'),
			// ...and fallback
			'components/libraries/cmslib/cache',
			// The logs and log directories, hardcoded
			'logs',
			'log',
		];

		parent::__construct();
	}
}
