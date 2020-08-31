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

?>

<form action="<?php echo Route::_('index.php?option=com_debate&view=rules'); ?>" method="post" name="adminForm" id="adminForm">
<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
		<div id="j-main-container" class="span10">

	<table class="adminlist">
		<thead>
		    <tr>
                <th width="1%" align="left">
                    <input type="checkbox" name="checkall-toggle" value="" onclick="Joomla.checkAll(this)" />
                </th>
                <th width="1%">
				    <div class='rules' style="width:242px">[Rules of Conduct in this Forum]</div>
                </th>
                 <th>
					<div class='rules'>Rule Identity Number</div>
				 </th>				
                
            </tr>
	    </thead>
		
		<tbody>
			<?php
			if(!empty($this->items)):
                    $n = count($this->items);
					
                    foreach ($this->items as $i => $rule) :
                        $canCreate = true;
                        $canEdit = true;
                        $canCheckin = true;
                        $canEditOwn = true;
                        $canChange = true;
                        $ruleID = $rule->id;                        
                        $title = $this->escape(substr($rule->rules, 0, 25));
						$title.='...';
            ?>
					<tr class="row<?php echo $i % 2; ?>">
							<td class="left">
                               <?php echo HTMLHelper::_('grid.id', $i, $ruleID); ?>
                            </td>
							<td style="width:5%; text-align:center">
                                <a href="<?php echo Route::_('index.php?option=com_debate&task=rule.edit&id='.(int) $rule->id); ?>"><?php echo $title ?></a>
								
                            </td>
							
						   <td align="center">
                              <?php echo $rule->id; ?>
                           </td>
					</tr>
					<?php 
					    endforeach;
						endif;
						?>
	    </tbody>

	</table>
	</div>
	<div>
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="boxchecked" value="0" />
        
        <?php echo HTMLHelper::_('form.token'); ?>
    </div>

</form>
