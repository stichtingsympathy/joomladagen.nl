<?php
/**
 * @package   OSMeta
 * @contact   www.joomlashack.com, help@joomlashack.com
 * @copyright 2013-2016 Open Source Training, LLC, All rights reserved
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL
 */

// No direct access to this file
defined('_JEXEC') or die();

$includePath = __DIR__ . '/admin/library/Installer/include.php';
if (! file_exists($includePath)) {
    $includePath = __DIR__ . '/library/Installer/include.php';
}

require_once $includePath;

use Alledia\Installer\AbstractScript;

/**
 * OSMeta Installer Script
 *
 * @since  1.0
 */
class Com_OSMetaInstallerScript extends AbstractScript
{
    /**
     * Method to run after an install/update method
     *
     * @return void
     */
    public function postFlight($type, $parent)
    {
        parent::postFlight($type, $parent);

        $db = JFactory::getDBO();

        // Remove the old pkg_osmeta, if existent
        $query = 'DELETE FROM `#__extensions` WHERE `type`="package" AND `element`="pkg_osmeta"';
        $db->setQuery($query);
        $db->execute();

        // Remove the old tables, if existent
        $tables = array(
            '#__osmeta_extensions',
            '#__osmeta_meta_extensions',
            '#__osmeta_keywords',
            '#__osmeta_keywords_items'
        );
        foreach ($tables as $table) {
            $query = "DROP TABLE IF EXISTS `{$table}`";
            $db->setQuery($query);
            $db->execute();
        }

        // If Joomla 3.5, fix table collation
        if (version_compare(JVERSION, '3.5', '>=')) {
            // Check if the database supports utf8mb4
            if (method_exists($db, 'serverClaimsUtf8mb4Support') && $db->serverClaimsUtf8mb4Support()) {
                $query = 'ALTER TABLE `#__osmeta_metadata` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
                $db->setQuery($query);
                $db->execute();
            }
        }

        return true;
    }
}
