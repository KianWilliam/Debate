<?php
/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2018-10-13 23:26:33Z $
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
use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

if (!Factory::getUser()->authorise('core.manage', 'com_debate'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'), 404);
}
$document = Factory::getDocument();

  $document->addStyleSheet(JURI::Base().'components/com_debate/assets/css/backclass.css');
 
  
JLoader::register('DebateHelper', JPATH_COMPONENT . '/helpers/debate.php');

$controller = BaseController::getInstance('debate');
$task = Factory::getApplication()->input->get('task');

$controller->execute($task);
$controller->redirect();

