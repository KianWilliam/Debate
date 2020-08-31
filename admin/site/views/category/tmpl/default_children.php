<?php 
/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2020-01-13 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2019- Kian William Nowrouzian
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
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$class = ' class="first"';

?>
<ul>
<?php 
foreach ($this->children[$this->counter]->get('_parent')->get('_children') as $id => $child) : 




	if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) :
	
		$last = $id + 1;
		
	if(count($this->children[$this->counter]->get('_parent')->get('_children'))==$id + 1)
	{
		$class = ' class="last"';
	}
	?>
	<li<?php echo $class; ?>>
		<?php $class = '';  ?>
			<span class="item-title"><a href="<?php echo Route::_(DebateHelperRoute::getCategoryRoute($child->id)); ?>">
				<?php echo $this->escape($child->title); ?></a>
			</span>

			<?php if ($this->params->get('show_subcat_desc') == 1) : ?>
			<?php if ($child->description) : ?>
				<div class="category-desc">
					<?php echo HTMLHelper::_('content.prepare', $child->description, '', 'com_debate.category'); ?>
				</div>
			<?php endif; ?>
            <?php endif; ?>

            <?php if ($this->params->get('show_cat_items') == 1) : ?>
			<div class="newsfeed-count">
				<?php echo Text::_('COM_DEBATE_CAT_NUM').":"; ?>
				<?php 
						echo count($child->getChildren());
						  ?>
						  
			</div>
		<?php endif; ?>
         
			
		</li>
	<?php endif; ?>
	<?php endforeach; ?>
	</ul>


