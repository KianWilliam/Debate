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

use Joomla\CMS\MVC\Model\AdminModel;
use Joomla\CMS\Table\Table;
use Joomla\CMS\Factory;




class DebateModelResponse extends AdminModel
{

	
	public function getTable($type = 'Message', $prefix = 'DebateTable', $config = array())
	{
		return Table::getInstance($type, $prefix, $config);
	}

    
	public function getForm($data = array(), $loadData = true)
	{
		$form = $this->loadForm(
			'com_debate.response',
			'response',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);
     
		if (empty($form))
		{
			$errors = $this->getErrors();
			throw new Exception(implode("\n", $errors), 500);
		}

		return $form;
	}

	
	protected function loadFormData()
	{
		$data = Factory::getApplication()->getUserState(
			'com_debate.default.response.data',
			array()
		);

		return $data;
	}
    
	
	public function getScript() 
	{
		return 'administrator/components/com_debate/models/debate.js';
	}
}