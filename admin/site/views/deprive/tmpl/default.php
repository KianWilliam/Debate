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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
 HTMLHelper::_('jquery.framework');
 
 $app = Factory::getApplication();
 $doc = Factory::getDocument();
 $user = Factory::getUser();
 
 $userid = $user->id;
 
 BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/models');
 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/tables');
 $mymodel = BaseDatabaseModel::getInstance('Config','DebateModel');
 $row = $mymodel->getItem(1);	

        $db = Factory::getDbo();

        $user = Factory::getUser();
		$username = $user->name;
		$userid = $user->id;		
		$query = $db->getQuery('true');
	    $query->select('*')->from($db->quoteName('#__debate_deprive_users'))->where('userid='.$db->quote($userid));
		$db->setQuery($query);
	    $depriveresult = $db->loadObject();
		
		
		
		$query = $db->getQuery('true');
	    $query->select('*')->from($db->quoteName('#__debate_fonders'))->where('userid='.$db->quote($depriveresult->fonderid));
		$db->setQuery($query);
	    $fonderresult = $db->loadObject();
	
 if(trim($row->forumoffline)=='No'):
 if(!empty($user->id)): 

 ?>
 <style>
 .forumainp a:link, .forumainp a:visited
 {
	  
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
 .deprive span, .deprive div
 {
	  color : <?php echo $row->textcolor; ?>;
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
 .deprive div a:link, .deprive div a:visited
 {
	 
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>;
 }
 </style>
	<div class="deprive">
	
	<span><?php echo $username; ?></span>
	<div>
	  You are deprived of posting in this forum on account of :
	  <div><?php echo $depriveresult->reason; ?> By:</div>
	  
	  <div><?php echo $fonderresult->name; ?></div>
	  <div>for a month. In case of any question contact the fonder @:</div> 
      <?php echo "<a href='mailto:".$fonderresult->email."'>".$fonderresult->name."</a>";  ?>
	  

	</div>
	 <div class="forumainp">
	 <a href="<?php echo Route::_('index.php?option=com_debate&view=categories'); ?>">Forum Main Page</a>
    </div> 
	
	</div>
 <?php
 else:
		echo "<div class='login'>You have to login first!</div>";

 endif;
 
		
else:
	echo "<div class='offline'>".$row->offlinemessage."</div>";
endif;
		
?>
<div class="kianwilliam">This extension has been developed by <a href="https://kwproductions121.com">KWProdcutions.Co</a> &copy; Copyright Reserved.</div>




