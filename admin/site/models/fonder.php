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

use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Factory;
use Joomla\CMS\Categories\Categories;
use Joomla\CMS\Helper\TagsHelper;



class DebateModelFonder extends ItemModel
{


	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'name'. 'a.name',
				'email', 'a.email',
				'profession', 'a.profession',
				'avatar', 'a.avatar',
				'jointime', 'a.jointime',
'userid', 'a.userid'				
			);
		}

		parent::__construct($config);
	}

	
	public function getItem($pk=null)
	{
		
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		if($pk===null)
		$fonderid = (int) $this->getState('fonder.id');
		else
			$fonderid = $pk;
		
		
	
	
		$query->select('*')->from($db->quoteName('#__debate_fonders') . ' AS a')->where('a.userid='.$fonderid);	

		$db->setQuery($query);
		$result = $db->loadObjectList();
		
	
		if(!empty($result))
		{
		
		$items = [];
		$items = $result;

		foreach ($items as $item)
		{
			if (!isset($this->_params))
			{
				$params = new Registry;
				$item->params = $params;
				$params->loadString($item->params);
			}

			if ($this->getState('load_tags', true))
			{
				$item->tags = new TagsHelper();
				$item->tags->getItemTags('com_debate.fonder', $item->id);
			}
		}

		return $items;
		}
		else
			return array();
	}

	protected function populateState($ordering = null, $direction = null)
	{
		$app = Factory::getApplication();

			$id = $app->input->get('id');
			
		    $this->setState('fonder.id', $id);
			

	}

	
}
