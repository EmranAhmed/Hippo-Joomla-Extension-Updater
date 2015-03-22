<?php
/**
 * @package      Hippo Joomla Extension Updater
 *
 * @author       Emran Ahmed
 * @copyright    Copyright (C) 2013 - 2015 Open Source Matters. All rights reserved.
 * @license      GNU General Public License version 2 or later;
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


class plgSystemHippoUpdater extends JPlugin
{
        /**
         * Constructor.
         *
         * @access protected
         *
         * @param object $subject The object to observe
         * @param array  $config  An array that holds the plugin configuration
         *
         * @since  1.0
         */
        public function __construct($subject, $config)
        {
            parent::__construct($subject, $config);
        }

        public function onExtensionAfterSave($option, $data)
        {

            // I use t3 thats why I add this condition. If you donot want just remove defined and T3::detect  from condition.
            if (defined('T3_PLUGIN') && T3::detect() && $option == 'com_templates.style' && !empty($data->id)) {

                $params = new JRegistry;
                $params->loadString($data->params);

                // Getting Param envato_purchase_code
                $key = $params->get('envato_purchase_code');

                // Getting Param envato_username
                $username = $params->get('envato_username');

                // Getting Template Name to sure which Template request for an update :)
                $template = trim($data->template); 

                $extra_query = '';

                if(!empty($key) and !empty($username) )
                {

                    // Important: you are supposed to use &amp; instead of a straight ampersand
                    $extra_query = 'purchase_code=' . urlencode($key);
                    $extra_query .='&amp;username=' . urlencode($username);
                    $extra_query .='&amp;template=' . urlencode($template);


                    // Important: Donot Modify Under this comment until you donot know what are you doing.
                    // ===================================================================================

                    // Load the updates record, if it exists
                    $db = JFactory::getDbo();
                    $query = $db->getQuery(true)
                    ->select('*')    
                    ->from($db->quoteName('#__updates'))
                    ->where($db->quoteName('element').'='.$db->quote($template));
                    $db->setQuery($query);
                    $updateObject = $db->loadObject();


                    if( !empty($updateObject) ){

                        // If we have updates records
                        $query = $db->getQuery(true)
                        ->update($db->quoteName('#__updates'))
                        ->set($db->quoteName('extra_query').'='.$db->quote($extra_query))
                        ->where($db->quoteName('update_id') .'='. (int) $updateObject->update_id);
                        $db->setQuery($query);
                        $db->execute();

                        $fields = array(
                            $db->quoteName('extra_query') . '=' . $db->quote($extra_query),
                            $db->quoteName('last_check_timestamp') . '=0'
                        );

                        // store update_sites with themes extra params ;)
                        $query = $db->getQuery(true)
                        ->update($db->quoteName('#__update_sites'))
                        ->set($fields)
                        ->where($db->quoteName('update_site_id') .'='. (int) $updateObject->update_site_id);
                        $db->setQuery($query);
                        $db->execute();
                    }
                }
            }
        }
    }