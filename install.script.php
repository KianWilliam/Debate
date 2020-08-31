<?php
/*
 * @package component Debate for Joomla! 3.x
 * @version $Id: com_debate 1.0.0 2020-01-13 10:10:10Z $
 * @author Kian William Nowrouzian
 * @copyright (C) 2016- Kian William Nowrouzian
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 
 This file is part of Debate.
    Debate is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    Debate is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with Debate.  If not, see <http://www.gnu.org/licenses/>.
 
*/
?>
<?php
defined('_JEXEC') or die('Restricted access');
use Joomla\CMS\Factory;
class pkg_DebateInstallerScript
{
 public function install($parent)
 {
  
   
  $db  = Factory::getDbo();
  $query = $db->getQuery(true);
  $query->update('#__extensions');
  $query->set($db->quoteName('enabled') . ' = 1');
  $query->where($db->quoteName('element') . ' = ' . $db->quote('deleteuserrecs'));
  $query->where($db->quoteName('type') . ' = ' . $db->quote('plugin'));
  $db->setQuery($query);
  $db->execute();
  
 
  
  
  
 }
   public function uninstall($parent) 
  {
	       
       
  }
}
