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
    $id = $app->input->get('id'); 
 BaseDatabaseModel::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/models');
 Table::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_debate/tables');
 $mymodel = BaseDatabaseModel::getInstance('Config','DebateModel');
 $row = $mymodel->getItem(1);						
 $document = Factory::getDocument();
 $user = Factory::getUser();


?>
<?php if(trim($row->forumoffline==='No')): ?>


<?php if(!empty($user->id)): ?>

<?php
if(!empty($this->item[0])):
?>
<style>
.fonder ul
{
	list-style-type:none;
}
.fondernav a:link, .fondernav a:visited
 {
	  
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>px;
 }
 .fonder ul li
 {
	  color : <?php echo $row->textcolor; ?>;
		  font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>px;
 }
 .fonder ul li a:link, .fonder ul li a:visited
 {
	   font-weight:  <?php echo $row->textfontweight; ?>;
	 font-style:  <?php echo $row->textfontstyle; ?>;
	 	 font-family: <?php echo $row->fontfamily; ?>;
		 font-size:	 <?php echo $row->textfontsize; ?>px;
 }
 .jointime
 {
	 padding-top:5px;
	 font-weight:bold;
 }
 .fimg
 {
	 margin-top:5px;
	 border-radius:5px;
 }
</style>
 
<div class='maincontainer'>	 
<div class="fondernav">
	 <a href="<?php echo Route::_('index.php?option=com_debate&view=categories&layout=default'); ?>">Forum Main Page</a>
    </div>

   <div class="fonder">
		<ul>
		<li>Name:<?php echo $this->item[0]->name ?></li>
		<li>Profession:<?php echo $this->item[0]->profession ?></li>
		<li><a href="mailto:<?php echo $this->item[0]->email ?>">Email Fonder</a></li>

		<li>
		<?php
			if(!empty($this->item[0]->avatar)):
		?>
					<img class="fimg" src="<?php echo Uri::Base()."administrator/components/com_debate/assets/images/avatar/". $this->item[0]->avatar ?> " />

		<?php else: ?>
			<span>No avatar available</span>
		<?php endif; ?>
		</li>
		<li class="jointime">Join Time:<?php echo $this->item[0]->jointime ?></li>
		</ul>
   </div>

</div>
<?php
else:
			echo '<div class="forum">There is no fonder in this forum.</div>';

endif;
 
else:
		echo '<div class="log">To take part in forum you have to login first, Go to login page site.</div>';

endif;

else:
	echo "<div class='offline'>".$row->offlinemessage."</div>";
endif;
 ?>
 <div class="fondernav">
  <a href="index.php?option=com_debate&view=categories">Forum Main Page</a>	 
    </div>    
 <div class="kianwilliam">This extension has been developed by <a href="https://kwproductions121.com">KWProdcutions.Co</a> &copy; Copyright Reserved.</div>



    


        
    
