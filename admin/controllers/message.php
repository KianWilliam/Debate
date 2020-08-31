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
use Joomla\CMS\Router\Route;
use Joomla\Registry\Registry;
class DebateControllerMessage extends FormController
{
  private function holdID(){		
		$context = "$this->option.edit.$this->context";
		$input = Factory::getApplication()->input;
		$recordId = $input->get("id");
		$this->holdEditId($context, $recordId);
		
	}
	
	public function saveBeta(){
		
		        $input = Factory::getApplication()->input;
				$db = Factory::getDbo();
				$query = $db->getQuery(true);
			
				$post = new Registry($input->get('jform', array(), 'array')); 
				
			
				$query->select('*')->from($db->quoteName('#__debate'))->where('id = '. $post->get('id'));
				$db->setQuery($query);

				$result = $db->loadObject();
				
				if(!empty($result)){
					
					
					
					
					
				if($result->fonderid !== $post->get('fonderid') || $result->fonderidea !== $post->get('fonderidea') || $result->title !== $post->get('title') || $result->message !== $post->get('message')):
				
				
                        $query = $db->getQuery(true);

                       $fields = array(
                       $db->quoteName('fonderid') . ' = ' . $db->quote($post->get('fonderid')),
                       $db->quoteName('fonderidea') . ' = ' . $db->quote($post->get('fonderidea')),
                       $db->quoteName('title') . ' = ' . $db->quote($post->get('title')),
                       $db->quoteName('message') . ' = ' . $db->quote($post->get('message')),
                          );


                   $conditions = array($db->quoteName('id') . ' = ' . $post->get('id') );

                    $query->update($db->quoteName('#__debate'))->set($fields)->where($conditions);

                   $db->setQuery($query);

                    $db->execute();
				
					$fonderid = $post->get('fonderid');
					$userid = $post->get('userid');
					$id = $post->get('id');
					$fidea = $post->get('fonderidea');
				


					
				   $this->setRedirect('index.php?option=' . $this->option . '&view=messages&fonderid='.$fonderid.'&userid='.$userid.'&messageid='.$id.'&fonderidea='.$fidea);

				
				else:
				  $this->setRedirect(Route::_('index.php?option=' . $this->option . '&view=messages', false));

			    endif;
				}
				
	}
	
	public function cancel($key=null){
		$this->holdID();
		return parent::cancel($key);
	}
}
