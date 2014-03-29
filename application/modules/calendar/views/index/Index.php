<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Views\Index;

$calendar = $this->get('calendar');
$date = $this->getRequest()->getParam('date');
?>
<link href="<?=$this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">

<div>
    <div style="float: left;">
       <div class="btn-group">
           <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'index', 'date' => $date));?>"><i class="fa fa-calendar"></i> <b><?=$this->getTrans('calendar_view');?></b></a>
           <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'calendar', 'date' => $date));?>"><i class="fa fa-th-list"></i> <?=$this->getTrans('list_view');?></a>
           <a class="btn btn-default" href="<?=$this->getUrl(array('date' => false));?>"><i class="fa fa-caret-square-o-down"></i> <?=$this->getTrans('return');?></a>
        </div>
    </div>
    <div style="float: right;"><?=$calendar->getNavigation();?></div>
</div><br><br>


<?=$calendar->getCalendarHtml();?>