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

require_once (dirname(__FILE__) . DS . 'helper.php');

$layout = $params->get('layout', 'projects');

$cacheParameters = new stdClass;
$cacheParameters->cachemode = 'safeuri';
$cacheParameters->class = 'modTeamcityHelper';
$cacheParameters->method = 'get'.substr($layout, 2);
$cacheParameters->methodparams = $params;
$cacheParameters->modeparams = array('id' => 'int', 'Itemid' => 'int');

$list = JModuleHelper::moduleCache($module, $params, $cacheParameters);

if (!count($list)) {
    return;
}

$rendering = $params->get('rendering', "rokbox");
$teamcityIcon = $params->get('teamcityIcon', 128);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
require JModuleHelper::getLayoutPath('mod_teamcity', $layout);

?>