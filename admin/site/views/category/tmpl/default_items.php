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
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
$input = Factory::getApplication()->input;
 $user = Factory::getUser();

$catid = $input->get('id');

$n = count($this->items);


for($i=0; $i<count($this->items)-1; $i++)
	for($k=$i+1; $k<count($this->items); $k++)
	{
		
		if(strtotime($this->items[$i][1]->created)<strtotime($this->items[$k][1]->created))
		{

			 $obj = $this->items[$i];
			 $this->items[$i] = $this->items[$k];
			 $this->items[$k] = $obj;
		}
	}



BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/models');
 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/tables');

 $mymodel = BaseDatabaseModel::getInstance('Config','DebateModel');
 						$row = $mymodel->getItem(1);
						$recs = $row->get('recnumcat');

$totalpages = $n / $recs;


if(!is_int($totalpages)){
	$totalpages=(int)$totalpages;
$totalpages++;
}
 
		$post = $input->get('jform', array(), 'post', array());


$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));


		
 $mymodel = BaseDatabaseModel::getInstance('Fonders','DebateModel');
 $fonders = $mymodel->getItems();

$db = Factory::getDbo();
			$query = $db->getQuery(true);
			$query->select('a.title')->from($db->quoteName('#__debate') .' As a')
			      ->where($db->quoteName('catid').'='.$catid)
                  ->where($db->quoteName('created').'='.Date('Y-m-d'));
				    $db->setQuery($query);
				    $result = $db->loadObjectList();
					
					if(!empty($result)):
					   echo "<div class='recentopics'>Recent Topics for this category are:";
					    foreach($result as $key=>$value):
							echo "<span style='border-right:1px solid #000'>".$value->title."</span>";
					    endforeach;
						echo "</div>";
					endif;
					
?>
<div class="butts" style="">
	<a href="<?php echo Route::_('index.php?option=com_debate&view=categories'); ?>" class="btn btn-primary">Main Categories Forum Page</a>
</div> 
<div class="butts" style="">
	<a href="<?php echo Route::_('index.php?option=com_debate&view=response&id=0&catid='.$catid.'&threadid=0&userid='.$user->id); ?>" class="btn btn-primary">New Message</a>

</div> 
<?php if (empty($this->items)) : ?>
	<p><?php echo Text::_('COM_DEBATE_NO_MESSAGES'); ?></p>
<?php else : ?>
 
