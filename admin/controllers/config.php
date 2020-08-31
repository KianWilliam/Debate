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


class DebateControllerConfig extends FormController
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
				
				$query->select('*')->from($db->quoteName('#__debate_config'))->where('id=1');
				$db->setQuery($query);
				$result = $db->loadObject();
				if(!empty($result)):
	
				
                        $query = $db->getQuery(true);

                       $fields = array(
                       $db->quoteName('forumtitle') . ' = ' . $db->quote($post->get('forumtitle')),
                       $db->quoteName('forumemail') . ' = ' . $db->quote($post->get('forumemail')),
                       $db->quoteName('forumoffline') . ' = ' . $db->quote($post->get('forumoffline')),
                       $db->quoteName('publishrules') . ' = ' . $db->quote($post->get('publishrules')),
					     $db->quoteName('viewfonderprofile') . ' = ' . $db->quote($post->get('viewfonderprofile')),
                       $db->quoteName('offlinemessage') . ' = ' . $db->quote($post->get('offlinemessage')),
                       $db->quoteName('showhistory') . ' = ' . $db->quote($post->get('showhistory')),
                       $db->quoteName('shownewposts') . ' = ' . $db->quote($post->get('shownewposts')),					   
					     $db->quoteName('messagereporting') . ' = ' . $db->quote($post->get('messagereporting')),
                       $db->quoteName('showuserstatistics') . ' = ' . $db->quote($post->get('showuserstatistics')),
                       $db->quoteName('allowsubscriptions') . ' = ' . $db->quote($post->get('allowsubscriptions')),
                       $db->quoteName('showusersonline') . ' = ' . $db->quote($post->get('showusersonline')),
					     $db->quoteName('showjoindate') . ' = ' . $db->quote($post->get('showjoindate')),
                       $db->quoteName('showlastvisitdate') . ' = ' . $db->quote($post->get('showlastvisitdate')),
                       $db->quoteName('recnumcat') . ' = ' . $db->quote($post->get('recnumcat')),
                       $db->quoteName('recnummess') . ' = ' . $db->quote($post->get('recnummess')),					   
					     $db->quoteName('buttbakcolor') . ' = ' . $db->quote($post->get('buttbakcolor')),
                       $db->quoteName('titlecolor') . ' = ' . $db->quote($post->get('titlecolor')),
                       $db->quoteName('textcolor') . ' = ' . $db->quote($post->get('textcolor')),
                       $db->quoteName('framebordercolor') . ' = ' . $db->quote($post->get('framebordercolor')),
					     $db->quoteName('titlefontweight') . ' = ' . $db->quote($post->get('titlefontweight')),
                       $db->quoteName('titlefontstyle') . ' = ' . $db->quote($post->get('titlefontstyle')),
                       $db->quoteName('textfontweight') . ' = ' . $db->quote($post->get('textfontweight')),
                       $db->quoteName('textfontstyle') . ' = ' . $db->quote($post->get('textfontstyle')),					   
					     $db->quoteName('fontfamily') . ' = ' . $db->quote($post->get('fontfamily')),
                       $db->quoteName('textfontsize') . ' = ' . $db->quote($post->get('textfontsize')),
                       $db->quoteName('titlefontsize') . ' = ' . $db->quote($post->get('titlefontsize')),
                       $db->quoteName('frameborderradius') . ' = ' . $db->quote($post->get('frameborderradius')),					   
                          );


                   $conditions = array($db->quoteName('id') . ' =  1 '  );

                    $query->update($db->quoteName('#__debate_config'))->set($fields)->where($conditions);

                   $db->setQuery($query);

                    $db->execute();
					else:
					
							$query = $db->getQuery(true);
							$columns = array('forumtitle', 'forumemail', 'forumoffline', 'publishrules', 'viewfonderprofile', 'offlinemessage',
							'showhistory', 'shownewposts', 'messagereporting', 'showuserstatistics', 'allowsubscriptions', 'showusersonline', 'showjoindate', 'showlastvisitdate',
							'recnumcat', 'recnummess', 'buttbakcolor', 'titlecolor', 'textcolor', 'framebordercolor', 
							'titlefontweight', 'titlefontstyle', 'textfontweight', 'textfontstyle', 'fontfamily', 'textfontsize', 'titlefontsize', 'frameborderradius');


                        $values = array( $db->quote($post->get('forumtitle')),
                        $db->quote($post->get('forumemail')),
                        $db->quote($post->get('forumoffline')),
                        $db->quote($post->get('publishrules')),
					    $db->quote($post->get('viewfonderprofile')),
                        $db->quote($post->get('offlinemessage')),
                        $db->quote($post->get('showhistory')),
                        $db->quote($post->get('shownewposts')),					   
					    $db->quote($post->get('messagereporting')),
                        $db->quote($post->get('showuserstatistics')),
                       $db->quote($post->get('allowsubscriptions')),
                        $db->quote($post->get('showusersonline')),
					     $db->quote($post->get('showjoindate')),
                        $db->quote($post->get('showlastvisitdate')),
                       $db->quote($post->get('recnumcat')),
                        $db->quote($post->get('recnummess')),					   
					      $db->quote($post->get('buttbakcolor')),
                        $db->quote($post->get('titlecolor')),
                       $db->quote($post->get('textcolor')),
                        $db->quote($post->get('framebordercolor')),
					      $db->quote($post->get('titlefontweight')),
                        $db->quote($post->get('titlefontstyle')),
                        $db->quote($post->get('textfontweight')),
                        $db->quote($post->get('textfontstyle')),					   
					     $db->quote($post->get('fontfamily')),
                       $db->quote($post->get('textfontsize')),
                       $db->quote($post->get('titlefontsize')),
                        $db->quote($post->get('frameborderradius')),	);


$query
    ->insert($db->quoteName('#__debate_config'))
    ->columns($db->quoteName($columns))
    ->values(implode(',', $values));


$db->setQuery($query);
$db->execute();

					
					endif;
				
				  $this->setRedirect('index.php?option=' . $this->option . '&view=config&layout=edit', false);

		
	}
	
}
