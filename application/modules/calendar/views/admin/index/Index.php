<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Views\Admin;

$calendar = $this->get('calendar');
?>
<link href="<?php echo $this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">

<?=$calendar->getNavigation();?>
<?=$calendar->getCalendarHtml();?>