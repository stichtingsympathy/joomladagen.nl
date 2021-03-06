<?php
/**
 * @package     Conference
 *
 * @author      Stichting Sympathy <info@stichtingsympathy.nl>
 * @copyright   Copyright (C) 2013 - [year] Stichting Sympathy. All rights reserved.
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * @link        https://stichtingsympathy.nl
 */

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;

defined('_JEXEC') or die;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

$returnUrl = base64_encode(Uri::root() . Route::_('index.php?option=com_conference&view=profile', false));
$params    = JComponentHelper::getParams('com_conference');

Factory::getDocument()->addScriptDeclaration("
        Joomla.submitbutton = function(task)
        {
            var form = document.getElementById('speakerForm');
            
            if (task == 'speaker.cancel' || document.formvalidator.isValid(form))
            {
                    " . $this->form->getField('bio')->save() . "
                    Joomla.submitform(task, form);
            }
        }
");

$this->template = Factory::getApplication()->getTemplate();
require_once JPATH_THEMES . '/' . $this->template . '/html/layouts/render.php';

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

$array = array(
	'title' => Text::_('COM_CONFERENCE_FIELD_SPEAKER')
);

echo JLayouts::render('template.content.header', $array);
?>
<section class="section__wrapper">
    <div class="container">
        <div class="article__item">
            <form name="speakerForm" id="speakerForm" class="form form-horizontal form-validate form__pwt"
                  action="<?php echo Route::_('index.php?option=com_conference&task=speaker.edit&id=' . $this->form->getValue('conference_speaker_id')); ?>"
                  method="post" enctype="multipart/form-data">
				<?php
				echo LayoutHelper::render('toolbar', array(
					'title' => 'COM_CONFERENCE_FIELD_SPEAKER',
					'view'  => 'speaker'
				));
				?>
				<?php echo $this->form->renderField('title'); ?>

				<?php if (!Factory::getUser()->id): ?>
                    <div class="form__group">
                        <div class="form__label">
							<?php echo $this->form->getLabel('email'); ?>
                        </div>
						<?php echo $this->form->getInput('email'); ?>
                        <span class="help-block"><?php echo Text::_('COM_CONFERENCE_FIELD_EMAIL_DESC') ?></span>
                    </div>
				<?php endif; ?>

                <div class="form__group">
                    <div class="form__label">
						<?php echo $this->form->getLabel('speakernotes'); ?>
                    </div>
					<?php echo $this->form->getInput('speakernotes'); ?>
                    <span class="help-block"><?php echo Text::_('COM_CONFERENCE_FIELD_NOTES_DESC') ?></span>
                </div>

                <hr>

				<?php if ($params->get('twitter', 1)): ?>
                    <div class="form__group">
                        <div class="form__label">
							<?php echo $this->form->getLabel('twitter'); ?>
                        </div>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">@</span>
								<?php echo $this->form->getInput('twitter'); ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ($params->get('facebook', 1)): ?>
                    <div class="form__group">
                        <div class="form__label">
							<?php echo $this->form->getLabel('facebook'); ?>
                        </div>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">https://www.facebook.com/</span>
								<?php echo $this->form->getInput('facebook'); ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ($params->get('googleplus', 1)): ?>
                    <div class="form__group">
                        <div class="form__label">
							<?php echo $this->form->getLabel('googleplus'); ?>
                        </div>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">https://plus.google.com/</span>
								<?php echo $this->form->getInput('googleplus'); ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ($params->get('linkedin', 1)): ?>
                    <div class="form__group">
                        <div class="form__label">
							<?php echo $this->form->getLabel('linkedin'); ?>
                        </div>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">https://www.linkedin.com/in/</span>
								<?php echo $this->form->getInput('linkedin'); ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
				<?php if ($params->get('website', 1)): ?>
                    <div class="form__group">
                        <div class="form__label">
							<?php echo $this->form->getLabel('website'); ?>
                        </div>
                        <div class="controls">
                            <div class="input-prepend">
                                <span class="add-on">https://</span>
								<?php echo $this->form->getInput('website'); ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
                <hr>
				<?php echo $this->form->renderField('bio'); ?>
                <hr>
                <div class="form__group">
                    <div class="form__label">
						<?php echo $this->form->getLabel('image'); ?>
                    </div>
                    <div class="controls">
						<?php echo $this->form->getInput('image'); ?>
                        <span class="help-block"><?php echo Text::_('COM_CONFERENCE_FIELD_IMAGE_DESC') ?></span>
                    </div>
                </div>

                <input type="hidden" name="task" value=""/>
                <input type="hidden" name="conference_speaker_id"
                       value="<?php echo $this->form->getValue('conference_speaker_id'); ?>"/>
                <input type="hidden" name="return" value="<?php echo $returnUrl; ?>"/>
				<?php echo $this->form->renderField('conference_speaker_id'); ?>
				<?php echo $this->form->renderField('enabled'); ?>
				<?php echo HTMLHelper::_('form.token'); ?>
            </form>
        </div>
    </div>
</section>