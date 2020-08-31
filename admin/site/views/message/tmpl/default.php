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
  use Joomla\CMS\Date\Date;
  use Joomla\CMS\Html\HTMLHelper;
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;

  HTMLHelper::_('jquery.framework');
HTMLHelper::_('behavior.formvalidator');
  $app = Factory::getApplication();
  $document = Factory::getDocument();
  
    $catid = $app->input->get('catid');
   $input = $app->input;
    $id = $app->input->get('id'); 
	
 BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/models');
 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/tables');
 $mymodel = BaseDatabaseModel::getInstance('Config','DebateModel');
 $row = $mymodel->getItem(1);
 
   $db = Factory::getDbo();
					$post = $input->get('jform', array(), 'post', array());

 
 	 if(!empty($id) && empty($post)){

 
                  $query = $db->getQuery(true);
			         $query->select('threadid')->from($db->quoteName('#__debate') .' As a')
			      ->where($db->quoteName('id').'='.$id);
				 $db->setQuery($query);
				 $res1 = $db->loadObject();
				 $query = $db->getQuery(true);
			   
		
	 }
				 
				     
					 
   $myrules = BaseDatabaseModel::getInstance('Rules','DebateModel');
   $rules = $myrules->getItems();
   $activerules = end($rules); 
			
 $mymodel = BaseDatabaseModel::getInstance('Fonders','DebateModel');
 $fonders = $mymodel->getItems();
 $fondermodel = BaseDatabaseModel::getInstance('Fonder','DebateModel');

						
  $document = Factory::getDocument();
  $user = Factory::getUser();
  
			
					
	 if(!empty($post)){
				 if(!empty($post['threadid'])):
				 $userid = $user->id;
				 $tid = $post['threadid'];
				     $query = $db->getQuery(true);
			         $query->select('*')->from($db->quoteName('#__debate_subscriptions') .' As b')
			      ->where($db->quoteName('userid').'='.$userid);
				 $db->setQuery($query);
				 $r = $db->loadObjectList();
				      if(empty($r)):
					       $query = $db->getQuery(true);
                    $columns = array( 'userid', 'threadid', 'datetime');
                    $values = array($db->quote($userid), $db->quote($tid), $db->quote(date("Y-m-d")));
                    $query->insert($db->quoteName('#__debate_subscriptions'))->columns($db->quoteName($columns))->values(implode(',', $values));
                    $db->setQuery($query);
                    $db->execute();
					else:
					echo "<div class='subs'><span class='icon-warning'></span>You are already subscribed to this message</div>";
					  endif;
				 endif;
	 }
		
  
   if(!empty($this->items)){
 
 	$threadid = $this->items[0]->threadid;
	 
 	$title = $this->items[0]->title;
	
	
		$query = $db->getQuery(true);
		
		
		$query->select('*')->from($db->quoteName('#__categories') . ' AS a')->where($db->quoteName('a.id').'='.$db->quote($catid));		
		$db->setQuery($query);
		$r = $db->loadObjectList();
		$ordering = $this->escape($this->state->get('list.ordering'));
        //$listDirn  = $this->escape($this->state->get('list.direction'));
		
		
			$query = $db->getQuery('true');
	$query->select('*')->from($db->quoteName('#__debate_view_times'))->where('threadid='.$threadid);
	$db->setQuery($query);
	$result = $db->loadObject();
	
	if(!empty($result)):
		$views = $result->views;
		
		$views++;
		$query = $db->getQuery('true');
		
		

$fields = array(
    $db->quoteName('views') . ' = ' . $views
);
		
		$query
         ->update($db->quoteName('#__debate_view_times'))
         ->set($fields)
         ->where('threadid='.$threadid);
		 $db->setQuery($query);
        $db->execute();
	else:
		$views=1;
	  
		$query = $db->getQuery('true');
		$query
         ->insert($db->quoteName('#__debate_view_times'))
         ->columns($db->quoteName('threadid'), $db->quoteName('views'))
         ->values($threadid, $views);
		 $db->setQuery($query);
        $db->execute();

	endif;
	
 
   }		
