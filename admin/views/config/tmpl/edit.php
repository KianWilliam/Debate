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

?>
<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'config.cancel' || document.formvalidator.isValid(document.id('config-form'))) {
			Joomla.submitform(task, document.getElementById('config-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('COM_DEBATE_VALIDATION_FORM_FAILED'));?>');
		}
	}
	
</script>
<style type="text/css">

</style>
 <div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
<form action="<?php echo Route::_('index.php?option=com_debate&view=config&layout=edit'); ?>" method="post" name="adminForm" id="config-form" class="form-validate" style="display:grid; width:100%">
              
			   <div class="width-60 fltlft" style="width:100%;">
					  <?php
				   $fieldSets = $this->form->getFieldsets();
                       foreach ($fieldSets as $name => $fieldSet) :
	                          if (isset($fieldSet->description) && trim($fieldSet->description)) :
		                              echo '<p class="tip">'.$this->escape(JText::_($fieldSet->description)).'</p>';
	                           endif;
	           ?>
	
	                             <fieldset class="panelform">
		                             <ul class="adminformlist" style="margin-left:auto; margin-right:auto; width:25%; list-style-type:none;">
		                                 <?php foreach ($this->form->getFieldset($name) as $field) : ?>
										 <?php 
										 
										 ?>
										 <?php if($field->getAttribute('type')!=="hidden"): ?>
			                                <li><?php echo $field->label; ?>
			                                <?php echo $field->input; ?></li>
											<?php else: ?>
											<?php  echo $field->input; ?>
											<?php endif; ?>
		                                  <?php endforeach; ?>
		                             </ul>
	                            </fieldset>
                     <?php endforeach; ?>
	                   
			   <input type="hidden" name="task" value="" />
	          <?php echo HTMLHelper::_('form.token'); ?>	
		   				
			   </div>			  
</form>
<?php
$add = "
jQuery(document).ready(function(){
	

	jQuery('#config-form div').children().css({float:'left' , marginLeft:'65px', width:'30%'});
});
";
$document->addScriptDeclaration($add);

