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


abstract class DebateHelperRoute
{
	
	
	public static function getResponseRoute($id, $catid, $threadid=null, $userid=null, $title=null, $firstid = null  )
	{
				 		

		$link = 'index.php?option=com_debate&view=response&id=' . $id;

		if ((int) $catid > 1)
		{
			$link .= '&catid=' . $catid;
		}
		
		
		if ( !empty($threadid))
		{
			$link .= '&threadid=' . $threadid;
		}
		
		
		if (!empty($userid))
		{
			$link .= '&userid=' . $userid;
		}
	

	
		if (!empty($title))
		{
			$link .= '&title=' . $title;
		}
	

		if (!empty($firstid))
		{
			$link .= '&firstid=' . $firstid;
		}
	
	

		return $link;
	}

	
	public static function getMessageRoute($id, $catid)
	{
				 		

		$link = 'index.php?option=com_debate&view=message&id=' . $id ;

		if ((int) $catid > 1)
		{
			$link .= '&catid=' . $catid;
		}
	
		return $link;
	}
	public static function getFonderRoute($id)
	{
		
			$id = (int) $id;
		

		if ($id < 1)
		{
			$link = '';
		}
		else
		{
			$link = 'index.php?option=com_debate&view=fonder&id=' . $id;
		}

		return $link;
	}
	public static function getUserRoute($id)
	{
		
			$id = (int) $id;
		

		if ($id < 1)
		{
			$link = '';
		}
		else
		{
			$link = 'index.php?option=com_debate&view=user&id=' . $id;
		}

		return $link;
	}
	public static function getTitleRoute($title)
	{	
			$link = 'index.php?option=com_debate&view=chtitle&format=json&title=' . $title;		

		return $link;
	}
	public static function getDepriveRoute()
	{
		
			
			$link = 'index.php?option=com_debate&view=deprive';
		

		return $link;
	}
	public static function getCategoryRoute($catid)
	{
		if ($catid instanceof JCategoryNode)
		{
			$id = $catid->id;
		}
		else
		{
			$id = (int) $catid;
		}

		if ($id < 1)
		{
			$link = '';
		}
		else
		{
			$link = 'index.php?option=com_debate&view=category&id=' . $id;
		}

		return $link;
	}
	//no parent id in model categories will be fixed. level 1
	public static function getCategoriesRoute()
	{
		
			$link = 'index.php?option=com_debate&view=categories';
		

		return $link;
	}
}
