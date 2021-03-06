<?php
/**
 * @package ilch
 */

namespace Modules\Partner\Config;
defined('ACCESS') or die('no direct access');

class Config extends \Ilch\Config\Install
{
    public $config = array
    (
        'key' => 'partner',
        'author' => 'Veldscholten Kevin',
        'icon_small' => 'partner.png',
        'languages' => array
        (
            'de_DE' => array
            (
                'name' => 'Partner',
                'description' => 'Hier können neue Partner erstellt werden.',
            ),
            'en_EN' => array
            (
                'name' => 'Partner',
                'description' => 'Here you can create new partners.',
            ),
        )
    );

    public function install()
    {
        $this->db()->queryMulti($this->getInstallSql());
    }

    public function uninstall()
    {
        $this->db()->queryMulti('DROP TABLE `[prefix]_partners`');
    }

    public function getInstallSql()
    {
        return 'CREATE TABLE IF NOT EXISTS `[prefix]_partners` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `pos` int(11) NOT NULL DEFAULT 0,
                  `name` varchar(100) NOT NULL,
                  `banner` varchar(255) NOT NULL,
                  `link` varchar(255) NOT NULL,
                  `setfree` int(11) NOT NULL DEFAULT 0,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;
        
                INSERT INTO `[prefix]_partners` (`id`, `name`, `banner`, `link`, `setfree`) VALUES
                (1, "ilch", "http://ilch.de/include/images/linkus/88x31.png", "http://ilch.de", "1");';
    }
}
