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
           <a class="btn btn-default btn-warning" href="<?=$this->getUrl(array('action' => 'index', 'date' => $date));?>"><i class="fa fa-calendar"></i> <?=$this->getTrans('calendar_view');?></a>
           <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'list', 'date' => $date));?>"><i class="fa fa-th-list"></i> <?=$this->getTrans('list_view');?></a>
        </div>
    </div>
    <div style="float: right;"><?=$calendar->getNaviHtml();?></div>
</div><br><br>


<?=$calendar->getCalendarHtml();?>