<?php
/**
 * @copyright Balthazar3k 2014
 * @package Eventplaner 2.0
 */

namespace Eventplaner\Config;

defined('ACCESS') or die('no direct access');

class Config extends \Ilch\Config\Install
{
    
    public $config = array
    (
        'key' => 'eventplaner',
        'author' => 'Angelo C. B3k',
        'icon_small' => 'eventplaner.png',
        'languages' => array
        (
            'de_DE' => array
            (
                'name' => 'Eventplaner',
                'description' => 'Mit dem Modul kann man Events planen (Raids).',
            ),
            'en_EN' => array
            (
                'name' => 'Eventplaner',
                'description' => 'With the module you can plan events (Raids).',
            ),
        )
    );
    
    protected $eventConfigs = array(
    	'event_calendar_size' => '800',
        'event_admin_rowsperpage' => '15',
        'event_close_time' => '02:00',
        'event_start_time' => '18:00',
        'event_ends_time' => '21:00',
        'event_starting_time' => '14:00',
        'event_ending_time' => '23:59',
        'event_steps_time' => '00:30',
        'event_status' => ''
    );
    
    protected $eventStatus = array(
        1 => array(
            'status' => 'active',
            'regist' => 'commitment',
            'style' => "background-color: darkgreen;\ncolor: #FFF;\ntext-shadow: -1px -1px 0 rgba(0,0,0,0.4);"
        ),
        2 => array(
            'status' => 'closed',
            'regist' => 'maybe',
            'style' => "color: #FFF;\nbackground-color: darkorange;\ntext-shadow: -1px -1px 0 rgba(0,0,0,0.4);"
        ),
        3 => array(
            'status' => 'canceled',
            'regist' => 'notime',
            'style' => "color: #FFF;\nbackground-color: darkblue;\ntext-shadow: -1px -1px 0 rgba(0,0,0,0.6);"
        ),
        4 => array(
            'status' => 'removed',
            'regist' => 'cancellation',
            'style' => "color: #FFF;\nbackground-color: darkred;\ntext-shadow: -1px -1px 0 rgba(0,0,0,0.4);"
        )
    );
            
    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
        
        $this->eventConfigs['event_status'] = json_encode($this->eventStatus, true);
        
        $config = new \Ilch\Config\Database($this->db());
        foreach( $this->eventConfigs as $key => $value){
            $config->set($key, $value);
        }
        
        $menuModel = new \Admin\Models\MenuItem();
        $menuMapper = new \Admin\Mappers\Menu();
        
        $menuModel->setMenuId(1);
        $menuModel->setType(3);
        $menuModel->setSort(90);
        $menuModel->setParentId(1);
        $menuModel->setTitle('Eventplaner');
        $menuModel->setModuleKey($this->key);
        $menuMapper->saveItem($menuModel);
    }

    public function uninstall()
    {
        $this->db()->drop('[prefix]_ep_events');
        $this->db()->drop('[prefix]_ep_registrations');
        $this->db()->query('DELETE FROM `[prefix]_config` WHERE `key` LIKE \'event_%\';');
        $this->db()->query('DELETE FROM `[prefix]_menu_items` WHERE `module_key` = \''.$this->key.'\';');
    }

    public function getInstallSql()
    {   /* IST NOCH ZUM TESTEN */
        return "
            CREATE TABLE IF NOT EXISTS `[prefix]_ep_events` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `status` int(2) NOT NULL,
                `start` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `ends` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `registrations` int(3) NOT NULL,
                `organizer` int(32) NOT NULL,
                `title` varchar(128) NOT NULL,
                `event` varchar(128) NOT NULL,
                `message` text NOT NULL,
                `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

            CREATE TABLE IF NOT EXISTS `[prefix]_ep_registrations` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `status` int(2) NOT NULL,
                `eid` int(8) NOT NULL,
                `uid` int(8) NOT NULL,
                `cid` int(8) NOT NULL,
                `comment` varchar(256) NOT NULL,
                `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
              ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
        ";
    }
}
?>
