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
defined('_JEXEC') or die( 'Restricted access' );
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;
use Joomla\CMS\Toolbar\ToolbarHelper;


class DebateViewDeprivelistusers extends HtmlView
{
	protected $items;
	protected $pagination;
	protected $state;
	public function display($tpl = null)
	{
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }
				$this->sidebar = JHtmlSidebar::render();


		$this->addToolbar();		
		parent::display($tpl);		
	}
	protected function addToolbar()
	{
		$title = Text::_('COM_DEBATE'). " - ". Text::_('COM_DEBATE_DEPRIVE_LIST');
		ToolBarHelper::title($title , 'generic.png');	

		
		ToolBarHelper::editList('deprivelistuser.edit','JTOOLBAR_EDIT');		
		ToolBarHelper::deleteList('COM_DEBATE_DEPRIVE_USERS_APPROVE_DELETE', 'deprivelistusers.delete','JTOOLBAR_DELETE');

		
	

	}



}