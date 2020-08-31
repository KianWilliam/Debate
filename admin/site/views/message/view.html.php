<?php 
/*
 * @package component debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2020-01-13 23:26:33Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2019- Kian William Nowrouzian
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
use Joomla\CMS\MVC\View\HtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

class DebateViewMessage extends HtmlView
{
	protected $state;
	protected $category;
	protected $pagination;
	protected $items;
	protected $params;
	
	function display($tpl = null)
	{
				$app = Factory::getApplication();

		$this->items = $this->get('items');
		
		$this->state = $this->get("state");
		$this->category = $this->get('category');
		
		$this->params = $this->state->get('params');
		$this->_prepareDocument();			

    	$this->setLayout('default.php');
		parent::display($tpl);
		
	}
	protected function _prepareDocument()
	{
		$app		= Factory::getApplication();
		$title = null;
		if(!empty($this->items[0]->title))
		$title 		= $this->items[0]->title;		
		if (empty($title)) {
			$title .= $app->getCfg('sitename');
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
			$title .= Text::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
		}
		elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
			$title .= Text::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
		}
		
		$this->document->setTitle($title);
	}
}