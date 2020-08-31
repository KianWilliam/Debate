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
jimport( 'joomla.filesystem.file' );
use Joomla\CMS\Date\Date;
use Joomla\CMS\MVC\Controller\FormController;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\User\UserHelper;
use Joomla\CMS\Router\Route;



class DebateControllerResponse extends FormController
{   
    public function cancel($key = null)
    {
        parent::cancel($key);
        
        $this->setRedirect(
            (string)Uri::getInstance(), 
            Text::_('COM_DEBATE_ADD_CANCELLED')
		);
    }
    
  
    public function save($key = null, $urlVar = null)
    {
				
		
		Session::checkToken() or jexit(Text::_('JINVALID_TOKEN'));
		$db = Factory::getDbo();

        $user = Factory::getUser();
		
		$username = $user->name;
		$userid = $user->id;
		$app = Factory::getApplication(); 
		$input = $app->input;
		$ipaddress = $input->server->get('HTTP_HOST', '', '');
		$post = $input->get('jform', array(), 'post', array());
		
		
		
		$query = $db->getQuery('true');
	    $query->select('*')->from($db->quoteName('#__debate_deprive_users'))->where('userid='.$db->quote($userid));
		$db->setQuery($query);
	    $depriveresult = $db->loadObject();
		$now = new Date('now');
		
		
		if(empty($depriveresult) ||  new JDate($depriveresult->deprivedate.' +1 month') <= $now)
		{	

				$query = $db->getQuery('true');
				$query->delete('#__debate_deprive_users')->where('userid = '.$db->quote($userid));
				$db->setQuery($query);
				$db->execute();

	
		
			$query = $db->getQuery(true);
            $columns = array('userid', 'ipaddress', 'datetime');
            $values = array( $db->quote($user->id), $db->quote($ipaddress),  $db->quote($now->toSQL()));
            $query
            ->insert($db->quoteName('#__debate_user_ip_address'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();
		
			$query = $db->getQuery('true');
	    $query->select('*')->from($db->quoteName('#__debate_fonders'))->where('userid='.$db->quote($userid));
		$db->setQuery($query);
	    $fonder = $db->loadObject();
		
				
				
	    if(!empty($post['firstid']))
                   	$firstid = $post['firstid'];	
		


		
		if(!empty($post['id']))
		   $id = $post['id'];
		else
			if(!empty($input->get('id')))
			    $id = $input->get('id');
			
		
		if(!empty($post['catid']))
		    $catid = $post['catid'];
		else
			$catid = $input->get('catid');

				if(!empty($post['threadid']))
		            $threadid = $post['threadid'];
		        else
					$threadid = $input->get('threadid');
			

		
		  $files = $input->files->get('jform');
	
		  $firstid = (int) $firstid;
		  
		  if($firstid  && !empty($id)){
			  
			  	 $alreadyloadedfiles = Folder::files(JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments');
				  foreach($alreadyloadedfiles as $value)
		          {
					  if(preg_match('/'.$id.'/', $value)){
						    $filename = str_replace("/", "\\", JPATH_ADMINISTRATOR."\\components\\com_debate\\FileAttachments\\" .$value );				
				               File::delete($filename);
					  }
				  }

			  
		  }
		  
		 
		
		  
		  
		   if(!Folder::exists(JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments'))
		  {
			  
			  Folder::create(JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments', 755);
		  }
		  
		  				  	  if(!$firstid  || empty($id)){

		  	  $query = $db->getQuery(true);
		  $query = "SELECT MAX(id) FROM `#__debate`";
		  $db->setQuery($query);
		  $recid = $db->loadResult();
		  $recid++;
							  }
		  
		  
		  if(!empty($files['attachmentfile'])){
		$pathindb = '';  
     foreach($files['attachmentfile'] as $k=>$v):
		
      $dest=null;
	  if(!empty($v['name']))
	  {		  
		  $alreadyloadedfiles = Folder::files(JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments');
		  if(preg_match('/\s+/', $username))
		       $un = str_replace(" ", "_", $username);
			
				  $filename = File::makeSafe($v['name']);
				  
				  $filearr = explode('.', $filename);

		          $src = $v['tmp_name'];
				  
			
				  	  if(!$firstid  || empty($id)){
				  
				   if(!empty($un)){
			      $dest = JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments\\'.$un.'_'.$filearr[0].'_'.$recid.'.'.$filearr[1];
				  				  $pathindb .= $un.'_'.$filearr[0].'_'.$recid.'.'.$filearr[1].',';
				  }
				  else
				  {
					   $dest = JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments\\'.$username.'_'.$filearr[0].'_'.$recid.'.'.$filearr[1];
				  				  $pathindb .= $username.'_'.$filearr[0].'_'.$recid.'.'.$filearr[1].',';
				  }
				  }
				  else
				  {
				       if(!empty($un)){
			      $dest = JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments\\'.$un.'_'.$filearr[0].'_'.$id.'.'.$filearr[1];
				  				  $pathindb .= $un.'_'.$filearr[0].'_'.$id.'.'.$filearr[1].',';
				  }
				  else
				  {
					   $dest = JPATH_ADMINISTRATOR.'\components\com_debate\FileAttachments\\'.$username.'_'.$filearr[0].'_'.$id.'.'.$filearr[1];
				  				  $pathindb .= $username.'_'.$filearr[0].'_'.$id.'.'.$filearr[1].',';
				  }
				      
				  }


		          File::upload($src, $dest);
			  
			  
		     
			 
		 
	  }
	  
	  endforeach;
	  $pathindb = substr($pathindb, 0, strlen($pathindb)-1);
	    
		  }
	 
	  		  

	
			
		
		
		$model = $this->getModel('response');
		
        
	
		$currentUri = (string)Uri::getInstance();
		
		$data  = $input->get('jform', array(),  'array');
		
      
		$context = "$this->option.default.$this->context";
        
		
		$form = $model->getForm($data, false);
		

		if (!$form)
		{
			$app->enqueueMessage($model->getError(), 'error');
			return false;
		}

	
	
		$data['userid'] = $userid;
		
		
		$date = new Date('now');
	
		$data['created']=$date->toSQL();
		
		if(!empty($fonder)):
			$data['fondermessage'] = 'Yes';

			endif;

		
		if(!empty($pathindb)):
		    $data['attachment']=$pathindb;
         else:
			$data['attachment']=null;
			endif;
			
			
			$data['published']=1;
		
		  
if($threadid==0)
{
	
	$db = Factory::getDbo();
	$query = $db->getQuery('true');
	$query->select(array($db->quoteName('id'),$db->quoteName('threadid')))->from($db->quoteName('#__debate_thread_id'));
	$db->setQuery($query);
	$result = $db->loadObject();
	
	if(!empty($result->threadid) && $result->threadid!==0):
		$threadid = $result->threadid;
		
		$data['threadid']=$threadid;
	
	    $threadid++;
		$query = $db->getQuery('true');
		$query->delete($db->quoteName('#__debate_thread_id'))->where($db->quoteName('id').'='.$db->quote($result->id));
		$db->setQuery($query);
        $db->execute();
		$query = $db->getQuery('true');
		$query
         ->insert($db->quoteName('#__debate_thread_id'))
         ->columns($db->quoteName('threadid'))
         ->values($threadid);
		 $db->setQuery($query);
        $db->execute();
	else:
		$threadid=1;
		$data['threadid']=$threadid;
	    $threadid++;
		$query = $db->getQuery('true');
		$query
         ->insert($db->quoteName('#__debate_thread_id'))
         ->columns($db->quoteName('threadid'))
         ->values($threadid);
		 $db->setQuery($query);
        $db->execute();

	endif;
	

			if (!$model->save($data))
		{
	
						$app->setUserState($context . '.data', $data);

			
			

			$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect($currentUri);

			return false;
		}
   }
else
{
	
		 	 if($data['id']==0){

		   	   if (!$model->save($data))

		{
	
						$app->setUserState($context . '.data', $data);


			$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect($currentUri);

			return false;
		}
	}
	else
	{
	
		 $model->delete($data['id']);
		  		

		
		
		$query = $db->getQuery(true);
            $columns = array('id', 'catid', 'threadid', 'userid', 'message', 'attachment', 'created', 'title', 'published');
            $values = array($db->quote($id),$db->quote($catid),$db->quote($threadid), $db->quote($user->id), $db->quote($data['message']), $db->quote($data['attachment']), $db->quote($now->toSQL()), $db->quote($data['title']), '1');

			$query
            ->insert($db->quoteName('#__debate'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));
            $db->setQuery($query);
            $db->execute();

			
      			 
UserHelper::removeUserFromGroup($user->id, 6);
UserHelper::addUserToGroup($user->id, 2);
	
			
			
	
        } 
   
	}
	
	
        
		
        
		$app->setUserState($context . '.data', null);
        
        
		$params   = $app->getParams();
		$userid_to_email = (int) $params->get('user_to_email');
		$user_to_email = JUser::getInstance($userid_to_email);
		$to_address = $user_to_email->get("email");
        
		$current_user = Factory::getUser();
		if ($current_user->get("id") > 0) 
		{
			$current_username = $current_user->get("username");
		}
		else 
		{
			$current_username = "a visitor to the site";
		}
		
        $config = Factory::getConfig();
$fromname = $config->get('fromname');
$mailfrom = $config->get('mailfrom');
		$mailer = Factory::getMailer();
		
		try 
		{
		$mailer->sendMail($mailfrom,$fromname,$to_address, "New response message added by " . $username, "Check your forum to view new message(s)");

		}
		catch (Exception $e)
		{
			throw new Exception(implode("\n", 'mailer function can not be initialized'), 500);

		}
		$threadid = $post['threadid'];

		if(!empty($threadid))
		{
			
			$query=	$db->getQuery(true);
				 				 
				 $query->select('*')->from($db->quoteName('#__debate'))->where('threadid='. $db->quote($threadid));
				 $db->setQuery($query);

    $linkid = $db->loadObject();
  
   
			
			$query = $db->getQuery(true);
			
				 				 
				 $query
    ->select(array('b.id, b.email', 'b.name'))
    ->from($db->quoteName('#__debate_subscriptions', 'a'))
    ->join('INNER', $db->quoteName('#__users', 'b') . ' ON (' . $db->quoteName('a.userid') . ' = ' . $db->quoteName('b.id') . ')')
    ->where($db->quoteName('a.threadid') . '='. $threadid)
    ->order($db->quoteName('a.id') . ' ASC');
				

				 $db->setQuery($query);
				 $r = $db->loadObjectList();
				 
		
    
				 if(!empty($r)):
				     $link = Route::_(Uri::Base().'index.php?option=com_debate&view=message&id='.$linkid->id.'&catid='.$catid);
				     	 $body = "There is a new response added to the thread with title: ".$post['title']." click here to view it:".$link;

			
				 for($s=0; $s<count($r); $s++):
				 
			         if((int) $r[$s]->id != (int) $userid){
                       try 
                       {
			             $mailer->sendMail($mailfrom, $fromname, $r[$s]->email, "New response message added by " . $username, $body); 
		               }
		               catch (Exception $e)
		               {
						throw new Exception(implode("\n", 'mailer function can not be initialized'), 500);

		               }
		             }  
		       
		               
				 endfor;
				 endif;
		}
     			

            if(!empty($firstid))
				
	           $this->setRedirect(Route::_(
				'index.php?option=com_debate&view=message&id='.$firstid.'&catid='.$catid,
				Text::_('COM_DEBATE_ADD_SUCCESSFUL'))
			);
				else
				
					$this->setRedirect(Route::_(
				'index.php?option=com_debate&view=category&id='.$catid,
				Text::_('COM_DEBATE_ADD_SUCCESSFUL'))
				);
				
					
		
        }
		else
        {
			$this->setRedirect(Route::_(
				'index.php?option=com_debate&view=deprive',
				Text::_('COM_DEBATE_DEPRIVE'))
				);
        }
		
		return true;
        
    }

}