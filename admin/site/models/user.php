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
use Joomla\CMS\Helper\TagsHelper;





class DebateModeUser extends ItemModel
{


	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'name'. 'a.name',
				'email', 'a.email'
				
			);
		}

		parent::__construct($config);
	}

	
	public function getItem($pk=1)
	{
		
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$userid = (int) $this->getState('user.id');
		$query->select('*')->from($db->quoteName('#__user') . ' AS b')->where('b.id='.$userid);		
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
				$item->tags->getItemTags('com_debate.user', $item->id);
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

			$id = $app->input->get('id', 0, 'int');
		    $this->setState('user.id', $id);

	}

	
}
