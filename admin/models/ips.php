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

class DebateModelIps extends ListModel {
	
	public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id', 'a.id',
                'userid', 'a.userid',
                'ipaddress','a.ipaddress',   
				'ordering', 'a.ordering',
				
            );
        }

        parent::__construct($config);
    }
	
		protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication();
		
		 // set the search state
      $userid = $this->getUserStateFromRequest($this->context.'.filter.userid', 'search_userid');
		$this->setState('filter.userid', $userid);	    
        
        // List state information.
        parent::populateState('a.id', 'asc');
      }
	  
	  protected function getStoreId($id = '') {		  
				$id .= ':' . $this->getState('filter.userid');

        return parent::getStoreId($id);
      }
	  
	  protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select('*');
        $query->from('#__debate_user_ip_address AS a');

    $filteruserid = $this->getState('filter.userid', null);
        if ($filteruserid !== null && strlen($filteruserid)>0 && $filteruserid!='*')
        {
                $query->where('a.userid=' . $db->escape($filteruserid) );
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
	public function delete($pk = []) {
				        $app = JFactory::getApplication()->input;
							
						$cid= $app->get('cid', array(), 'array');
						$cid = implode(',', $cid);
						//	var_dump($cid);
							//exit();
                             
					  $db = JFactory::getDBO();
   
        $query = $db->getQuery(true);
                    $query->delete($db->quoteName("#__debate_user_ip_address"))
                    ->where("id IN (".$cid.")");
					
					
        $db->setQuery($query);
		
        $db->execute();
        
    			
			}

	

	
	
}
