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
use Joomla\CMS\Table\Table;

class DebateModelMessage extends ListModel
{
	
protected $_item = null;

protected $_siblings = null;

	protected $_children = null;

	protected $_parent = null;

	
	protected $_category = null;

	
	protected $_categories = null;

	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title'. 'a.title',
				'message', 'a.message',
				'published', 'a.published',
				'ordering', 'a.ordering'				
			);
		}

		parent::__construct($config);
	}

	
	public function getItems()
	{
	    $items = parent::getItems();	
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$messageid = (int) $this->getState('message.id');
		$categoryId = (int) $this->getState('category.id');

		$query->select('*')->from($db->quoteName('#__debate') . ' AS b')->where('b.id='.$messageid);		
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$threadid = (int) $result[0]->threadid;
		if(!empty($result)){
		$query = $db->getQuery(true);
		$search = $this->getState('list.filter');
         if (empty($search))
		 {
            $query->select('*')->from($db->quoteName('#__debate') . ' AS a')->where('threadid='.$result[0]->threadid)->where('catid='.$result[0]->catid);
			  $query->where('a.published = 1');
		                         
								   $orderCol = $this->state->get('list.ordering');
                                   $orderDirn = $this->state->get('list.direction');

                                    $order = $orderCol;

                                    if (!empty($orderDirn))
                                         $order .= " " . $orderDirn;

                                     if (!empty($orderCol))
                                           $query->order($order);

		
        $db->setQuery($query);
		$resultb = $db->loadObjectList();

		 }
		else
		{
				
										
										if( (!preg_match('/AND/', $search)) && (!preg_match('/OR/', $search)) ):


										$querymess =  'SELECT * FROM `#__debate` WHERE catid = '.$categoryId.' AND  threadid = '.$threadid.' AND ';				                        
							            $querymess .= '(message LIKE  '.$db->quote('%'.$db->escape(trim($search), true).'%').')';												  


										 else:
										 
										if( (preg_match('/AND/', $search)) && (!preg_match('/OR/', $search)) )
										 {
											 								

											  $searchwords = explode('AND',$search);
										 
										$querymess =  'SELECT * FROM `#__debate` WHERE catid = '.$categoryId.' AND  threadid = '.$threadid.' AND ';

										 
										 for($i=0; $i<count($searchwords); $i++):
										   	if(!empty($searchwords[$i]))
				                                 $querymess .= '(message LIKE  '.$db->quote('%'.$db->escape(trim($searchwords[$i]), true).'%').') AND ';													 
										 endfor;
										$length = strlen($querymess);
										  $querymess = substr($querymess,0, $length-4);
										  
										
										 
										 }
										 else
											if( (!preg_match('/AND/', $search)) && (preg_match('/OR/', $search)) )
											{

												 $searchwords = explode('OR',$search);
												 $querymess =  'SELECT * FROM `#__debate` WHERE catid = '.$categoryId.' AND  threadid = '.$threadid.' AND (';

										        for($i=0; $i<count($searchwords); $i++):
												 if(!empty($searchwords[$i]) )
								                      $querymess .= '(message LIKE  '.$db->quote('%'.$db->escape(trim($searchwords[$i]), true).'%').') OR ';												  
										       endfor;
										       $length = strlen($querymess);
										       $querymess = substr($querymess,0, $length-3);
											   $querymess .= ')';
											 			   
											   
											}
											else
											if( (preg_match('/AND/', $search)) && (preg_match('/OR/', $search)) )
											{
												

										 $searchwords = explode('AND',$search);
										$querymess =  'SELECT * FROM `#__debate` WHERE catid = '.$categoryId.' AND  threadid = '.$threadid.' AND ( ';							 
										 for($i=0; $i<count($searchwords); $i++):
										 
										        if(!empty($searchwords[$i]) && !preg_match('/OR/', $searchwords[$i])):
								                $querymess .= '(message LIKE  '.$db->quote('%'.$db->escape(trim($searchwords[$i]), true).'%').') AND ';												  

												else:
												if(preg_match('/OR/',$searchwords[$i]))
												  	$searchinwords = explode('OR',$searchwords[$i]);
												
													
													for($k=0; $k<count($searchinwords); $k++):
													 	$querymess .= '(message LIKE  '.$db->quote('%'.$db->escape(trim($searchinwords[$k]), true).'%').') OR ';												  
													endfor;
													 $length = strlen($querymess);
										             $querymess = substr($querymess,0, $length-3);	
													 $querymess .= " AND ";
										        endif;									 
										   endfor;
										    $length = strlen($querymess);
										    $querymess = substr($querymess,0, $length-4);
											$querymess .= ')';
											
											
											
											}											
										 endif;
										
										 
										  $db->setQuery($querymess);
										  $resultb = $db->loadObjectList();
										


										 
									}		                            
        
		                        
			                       
		}
		if(!empty($resultb))
		{
		
		$items = [];
		$items = $resultb;

		foreach ($items as $item)
		{
			if (!isset($this->_params))
			{
				$params = new Registry;
				$item->params = $params;
				$params->loadString($item->params);
			}

	
		}

		return $items;
		}
		else
			return array();
	}

	protected function populateState($ordering = null, $direction = null)
	{
				parent::populateState('a.id', 'asc');

		$app = Factory::getApplication();
		$params=$app->getParams();
		$this->setState('list.filter', $app->input->getString('filter-search'));
		
        

		$filterpublished = $app->input->get('filter_published', 'published');
       
		
		
		if (!in_array($filterpublished, $this->filter_fields))
		{
			$filterpublished = 'published';
		}


		

		$id = $app->input->get('id', 0, 'int');
		$this->setState('message.id', $id);

		$catid = $app->input->get('catid', 0, 'int');
		$this->setState('category.id', $catid);

		$this->setState('params', $params);
	}

	
	public function getCategory()
	{
		if (!is_object($this->_item))
		{
		
			
				$categories = Categories::getInstance('Debate');
			$this->_item = $categories->get($this->getState('category.id'));

			

			if (is_object($this->_item))
			{
				$this->_children = $this->_item->getChildren();
				$this->_parent = false;

				if ($this->_item->getParent())
				{
					$this->_parent = $this->_item->getParent();
				}

				$this->_rightsibling = $this->_item->getSibling();
				$this->_leftsibling = $this->_item->getSibling(false);
			}
			else
			{
				$this->_children = false;
				$this->_parent = false;
			}
		}

		return $this->_item;
	}


	public function getParent()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_parent;
	}

	
	public function &getLeftSibling()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_leftsibling;
	}

	
	public function &getRightSibling()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_rightsibling;
	}

	
	public function &getChildren()
	{
		if (!is_object($this->_item))
		{
			$this->getCategory();
		}

		return $this->_children;
	}

	
	public function hit($pk = 0)
	{
		$input    = Factory::getApplication()->input;
		$hitcount = $input->getInt('hitcount', 1);

		if ($hitcount)
		{
			$pk    = (!empty($pk)) ? $pk : (int) $this->getState('category.id');
			$table = Table::getInstance('Category', 'Table');
			$table->load($pk);
			$table->hit($pk);
		}

		return true;
	}
}
