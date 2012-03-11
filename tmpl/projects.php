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

$document =& JFactory::getDocument();
$document->addStyleSheet('media/mod_teamcity/teamcity.css');

?>

<!-- Teamcity by Cedric Walter - www.waltercedric.com -->
<div class="teamcity <?php echo $moduleclass_sfx; ?>">
    <img src='media/mod_teamcity/icon<?php echo $teamcityIcon; ?>.png'>
    <ul>
        <?php foreach ($list as $item) : ?>
        <li>
            <a rel="<?echo $rendering ?>" href="<?php echo $item['url'] ?>">
                <?php echo $item['name'] ?>

            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
    <div style="text-align: center;">
        <a href="http://www.waltercedric.com"
           style="font: normal normal normal 10px/normal arial; color: rgb(187, 187, 187); border-bottom-style: none; border-bottom-width: initial; border-bottom-color: initial; text-decoration: none; "
           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'"
           target="_blank"><b>Teamcity</b></a>
    </div>
</div>