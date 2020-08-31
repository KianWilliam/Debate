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
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;

 
class DebateViewChtitle extends HtmlView
{
	

	function display($tpl = null)
	{
		$input = Factory::getApplication()->input;
	
			$post = $_POST['title'];
			$db = Factory::getDbo();
            $query = $db->getQuery('true');
	               
										$query->select('*')->from($db->quoteName('#__debate'))->where('title='.$db->quote($post)); 


						

						 $db->setQuery($query);
	                     $result = $db->loadObject();
						 
						 if(!empty($result))
							 $res = "false";
						 else
							 $res = "true";
		
						echo new JResponseJson($res);
		                exit();
	}
}