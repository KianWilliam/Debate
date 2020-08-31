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

$user = JFactory::getUser();
$userId = $user->get('id');

$listOrder = $this->state->get('list.ordering');
$listDirn = $this->state->get('list.direction');
$this->searchterms	= $this->state->get('filter.search');

$canOrder = true; 
$saveOrder = $listOrder == 'a.ordering';
?>

<form action="<?php echo Route::_('index.php?option=com_debate&view=ips'); ?>" method="post" name="adminForm" id="adminForm">

	<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
	<div class="span10" style='float:right;'>
		<div>
			<input type="text" name="search_userid" id="search_userid" placeholder="userid" value="" title="<?php echo Text::_('Search ips by userid.'); ?>" />
			<button type="submit">
				<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>
			</button>
			<button type="button" onclick="document.id('search_userid').value='';this.form.submit();">
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
                <th width="1%" align="left">
					<?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
                </th>
				
				 <th width="1%">
                    <?php echo HTMLHelper::_('grid.sort', 'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
                   
                </th>
                								
                <th width="1%" align="center">
				    <div class="ipaddresses">
					    URLs
					</div>
                </th>
                
				<th width="1%" align="center">
                    <div class="userids">
					    User ids
					</div>
                </th>
				
				<th width="1%" align="center">
                    <div class="time">
					    Time
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
                    foreach ($this->items as $i => $ip) :
                        $ordering = ($listOrder == 'a.ordering');
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $ipID = $ip->id;                        
                        $ipaddress = $this->escape($ip->ipaddress);
						
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo HTMLHelper::_('grid.id', $i, $ipID); ?>
                            </td>
							<td >
								<?php echo $ip->id; ?>

							</td>
							
							<td class="order" style="text-align:center">
                               <?php if ($canChange) : ?>
                               <?php if ($saveOrder) : ?>                                
                                    <span><?php echo $this->pagination->orderUpIcon($i, ($ip->ordering == @$this->items[$i - 1]->ordering), 'ips.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
                                    <span><?php echo $this->pagination->orderDownIcon($i, $n, ($ip->ordering == @$this->items[$i + 1]->ordering), 'ips.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
                               <?php endif; ?>
                               <?php $disabled = $saveOrder ? '' : 'disabled="disabled"'; ?>
                                <input  type="text" name="order[]" size="5" value="<?php echo $ip->ordering; ?>" <?php echo $disabled ?> class="text-area-order" />
                             <?php else : ?>
                                <?php echo $ip->ordering; ?>
                             <?php endif; ?>
                           </td>
						  	
						  <td align="center">
							  <?php echo $ipaddress; ?>
                           </td>
						    <td align="center">
                                 <?php echo $ip->userid; ?>
                           </td>
						    <td align="center">
                                 <?php echo $ip->datetime; ?>
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
