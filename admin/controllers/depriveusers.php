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
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

class DebateControllerDepriveusers extends AdminController
{
	public function getModel($name = 'Depriveuser', $prefix = 'DebateModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		
		return $model;
	}
	public function deleteUsers()
	{

    Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		
		$input = Factory::getApplication()->input;
		$cid = $input->get('cid', array(), '', 'array');
		
	if (!is_array($cid) || count($cid) < 1)
    {
				 Factory::getApplication()->enqueueMessage($this->text_prefix . '_NO_ITEM_SELECTED', 'error');

    }
    else
    {
		
        $model = $this->getModel();

        jimport('joomla.utilities.arrayhelper');
        JArrayHelper::toInteger($cid);        
		
		
	    $db = Factory::getDbo();
		foreach($cid as $key=>$value):
		$query = $db->getQuery(true);
			$query->select('messageid')->from($db->quoteName('#__debate_deprive_users'))->where($db->quoteName('id'). ' = ' . (int) $value);
             $db->setQuery($query);
			 $result = $db->loadObject();
		$query = $db->getQuery(true);
			$fields = array($db->quoteName('fonderid') . " = 0 "  ,$db->quoteName('fonderidea') . " = ". $db->quote('no') );

	$conditions = array($db->quoteName('id') . ' = ' . $db->quote($result->messageid)); 

	$query->update($db->quoteName('#__debate'))->set($fields)->where($conditions);
	
           
            $db->setQuery($query);
            $db->execute();
		
		
		endforeach;
		
		
       if ($model->delete($cid))
        {
          
        }
        else
        {
            $this->setMessage($model->getError());
        }
		

    }
		$this->setRedirect(JRoute::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));

		
		
	}
}