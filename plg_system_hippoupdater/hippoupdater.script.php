<?php
    /**
     * @package      Hippo Joomla Extension Updater
     *
     * @author       Emran Ahmed
     * @copyright    Copyright (C) 2013 - 2015 Open Source Matters. All rights reserved.
     * @license      GNU General Public License version 2 or later;
     */

    // no direct access
    defined('_JEXEC') or die();

    class plgSystemHippoUpdaterInstallerScript
    {
        /**
         * Just enable this plugin after installation :)
         *
         * @param     string                $route      Which action is happening (install|uninstall|discover_install)
         * @param     JAdapterInstance      $adapter    The object responsible for running this script
         *
         * @return    boolean                           True on success
         */
        public function postflight($route, JAdapterInstance $adapter)
        {
            $db = JFactory::getDBO();
            $query = $db->getQuery(TRUE);
            $query
                ->update('#__extensions')
                ->set("`enabled`='1'")
                ->where("`type`='plugin'")
                ->where("`folder`='system'")
                ->where("`element`='hippoupdater'");
            $db->setQuery($query);
            $db->execute();
            return TRUE;
        }
    }