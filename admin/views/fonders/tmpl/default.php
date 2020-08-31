<?php

/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2018-10-13 23:26:33Z $
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
defined('_JEXEC') or die('Restricted access');   
JHTML::_('behavior.tooltip');
JHTML::_('behavior.modal');
jimport('joomla.application.component.model'); 
// JModelLegacy::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/models');
 //JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_categories/tables');

 //$mymodel = JModelLegacy::getInstance('Category','CategoriesModel');
		
$user = JFactory::getUser();
$userId = $user->get('id');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');

$canOrder = true; 
$saveOrder = $listOrder == 'a.ordering';
?>
<script language="javascript" type="text/javascript">
function tableOrdering( order, dir, task )
{
	var form = document.adminForm;

	form.filter_order.value = order;
	form.filter_order_Dir.value = dir;
	document.adminForm.submit( task );
}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_debate&view=fonders'); ?>" method="post" name="adminForm" id="adminForm">

	<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">

	<table class="adminlist">
		<thead>
		    <tr>
                <th width="1%" align="center">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
                </th>
                <th width="1%">				
                    <?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.name', $listDirn, $listOrder); ?>
										
                </th>
                								
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
                </th>
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                    <?php if ($canOrder && $saveOrder) : ?>
                        <?php echo JHtml::_('grid.order', $this->items, 'filesave.png', 'items.saveorder'); ?>
                    <?php endif; ?>
                </th>
                <th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
            </tr>
	    </thead>
		
		<tbody>
			<?php
                    $n = count($this->items);
                    foreach ($this->items as $i => $fonder) :
                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $fonderID = $fonder->id;                        
                        $name = $this->escape($fonder->name);
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left" align="center">
                               <?php echo JHtml::_('grid.id', $i, $fonderID); ?>
                            </td>
							<td style="width:5%; text-align:center">
                                <a href="<?php echo JRoute::_('index.php?option=com_debate&task=fonder.edit&id='.(int) $fonder->id); ?>"><?php echo $name ?></a>
								<p class="smallsub">
								<img src="<?php echo JURI::Base().'components/com_debate/assets/images/avatar/'.$fonder->avatar?>" style="width:65px; height:75px;" /> 
                                </p>
                            </td>
							<td class="center">
                                <?php echo JHtml::_('jgrid.published', $fonder->published, $i, 'fonders.', true, 'cb'); ?>
                            </td>
							<td class="order" style="text-align:center">
                               <?php if ($saveOrder) : ?>
                                <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $fonder->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                             <?php else : ?>
                                <?php echo $fonder->ordering; ?>
                             <?php endif; ?>
                           </td>
						   <td align="center">
                              <?php echo $fonder->id; ?>
                           </td>
					</tr>
					<?php endforeach; ?>
	    </tbody>

	</table>
	</div>
	<div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        <input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>

</form>
