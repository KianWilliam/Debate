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
defined('_JEXEC') or die();

use Joomla\CMS\Factory;
use Joomla\CMS\Component\Router\RouterBase;

jimport('joomla.error.profiler');

class DebateRouter extends RouterBase
{
    public function build(&$query)
    {
		
        $segments = array();
        if (isset($query['view']))
        {
            $segments[] = $query['view'];
            unset($query['view']);
        }
        if (isset($query['id']))
        {
            $segments[] = $query['id'];
            unset($query['id']);
        };
		
		 if (isset($query['catid']))
        {
            $segments[] = $query['catid'];
            unset($query['catid']);
        };
		
		 if (isset($query['threadid']))
        {
            $segments[] = $query['threadid'];
            unset($query['threadid']);
        };
		
		 if (isset($query['userid']))
        {
            $segments[] = $query['userid'];
            unset($query['userid']);
        };
		
		 if (isset($query['title']))
        {
            $segments[] = $query['title'];
            unset($query['title']);
        };
		
		 if (isset($query['firstid']))
        {
            $segments[] = $query['firstid'];
            unset($query['firstid']);
        };
		
        return $segments;
   }
public function parse(&$segments)
{
    $vars = array();
    switch($segments[0])
    {
        case 'categories':
            $vars['view'] = 'categories';
            break;
        case 'category':
            $vars['view'] = 'category';
			if(preg_match('/:/', $segments[1])){
            $id = explode(':', $segments[1]);				 
            $vars['id'] = (int) $id[0];
			}else{
				
				  $vars['id'] = (int) $segments[1];
			}
            break;
		 case 'message':
            $vars['view'] = 'message';
			$id = explode(':', $segments[1]);
            $vars['id'] = (int) $id[0];
			$vars['catid'] = (int) $segments[2];
            break;
        case 'response':
		
            $vars['view'] = 'response';
            $id = explode(':', $segments[1]);
            $vars['id'] = (int) $id[0];
			if(isset($segments[2]))
			    $vars['catid'] = (int) $segments[2];
			if(isset($segments[3]))
            $vars['threadid'] = (int) $segments[3];
			if(isset($segments[4]))
				$vars['userid']=(int) $segments[4];
			if(isset($segments[5]))
				$vars['title']= $segments[5];
			if(isset($segments[6]))
				$vars['firstid']=(int) $segments[6];
            break;
		case 'fonder':
            $vars['view'] = 'fonder';
            $id = explode(':', $segments[1]);
            $vars['id'] = (int) $id[0];
            break;
		case 'user':
            $vars['view'] = 'user';
            $id = explode(':', $segments[1]);
            $vars['id'] = (int) $id[0];
            break;
		case 'chtitle':
            $vars['view'] = 'chtitle';
            $formattitle = explode(':', $segments[1]);
			$vars['format']=$formattitle[0];
            $vars['title'] = $formattitle[1];
            break;
		case 'deprive':
            $vars['view'] = 'deprive';
            break;
    }
    return $vars;
}

}

	


	

	
