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
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Router\Route;

class DebateControllerFiles extends AdminController
{
	public function deleteFiles()
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
        	 
          if(Folder::exists(JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments')):
		   
		  $db = Factory::getDbo();
		  
		    for($i=0; $i<count($cid); $i++):
				$query = $db->getQuery(true);
				$query->select($db->quoteName('attachment'))->from($db->quoteName('#__debate'))->where($db->quoteName('id').' = '. $db->quote($cid[$i]));
								$db->setQuery($query);

                $result = $db->loadObject();
				
                
				if(!empty($result)):
				 
				
				   if(!strpos($result->attachment, ',')){
					   
					   $safefilename = $result->attachment;
					   	 
					   
					   
					   $safefilename = str_replace("/", "\\", JPATH_ADMINISTRATOR."\\components\\com_debate\\FileAttachments\\" .$safefilename );
					   
				
				               File::delete($safefilename);
							   
							   
				   }
						   else
						   {
							   $files = explode(',' ,$result->attachment);
							   
							   for($k=0; $k<count($files); $k++)
							   {
								  
								   	$filepath = str_replace("/", "\\", JPATH_ADMINISTRATOR."\\components\\com_debate\\FileAttachments\\" .$files[$k] );

								   	$files[$k] =  $filepath;


							   }	
                              	File::delete($files);	
							   
						   }
						   
						    $query = $db->getQuery(true);
				$query->update($db->quoteName('#__debate'))->set($db->quoteName('attachment').' = NULL')->where('id = '. $cid[$i]);
				$db->setQuery($query);
				$db->execute();
			   
				endif;

			endfor;
		
		  
		  endif;
		   
		
		
    }
		$this->setRedirect(Route::_('index.php?option=' . $this->option . '&view=' . $this->view_list, false));

		
		
	}
	
}
