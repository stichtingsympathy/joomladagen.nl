<?php
defined('_JEXEC') or die;

function modChrome_tpl($module, &$params, &$attribs)
{

	$moduleTag = $params->get('module_tag', 'div');
	$headerTag = htmlspecialchars($params->get('header_tag', 'h3'));
	$moduleClass = '';
	$moduleClassSfx = htmlspecialchars($params->get('moduleclass_sfx', ''));

	if ( isset($attribs['class'])) {
		$moduleClass = $attribs['class'] . ' ';
	}

	if ($module->content)
	{
		echo '<' . $moduleTag . ' class="' . $moduleClass . $moduleClassSfx . ' module">';

		if ($module->showtitle)
		{
			echo '<div class="module__header"><p class="module__title module__title--' . $headerTag . '">' . $module->title . '</p></div>';
		}

		echo '<div class="module__content">' . $module->content . '</div>';

		echo '</' . $moduleTag . '>';
	}
}
