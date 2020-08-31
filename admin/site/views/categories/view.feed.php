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
use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Document\Feed\FeedItem;
use Joomla\CMS\MVC\View\CategoriesView;

 class DebateViewCategories extends CategoriesView
 {
 public function display($tpl = null) { 		
       $app  = Factory::getApplication(); 		
       $this->items   = $this->get('Newposts'); 
    if (count($errors = $this->get('Errors')))
 	{
 		throw new Exception(implode("\n", $errors));
 	}
	
       if (empty($this->items)){
           return;
       }
	   	do{ 
			 //clean all output buffers 		   
         } while(@ob_end_clean());
  		  		 
       $document = Factory::getDocument();
       $type = $app->input->get("type","rss");
       $document->link = Route::_('index.php?option=com_debate&view=categories&format=feed&type='.$type);

       foreach($this->items as $item)
       {
         $db = Factory::getDbo();
	   $query = $db->getQuery(true);
	   $query->select('*')->from($db->quoteName('#__users'))->where('id = '.$item->userid);
	   $db->setQuery($query);
	   $result = $db->loadObject();
	    $query = $db->getQuery(true);
	   $query->select('*')->from($db->quoteName('#__categories'))->where('id = '.$item->catid);
	   $db->setQuery($query);
	   $res = $db->loadObject();
		$feeditem   = new JFeedItem;
 		$feeditem->title  = $item->title;
 		$feeditem->link  = Route::_('index.php?option=com_debate&view=message&id='.(int) $item->id.'&catid='.(int) $item->catid);
 		$feeditem->description = $item->description;
		$feeditem->author = $result->name;
		$feeditem->authorEmail = $result->email;
 		$feeditem->date  = $item->created;
		$feeditem->category = $res->title;



 		$document->addItem($feeditem);
 	}

	//echo $document->render();
 	//jexit(); 
 }
 }