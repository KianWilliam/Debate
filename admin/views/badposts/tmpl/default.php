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
defined('_JEXEC') or die('Restricted access');  
use Joomla\CMS\Factory; 
use Joomla\CMS\HTML\HTMLHelper; 
use Joomla\CMS\MVC\BaseModel;
use Joomla\CMS\Router\Route;
use Joomla\CMS\language\Text;

HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.modal');
jimport('joomla.application.component.model'); 

		
$user = Factory::getUser();
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
Joomla.submitbutton = function(task)
	{
		if (task == 'badposts.deleteBadUsers') {
			if(confirm("Are you sure to delete these record(s)? the related original messages shall be updated too!")){
					
					Joomla.submitform(task, document.getElementById('adminForm'));

                   return true;
			}
		}
		else
				if (task === 'badpost.edit' || task ==='badposts.publish' || taks==='badposts.unpublish' ) {
										Joomla.submitform(task, document.getElementById('adminForm'));

				}
			else
				return false;
		
		
	}
</script>
<form action="<?php echo Route::_('index.php?option=com_debate&view=badposts'); ?>" method="post" name="adminForm" id="adminForm">

	<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
	<div class="span10" style='float:right;'>
	<div>
	<strong>Important Notice!</strong> Because of the mutual effects of actions between messages/message
	layouts with edited-messages, deprive-users, bad-users layouts and vice and versa, the search in here is designed for one record at a time
	for your own benefit not to make mistake!<strong> For instance in id field, you can not employ 12 AND 10 OR 9, you have to input just 12.</strong>
	The same for other fields.
	</div>
	<label style="font-weight:bold">Search factors:</label>
		<div>
			<input type="text" name="search_messageid" id="search_messageid" value="" placeholder="message id" title="<?php echo Text::_('Search in messageids...'); ?>" />
			<input type="text" name="search_userid" id="search_userid" value="" placeholder="userid" title="<?php echo Text::_('Search in userids...'); ?>" />
			<input type="text" name="search_date" id="search_date" value="" placeholder="Y-m-d" title="<?php echo Text::_('Search in dates...'); ?>" />
			<input type="text" name="search_fonderid" id="search_fonderid" value="" placeholder="fonderid" title="<?php echo Text::_('Search in fonderids...'); ?>" />
		
		<button type="submit">
				<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>
			</button>
			<button type="button" onclick="document.id('search_fonderid').value='';document.id('search_userid').value='';document.id('search_messageid').value='';document.id('search_date').value='';this.form.submit();">
				<?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?>
			</button>
			
		</div>
       
		</div>
    <div id="j-main-container" class="span10">
	<table class="adminlist">
		<thead>
		    <tr>
                <th width="1%" align="left">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
                </th>
                <th width="1%">
					<?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
                								
               
                <th width="1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                    <?php if ($canOrder && $saveOrder) : ?>
                        <?php echo HTMLHelper::_('grid.order', $this->items, 'filesave.png', 'items.saveorder'); ?>
                    <?php endif; ?>
                </th>
                <th width="1%">
				     <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_USERID', 'a.userid', $listDirn, $listOrder); ?>
                </th>
				<th width="1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_FONDERID', 'a.fonderid', $listDirn, $listOrder); ?>
                </th>
				<th width="1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_MESSAGEID', 'a.messageid', $listDirn, $listOrder); ?>
                </th>
				<th width="3%">
                    <div class="reason">Reason</div>
                </th>
				<th width="1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_BADPOST_DATE', 'a.baddate', $listDirn, $listOrder); ?>
                </th>
            </tr>
	    </thead>
		<tfoot>
            <tr>
                <td colspan="10">
                     <?php echo $this->pagination->getListFooter(); ?>
                </td>
            </tr>
        </tfoot>
		<tbody>
			<?php
                    $n = count($this->items);
                    foreach ($this->items as $i => $badpost) :
                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $badpostID = $badpost->id;                        
                        $userid = $this->escape($badpost->userid);
						
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo HTMLHelper::_('grid.id', $i, $badpostID); ?>
                            </td>
							<td style="text-align:center">
                                <a href="<?php echo Route::_('index.php?option=com_debate&task=badpost.edit&id='.(int) $badpost->id); ?>"><?php echo $badpostID ?></a>
								                            
                            </td>
							
							<td class="order" style="text-align:center">
                               <?php if ($canChange) : ?>
                               <?php if ($saveOrder) : ?>
                                <?php if ($listDirn == 'asc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($badpost->ordering == @$this->items[$i - 1]->ordering), 'badposts.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($badpost->ordering == @$this->items[$i + 1]->ordering), 'badposts.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php elseif ($listDirn == 'desc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($badpost->ordering == @$this->items[$i - 1]->ordering), 'badposts.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($badpost->ordering == @$this->items[$i + 1]->ordering), 'badposts.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php endif; ?>
                               <?php endif; ?>
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $badpost->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                             <?php else : ?>
                                <?php echo $badpost->ordering; ?>
                             <?php endif; ?>
                           </td>
						   <td align="center">
                              <?php echo $badpost->userid; ?>
                           </td>
						    <td align="center">
                              <?php 
								  echo $badpost->fonderid; 				
							  ?>
                           </td>
						    <td align="center">
                              <?php 
								  echo $badpost->messageid; 				
							  ?>
                           </td>
						   <td align="center">
                              <?php 
								  echo $badpost->reason; 				
							  ?>
							  <hr />
                           </td>
						    <td align="center">
                              <?php 
								  echo $badpost->baddate; 				
							  ?>
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
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>

</form>
