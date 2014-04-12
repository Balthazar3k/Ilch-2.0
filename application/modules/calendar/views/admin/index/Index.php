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
    <div class="col-lg-8">
       <?=$calendar->getNaviHtml();?>
    </div>
</div><br><br>

<div class="col-lg-8"><?=$calendar->getCalendarHtml();?></div>