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
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\Registry\Registry;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Router\Route;
class DebateControllerFonder extends FormController
{
	
  private function holdID(){		
		$context = "$this->option.edit.$this->context";
		$input = Factory::getApplication()->input;
		$recordId = $input->get("id");
		$this->holdEditId($context, $recordId);
		
	}
	
	
	
	public function cancel($key=null){
		$this->holdID();
		return parent::cancel($key);
	}
	public function saveOmega()
	{
				$input = Factory::getApplication()->input;
				$files = $input->files->get('jform');
				$db = Factory::getDbo();
				$query = $db->getQuery(true);
			

				$post = new Registry($input->get('jform', array(), 'array')); 
			

				
				
				
      $dest=null;
	  $userid = $post->get('userid');
	  
	  $id = $post->get('id');
	  
       if( $id==0){
		   
         if($files!==null )
	     {
		  if(!Folder::exists(JPATH_ADMINISTRATOR.'\components\com_debate\assets\images\avatar'))
		  {	
	  
			  Folder::create(JPATH_ADMINISTRATOR.'\components\com_debate\assets\images\avatar', 755);
		  }
		   $newfile = $files['avatar']['name'];
		   $filename = File::makeSafe($newfile);

		   $src = $files['avatar']['tmp_name'];		
		   $dest = JPATH_ADMINISTRATOR.'\components\com_debate\assets\images\avatar\\'.$filename;
		   File::upload($src, $dest);
		 }
		 
		   $columns = array('name', 'email', 'profession', 'avatar', 'jointime', 'userid', 'published');
           $values = array($db->quote($post->get('name')), $db->quote($post->get('email')), 
		   $db->quote($post->get('profession')), $db->quote($filename), $db->quote(date('Y-m-d')), $post->get('userid'), $post->get('published'));
		   
           $query->insert($db->quoteName('#__debate_fonders'))->columns($db->quoteName($columns))->values(implode(',', $values));
		   		   

           $db->setQuery($query);
           $db->execute();
				  
			 
			  
		     }
			 else
				 if($post->get('id')!=0)
				 {
					 
					 $newfile = $files['avatar']['name'];
		             $filename = File::makeSafe($newfile);
					 $src = $files['avatar']['tmp_name'];
					 
                     $query->select('*')->from($db->quoteName('#__debate_fonders'))->where($db->quoteName('id') .'='. $db->quote($id));

					 $db->setQuery($query);
					 $avatar = $db->loadObject();					 
				            
							   if($avatar->avatar ===  $filename ){
							   }
							   else
								   if(!empty($filename))
							   {
								    File::delete(JPATH_ADMINISTRATOR.'\components\com_debate\assets\images\avatar\\'.$avatar->avatar);
								    $dest = JPATH_ADMINISTRATOR.'\components\com_debate\assets\images\avatar\\'.$filename;
		                            File::upload($src, $dest);
									$fields = array($db->quoteName('avatar') . ' = ' . $db->quote($filename));												
                                    $conditions = array($db->quoteName('userid') . ' = ' . $db->quote($userid));
                                    $query->update($db->quoteName('#__debate_fonders'))->set($fields)->where($conditions);
                                    $db->setQuery($query);
                                    $result = $db->execute();
							   }
								  
					 if($post->get('name')!==$avatar->name):
					                $fields = array($db->quoteName('name') . ' = ' . $db->quote($post->get('name')));												
                                    $conditions = array($db->quoteName('userid') . ' = ' . $db->quote($userid));
                                    $query->update($db->quoteName('#__debate_fonders'))->set($fields)->where($conditions);
                                    $db->setQuery($query);
                                    $result = $db->execute();
					 endif;
					 if($post->get('email')!==$avatar->email):
					                $fields = array($db->quoteName('email') . ' = ' . $db->quote($post->get('email')));												
                                    $conditions = array($db->quoteName('userid') . ' = ' . $db->quote($userid));
                                    $query->update($db->quoteName('#__debate_fonders'))->set($fields)->where($conditions);
                                    $db->setQuery($query);
                                    $result = $db->execute();
					 endif;
					 if($post->get('profession')!==$avatar->profession):
					                $fields = array($db->quoteName('profession') . ' = ' . $db->quote($post->get('profession')));												
                                    $conditions = array($db->quoteName('userid') . ' = ' . $db->quote($userid));
                                    $query->update($db->quoteName('#__debate_fonders'))->set($fields)->where($conditions);
                                    $db->setQuery($query);
                                    $result = $db->execute();
					 endif;
					 if($post->get('userid')!=$avatar->userid):
					                $fields = array($db->quoteName('userid') . ' = ' . $db->quote($post->get('userid')));												
                                    $conditions = array($db->quoteName('id') . ' = ' . $db->quote($id));
                                    $query->update($db->quoteName('#__debate_fonders'))->set($fields)->where($conditions);
                                    $db->setQuery($query);
                                    $result = $db->execute();
					 endif;

					 
				 }
			 
		 
	  
		$this->setRedirect('index.php?option=com_debate&view=fonders', Text::_('COM_DEBATE_FONDER'));

	}
}
