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
class DebateModelDeprivelist extends JModelList {
	
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',                
				'userid', 'a.userid',
				'fonderid', 'a.fonderid',
				'messageid', 'a.messageid',
				'deprivedate', 'a.deprivedate',
				'published', 'a.published',
				'ordering', 'a.ordering',
                'checked_out', 'a.checked_out',
                'checked_out_time', 'a.checked_out_time'
            );
        }

        parent::__construct($config);
    }
	
		protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication();
		
		 // set the search state
        $search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        $this->setState('filter.search', $search);     
        $published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);
		
		           
		

        // List state information.
        parent::populateState('a.id', 'desc');
      }
	  
	  protected function getStoreId($id = '') {		  
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
        return parent::getStoreId($id);
      }
	  
	  protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select('*');
        $query->from('#__debate_deprive_list AS a');

 
        // Filter by published state
        $published = $this->getState('filter.published');
        if (is_numeric($published)) {
            $query->where('a.published = ' . (int) $published);
        } else if ($published === '') {
            $query->where('(a.published = 0 OR a.published = 1)');
        }
        
		
		
        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search))
        {
            $search = $db->quote('%'.$db->escape($search, true).'%');
            $query->where('( a.deprivedate LIKE '.$search.' OR a.messageid LIKE '.$search.' OR a.userid LIKE '.$search.' OR a.fonderid LIKE '.$search.' )');
        }


        // Add the list ordering clause.
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
