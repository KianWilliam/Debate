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
use Joomla\CMS\MVC\Model\BaseDatabaseModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Factory;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Uri\Uri;



HTMLHelper::addIncludePath(JPATH_COMPONENT . '/helpers');
HTMLHelper::_('behavior.caption');

 BaseDatabaseModel::addIncludePath(JPATH_SITE . '/components/com_debate/models');
 BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/models');
 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/tables');
 
 $mymodel = BaseDatabaseModel::getInstance('Config','DebateModel');
  $row = $mymodel->getItem(1);
  
   $myrules = BaseDatabaseModel::getInstance('Rules','DebateModel');
   $rules = $myrules->getItems();
   $activerules = end($rules);
   



 $categoriesmodel = BaseDatabaseModel::getInstance('Categories','DebateModel');
 $categoriesitems = $categoriesmodel->getItems();
 
 $categoriesnum = count($categoriesitems); 
  


 
 $fondersmodel = BaseDatabaseModel::getInstance('Fonders','DebateModel');
 $fonders = $fondersmodel->getItems();
 

 $totaltitles = 0;
 $input = JFactory::getApplication()->input;
 $todaynewtitles = 0;
 $i=0;
 foreach($categoriesitems as $key=>$value):
 

 $input->set('catid', $value->id);
 

  $catmodel = BaseDatabaseModel::getInstance('Category','DebateModel');

     $items = $catmodel->getItems(); 


 $this->items[$this->parent->id][$i++]->numitems=count(array_filter($items));

 if(!empty($items)){
 $totaltitles += count(array_filter($items)); 
 
  foreach($items as $k=>$v):
  if($v!==null && count($v)!==0 && !empty($v[0]->created))	  
   
    if($v[0]->created===date('YYYY-mm-dd'))
		$todaynewtitles++;
	
  endforeach;
 }
 endforeach;
 
 
 
