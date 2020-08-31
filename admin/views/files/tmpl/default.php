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
use Joomla\CMS\Uri\Uri;
HTMLHelper::_('behavior.tooltip');
HTMLHelper::_('behavior.formvalidation');
 
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
<form action="<?php echo Route::_('index.php?option=com_debate&view=files'); ?>" method="post" name="adminForm" id="adminForm">
<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
	<div class="span10" style='float:right;'>
		<label style="font-weight:bold">Search factors:</label>
		<div>
			<input type="text" name="search_title" id="search_title" value="" placeholder="message title" title="<?php echo Text::_('Search in titles...'); ?>" />
			<input type="text" name="search_userid" id="search_userid" value="" placeholder="userid" title="<?php echo Text::_('Search in userids...'); ?>" />
            <button type="submit">
				<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>
			</button>
			<button type="button" onclick="document.id('search_title').value='';document.id('search_userid').value='';this.form.submit();">
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
                    <?php echo HTMLHelper::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
                </th>
                								
               
                <th width="1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                    <?php if ($canOrder && $saveOrder) : ?>
                        <?php echo HTMLHelper::_('grid.order', $this->items, 'filesave.png', 'items.saveorder'); ?>
                    <?php endif; ?>
                </th>
				 <th width="1%">
                    <div class="fileattachments">Attachments</div>
                </th>
                <th width="1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
				<th width="1%">
                    <div class="userids">
					    User ids
					</div>
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
                    foreach ($this->items as $i => $message) :
                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $messageID = $message->id;                        
                        $title = $this->escape($message->title);
														

						
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo HTMLHelper::_('grid.id', $i, $messageID); ?>
                            </td>
							<td style="width:5%; text-align:center">
                                <a href="<?php echo Route::_('index.php?option=com_debate&task=message.edit&id='.(int) $message->id); ?>"><?php echo $title ?></a>
							</td>
							
							<td class="order" style="text-align:center">
                               <?php if ($canChange) : ?>
                               <?php if ($saveOrder) : ?>
                                <?php if ($listDirn == 'asc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($message->ordering == @$this->items[$i - 1]->ordering), 'files.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($message->ordering == @$this->items[$i + 1]->ordering), 'files.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php elseif ($listDirn == 'desc') : ?>
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($message->ordering == @$this->items[$i - 1]->ordering), 'files.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($message->ordering == @$this->items[$i + 1]->ordering), 'files.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                                <?php endif; ?>
                               <?php endif; ?>
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $message->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                             <?php else : ?>
                                <?php echo $message->ordering; ?>
                             <?php endif; ?>
                           </td>
						  	<td align="center">
							
							
								<?php
								//, for multiple attachments
								if(preg_match('/\,/', $message->attachment)){
									$attachments = explode(',', $message->attachment);
									
									foreach($attachments as $k=>$val):
									
										if(strpos($val, 'png') || strpos($val, 'jpg') || strpos($val, 'gif') || strpos($val, 'jpeg')):
										?>

								<a href="<?php echo Uri::Base().'components/com_debate/FileAttachments/'.$val ?>"><img src="<?php echo Uri::Base().'components/com_debate/FileAttachments/'.$val ?>" width="40px" height="40px" /></a>
								<?php else: ?>
								<br />
								<img src="<?php echo Uri::Base()."components/com_debate/assets/images/files.gif"?>"  width="40px" height="40px" /><br />
								<a href="<?php echo Uri::Base().'components/com_debate/FileAttachments/'.$val?>" >
								<?php echo $val; ?></a>
                              <?php 
								endif;
									endforeach;
									
								}
								else{
								if(strpos($message->attachment, 'png') || strpos($message->attachment, 'jpg') || strpos($message->attachment, 'gif') || strpos($message->attachment, 'jpeg')):
								?>
								<a href="<?php echo Uri::Base().'components/com_debate/FileAttachments/'.$message->attachment ?>"><img src="<?php echo Uri::Base().'components/com_debate/FileAttachments/'.$message->attachment ?>" width="40px" height="40px" /></a>
								<?php else: ?>
								<br />
								<img src="<?php echo Uri::Base()."components/com_debate/assets/images/files.gif"?>" width="40px" height="40px" />
								<br />
								<a href="<?php echo Uri::Base().'components/com_debate/FileAttachments/'.$message->attachment?>" >
								<?php echo $message->attachment; ?></a>
                              <?php 
								
							  
							  endif;
							       
								}
								   
								   
								   
								   ?>
                           </td>
						  <td align="center">
                              <?php echo $message->id; ?>
                           </td>
						    <td align="center">
                                 <?php echo $message->userid; ?>
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
