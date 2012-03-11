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

jimport('joomla.error.log');
jimport('joomla.factory');

require_once(JPATH_SITE . DS . 'libraries' . DS . 'simplepie' . DS . 'simplepie.php');

class Teamcity
{
    var $pollIntervalMin = null;

    var $pollIntervalMax = null;

    var $server = null;

    var $publicServer = null;

    var $debug = true;

    var $logger = null;

    var $displayBuild = null;

    var $displayBuildStatus = null;


    function Teamcity($user, $password, $teamcityServer)
    {
        $this->pollIntervalMin = 1000 * 60; // 1 minute
        $this->pollIntervalMax = 1000 * 60 * 5; // 5 minutes
        $this->server = 'http://' . urlencode($user) . ':' . urlencode($password) . '@' . $teamcityServer;
        $this->publicServer = "http://" . $teamcityServer;

        $this->logger = &JLog::getInstance('mod_teamcity.php', array('format' => "{DATE}\t{TIME}\t{COMMENT}"));
    }

    public function getProjects()
    {
        $url = $this->server . "/httpAuth/app/rest/projects";

        $url = htmlspecialchars($url);

        $xml = $this->getUrlContent($url);
        $model = array();
        if ($xml != null && strlen($xml) != 0) {
            $root = new SimpleXMLElement($xml);
            foreach ($root->project as $project) {
                $item = array();
                $item['url'] = urlencode($this->getProjectOverviewURL($project->attributes()->id));
                $item['name'] = "" . $project->attributes()->name;
                $item['build'] = $this->getBuildsOverview($project->attributes()->href);
                $model[] = $item;
            }
        }
        return $model;
    }






    public function getBuildsOverview($projectHref)
    {
        $url = $this->server . $projectHref;
        $xml = $this->getUrlContent($url);
        $root = new SimpleXMLElement($xml);

        $model = array();
        $model['id'] = htmlspecialchars($root->attributes()->id);
        $model['description'] = htmlspecialchars($root->attributes()->description);
        $model['archived'] = htmlspecialchars($root->attributes()->archived);
        $model['webUrl'] = urlencode($root->attributes()->webUrl);
        $model['href'] = urlencode($root->attributes()->href);
        $model['status'] = htmlspecialchars($this->getBuildStatus($model['id']));

        foreach ($root->buildTypes->buildType as $buildType) {
            $item = array();
            $item['status'] = htmlspecialchars($this->getBuildStatus($buildType->attributes()->id));
            $item['id'] = htmlspecialchars($buildType->attributes()->id);
            $item['webUrl'] = urlencode($buildType->attributes()->webUrl);
            $model[] = $item;
        }
        return $model;
    }

    public function getProjectOverviewURL($id)
    {
        return $this->publicServer . "/project.html?projectId=" . $id . "&tab=projectOverview";
    }

    private function getUrlContent($url)
    {
        $ch = curl_init($url);
        $this->log("getUrlContent " . $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $output contains the output string
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            $this->log('The domain is available!');
        } else {
            $this->log('The domain is not available');
        }
        curl_close($ch);
        return $output;
    }

    /**
     * Parse following xml
     *
     * <builds nextHref="/httpAuth/app/rest/builds?count=1&amp;start=1&amp;amp;start=10;buildType=bt27" count="1">
     * <build id="390" number="53" status="ERROR" buildTypeId="bt4" href="/httpAuth/app/rest/builds/id:390" webUrl="http://teamcity.waltercedric.com/viewLog.html?buildId=390&amp;buildTypeId=bt4"/></builds>
     *
     *
     * @param $buildType
     */
    function getBuildStatus($buildType)
    {
        $url = $this->server . "/httpAuth/app/rest/builds?buildType=" . $buildType;

        $xml = $this->getUrlContent($url);
        $root = new SimpleXMLElement($xml);

        $status = "NEVERBUILT";

        if ($root->attributes()->count != 0) {
            $status = $root->build->attributes()->status;
        }

        return $status;
    }

    function getUsers()
    {
        $url = $this->server . "/httpAuth/app/rest/users";

        $xml = $this->getUrlContent($url);
        $root = new SimpleXMLElement($xml);

        $users = array();
        foreach ($root->user as $user) {
            $aUser = array();
            $aUser['name'] = htmlspecialchars($user->attributes()->name);
            $aUser['username'] = htmlspecialchars($user->attributes()->username);
            $aUser['href'] = urlencode($user->href);
            $users[] = $aUser;
        }
        return $users;
    }













    function log($comment)
    {
        if ($this->debug) {
            $this->logger->addEntry(array('comment' => $comment));
        }
    }
}