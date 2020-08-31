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
use Joomla\CMS\Router\Route;
use Joomla\CMS\language\Text;
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');

$fonderID = $this->item->id;
$document = Factory::getDocument();
$user = Factory::getUser();
$this->form->setValue('userid', '', $user->id);

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'fonder.cancel' || document.formvalidator.isValid(document.id('fonder-form'))) {
			Joomla.submitform(task, document.getElementById('fonder-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_DEBATE_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>
<form action="<?php echo Route::_('index.php?option=com_debate&view=fonder&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="fonder-form" class="form-validate" enctype="multipart/form-data">
               <div class="width-60 fltlft">
				    <fieldset class="adminform">
						<legend><?php echo empty($this->item->id) ? JText::_('COM_DEBATE_NEW') : JText::sprintf('COM_DEBATE_FONDER_SETTINGS', $this->item->id); ?></legend>
						<ul class="adminformlist">
								<li><?php echo $this->form->getLabel('name'); ?>
				                <?php echo $this->form->getInput('name'); ?></li>
				               				                
				                <li><?php echo $this->form->getLabel('published'); ?>
				                <?php echo $this->form->getInput('published'); ?></li>				             

				                <li><?php echo $this->form->getLabel('id'); ?>
				                  <?php echo $this->form->getInput('id'); ?></li>
								  
								  <li><?php echo $this->form->getLabel('email'); ?>
				                  <?php echo $this->form->getInput('email'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('profession'); ?>
				                  <?php echo $this->form->getInput('profession'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('userid'); echo "(This is your userid, if you want to create a fonder input her/his userid from users menu!)"; ?>
				                  <?php echo $this->form->getInput('userid'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('avatar'); ?>
				                  <?php echo $this->form->getInput('avatar'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('jointime'); ?>
				                  <?php echo $this->form->getInput('jointime'); ?></li>
								  
						</ul>
						
					</fieldset>
			   </div>
			   <div class="width-40 fltrt">
			   
			   <input type="hidden" name="task" value="" />
	          <?php echo HTMLHelper::_('form.token'); ?>
			   
			   </div>
			   
</form>
