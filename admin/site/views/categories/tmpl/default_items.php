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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

HTMLHelper::_('bootstrap.tooltip');



$class = ' class="first"';
if ($this->maxLevelcat != 0 && count($this->items[$this->parent->id]) > 0) :

?>
	<?php foreach ($this->items[$this->parent->id] as $id => $item) :	
	
	
	?>
	
		<?php
		if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
		
			if (!isset($this->items[$this->parent->id][$id + 1]))
			{
				$class = ' class="last"';
			}
			?>
			<div <?php echo $class; ?> >
			<?php $class = ''; ?>
				<h3 class="page-header item-title">
				<a href="<?php echo Route::_(DebateHelperRoute::getCategoryRoute($item->id)); ?>">
				

					<?php echo $this->escape($item->title); ?></a>
					<?php 
					//if ($this->params->get('show_cat_items_cat') == 1) :
					?>
						<span class="badge badge-info tip hasTooltip" title="<?php echo HTMLHelper::_('tooltipText', 'COM_DEBATE_NUM_ITEMS'); ?>">
							<?php echo Text::_('COM_DEBATE_NUM_ITEMS'); ?>&nbsp;
							<?php 
							echo $item->numitems;
							
							
							?>
						</span>
					<?php
					//endif; 
					?>
					<?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) : ?>
						<a id="category-btn-<?php echo $item->id; ?>" href="#category-<?php echo $item->id; ?>"
							data-toggle="collapse" data-toggle="button" class="btn btn-mini pull-right"><span class="icon-plus"></span></a>
					<?php endif; ?>
				</h3>
				<?php if ($this->params->get('show_subcat_desc_cat') == 1) : ?>
					<?php if ($item->description) : ?>
						<div class="category-desc">
							<?php echo HTMLHelper::_('content.prepare', $item->description, '', 'com_debate.categories'); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

				<?php if (count($item->getChildren()) > 0 && $this->maxLevelcat > 1) : ?>
					<div class="collapse fade" id="category-<?php echo $item->id; ?>">
					<?php
					$this->items[$item->id] = $item->getChildren();
					$this->parent = $item;
					$this->maxLevelcat--;
					echo $this->loadTemplate('items');
					$this->parent = $item->getParent();
					$this->maxLevelcat++;
					?>
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>