?>
<?php if(trim($row->forumoffline==='No')): ?>

<?php if(!empty($user->id)): ?>
<?php
$parentarr=[]; 
	$catobj= $this->category;

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

?>
<?php
if($parentarr==null):
$catid = (int) $catid;
?>
<div class='goback'><a href="<?php echo Route::_('index.php?option=com_debate&view=category&id='.$catid); ?>" > Go to Root Categories</a></div>
<?php
 endif;
    if(!empty($this->items)){
$n = count($this->items);

						$recs = $row->get('recnummess');

$totalpages = $n / $recs;

if(!is_int($totalpages)){
	$totalpages=(int)$totalpages;
$totalpages++;
}
 


 ?>
 <style type="text/css"> 
 .resub a:link, .resub a:visited, .debate-message button
.debate-message form input[type="submit"], input[type="text"] {
	 background-color: <?php echo $row->buttbakcolor ?>;
	 font-family: <?php echo $row->fontfamily; ?>;
	 color:#fff;
	 text-align:center;
	 padding:5px;
 }
 
 .debate-message .title{
	 color : <?php echo $row->titlecolor; ?>;
	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->titlefontsize; ?>;



 }
 .updown a:link, .updown a:visited, .debate-message ul li a:link,
 .debate-message ul li a:visited, .fmain a:link, .fmain a:visited
 {
	  
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
 .updown a:hover
 {
	 font-style:italic;
 }
 .postnums, .cattitle, .debate-message .category li
 {
	  color : <?php echo $row->textcolor; ?>;
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
 .message a:link, .message a:visited
 {
	  font-weight:  bold;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
 .pn {float:right}
 

 
</style>
    <div class="resub">
		<a href="<?php echo Route::_('index.php?option=com_debate&view=response&id=0&catid='.$catid.'&threadid='.$threadid.'&userid='.$user->id.'&title='.$title.'&firstid='.$id); ?>" class="btn btn-primary"><?php echo Text::_('COM_DEBATE_RESPONSE'); ?></a>


	<?php
		   if(trim($row->allowsubscriptions)==='Yes'):
		   ?>
		   		<div class="subscriptions">
				<form action="<?php echo Route::_('index.php?option=com_debate&view=message&id='.$id.'&catid='.$catid); ?>" method="post" name="subscribeadminForm" id="subscribeadminForm" class="form-validate">
                <input type="hidden" name="jform[threadid]" value="<?php echo $threadid ;?>" />				
				<input type="submit" class="btn btn-primary" name="submit" value="Subscribe To This Message">				
                 <input type="hidden" name="task" value="" />
	             <?php echo HTMLHelper::_('form.token'); ?>
                </form>
                </div>
<?php endif; ?>
	 </div> 
<div class='maincontainer debate-message'>	 
<div class='title'><?php echo $title; ?></div>
<div class='updown'>
     <a href="#down">Go To Down</a>
	      <a name="up"></a>
						<span style="padding:5px;display:block;" >( For security reasons search is ONLY in contents of messages! )</span>

</div>
	<form action="<?php echo Route::_('index.php?option=com_debate&view=message&id='.$id.'&catid='.$catid); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
	<fieldset class="filters btn-toolbar">

	 	<div class="btn-group">
				<label class="filter-search-lbl element-invisible" for="filter-search"><span class="label label-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span><?php echo Text::_('COM_DEBATE_FILTER_LABEL') . '&#160;'; ?></label>
				<input type="text" title="Separate words with uppercase AND , OR to obtain best result" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox"  title="<?php echo Text::_('COM_DEBATE_FILTER_SEARCH_DESC'); ?>" placeholder="<?php echo Text::_('COM_DEBATE_FILTER_SEARCH_DESC'); ?>" />
				<input type='submit' name='submit' value='Search' />
	    </div>
	</fieldset>

		<div class="postnum"> Posts for this topic:<?php echo count($this->items); ?></div>
		<div class='message'>
		<?php
          if(trim($row->messagereporting)==='Yes'):
		     echo "<a href='mailto:".$row->forumemail."' >Report to Forum</a>";
          endif; 
		?>
		 <a href='window.print()' title='print'><span class="icon-print"></span></a>
		</div>
		<div><a href='mailto:<?php echo $user->email?>'>Email to sender of the topic</a></div>
		<div class='cattitle'>This topic is under category:<?php echo $r[0]->title; ?></div>
		
		   
		   
		   
 		  
	
<ul class="category list-striped list-condensed">	
<?php 
             if(!empty($post['page']))
			 $page = $post['page'];
			 else
				 $page = 1;
			 
			 $start = ($page * $recs) - $recs;
			 $limit = $start + $recs;
			
 for ($i=$start; $i<$limit; $i++) :
if(!empty($this->items[$i])) {
     $value = $this->items[$i];

echo '<li class="messagecontainer">';

echo '<div class="fonder">';
						
					
							if(!empty($this->items[$i]->fonderid)):
							
							  foreach($fonders as $key=>$fval):
							    if($this->items[$i]->fonderid==$fval->userid):
								  $fondername=$fval->name;
								  break;
								endif;
							  endforeach;
							 
							   if(trim($row->viewfonderprofile)==='Yes'):
								 echo "<div class='fonder'><a href='".Route::_('index.php?option=com_debate&view=fonder&id='.$this->items[$i]->userid)."'> This message is edited by:".$fondername."</a></div>";

							   else:
							     echo "This message is edited by :".$fondername;
							   endif;
							endif;
							
					
		echo '</div>';

if($value->userid):
        
		$query = $db->getQuery(true);
		$query->select('*')->from($db->quoteName('#__users') . ' AS a')->where('a.id='.$value->userid);		
		$db->setQuery($query);
		$result1 = $db->loadObjectList();
		$query = $db->getQuery(true);
		$query->select('*')->from($db->quoteName('#__debate') . ' AS b')->where('b.userid='.$value->userid);		
		$db->setQuery($query);
		$result2 = $db->loadObjectList();
		$query = $db->getQuery(true);
		$query->select('*')->from($db->quoteName('#__debate_fonders') . ' AS a')->where('a.userid='.$value->userid);		
		$db->setQuery($query);
		$result3 = $db->loadObject();
		
		$lastvisitDate = Factory::getDate($result1[0]->lastvisitDate);
		
		
		$currentDate = new Date('now -1 hour');
		$created = new Date($value->created);
			

		if($value->fondermessage==='Yes'):
			echo "<div class='fonder'>This message is sent by a fonder of this forum.</div>";

		endif;
		if(!empty($result3)){
			if($value->fondermessage!=='Yes')
				echo "<div>Response from a fonder of this forum</div>";
	    echo "<div class='fonder'><a href='".Route::_('index.php?option=com_debate&view=fonder&id='.$this->items[$i]->userid)."'>".$result3->name."</a></div>";
		}
		
?>
<div class="pn"><?php $no = $i+1;  echo "No.".$no; ?></div>
<div class='message'>User:<?php echo $result1[0]->name; ?> has total <?php echo count($result2); ?> posts.</div>
<?php if(trim($row->showjoindate)=='Yes'):  ?>
<div class='message'>Registeration Date:<?php echo $result1[0]->registerDate; ?></div>
<?php endif;  ?>
<?php if(trim($row->showlastvisitdate)=='Yes'):  ?>
<div class='message'>Date of Last Visit:<?php echo $result1[0]->lastvisitDate; ?></div>
<?php endif;  ?>

<div class='message memail'> <span  class="icon-envelope"></span> Contact <?php echo $result1[0]->name; ?> via email: <?php echo HTMLHelper::_('email.cloak', $result1[0]->email, 1, 'Email Sender', 0) ?>
</div>

<?php

endif;
?>
<?php
if(intval($value->userid)==intval($user->id) && $currentDate<=$created):

?>

<div class='message'>Edit message:

<?php 
	if(preg_match('/&/', $title))
		$title = str_replace('&','And', $title);
	
?>
<a href='<?php echo Route::_('index.php?option=com_debate&view=response&id='.$value->id.'&catid='.$catid.'&threadid='.$value->threadid.'&userid='.$user->id.'&title='.$title.'&firstid='.$id); ?>' title='edit'>
<span class="icon-brush">
</span>
</a>

</div>
<?php endif; ?>
<div class='message'><?php echo $value->message ?></div>
<?php
if(strpos($value->attachment, ',')){
      $f = explode(',', $value->attachment);
  foreach($f as $k=>$v):
 
      
	  		$ext = pathinfo($v, PATHINFO_EXTENSION);
			if($ext == 'jpg' || $ext == 'gif' || $ext == 'png'):
?>
<div><a class='attimg' href='<?php echo Uri::Base().'administrator/components/com_debate/FileAttachments/'.$v; ?>' ><img src='<?php echo Uri::Base().'administrator/components/com_debate/FileAttachments/'.$v; ?>' width='150px' height='121px'/></a></div>
<?php else: ?>
<div><a class='attimg' href='<?php echo Uri::Base().'administrator/components/com_debate/FileAttachments/'.$v ?>'><?php echo $v ?></a></div>
<?php 
endif;

  
  endforeach;
  
  
  
}else{
if(!empty($value->attachment)):	

		$ext = pathinfo($value->attachment, PATHINFO_EXTENSION);
if($ext == 'jpg' || $ext == 'gif' || $ext == 'png'):
?>
<div><a class='attimg' href='<?php echo Uri::Base().'administrator/components/com_debate/FileAttachments/'.$value->attachment; ?>' ><img src='<?php echo Uri::Base().'administrator/components/com_debate/FileAttachments/'.$value->attachment; ?>' width='150px' height='121px'/></a></div>
<?php else: ?>
<div><a class='attimg' href='<?php echo Uri::Base().'administrator/components/com_debate/FileAttachments/'.$value->attachment; ?>'>View Attachment</a></div>
<?php 

endif;

endif;
}

?>

<?php
echo '</li>';
}
endfor;

     echo "<div class='rssfeed'><a href='".Route::_('index.php?option=com_debate&view=message&id='.$id.'&catid='.$catid.'&format=feed&type=rss')."'><img src='".Uri::Base()."components/com_debate/assets/images/rss.jpg' width='55px' height='55px'></a></div>";

?>	
</ul>
        <?php if (!empty($this->items)) : 
			   if($totalpages>1):

		 for($k=1; $k<=$totalpages; $k++):
		 if($k==$page)
			 echo "<span class='btn'>Page:".$k."</span>";
		 else
			 echo '<button type="submit" name="jform[page]" value="' .$k.'" class="btn"> '. $k .'</button>';
		   endfor;
		   endif;
			
		 endif; ?> 
		<input type="hidden" name="task" value="" />
		<?php echo HTMLHelper::_('form.token'); ?>
</form>
<div class='updown'>
     <a href="#up">Go To Up</a>
	      <a name="down"></a>

</div>
</div>
 <div class="resub">
	 <a href="<?php echo Route::_('index.php?option=com_debate&view=response&id=0&catid='.$catid.'&threadid='.$threadid.'&userid='.$user->id.'&title='.$title.'&firstid='.$id); ?>" class="btn btn-primary"><?php echo Text::_('COM_DEBATE_RESPONSE'); ?></a>

</div> 
<?php
	}
	else
	{
		echo "<div>There is no message in this category or the result of your search is quite empty!</div>";
	}

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
			echo "No rules have been set!";
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
		echo 'To take part in forum you have to login first, Go to login page site.';

endif;

else:
	echo "<div class='offline'>".$row->offlinemessage."</div>";
endif;
 ?>
     <div class="fmain">
	 <a href="<?php echo Route::_('index.php?option=com_debate&view=categories'); ?>">Forum Main Page</a>
    </div> 
 <div class="kianwilliam">This extension has been developed by <a href="https://kwproductions121.com">KWProdcutions.Co</a> &copy; Copyright Reserved.</div>

<?php
echo "<script src='".Uri::Base()."administrator/components/com_debate/views/config/submitbutton.js'></script>";

    


        
    
