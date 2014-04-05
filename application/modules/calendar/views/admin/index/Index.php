<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Views\Admin;

$calendar = $this->get('calendar');
$date = $this->getRequest()->getParam('date');
?>
<link href="<?php echo $this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">

<div>
    <div style="float: left;">
       <div class="btn-group">
       </div>
    </div>
    <div style="float: right;"><?=$calendar->getNaviHtml();?></div>
</div><br><br>

<?=$calendar->getCalendarHtml();?>

<div>
    <div style="float: left;">
       <div class="btn-group">
       </div>
    </div>
    <div style="float: right;"><?=$calendar->getNaviHtml();?></div>
</div>