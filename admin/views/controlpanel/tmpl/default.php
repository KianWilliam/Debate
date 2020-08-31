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
use Joomla\CMS\Uri\Uri;
$document = Factory::getDocument();
$document->addStyleSheet(Uri::Base().'components/com_debate/assets/css/backclass.css');


?>
<style type="text/css">
.messages img
{
	border-radius:55px;
}
.kianwilliam
{
	display:inline-block;
	width:100%;
	text-align:center;
	margin-top:121px;
	
}
</style>

<div id="j-sidebar-container" class="span2" >
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
	<div class="controlpanel">
	
		<div class="fonders"><a href="index.php?option=com_debate&view=fonders"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/fonders.gif' ?>"  title="Fonders" /></a></div>
	    <div class="fcategories"><a href="index.php?option=com_categories&extension=com_debate&view=categories"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/categories.gif' ?>" title="Categories" /></a></div>

		<div class="messages"><a href="index.php?option=com_debate&view=messages"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/messages.gif' ?>" title="Messages" /></a></div>
		<div class="editedposts"><a href="index.php?option=com_debate&view=editedmessages"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/edited.gif' ?>" title="Edited Messages" /></a></div>

		<div class="deprivedposts"><a href="index.php?option=com_debate&view=depriveusers"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/deprived.gif' ?>" title="Deprived Users" /></a></div>
		<div class="deprivedposts"><a href="index.php?option=com_debate&view=deprivelistusers"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/deprivelistusers.jpg' ?>" title="Deprived List Users" /></a></div>

		<div class="badposts"><a href="index.php?option=com_debate&view=badposts"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/badposts.gif' ?>" title="Bad Posts" /></a></div>
				
		<div class="users"><a href="index.php?option=com_users&view=users"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/users.gif' ?>" title="Users" /></a></div>
		<div class="ips"><a href="index.php?option=com_debate&view=ips"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/ips.gif' ?>" title="Ip Addresses" /></a></div>

		<div class="files"><a href="index.php?option=com_debate&view=files"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/files.gif' ?>" title="Files" /></a></div>
		<div class="frules"><a href="index.php?option=com_debate&view=rules"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/rules.gif' ?>" title="Rules" /></a></div>
		<div class="fconfig"><a href="index.php?option=com_debate&view=config&layout=edit"><img src="<?php echo Uri::Base().'components/com_debate/assets/images/config.gif' ?>" title="Settings" /></a></div>
	
		
	</div>
	</div>
	<div class="kianwilliam">This extension has been developed by <a href="https://kwproductions121.com">KWProdcutions.Co</a> &copy; Copyright Reserved.
	In case of any question or support contact : <a href="https://extensions.kwproductions121.com">Extensions</a></div>

	