Factory::getDocument()->addScriptDeclaration("
jQuery(function($) {
	$('.categories-list').find('[id^=category-btn-]').each(function(index, btn) {
		var btn = $(btn);
		btn.on('click', function() {
			btn.find('span').toggleClass('icon-plus');
			btn.find('span').toggleClass('icon-minus');
		});
	});
});");

$db = Factory::getDbo();
$query = $db->getQuery(true);
$query->select('COUNT(*)');
$query->from($db->quoteName('#__debate'));
$db->setQuery($query);
$totalMessages = $db->loadResult();



 $query = $db->getQuery(true);
 $query->select($db->quoteName('threadid'))->from($db->quoteName('#__debate_thread_id'));
 $db->setQuery($query);
 $result=$db->loadObject();
    if(!empty($result)):
     $totalthreads = $result->threadid;
     $totalanswers = 0;
	 if(!empty($totalthreads))
	 {
       for($i=0; $i<intval($totalthreads); $i++):
	       $query = $db->getQuery(true);
           $query->select('COUNT(*)')->from($db->quoteName('#__debate'))->where($db->quoteName('threadid').'='.$i);
		   $db->setQuery($query);
           $r = $db->loadResult();
		   if(!empty($r)){
			   $r--;
			   $totalanswers += $r;
		   }
       endfor;
	   
	 
	 }
    endif;
	$totalusers = 0;
	$query = $db->getQuery(true);
    $query->select('COUNT(*)')->from($db->quoteName('#__users'));
	$db->setQuery($query);
	$rusers = $db->loadResult();
	if(!empty($rusers))
		$totalusers = $rusers;
	
	       $query = $db->getQuery(true);
           $query->select($db->quoteName('name'))->from($db->quoteName('#__users'))->order('id DESC');
		   $db->setQuery($query);
	$latestuser = $db->loadObjectList();
	if(!empty($latestuser))
		$latestusername = $latestuser[0]->name;
	$document = Factory::getDocument();
	

	if(trim($row->forumoffline)==='No'):
	
	


?>
<style type="text/css"> 
 .catslist button {
	 background-color: <?php echo $row->buttbakcolor ?>;
	 font-family: <?php echo $row->fontfamily; ?>;
	 
 }
 .catslist h3{
	 color : <?php echo $row->titlecolor; ?>;
	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->titlefontsize; ?>;



 }
 .catslist .badge
 {
	 	 background-color: <?php echo $row->titlecolor ?>;
		 	 	 color : <?php echo $row->textcolor; ?>;

		  display:table;
		 margin-top:5px;
		 border-radius:5px;

 }
 .catslist h3+div
 {
	 	 color : <?php echo $row->textcolor; ?>;
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;


 }
 .forumtitle
 {
	 	 color : <?php echo $row->titlecolor; ?>;
		 	 font-weight:  <?php echo $row->titlefontweight; ?>;
	 font-style:  <?php echo $row->titlefontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->titlefontsize+5; ?>px;

 }
 .forumemail
 {
     margin-top:5px;
 }
 .mbut
 {
	 margin-top:5px;
 }
</style>
<div class="categories-list<?php echo $this->pageclass_sfx; ?>  catslist">
	<?php
	if(!empty(trim($row->forumtitle))):
	          echo "<div class='forumtitle'>".$row->forumtitle."</div>";
			  if(!empty(trim($row->forumemail))):
			  			      echo "<div class='forumemail'>".HTMLHelper::_('email.cloak', $row->forumemail, 1, 'Email Forum Board', 0)."</div>";
            
			  endif;
	endif;

		echo LayoutHelper::render('joomla.content.categories_default', $this);
		echo $this->loadTemplate('items');
	?>
</div>
<?php 
if(trim($row->showuserstatistics)==='Yes'){
?>
<div class="statistics">
<img src="<?php echo Uri::Base().'components/com_debate/assets/images/statistics.jpg'; ?>" width="121px" height="101px" />
<?php 
  if(!empty($totalMessages)):
		echo "<div class='totalmessages'>Total messages for this user:".$totalMessages."</div>";
  else:
        echo "<div class='totalmessages'>There is no message in this forum yet.</div>";
  endif;
  
  if(!empty($totaltitles)):
		echo "<div class='totaltitles'>Total titles:".$totaltitles."</div>";
  else:
        echo "<div class='totaltitles'>There is no title in this forum yet.</div>";
  endif;
  
  
  if(!empty($todaynewtitles)):
		echo "<div class='todaynewtitles'>Today's new titles: ".$todaynewtitles."</div>";
  else:
        echo "<div class='todaynewtitles'>There is no new title for today in this forum yet.</div>";
  endif;
  if(!empty($totalanswers)):
		echo "<div class='totalanswers'> Total responds:".$totalanswers."</div>";
  else:
        echo "<div class='totalanswers'>There is no answer in this forum yet.</div>";
  endif;
  if(!empty($latestusername)):
		echo "<div class='latestun'>Latest user:".$latestusername."</div>";
  else:
        echo "<div class='latestun'>No new user recently.</div>";
  endif;

?>
</div>
<?php } 
 if(trim($row->publishrules)==='Yes'):
 ?>
 <div class="mbut"><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">View Forum Rules</button></div>


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
		if(!empty($activerules->rules)):
		    echo $activerules->rules;
		else:
			echo "No rules have been set!";
		endif;
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
 
 if(trim($row->showusersonline)=='Yes'):
 
	
 $query = $db->getQuery(true);
 $query->select('DISTINCT username')->from($db->quoteName('#__session'));
 $db->setQuery($query);
 $result=$db->loadObjectList();
 
 $onlinelist='';
 if(!empty($result)):
	foreach($result as $key=>$value):
	  $onlinelist .= $value->username. "-";
	  endforeach;
	  $onlinelist = substr($onlinelist, 0, strlen($onlinelist)-1);
	  
	  echo "<div><div class='onlinelist'>Users on line:".$onlinelist."</div></div>";
	  
 endif;
 
 endif;
 
 
 if(trim($row->shownewposts)=='Yes'):
 $newposts = $this->get("Newposts");
 

if(!empty($newposts)):
  echo "<div class='newposts'>Today's Message(s):";

 foreach($newposts as $key=>$value):
 
 	
 $query = $db->getQuery(true);
 $query->select('name')->from($db->quoteName('#__users'))->where('id='.$value->userid);
 $db->setQuery($query);
 $result=$db->loadObject();
 
 
    echo "<div><a href='".Route::_('index.php?option=com_debate&view=message&id='.$value->id.'&catid='.$value->catid)."'>".$value->title." from ".$result->name."</a></div>";
 
 endforeach;
 
 echo "</div>";
 
echo "<p></p>";


      echo "<div class='rssfeed'><a href='".Route::_('index.php?option=com_debate&view=categories&format=feed&type=rss')."'><img src='".Uri::Base()."components/com_debate/assets/images/rss.jpg' width='55px' height='55px'></a></div>";
echo "<p></p>";
 
 endif;
 
 endif;
 
 
 if(!empty($fonders)):
 echo "<div class='fonders'>Fonders:";
 
	foreach($fonders as $key=>$value):
	
	      if(trim($row->viewfonderprofile)=='Yes'):
		    echo "<div class='fonder'><a href='index.php?option=com_debate&view=fonder&id=".$value->userid."'>".$value->name."</a></div>";

		  else:
		    echo "<div class='fonder'>".$value->name."</div>";
		  endif;
	endforeach;
 echo "</div>";
 endif;

else:
	echo "<div class='offline'>".$row->offlinemessage."</div>";
endif;
?>
<div class="kianwilliam">This extension has been developed by <a href="https://kwproductions121.com">KWProdcutions.Co</a> &copy; Copyright Reserved.</div>


