<?php
/**
 * Holds Admin\Config\Config.
 *
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Guestbook\Config;
defined('ACCESS') or die('no direct access');

class Config extends \Ilch\Config\Install
{
    public $key = 'guestbook';
    public $author = 'Thomas Stantin';
    public $name = array
    (
        'en_EN' => 'Guestbook',
        'de_DE' => 'Gästebuch',
    );
    public $icon_small = 'guestbook.png';

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
    }

    public function uninstall()
    {
    }
    
    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_gbook` (
               `id` int(11) NOT NULL AUTO_INCREMENT,
               `email` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
               `text` mediumtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
               `datetime` datetime NOT NULL,
               `homepage` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
               `name` varchar(256) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
               PRIMARY KEY (`id`)
               ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;';
    }
}

