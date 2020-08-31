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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');

HTMLHelper::_('behavior.caption');
HTMLHelper::_('formbehavior.chosen', 'select');
 $user = Factory::getUser();
 $input = Factory::getApplication()->input;

		$search = $input->getString('filter-search');


 
 jimport('joomla.application.component.model'); 
 BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/models');
 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/tables');

 $mymodel = BaseDatabaseModel::getInstance('Config','DebateModel');
 						$row = $mymodel->getItem(1);
						
						 
   $myrules = BaseDatabaseModel::getInstance('Rules','DebateModel');
   $rules = $myrules->getItems();
   $activerules = end($rules);
   


if(!empty($this->params))
   $pageClass = $this->params->get('pageclass_sfx');
if(trim($row->forumoffline==='No')):
if(!empty($user->id)):
?>
<style type="text/css"> 
 .debate-category .butts 
 {
	 text-align:center;
 }
 .debate-category .butts a:link ,
  .debate-category .butts a:visited,
 .debate-category form input,
 .debate-category button,
 .debate-category .currentp{
	 background-color: <?php echo $row->buttbakcolor ?>;
	 font-family: <?php echo $row->fontfamily; ?>;
	 text-align:center;
	 	 	 color : <?php echo $row->textcolor; ?>;

 }
 .debate-category h2, .debate-category .cat-children{
	 color : <?php echo $row->titlecolor; ?>;
	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->titlefontsize+1; ?>px;



 }
 .debate-category .list-title a:link,
  .debate-category .list-title a:visited,
  .debate-category .item-title a:link,
  .debate-category .item-title a:visited
 {
	  color : <?php echo $row->titlecolor; ?>;
	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->titlefontsize; ?>;
 }
  .debate-category .list-title  
 {
	  color : <?php echo $row->titlecolor; ?>;
	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->titlefontsize-1; ?>;
 }
 .debate-category .cat-children .newsfeed-count
 {
	   color : <?php echo $row->titlecolor; ?>;
	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
 .itemnums
 {
	 	 color : <?php echo $row->titlecolor; ?>;
		 		 font-size:	 <?php echo $row->textfontsize; ?>;


 }
 .resp, .fonder a:link, .fonder a:visited, .fonder
 {
	   font-size:<?php echo $row->textfontsize; ?>;

 }
 
 .debate-category .category-desc , .lastresponse
 {
	 	 color : <?php echo $row->textcolor; ?>;
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;


 }
 
</style>
<div class="debate-category<?php if(!empty($this->pageclass_sfx)) echo $this->pageclass_sfx; ?>">
<?php if(!empty($this->params)){ ?>

	<?php if ($this->params->get('show_page_heading')) : ?>
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	<?php endif; ?>
	<?php if ($this->params->get('show_category_title', 1)) : ?>
		<h2>
			<?php echo HTMLHelper::_('content.prepare', $this->category->title, '', 'com_debate.category.title'); ?>
		</h2>
	<?php endif; ?>

	<?php if ($this->params->get('show_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<img src="<?php echo $this->category->getParams()->get('image'); ?>"/>
			<?php endif; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_debate.category'); ?>
			<?php endif; ?>
			<div class="clr"></div>
		</div>
	<?php
	endif;
}
	?>
	<div  class="itemnums">
	
	<div>
	<?php
	$parentarr = [];
	$catobj = $this->category;
	
	while($catobj->getParent()->parent_id):
	$parentarr[]= "<a href='". Route::_(DebateHelperRoute::getCategoryRoute($catobj->getParent()->id))."'>".$catobj->getParent()->title."</a>";
	$catobj = $catobj->getParent();
    endwhile;
	for($i=count($parentarr)-1; $i>=0; $i--):
   if($i==0):
	  echo $parentarr[$i]; 
	else:
		echo $parentarr[$i].'/'; 
	endif;
    endfor;
	if(count($parentarr)!=0)
   echo '/'.$this->category->title;
   ?>
   </div>
<?php

if(empty($search)){
	
 ?>
	<span style="padding-left:5px"> Number of Topics in this category is <?php  echo count(array_filter($this->items)); ?> </span>
	<?php 
}
	else{
				 echo '<span style="padding-left:5px"> Your search returned '. count(array_filter($this->items)) .' results.</span>';
      
	}
?>

	</div>

	<?php 
	echo $this->loadTemplate('items'); 
	

	?>
     
	<?php
    	
		if(!empty($this->children[$this->counter]))
		if ($this->maxLevel != 0 && count($this->children[$this->counter]->get('_parent')->get('_children'))>0) :

	?>
		<div class="cat-children">
			<h3><?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?></h3>
			<?php echo $this->loadTemplate('children'); ?>
		</div>
	<?php endif; ?>
</div>
<?php


 if(trim($row->publishrules)==='Yes'):
  
  ?>
 <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">View Forum Rules</button>


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Rules of This Forum</h4>
      </div>
      <div class="modal-body">
        <p>
		<?php 
		if(!empty($activerules->rules))
		    echo $activerules->rules;
		else
			echo "<div class='category-desc'>No rules have been set!</div>";
		?>
		</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 <?php
   

 endif;
 

   else: 
	echo '<div class="category-desc">To take part in forum you have to login first, Go to login page site.</div>';
  endif;
  
  else:
		echo "<div class='offline'>".$row->offlinemessage."</div>";
  endif;
?>
     <div class="fmp">
	 <a href="<?php echo Route::_('index.php?option=com_debate&view=categories'); ?>">Forum Main Page</a>
    </div> 
	
<div class="kianwilliam">This extension has been developed by <a href="https://kwproductions121.com">KWProdcutions.Co</a> &copy; Copyright Reserved.</div>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  