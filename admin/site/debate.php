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
 use Joomla\CMS\User\UserHelper;
 use Joomla\CMS\MVC\Controller\BaseController;

 require_once JPATH_COMPONENT.'/helpers/route.php';
 $document = Factory::getDocument();
 
  $document->addStyleSheet(JURI::Base().'components/com_debate/assets/css/style.css');
 $input = Factory::getApplication()->input;
 $user = Factory::getUser();
 $data  = $input->get('jform', array(),  'array');
 
 if(!empty($data)):
 
 
 if( !empty($data['id']) && $data['id']!==0){			 

UserHelper::removeUserFromGroup($user->id, 2);
UserHelper::addUserToGroup($user->id, 6);	 
	 	
 }
 
 endif;
 
 $controller	= BaseController::getInstance('debate');
 $controller->execute($input->get('task'));
 $controller->redirect();
