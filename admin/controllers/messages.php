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
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Router\Route;
class DebateControllerMessages extends AdminController
{
	public function getModel($name = 'Message', $prefix = 'DebateModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		
		return $model;
	}
	public function deleteMessages()
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
		$files = [];
		$threadids = [];
		
	    $db = Factory::getDbo();
		foreach($cid as $key=>$value):
		$query = $db->getQuery('true');
	    $query->select('*')->from($db->quoteName('#__debate'))->where('id='.$value);
		$db->setQuery($query);
		$rec = $db->loadObject();
		if(!empty($rec->attachment))
			$files[]=$rec->attachment;
		$threadids [] = $rec->threadid;
		
		
		endforeach;
		$threads=array_unique($threadids);
				
				foreach($cid as $key=>$value):
				
		
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__debate_subscriptions'))->where($db->quoteName('userid') . ' = ' . (int) $value);
        try
		{
			$db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__debate_fonders'))->where($db->quoteName('userid') . ' = ' . (int) $value);
        try
		{
			$db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		
		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__debate_badpost_users'))->where($db->quoteName('userid') . ' = ' . (int) $value);
        try
		{
			$db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}


		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__debate_edit_users'))->where($db->quoteName('userid') . ' = ' . (int) $value);
        try
		{
			$db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		

		$query = $db->getQuery(true);
		$query->delete($db->quoteName('#__debate_deprive_users'))->where($db->quoteName('userid') . ' = ' . (int) $value);
         try
		{
			$db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		
				
				
				endforeach;

		
        foreach($files as $key=>$val):
		if(strpos($val, ",")):
			$arrfiles = explode(',', $val);
			foreach($arrfiles as $k=>$v):
			  		  File::delete(JPATH_ADMINISTRATOR."\components\com_debate\FileAttachments\\".$v);

			endforeach;
		else:
		  File::delete(JPATH_ADMINISTRATOR."\components\com_debate\FileAttachments\\".$val);
		endif;
		endforeach;
		
        	for($i=0; $i<count($threads); $i++){
			$query = $db->getQuery(true);
			$query->select('*')->from($db->quoteName('#__debate'))->where($db->quoteName('threadid'). ' = ' . (int) $threads[$i]);
             $db->setQuery($query);
			 $result = $db->loadObject();
			 foreach($cid as $k1=>$v1):
			 if($result->id==$v1)
			 {			
				 $query = $db->getQuery(true);
				 $query->update($db->quoteName('#__debate'))->set('published = 0')->where('threadid = '.$db->quote($threads[$i]));
				 $db->setQuery($query);
				 $db->execute();
			 }
			 endforeach;
		}
		
		
       if ($model->delete($cid))
        {
          
        }
        else
        {
            $this->setMessage($model->getError());
        }
		

    }
		$this->setRedirect(Route::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));

		
		
	}
}
