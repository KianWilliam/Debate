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
 use Joomla\CMS\MVC\View\CategoryView;

class DebateViewCategory extends CategoryView
{
		
	
	protected  $extension = 'com_debate';

	protected  $defaultPageTitle = 'COM_DEBATE_DEFAULT_PAGE_TITLE';
	
	protected $viewName = 'category';

	

	public function display($tpl = null)
	{
		
$this->items = $this->get('items');
$this->state = $this->get('state');


$this->params = $this->state->get('params');

$this->category = $this->get('category');
$this->children=$this->get('children');
$this->maxLevel = $this->params->get('maxLevel');
$this->counter = $this->params->get('counter1');
$this->pagination = $this->get('pagination');



	


if(!empty($this->items)){
		foreach ($this->items as $item)
		{
			if(isset($item->slug) && isset($item->alias))
			$item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
		if(isset($item->params)){
			$temp       = $item->params;
			$item->params = clone $this->params;
			$item->params->merge($temp);
		}

			
		}
       }
	   
$this->prepareDocument();

		 parent::display($tpl);
	}

	
	protected function prepareDocument()
	{

		
				$title = $this->category->title;
		$this->document->setTitle($title);

        
	}

}