<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString(), ENT_COMPAT, 'UTF-8'); ?>" method="post" name="adminForm" id="adminForm">
						<span style="padding:5px;display:block;" >( For security reasons search is ONLY in titles of messages! )</span>

	<?php 
	         if ($this->params->get('filter_field') !== 'hide' || $this->params->get('show_pagination_limit')) : 
			 ?>
	<fieldset class="filters btn-toolbar">
		

			<div class="btn-group">
				<label class="filter-search-lbl element-invisible" for="filter-search"><span class="label label-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span><?php echo Text::_('COM_DEBATE_FILTER_LABEL') . '&#160;'; ?></label>
				<input type="text" title="Separate words with uppercase AND , OR to obtain best results for multiple titles search" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox"   placeholder="<?php echo Text::_('COM_DEBATE_FILTER_SEARCH_DESC'); ?>" />
			    <input type="submit" name="search" value="Search" />
			</div>
		
		
	</fieldset>
	<?php 
	  endif;
	  ?>
		<ul class="category list-striped list-condensed">
			<?php 
			if(!empty($post['page']))
			 $page = $post['page'];
			 else
				 $page = 1;
			 
			 $start = ($page * $recs) - $recs;
			 
			 $limit = $start + $recs;
		      
			
			
			  
			   for ($i=$start; $i<$limit; $i++) : 

			   if(!empty($this->items[$i])):
			
			?>
			<?php if (!empty($this->items[$i][0]->published )) : ?>

				<?php if ($this->items[$i][0]->published == 0) : ?>
					<li class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
				<?php else : ?>
					<li class="cat-list-row<?php echo $i % 2; ?>" >
				<?php endif; ?>
           <?php endif; ?>

				
				<span class="">
					<div class="list-title">
					<?php if(!empty($this->items[$i][0]->id)): ?>
					<?php 
					
			$query = $db->getQuery(true);
			$query->select('name')->from($db->quoteName('#__users') )
			      ->where($db->quoteName('id').'='.$this->items[$i][0]->userid);
				  $db->setQuery($query);
				  $name = $db->loadResult();
				  
				  			$query = $db->getQuery(true);
				    $query->select('views')->from($db->quoteName('#__debate_view_times') .' As a')
			      ->where($db->quoteName('threadid').'='.$db->quote($this->items[$i][0]->threadid));
				 $db->setQuery($query);
				 				 $res = $db->loadObject();
								 
								 $query = $db->getQuery(true);
				    $query->select('id')->from($db->quoteName('#__debate') .' As a')
			      ->where($db->quoteName('threadid').'='.$db->quote($this->items[$i][0]->threadid));
				 $db->setQuery($query);
				 $db->execute();
				 				 $responses = $db->getNumRows();
								 $responses--;
				  
					?>
						<a href="<?php echo Route::_(DebateHelperRoute::getMessageRoute($this->items[$i][0]->id, $this->items[$i][0]->catid)); ?>">
							<?php echo $this->items[$i][0]->title; ?></a> Sent by: <?php echo $name ?> @ <?php echo $this->items[$i][0]->created ?>
								<div><?php if(!empty($res)) echo "<div class='resp'>Viewed ".$res->views." times</div>" ?></div>
							<?php 
							         if($responses>=1)
							         echo "<div class='resp'>There are ".$responses." response(s) in this thread</div>";
								
							?>
                    <?php endif; ?>

						<div class="fonder">
						<?php 
					
								if(!empty($this->items[$i][0]->fonderid)):
							
							  foreach($fonders as $key=>$value):
							    if($this->items[$i][0]->fonderid==$value->userid):
								  $fondername=$value->name;
								  break;
								endif;
							  endforeach;							  
							   if(trim($row->viewfonderprofile)==='Yes'):
                					echo "<div class='fonder'><a href='".Route::_('index.php?option=com_debate&view=fonder&id='.$this->items[$i][0]->fonderid)."'> This message is edited by:".$fondername."</a></div><br />";
							   else:
							     echo "<div class='fonder'>This message is edited by :".$fondername."</div>";
							   endif;
							endif;
							if(!empty($this->items[$i][0]->fondermessage)):
							if($this->items[$i][0]->fondermessage==='Yes'):
								echo "<div class='fonder'>This message is sent by a fonder of this forum.</div>";
							endif;
							endif;
							
						?>
						</div>
					</div>
				</span>
				<?php 
				
				
				
				?>

				<?php if ($this->items[$i][0]->published == 0) { ?>
					<span class="label label-warning" style='margin-left:5px;'><?php echo Text::_('JUNPUBLISHED'); ?></span>
				<?php }

				?>
				

				
				
				</li>
				<li>
				
				<?php 
					if(empty($_POST["filter-search"])):
				if($this->items[$i][0]->id!=$this->items[$i][1]->id):
			    $query = $db->getQuery(true);
			    $query->select('b.name, b.email')->from($db->quoteName('#__users') .' As b')
				 ->where($db->quoteName('id').'='.$db->quote($this->items[$i][1]->userid));				  

				 $db->setQuery($query);
				 $result = $db->loadObjectList();				 
				echo '<div class="lastresponse">Last response @ '.$this->items[$i][1]->created. ' By <a href=mailto:"'.$result[0]->email.'">'.$result[0]->name.'</a></div>';
				else:
				if(!empty($this->items[$i][0]->title))
				echo '<div class="lastresponse">No response for this title yet!</div>';
				endif;
					else:
			
			    	 $query = $db->getQuery(true);
				   $query->select('*')->from($db->quoteName('#__debate') .' As a')
			      ->where($db->quoteName('threadid').'='.$db->quote($this->items[$i][0]->threadid));
			      $db->setQuery($query);
			      $results = $db->loadObjectList();
			      
			      if(count($results)>1){
			      $userid = $results[count($results)-1]->userid;
			      
			     	$query = $db->getQuery(true);
			$query->select('*')->from($db->quoteName('#__users') )
			      ->where($db->quoteName('id').'='.$db->quote($userid));
				  $db->setQuery($query);
				  $r = $db->loadObject();
				 
				  	echo '<div class="lastresponse">Last response @ '.$results[count($results)-1]->created. ' By <a href=mailto:"'.$r->email.'">'.$r->name.'</a></div>';
			      }
			      else
			      {
			          	echo '<div class="lastresponse">No response for this title yet!</div>';
			      }
			      
			      
		
			    endif;
			
				?>
				</li>
			<?php 
			endif;
			      endfor;
				  
				  
				  ?>
		</ul>

		<?php 
	   if($totalpages>1):
	   
		   for($k=1; $k<=$totalpages; $k++):
		   if($k!=$page){
		     ?>
			 <button type="submit" name="jform[page]" value="<?php echo $k; ?>" class="btn" style="float:left;"><?php echo $k ?></button>
			 <?php 
		   }else{
		   echo "<div class='currentp' style='width:121px;float:left;'>Current Page:".$k."</div>";}
		   endfor;
		  
		   endif;
		   
		?>
	</form>
	<div class="butts" style="">
	<a href="<?php echo Route::_('index.php?option=com_debate&view=response&id=0&catid='.$catid.'&threadid=0&userid='.$user->id); ?>" class="btn btn-primary">New Message</a>
     </div> 
<?php 
endif; 

