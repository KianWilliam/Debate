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

use Joomla\Registry\Registry;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;


class DebateModelCategories extends ListModel
{
	
	public $_context = 'com_debate.categories';

	protected $_extension = 'com_debate';

	private $_parent = null;

	private $_items = [];

	protected function populateState($ordering = null, $direction = null)
	{
		$app = Factory::getApplication();
		$this->setState('filter.extension', $this->_extension);

		// Get the parent id if defined.
		$parentId = $app->input->getInt('id');
		$this->setState('filter.parentId', $parentId);

		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('filter.published',	1);
		$this->setState('filter.access',	true);
	}

	
	protected function getStoreId($id = '')
	{
		$id .= ':' . $this->getState('filter.extension');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.access');
		$id .= ':' . $this->getState('filter.parentId');

		return parent::getStoreId($id);
	}

	
	public function getItems()
	{
		if (!count($this->_items))
		{
			$app = Factory::getApplication();
			$menu = $app->getMenu();
			$active = $menu->getActive();
			$params = new Registry;

			if ($active)
			{
				$params->loadString($active->params);
			}

			$options = array();
			$options['countItems'] = $params->get('show_cat_items_cat', 1) || !$params->get('show_empty_categories_cat', 0);
			$categories = Categories::getInstance('Debate', $options);
			$this->_parent = $categories->get($this->getState('filter.parentId', 'root'));

			if (is_object($this->_parent))
			{
				$this->_items = $this->_parent->getChildren();
			}
			else
			{
				$this->_items = false;
			}
		}
		
		

		return $this->_items;
	}


	public function getParent()
	{
		if (!is_object($this->_parent))
		{
			$this->getItems();
		}

		return $this->_parent;
	}
	public function getNewposts()
	{
		$db = Factory::getDbo();
        $query = $db->getQuery(true);
		$newposts = [];
	

    $query
    ->select($db->quoteName('id'))
    ->from($db->quoteName('#__categories', 'a'));

  

         $db->setQuery($query);

         $catresults = $db->loadObjectList();
		 
         if(!empty($catresults)){

	foreach($catresults as $key=>$value):
	         $query = $db->getQuery(true);



	$today = Date ('Y-m-d');
	
		 $query->select('*')
               ->from($db->quoteName('#__debate'))
	           ->where('catid='.$value->id)
	           ->where('(created  LIKE '.$db->quote('%'.$db->escape($today, true).'%').')' )
	          ->order('id asc');
			
			 
			   $db->setQuery($query);
			   
	           $messageresult = $db->loadObject();
			  
	   
	           if(!empty($messageresult)):
	   
	              $newposts[] = $messageresult;

               endif;


		   
       
	     endforeach;
		 
		 		 return $newposts;

	 }
   else
       return array();
 }
	
}