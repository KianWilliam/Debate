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

		
$user = JFactory::getUser();
$userId = $user->get('id');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
//$this->searchterms	= $this->state->get('filter.search');


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
<form action="<?php echo JRoute::_('index.php?option=com_debate&view=deprivelist'); ?>" method="post" name="adminForm" id="adminForm">

	<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
	<div class="span10" style='float:right;'>
	<label style="font-weight:bold">Search factors:</label>
		<div>
			<input type="text" name="search_messageid" id="search_messageid" value="" placeholder="message id" title="<?php echo JText::_('Search in messageids...'); ?>" />
			<input type="text" name="search_userid" id="search_userid" value="" placeholder="userid" title="<?php echo JText::_('Search in userids...'); ?>" />
			<input type="text" name="search_date" id="search_date" value="" placeholder="Y-m-d" title="<?php echo JText::_('Search in dates...'); ?>" />
			<input type="text" name="search_fonderid" id="search_fonderid" value="" placeholder="fonderid" title="<?php echo JText::_('Search in fonderids...'); ?>" />
		
		<button type="submit">
				<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
			</button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();">
				<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
			</button>
		</div>
		<div>
			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value="">
					<?php echo JText::_('JOPTION_SELECT_PUBLISHED');?>
				</option>
				<?php
	             $p = array(0 => 'Not_Published', 1 => 'Published');	
	             $options = array();	
	             foreach($p as $key=>$value) :		
		                 $options[] = JHTML::_('select.option', $key, $value);
	            endforeach;	
	            echo JHTML::_('select.options', $options,  'value', 'text', $this->state->get('filter.published'), true);	
				?>
			</select>
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
					<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>

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
				    <?php echo JHtml::_('grid.sort', 'JGLOBAL_USERID', 'a.userid', $listDirn, $listOrder); ?>

                </th>
				<th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_FONDERID', 'a.fonderid', $listDirn, $listOrder); ?>
                </th>
				<th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_MESSAGEID', 'a.messageid', $listDirn, $listOrder); ?>
                </th>
				<th width="1%">
                    <div class="reason">Reason</div>
                </th>
				<th width="1%">
                    <?php echo JHtml::_('grid.sort', 'JGRID_HEADING_DEPRIVE_DATE', 'a.deprivedate', $listDirn, $listOrder); ?>
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
                    foreach ($this->items as $i => $depriveuser) :
                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $depriveuserID = $depriveuser->id;                        
                        $userid = $this->escape($depriveuser->userid);
						
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo JHtml::_('grid.id', $i, $depriveuserID); ?>
                            </td>
							<td style="width:5%; text-align:center">
                                <a href="<?php echo JRoute::_('index.php?option=com_debate&task=deprivelistuser.edit&id='.(int) $depriveuser->id); ?>"><?php echo $userid ?></a>
								                            
                            </td>
							<td class="center">
                                <?php echo JHtml::_('jgrid.published', $depriveuser->published, $i, 'deprivelist.', true, 'cb'); ?>
                            </td>
							<td class="order" style="text-align:center">
                               <?php if ($canChange) : ?>
                               <?php if ($saveOrder) : ?>
                                <?php if ($listDirn == 'asc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($depriveuser->ordering == @$this->items[$i - 1]->ordering), 'deprivelist.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($depriveuser->ordering == @$this->items[$i + 1]->ordering), 'deprivelist.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php elseif ($listDirn == 'desc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($depriveuser->ordering == @$this->items[$i - 1]->ordering), 'deprivelist.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($depriveuser->ordering == @$this->items[$i + 1]->ordering), 'deprivelist.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php endif; ?>
                               <?php endif; ?>
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $depriveuser->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                             <?php else : ?>
                                <?php echo $depriveuser->ordering; ?>
                             <?php endif; ?>
                           </td>
						   <td align="center">
                              <?php echo $depriveuser->id; ?>
                           </td>
						    <td align="center">
                              <?php 
								  echo $depriveuser->fonderid; 				
							  ?>
                           </td>
						    <td align="center">
                              <?php 
								  echo $depriveuser->messageid; 				
							  ?>
                           </td>
						    <td align="center">
                              <?php 
								  echo $depriveuser->reason; 				
							  ?>
                           </td>
						    <td align="center">
                              <?php 
								  echo $depriveuser->deprivedate; 				
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
        <?php echo JHtml::_('form.token'); ?>
    </div>

</form>
