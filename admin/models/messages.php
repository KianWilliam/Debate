<?php 

/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2018-10-13 23:26:33Z $
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
jimport('joomla.application.component.modellist');
class DebateModelMessages extends JModelList {

	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'title', 'a.title',
                'ordering', 'a.ordering',
                'checked_out', 'a.checked_out',
                'checked_out_time', 'a.checked_out_time',
				'catid', 'a.catid', 'category_id', 'category_title',
                'published', 'a.published',
				'userid', 'a.userid',
				'threadid', 'a.threadid',
				'fonderid', 'a.fonderid',
                'created', 'a.created'                
            );
        }

        parent::__construct($config);
    }
	
		protected function populateState($ordering = null, $direction = null) {
        $app = JFactory::getApplication();
		
		   $id = $this->getUserStateFromRequest($this->context.'.filter.id', 'search_id');
        $this->setState('filter.id', $id); 
        $title = $this->getUserStateFromRequest($this->context.'.filter.title', 'search_title');
        $this->setState('filter.title', $title);     
        $catid = $this->getUserStateFromRequest($this->context.'.filter.catid', 'search_catid');
        $this->setState('filter.catid', $catid);
        $userid = $this->getUserStateFromRequest($this->context.'.filter.userid', 'search_userid');
        $this->setState('filter.userid', $userid);     
        $threadid = $this->getUserStateFromRequest($this->context.'.filter.threadid', 'search_threadid');
        $this->setState('filter.threadid', $threadid);	
        $fonderid = $this->getUserStateFromRequest($this->context.'.filter.fonderid', 'search_fonderid');
        $this->setState('filter.fonderid', $fonderid);	
         $created = $this->getUserStateFromRequest($this->context . '.filter.created', 'search_created', '');
        $this->setState('filter.created', $created);		
        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);
		 
		

        parent::populateState('a.title', 'desc');
      }
	  
	  protected function getStoreId($id = '') {	
		$id .= ':' . $this->getState('filter.id');	  
		$id .= ':' . $this->getState('filter.catid');
		$id .= ':' . $this->getState('filter.title');
		$id .= ':' . $this->getState('filter.fonderid');
		$id .= ':' . $this->getState('filter.userid');
        $id .= ':' . $this->getState('filter.threadid');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.created');

        return parent::getStoreId($id);
      }
	  
	  protected function getListQuery() {
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from('#__debate AS a');

 
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('a.published = ' . (int) $published);
        } else if ($published === '') {
            $query->where('(a.published = 0 OR a.published = 1)');
        }
		      

  $filterid = $this->getState('filter.id', null);
        if ($filterid !== null && strlen($filterid)>0 && $filterid!='*')
        {
                $query->where('a.id=' . $db->escape($filterid) );
        }
        
        $filtercatid = $this->getState('filter.catid', null);
        if ($filtercatid !== null && strlen($filtercatid)>0 && $filtercatid!='*')
        {
                $query->where('a.catid=' . $db->escape($filtercatid) );
        }
		
		 $filteruserid = $this->getState('filter.userid', null);
        if ($filteruserid !== null && strlen($filteruserid)>0 && $filteruserid!='*')
        {
                $query->where('a.userid=' . $db->escape($filteruserid) );
        }
		
		 $filterfonderid = $this->getState('filter.fonderid', null);
        if ($filterfonderid !== null && strlen($filterfonderid)>0 && $filterfonderid!='*')
        {
                $query->where('a.fonderid=' . $db->escape($filterfonderid) );
        }
		
		 $filterthreadid = $this->getState('filter.threadid', null);
        if ($filterthreadid !== null && strlen($filterthreadid)>0 && $filterthreadid!='*')
        {
                $query->where('a.threadid=' . $db->escape($filterthreadid) );
        }
		
        $title = $this->getState('filter.title');
        if (!empty($title))
        {
            $title = $db->quote('%'.$db->escape($title, true).'%');
            $query->where('( a.title LIKE '.$title.' )');
        }
		
   $created = $this->getState('filter.created');
  
        if (!empty($created))
        {
            $created = $db->quote('%'.$db->escape($created, true).'%');
            $query->where('( a.created LIKE '.$created.' )');
        }
		


        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');

        $order = $orderCol;

        if (!empty($orderDirn))
            $order .= " " . $orderDirn;

        if (!empty($orderCol))
            $query->order($order);

        return $query;
    }

	

	
	
}
