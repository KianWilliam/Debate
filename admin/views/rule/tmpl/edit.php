<?php

/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2020-01-13 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2017- Kian William Nowrouzian
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of debate.
    debate is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    debate is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with debate.  If not, see <http://www.gnu.org/licenses/>. 
*/


?>
<?php 
defined('_JEXEC') or die;
use Joomla\CMS\Factory; 
use Joomla\CMS\HTML\HTMLHelper; 
use Joomla\CMS\MVC\BaseModel;
use Joomla\CMS\Router\Route;
use Joomla\CMS\language\Text;
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');
$messageID = $this->item->id;
$document = JFactory::getDocument();

?>
<style>
textarea#jform_rules
{
	width:50%;
}
#jform_rules-lbl,
#jform_id-lbl
{
	width:93px;
}
ul
{
	list-style-type:none;
}
</style>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'rule.cancel' || document.formvalidator.isValid(document.id('rule-form'))) {
			Joomla.submitform(task, document.getElementById('rule-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_DEBATE_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<form action="<?php echo Route::_('index.php?option=com_debate&view=rule&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="rule-form" class="form-validate">
               <div class="fltlft">
				    <fieldset class="adminform">
						<legend><?php echo empty($this->item->id) ? Text::_('COM_DEBATE_NEW') : Text::sprintf('COM_DEBATE_RULE_SETTINGS', $this->item->id); ?></legend>

						<ul class="adminformlist">
								  <li><?php echo $this->form->getLabel('id'); ?>
				                  <?php echo $this->form->getInput('id'); ?></li>
								  
								  <li><?php echo $this->form->getLabel('rules'); ?>
				                  <?php echo $this->form->getInput('rules'); ?></li>
						</ul>
						
					</fieldset>
			   </div>                     
			   <input type="hidden" name="task" value="" />
	          <?php echo HTMLHelper::_('form.token'); ?>			   
</form>
