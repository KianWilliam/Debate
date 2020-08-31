<?php 

/**
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
 
**/


?>
<?php
defined('_JEXEC') or die;
use Joomla\CMS\User\User;
use Joomla\CMS\User\UserHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Filesystem\File;
class PlgUserDeleteuserrecs extends CMSPlugin
{
	protected $db;
	
	public function onUserAfterDelete($user, $succes, $msg)
	{
	
		
		if (!$succes) {
			return false;
		}
		if($succes)
		{

		$query = $this->db->getQuery(true);
		$query->select('*')->from($this->db->quoteName('#__debate'))->where($this->db->quoteName('userid') . ' = ' . (int) $user['id']);
		$this->db->setQuery($query);
		$res = $this->db->loadObjectList();
		$threadids = [];
		$files = [];
		if(!empty($res)){
		for($i=0; $i<count($res); $i++):
		   if(!empty($res[$i]->attachment)){
			   $files[] = $res[$i]->attachment;			   
            
		   }
		       $threadids[] = $res[$i]->threadid;		   
		endfor;
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
		
		$threads = array_unique($threadids);
	
		
		for($i=0; $i<count($threads); $i++){
			$query = $this->db->getQuery(true);
			$query->select('*')->from($this->db->quoteName('#__debate'))->where($this->db->quoteName('threadid'). ' = ' . (int) $threads[$i]);
             $this->db->setQuery($query);
			 $result = $this->db->loadObject();
			 if($result->userid==$user['id'])
			 {			
				 $query = $this->db->getQuery(true);
				 $query->update($this->db->quoteName('#__debate'))->set('published = 0')->where($this->db->quoteName('userid') . ' != ' . (int) $user['id'])
				 ->where('threadid = '.$this->db->quote($threads[$i]));
				 $this->db->setQuery($query);
				 $this->db->execute();
			 }
		}

				
	
	

		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__debate'))->where($this->db->quoteName('userid') . ' = ' . (int) $user['id']);

         try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			var_dump($e);
			return false;
		}

		}
		
		
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__debate_subscriptions'))->where($this->db->quoteName('userid') . ' = ' . (int) $user['id']);
        try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__debate_fonders'))->where($this->db->quoteName('userid') . ' = ' . (int) $user['id']);
        try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		
		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__debate_badpost_users'))->where($this->db->quoteName('userid') . ' = ' . (int) $user['id']);
        try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}


		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__debate_edit_users'))->where($this->db->quoteName('userid') . ' = ' . (int) $user['id']);
        try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		

		$query = $this->db->getQuery(true);
		$query->delete($this->db->quoteName('#__debate_deprive_users'))->where($this->db->quoteName('userid') . ' = ' . (int) $user['id']);
         try
		{
			$this->db->setQuery($query)->execute();
		}
		catch (JDatabaseExceptionExecuting $e)
		{
			return false;
		}

		
		return true;
		
		}

		


	}	
	


}
