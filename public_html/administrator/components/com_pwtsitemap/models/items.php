<?php
/**
 * @package    Pwtsitemap
 *
 * @author     Perfect Web Team <extensions@perfectwebteam.com>
 * @copyright  Copyright (C) 2016 - 2017 Perfect Web Team. All rights reserved.
 * @license    GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link       https://extensions.perfectwebteam.com
 */

defined('_JEXEC') or die;

require_once JPATH_ADMINISTRATOR . '/components/com_menus/models/items.php';

/**
 * PWT Sitemap items model
 *
 * @since   1.0.0
 */
class PwtSitemapModelItems extends MenusModelItems
{
	/**
	 * Get all available menu items
	 *
	 * @return  stdClass
	 *
	 * @since   1.0.0
	 */
	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as $i => $item)
		{
			$item->params = new Joomla\Registry\Registry(json_decode($item->params));

			// Unset filtered items with no childs or disable the parameters if it has a child
			if (!PwtSitemapHelper::filterMenuType($item->type) && $item->lft + 1 == $item->rgt)
			{
				unset($items[$i]);
			}
			elseif (!PwtSitemapHelper::filterMenuType($item->type))
			{
				$item->params->set('addtohtmlsitemap', 'disabled');
				$item->params->set('addtoxmlsitemap', 'disabled');
			}
		}

		return $items;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * @param   string  $ordering
	 * @param   string  $direction
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	protected function populateState($ordering = 'a.lft', $direction = 'asc')
	{
		parent::populateState($ordering, $direction);
	}
}