<?php
/**
 * @package   admintools
 * @copyright Copyright (c)2010-2020 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

namespace Akeeba\AdminTools\Admin\View\WebConfigMaker;

defined('_JEXEC') or die;

use Akeeba\AdminTools\Admin\Helper\ServerTechnology;
use Akeeba\AdminTools\Admin\Model\WebConfigMaker;
use FOF30\View\DataView\Html as BaseView;

class Html extends BaseView
{
	/**
	 * web.config contents for preview
	 *
	 * @var  string
	 */
	public $webConfig;

	/**
	 * The web.config Maker configuration
	 *
	 * @var  array
	 */
	public $wcconfig;

	/**
	 * Is this supported? 0 No, 1 Yes, 2 Maybe
	 *
	 * @var  int
	 */
	public $isSupported;

	/**
	 * Should I enable www and non-www redirects, based on the value of $live_site?
	 *
	 * @var bool
	 */
	public $enableRedirects;

	protected function onBeforePreview()
	{
		/** @var WebConfigMaker $model */
		$model           = $this->getModel();
		$this->webConfig = $model->makeConfigFile();
		$this->setLayout('plain');
	}

	protected function onBeforeMain()
	{
		/** @var WebConfigMaker $model */
		$model                 = $this->getModel();
		$this->wcconfig        = $model->loadConfiguration();
		$this->isSupported     = ServerTechnology::isWebConfigSupported();
		$this->enableRedirects = $model->enableRedirects();
	}
}
