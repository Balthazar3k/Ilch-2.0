<?php
/**
 * @copyright Balthazar3k 2014
 * @package Eventplaner 2.0
 */
namespace Eventplaner\Views\Admin;

$calendar = $this->get('calendar');
?>
<link href="<?php echo $this->getStaticUrl('../application/modules/eventplaner/static/css/index.css'); ?>" rel="stylesheet">

<h4><?=$this->getTrans('calendarView');?></h4>

<?=$calendar->getHtml();?>