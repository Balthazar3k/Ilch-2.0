<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Views\Admin;
use Calendar\Plugins\Cycle as Cycle;

$calendar = $this->get('calendar');
$date = $this->getRequest()->getParam('date');
?>

<link href="<?php echo $this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">

<div>
    <div style="float: left;">
       <?=$calendar->getNaviHtml();?>
    </div>
    <div style="float: right;"></div>
</div><br><br>

<?=$calendar->getCalendarHtml();?>