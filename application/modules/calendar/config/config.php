<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Config;

defined('ACCESS') or die('no direct access');

class Config extends \Ilch\Config\Install
{
    
    public $config = array
    (
        'key' => 'calendar',
        'author' => 'Angelo C. B3k',
        'icon_small' => 'calendar.png',
        'languages' => array
        (
            'de_DE' => array
            (
                'name' => 'Kalender',
                'description' => '',
            ),
            'en_EN' => array
            (
                'name' => 'Calendar',
                'description' => '',
            ),
        )
    );
            
    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
    }

    public function uninstall()
    {
    }

    public function getInstallSql()
    {   
        return "
            CREATE TABLE IF NOT EXISTS `[prefix]_calendar` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `module_key` varchar(255) NOT NULL,
                `module_url` varchar(255) NOT NULL,
                `cycle` int(1) NOT NULL,
                `date_start` datetime NOT NULL,
                `date_ends` datetime NOT NULL,
                `organizer` int(32) NOT NULL,
                `title` varchar(255) NOT NULL,
                `message` text NOT NULL,
                `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `changed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `series` int(11) NOT NULL DEFAULT 0,
                PRIMARY KEY (`id`)
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        ";
    }
}
?>
