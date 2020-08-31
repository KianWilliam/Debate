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
$document = Factory::getDocument();
$user = Factory::getUser();

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
			if (task == 'message.cancel') {
			Joomla.submitform(task, document.getElementById('message-form'));
		}
		else
		if((document.getElementById("jform_fonderid").value==0 && document.getElementById("jform_fonderidea").value!=="no")||(document.getElementById("jform_fonderid").value!=0 && document.getElementById("jform_fonderidea").value==="no"))
		{
			alert("Input your fonder idea And/Or fonderid if you are going to change this message or its situation (edit-badpost-deprive)!");
		}
		else
		if ( document.formvalidator.isValid(document.id('message-form'))) {
			Joomla.submitform(task, document.getElementById('message-form'));
		}
		else {
			alert('<?php echo $this->escape(Text::_('COM_DEBATE_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo Route::_('index.php?option=com_debate&view=message&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="message-form" class="form-validate">
               <div class="fltlft " style="width:40%;">
				    <fieldset class="adminform">
						<legend><?php echo empty($this->item->id) ? Text::_('COM_DEBATE_NEW') : Text::sprintf('COM_DEBATE_MESSAGE_SETTINGS', $this->item->id); ?></legend>
						<ul class="adminformlist" style="list-style:none;">
								<li><?php echo $this->form->getLabel('title'); ?>
				                <?php echo $this->form->getInput('title'); ?></li>
				               				                
				                <li><?php echo $this->form->getLabel('published'); ?>
				                <?php echo $this->form->getInput('published'); ?></li>				             

				                <li><?php echo $this->form->getLabel('id'); ?>
				                  <?php echo $this->form->getInput('id'); ?></li>
								  
								  <li><?php echo $this->form->getLabel('catid'); ?>
				                  <?php echo $this->form->getInput('catid'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('fonderid'); echo "In case you are going to change this item your fonderid(userid) is:".$user->id; ?>
				                  <?php echo $this->form->getInput('fonderid'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('fonderidea'); ?>
				                  <?php echo $this->form->getInput('fonderidea'); ?></li>
								  
								  <li><?php echo $this->form->getLabel('fondermessage'); ?>
				                  <?php echo $this->form->getInput('fondermessage'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('threadid'); ?>
				                  <?php echo $this->form->getInput('threadid'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('userid'); ?>
				                  <?php echo $this->form->getInput('userid'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('created'); ?>
				                  <?php echo $this->form->getInput('created'); ?></li>
								  
								   <li style="height:299px;"><?php echo $this->form->getLabel('message'); ?>
				                  <?php echo $this->form->getInput('message'); ?></li>
								  
								   <li><?php echo $this->form->getLabel('attachment'); ?>
				                  <?php echo $this->form->getInput('attachment'); ?></li>
						</ul>
						
					</fieldset>
			   </div>
			   <div class="width-40 fltrt">
			   <?php
				   $fieldSets = $this->form->getFieldsets('params');
                       foreach ($fieldSets as $name => $fieldSet) :
	                      echo HTMLHelper::_('sliders.panel', Text::_($fieldSet->label), $name.'-params');
	                          if (isset($fieldSet->description) && trim($fieldSet->description)) :
		                              echo '<p class="tip">'.$this->escape(Text::_($fieldSet->description)).'</p>';
	                           endif;
	           ?>
	                             <fieldset class="panelform">
		                             <ul class="adminformlist">
		                                 <?php foreach ($this->form->getFieldset($name) as $field) : ?>
			                                <li><?php echo $field->label; ?>
			                                <?php echo $field->input; ?></li>
		                                  <?php endforeach; ?>
		                             </ul>
	                            </fieldset>
                     <?php endforeach; ?>
			   <input type="hidden" name="task" value="" />
	          <?php echo HTMLHelper::_('form.token'); ?>
			   
			   </div>
			   
</form>
<style>
#jform_message_ifr
{
	height:250px !important;
}
ul li label
{
	width:121px;
}
</style>
