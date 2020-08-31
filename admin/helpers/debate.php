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
use Joomla\CMS\Helper\ContentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

abstract class DebateHelper extends ContentHelper
{
	
	public static function addSubmenu($vName = null)
	{
		$document = Factory::getDocument();
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_CONTROL_PANEL'),
			'index.php?option=com_debate&view=controlpanel',
			$vName == 'control panel'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_MESSAGES'),
			'index.php?option=com_debate&view=messages',
			$vName == 'messages'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_RULES'),
			'index.php?option=com_debate&view=rules',
			$vName == 'rules'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_FONDERS'),
			'index.php?option=com_debate&view=fonders',
			$vName == 'fonders'
		);
		
				JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_FILES'),
			'index.php?option=com_debate&view=files',
			$vName == 'files'
		);

		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_IPS'),
			'index.php?option=com_debate&view=ips',
			$vName == 'ips'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_CONFIG'),
			'index.php?option=com_debate&view=config&layout=edit',
			$vName == 'config'
		);
		
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_DEPRIVEUSERS'),
			'index.php?option=com_debate&view=depriveusers',
			$vName == 'depriveusers'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_DEPRIVELIST'),
			'index.php?option=com_debate&view=deprivelistusers',
			$vName == 'deprivelistusers'
		);
		
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_BADPOSTS'),
			'index.php?option=com_debate&view=badposts',
			$vName == 'badposts'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_EDITEDMESSAGES'),
			'index.php?option=com_debate&view=editedmessages',
			$vName == 'editedmessages'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_CATEGORIES'),
			'index.php?option=com_categories&extension=com_debate',
			$vName == 'categories'
		);
		
		JHtmlSidebar::addEntry(
			Text::_('COM_DEBATE_SUBMENU_USERS'),
			'index.php?option=com_users&extension=com_debate',
			$vName == 'users'
		);
		
		if($vName=='categories')
		{
			$document->setTitle(Text::_('COM_DEBATE_ADMINISTRATION_CATEGORIES'));
		}


		
	}
	
}
