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
use Joomla\CMS\Component\ComponentHelper;




class DebateModelCategory extends ListModel
{
	
	protected $_item = null;

	protected $_siblings = null;

	protected $_children = null;

	protected $_parent = null;

	
	protected $_category = null;

	
	protected $_categories = null;
	protected $allqueries = [];

	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'published', 'a.published',

				'ordering', 'a.ordering',
			);
		}

		parent::__construct($config);
	}

	
	public function getItems()
	{
		
		  $r= parent::getItems();
		
	
	

		return $this->allqueries;
	}

	
	protected function getListQuery()
	{
		
		
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		$query->select('MIN('.$db->quoteName('a.threadid').')')->from($db->quoteName('#__debate') . ' AS a')->join('LEFT', '#__categories AS c ON c.id = a.catid');
		if ($categoryId = $this->getState('category.id'))
		{
			$query->where('a.catid = ' . (int) $categoryId);
		}
		$query->where('a.fonderidea != "badpost"');
		$query->where('a.fonderidea != "deprive"');


		$db->setQuery($query);
		$result = $db->loadResult();
		
		
		$min_thread_id = $result;
		
		if(!empty($min_thread_id))
		{
			$query = $db->getQuery(true);
		    $query->select('MAX('.$db->quoteName('a.threadid').')')->from($db->quoteName('#__debate') . ' AS a')->join('LEFT', '#__categories AS c ON c.id = a.catid');
		    if ($categoryId = $this->getState('category.id'))
		    {
			   $query->where('a.catid = ' . (int) $categoryId);
		    }
			$query->where('a.fonderidea != "badpost"');
		    $query->where('a.fonderidea != "deprive"');
		    $db->setQuery($query);
		    $result = $db->loadResult();
			
			$max_thread_id = $result;
			$catthreadids = [];
		
							for($i=intval($min_thread_id); $i<=intval($max_thread_id); $i++)
							{
								$query = $db->getQuery(true);
					$query->select('a.*')->from($db->quoteName('#__debate') . ' AS a')
					->join('LEFT', '#__categories AS c ON c.id = a.catid')
					->where('a.threadid = '.$i)->where('a.catid = '. (int) $categoryId);
					          $db->setQuery($query);
							  $r = $db->loadResult();
							  if(!empty($r))
								  $catthreadids [] = $i;
					
							}

				
	
			if(!empty($max_thread_id))
			{
				$queries = [];
			
				
				for($l=0; $l<count($catthreadids); $l++)
				{
					
					$query = $db->getQuery(true);
					$query->select('MIN(a.id)')->from($db->quoteName('#__debate') . ' AS a')
					->where('a.threadid = '. $catthreadids[$l]);
					

					$db->setQuery($query);
					$minid = $db->loadResult();
										

					$query = $db->getQuery(true);
					$query->select('MAX(a.id)')->from($db->quoteName('#__debate') . ' AS a')
					->where('a.threadid = '. $catthreadids[$l]);
					
					$db->setQuery($query);
					$maxid = $db->loadResult();
					
				
				
					
				if(!empty($minid)){
					
										$query = $db->getQuery(true);

					
					$query->select('a.*')->from($db->quoteName('#__debate') . ' AS a');
					             


					
                     if ($categoryId = $this->getState('category.id'))
		             {
						
				        $query->where('a.threadid = ' .  $catthreadids[$l])->where('a.id = ' . $minid);
						
						
						
									 $query->where('(a.published = 1)');
									

		                         

                                 
								  
                                  $search = $this->getState('list.filter');
                            		if (!empty($search))
		                            {
										
										if(!strpos($search, 'AND') && !strpos($search, 'OR')):
										
			                             $search = $db->quote('%' . $db->escape($search, true) . '%');
			                             $query->where('(a.title LIKE ' . $search . ')');
										 else:
										 
										 if(strpos($search, 'AND') && !strpos($search, 'OR'))
										 {
											 
											  $searchwords = explode('AND',$search);
										
										$querymess =  'SELECT * FROM `#__debate` WHERE catid = '.$categoryId.' AND ';


										 $db->getQuery(true);
										 
										 for($i=0; $i<count($searchwords); $i++):


										   			 if(!empty($searchwords[$i]))
				                                 $querymess .= '(title LIKE  '.$db->quote('%'.$db->escape(trim($searchwords[$i]), true).'%').') AND ';
                                               
													 
													

										 endfor;
									
										 $querymess .= '  published LIKE '.$db->quote('%'.$db->escape(trim("1"), true).'%');

										
										  
											  $db->setQuery($querymess);	
											  

											  
					                            $objs  = $db->loadObjectList();
																							  
                                           
											 $allobjs = [];
											 $arr = [];
											 for($i=0; $i<count($objs); $i++):
											 
											  $allobjs [] = $objs [$i];
											 
											   if(count($objs)>1){
											       for($j=$i+1;$j<count($objs); $j++):
												   
												   $arr [] = $objs [$j];
												      if($objs[$i]->threadid !== $objs[$j]->threadid)
													  {
														  break;
													  }
												   endfor;
												   
												 if(!empty($arr) && count($arr)==1){
													
													 array_pop($arr);
												 
												   												     

												 }
												
													if(!empty($arr) && count($arr)!=0)  
												           $allobjs [] = end($arr);
													   else
														   $allobjs [] = $objs[$i];
													   
													  
										 }
										 else{
											
										 }
											   		
												 $arr = [];  
												    if(count($objs)>1)
												   $i = $j;
												   $i--;		   

											  endfor;
											  	$arr = [];
										for($t=0; $t<count($allobjs); $t++):
										    if($t==0)
										       $arr[]=$allobjs[0];
										    if($allobjs[$t+1]->threadid != $allobjs[$t]->threadid)
										           $arr[] = $allobjs[$t+1];
										    endfor;
										    $allobjs =$arr;
											  	  $arr = [];
											  for($o=0; $o<count($allobjs); $o++)
											  {
											      if(!empty($allobjs[$o])){
											      $arr [$o][] = $allobjs[$o];
											     
											      }
										
											  }
										
											  $this->allqueries = $arr;
											  
											
											  return "";
										 
										 }
										 else
											if(!strpos($search, 'AND') && strpos($search, 'OR'))
											{
												 $searchwords = explode('OR',$search);
										 
										         $querymess =  'SELECT * FROM `#__debate` WHERE catid = '.$categoryId.' AND  ( ';
										        for($i=0; $i<count($searchwords); $i++):
												 if(!empty($searchwords[$i]) )
								                      $querymess .= '(title LIKE  '.$db->quote('%'.$db->escape(trim($searchwords[$i]), true).'%').') OR ';												  
										       endfor;
										       $length = strlen($querymess);
										       $querymess = substr($querymess,0, $length-3);
											   $querymess .= ')';
											
											     $db->setQuery($querymess);	
											  

											  
					                            $objs  = $db->loadObjectList();
											
											
											  $allobjs = [];
											 $arr = [];
											 for($i=0; $i<count($objs); $i++):
											 		 $allobjs [] = $objs [$i];

											    if(count($objs)>1){
                                                       
											   
											       for($j=$i+1;$j<count($objs); $j++):
												   		$arr [] = $objs [$j];

												      if($objs[$i]->threadid !== $objs[$j]->threadid)
														  break;
												   endfor;
												    if(!empty($arr) && count($arr)==1){
													
													 array_pop($arr); 
												   												     

												 }
												 	if(!empty($arr) && count($arr)!=0)  
												           $allobjs [] = end($arr);
													   else
														   $allobjs [] = $objs[$i];
												}
												else
												{
													
												}
												$arr = [];
												 if(count($objs)>1)
												   $i = $j;
												   $i--;
												  
												   

											  endfor;
											 	$arr = [];
										for($t=0; $t<count($allobjs); $t++):
										    if($t==0)
										       $arr[]=$allobjs[0];
										    if($allobjs[$t+1]->threadid != $allobjs[$t]->threadid)
										           $arr[] = $allobjs[$t+1];
										    endfor;
										    $allobjs =$arr;
											  	  $arr = [];
											  for($o=0; $o<count($allobjs); $o++)
											  {
											      if(!empty($allobjs[$o])){
											      $arr [$o][] = $allobjs[$o];
											     
											      }
										
											  }
										
											  $this->allqueries = $arr;

											  return "";
											   
											   
											   
											   
											}
											else{

										
										 $searchwords = explode('AND',$search);
										
										 
									$querymess =  'SELECT * FROM `#__debate` WHERE catid = '.$categoryId.' AND  ( ';

										 for($i=0; $i<count($searchwords); $i++):
										        if(!empty($searchwords[$i]) && !preg_match('/OR/', $searchwords[$i])):
								                $querymess .= '(title LIKE  '.$db->quote('%'.$db->escape(trim($searchwords[$i]), true).'%').') AND ';												  

												else:
												if(preg_match('/OR/',$searchwords[$i]))
												  	$searchinwords = explode('OR',$searchwords[$i]);
													
													for($k=0; $k<count($searchinwords); $k++):
													 	$querymess .= '(title LIKE  '.$db->quote('%'.$db->escape(trim($searchinwords[$k]), true).'%').') OR ';												  
													endfor;
													 $length = strlen($querymess);
										             $querymess = substr($querymess,0, $length-3);	
													 $querymess .= " AND ";
										        endif;									 
										   endfor;
										    $length = strlen($querymess);
										    $querymess = substr($querymess,0, $length-4);
											$querymess .= ')';
											
									
											 $db->setQuery($querymess);	
											  

											  
					                            $objs  = $db->loadObjectList();
											
											  $allobjs = [];
											 $arr = [];
											 
											 for($i=0; $i<count($objs); $i++):
											 			$allobjs [] = $objs [$i];

											   
											   if(count($objs)>1){

											   											   
											       for($j=$i+1;$j<count($objs); $j++):
                                                       $arr [] = $objs [$j];

												      if($objs[$i]->threadid !== $objs[$j]->threadid)
														  break;
												   endfor;
												    if(!empty($arr) && count($arr)==1){
													
													 array_pop($arr);			 
												   												     

												 }
												 	if(!empty($arr) && count($arr)!=0)  
												           $allobjs [] = end($arr);
													   else
														   $allobjs [] = $objs[$i];
											   }
											   else
											   {
												  
											   }
											   $arr = [];
											   	 if(count($objs)>1)
												   $i = $j;
												   $i--;
												   

											  endfor;
											  	$arr = [];
										for($t=0; $t<count($allobjs); $t++):
										    if($t==0)
										       $arr[]=$allobjs[0];
										    if($allobjs[$t+1]->threadid != $allobjs[$t]->threadid)
										           $arr[] = $allobjs[$t+1];
										    endfor;
										    $allobjs =$arr;
											  	  $arr = [];
											  for($o=0; $o<count($allobjs); $o++)
											  {
											      if(!empty($allobjs[$o])){
											      $arr [$o][] = $allobjs[$o];
											     
											      }
										
											  }
										
											  $this->allqueries = $arr;
											 

											  return "";
											   
											   
										
											}
											
										 endif;
									}

		                            

					   		              
					   
					 }
					 
					 					   		           

					   $db->setQuery($query);
					   $firstobj = $db->loadObject();
					   
					  
					  $query = $db->getQuery(true);
					
					$query->select('a.*')->from($db->quoteName('#__debate') . ' AS a');
				
				        $query->where('a.threadid = ' .  $catthreadids[$l])->where('a.id = '. (int) $maxid)->where('published = 1');
						$db->setQuery($query);
						$secondobj = $db->loadObject();
						
						
						$objs = [];
						if(!empty($firstobj) && !empty($secondobj))	:

						
                        $objs[] = $firstobj;
						
					    $objs[] = $secondobj;		
                   
						 $this->allqueries[] =  $objs;
						endif;
						
			
					}
				}
							
				
			}
			
		}
		

		return "";
	}

	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = Factory::getApplication();
			

		$params=$app->getParams();
		
		
		$this->setState('list.filter', $app->input->getString('filter-search'));
		
		 
        

		$orderCol = $app->input->get('filter_order', 'ordering');
		$filterpublished = $app->input->get('filter_published', 'published');


		if (!in_array($orderCol, $this->filter_fields))
		{
			$orderCol = 'ordering';
		}
		
		
		if (!in_array($filterpublished, $this->filter_fields))
		{
			$filterpublished = 'published';
		}


		$this->setState('list.ordering', $orderCol);

		$listOrder = $app->input->get('filter_order_Dir', 'DESC');

		if (!in_array(strtoupper($listOrder), array('DESC', 'ASC', '')))
		{
			$listOrder = 'DESC';
		}

		$this->setState('list.direction', $listOrder);
		
					if($app->input->get('view')=="category")
					{
						

		                         $id = $app->input->get('id', 0, 'int');
					}
						else
						{
							
									  $id = $app->input->get('catid', 0, 'int');
									  
						}
								  
							  

		                         $this->setState('category.id', $id);

		

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
			$table = JTable::getInstance('Category', 'JTable');
			$table->load($pk);
			$table->hit($pk);
		}

		return true;
	}
}
