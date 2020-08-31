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

use Joomla\CMS\Component\Router\Rules\RulesInterface;
use Joomla\CMS\Categories\Categories;

class DebateRouterRulesLegacy implements RulesInterface
{
	
	public function __construct($router)
	{
		$this->router = $router;
	}

	
	public function preprocess(&$query)
	{
	}

	
	public function build(&$query, &$segments)
	{
		 

		if (empty($query['Itemid']))
		{
			$menuItem = $this->router->menu->getActive();
		}
		else
		{
			$menuItem = $this->router->menu->getItem($query['Itemid']);
		}

		$mView = empty($menuItem->query['view']) ? null : $menuItem->query['view'];
		$mId   = empty($menuItem->query['id']) ? null : $menuItem->query['id'];


		if (isset($query['view']))
		{
			$view = $query['view'];

			if (empty($menuItem) || $menuItem->component !== 'com_debate' || empty($query['Itemid']))
			{
				$segments[] = $query['view'];
			}

			unset($query['view']);
		}

		if ((isset($query['view']) && isset($query['id'])) && $mView == $query['view'] && $mId == (int) $query['id'])
		{
			unset($query['view'], $query['catid'], $query['id']);

			return;
		}
		


		if (isset($view) && ( $view === 'category' || $view === 'message' || $view === 'response'  || $view === 'fonder' || $view === 'user' || $view==='chtitle'))
		{
			/*if ($mId != (int) $query['id'] || $mView != $view)
			{
				if ( ($view === 'message' && isset($query['catid'])) || ($view === 'response' && isset($query['catid'])) )
				{
					$catid = $query['catid'];
				}
				elseif (isset($query['id']))
				{
					$catid = $query['id'];
				}*/
			
				if (isset($view) && ( $view === 'category' ) ):
				
						$catid = $query['id'];	
                        	$categories = Categories::getInstance('Debate');
				$category = $categories->get($catid);

				if ($category)
				{
					$path = $category->getPath();
					$path = array_reverse($path);

					$array = array();

					foreach ($path as $id)
					{
						if ((int) $id === (int) $menuCatid)
						{
							break;
						}

						/*if ($advanced)
						{
							list($tmp, $id) = explode(':', $id, 2);
						}*/

						$array[] = $id;
					}

					$segments = array_merge($segments, array_reverse($array));
				}
				
						
				endif;
				
						if (isset($view) && ( $view === 'message'):
												$id = $query['id'];
												$segments[]=$id;
												$catid = $query['catid'];
	                                            $categories = Categories::getInstance('Debate');
				                                $category = $categories->get($catid);

				                if ($category)
				                {
					              $path = $category->getPath();
					              $path = array_reverse($path);

					              $array = array();

					              foreach ($path as $id)
					              {
						           if ((int) $id === (int) $menuCatid)
						           {
							          break;
						           }

						         

						           $array[] = $id;
					             }

					              $segments = array_merge($segments, array_reverse($array));
				              }
																
						     endif;

                if (isset($view) && ( $view === 'response'){
												$id = $query['id'];
												$segments[]=$id;
												$catid = $query['catid'];	
	                               $categories = Categories::getInstance('Debate');
				                   $category = $categories->get($catid);

				          if ($category)
				          {
					        $path = $category->getPath();
					        $path = array_reverse($path);

					        $array = array();

					      foreach ($path as $id)
					      {
						    if ((int) $id === (int) $menuCatid)
						    {
							   break;
						    }

						

						    $array[] = $id;
					      }

					      $segments = array_merge($segments, array_reverse($array));
				         }
						 if(!empty($query['threadid'])):
							$threadid =$query['threadid'];
							$segments[]=$threadid;
							endif;
						if(!empty($query['userid'])):
								$userid = $query['userid'];
								$segments[]=$userid;
						endif;
						if(!empty($query['title'])):
								$title=$query['title'];
								$segments[]=$title;
						endif;
						if(!empty($query['firstid'])):
								$firstid=$query['firstid'];
								$segments[] = $firstid;
						endif;
						
				}
				  if (isset($view) && ( $view === 'fonder'){
												$id = $query['id'];
												$segments[]=$id;
				  }
				  
				    if (isset($view) && ( $view === 'user'){
												$id = $query['id'];
												$segments[]=$id;
				  }
				  
				   if (isset($view) && ( $view === 'chtitle'){
					                            $format=$query["format"];
					                            $segments[]=$format;
												$title = $query['title'];												
												$segments[]=$title;
				  }

				
							unset($query['id'], $query['catid'],$query['threadid'], $query['title'],$query['firstid'], $query['format']);

				
			}

		

		if (isset($query['layout']))
		{
			if (!empty($query['Itemid']) && isset($menuItem->query['layout']))
			{
				if ($query['layout'] == $menuItem->query['layout'])
				{
					unset($query['layout']);
				}
			}
			else
			{
				if ($query['layout'] === 'default')
				{
					unset($query['layout']);
				}
			}
		}

		$total = count($segments);

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = str_replace(':', '-', $segments[$i]);
		}
	}

	
	public function parse(&$segments, &$vars)
	{
		$total = count($segments);

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = preg_replace('/-/', ':', $segments[$i], 1);
		}

		$item	= $this->router->menu->getActive();
		

		$count = count($segments);

		if (!isset($item))
		{
			$vars['view'] = $segments[0];
		if(isset($segments[1]) && $segments[0]!=="chtitle")
			$vars['id']   = $segments[1];
		else
			$vars['format'] = $segments[1];
		if(isset($segments[2]) && $segments[0]!=="chtitle")
			$vars['catid']   = $segments[2];
		else
			$vars['title'] = $segments[2];
		if(isset($segments[3]))
			$vars['threadid']   = $segments[3];
		if(isset($segments[4]))
			$vars['userid']   = $segments[4];
		if(isset($segments[5]))
			$vars['title']   = $segments[5];
		if(isset($segments[6]))
			$vars['firstid']   = $segments[6];
		

			return;
		}
		$id = (isset($item->query['id']) && $item->query['id'] > 1) ? $item->query['id'] : 'root';

		$categories = Categories::getInstance('Debate')->get($id)->getChildren();
		$vars['catid'] = $id;
		$vars['id'] = $id;
		$found = 0;

		foreach ($segments as $segment)
		{
			$segment = $advanced ? str_replace(':', '-', $segment) : $segment;

			foreach ($categories as $category)
			{
				if ($category->slug == $segment || $category->alias == $segment)
				{
					$vars['id'] = $category->id;
					$vars['catid'] = $category->id;
					$vars['view'] = 'category';
					$categories = $category->getChildren();
					$found = 1;
					break;
				}
			}

			if ($found == 0)
			{
				
			$vars['view'] = $segments[0];			
			$vars['id']   = $segments[1];			
			$vars['catid']   = $segments[2];
    
			
		
			
			}

			$found = 0;
		}
	}
}
