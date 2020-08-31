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

defined('_JEXEC') or die;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Version;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

class DebateHelperBackendmedialoader
{

    static $loaded = false;

    public static function load()
    {

        if (self::$loaded) {
            return;
        }

        self::$loaded = true;


        $document = Factory::getDocument();

        HTMLHelper::_('behavior.formvalidator');

        // Add the modal field script to the document head.
        HTMLHelper::_('jquery.framework');
        HTMLHelper::_('script', 'system/fields/modal-fields.min.js', array('version' => 'auto', 'relative' => true));


        $CSSs = Array();
        $JSs = Array();

        HTMLHelper::_('jquery.framework');

        $CSSs[] = 'backend/css/debate.css';

        if (version_compare(JVERSION, '4.0', '<' ) == 1) {
            $CSSs[] = 'backend/css/joomla3.css';
        }

        $JSs = array_merge($JSs, Array(                
        ));

        foreach($CSSs as $css) {
            $script = Uri::root() . 'media/com_debate/'.$css.'?v=1.0.0';
            $document->addStyleSheet($script);
        }



    }

}

	
	
