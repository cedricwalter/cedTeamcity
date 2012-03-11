<?php
/**
 * @version        CedTeamcity
 * @package
 * @copyright    Copyright (C) 2009-2012 Cedric Walter. All rights reserved.
 * @copyright    www.cedricwalter.com / www.waltercedric.com
 *
 * @license        GNU/GPL v3.0, see LICENSE.php
 *
 * CedTeamcity is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__) . DS . 'Teamcity.php');

abstract class modTeamcityHelper
{

    public static function getList($params)
    {
        $user = $params->get('user', 'xxxxxx');
        $password = $params->get('password', 'xxxxxxx');
        $teamcityServer = $params->get('teamcityServer', 'xxxxxxx');

        $Teamcity = new Teamcity($user, $password, $teamcityServer);

        return $Teamcity->getProjects();
    }

    public static function addStyleSheet()
    {
        $document =& JFactory::getDocument();
        $document->addStyleSheet('media/mod_teamcity/teamcity.css');
    }

}