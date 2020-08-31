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
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\MVC\Model\ListModel;

class DebateModelDeprivelistusers extends ListModel {
	
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',                
				'userid', 'a.userid',
				'fonderid', 'a.fonderid',
				'messageid', 'a.messageid',
				'deprivedate', 'a.deprivedate',
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
       	$messageid = $this->getUserStateFromRequest($this->context.'.filter.messageid', 'search_messageid');
        $this->setState('filter.messageid', $messageid);	
        $date = $this->getUserStateFromRequest($this->context.'.filter.date', 'search_date');
        $this->setState('filter.date', $date);	
		$fonderid = $this->getUserStateFromRequest($this->context.'.filter.fonderid', 'search_fonderid');
        $this->setState('filter.fonderid', $fonderid);	
        $userid = $this->getUserStateFromRequest($this->context.'.filter.userid', 'search_userid');
        $this->setState('filter.userid', $userid);	
        // List state information.
        parent::populateState('a.id', 'desc');
      }
	  
	  protected function getStoreId($id = '') {		  
		$id .= ':' . $this->getState('filter.messageid');
		$id .= ':' . $this->getState('filter.fonderid');
		$id .= ':' . $this->getState('filter.userid');
	    $id .= ':' . $this->getState('filter.date');
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
		
		 $filterdate = $this->getState('filter.date', null);
        if ($filterdate !== null && strlen($filterdate)>0 && $filterdate!='*')
        {
				$query->where('a.deprivedate LIKE ' . $db->quote('%'.$db->escape(trim($filterdate), true).'%')  );

        }
		 $filtermessageid = $this->getState('filter.messageid', null);
        if ($filtermessageid !== null && strlen($filtermessageid)>0 && $filtermessageid!='*')
        {
                $query->where('a.messageid=' . $db->escape($filtermessageid) );
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
