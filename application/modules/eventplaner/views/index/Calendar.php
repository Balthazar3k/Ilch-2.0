<?php
/**
 * @copyright Balthazar3k 2014
 * @package Eventplaner 2.0
 */
namespace Eventplaner\Views\Index;

$calendar = $this->get('calendar');
$date = $this->getRequest()->getParam('date');
?>
<link href="<?php echo $this->getStaticUrl('../application/modules/eventplaner/static/css/index.css'); ?>" rel="stylesheet">

<div>
    <div style="float: left;">
       <div class="btn-group">
           <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'calendar', 'date' => $date));?>"><i class="fa fa-calendar"></i> <b><?=$this->getTrans('calendarView');?></b></a>
            <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'index', 'date' => $date));?>"><i class="fa fa-th-list"></i> <?=$this->getTrans('listView');?></a>
            <a class="btn btn-default" href="<?=$this->getUrl(array('date' => false));?>"><i class="fa fa-caret-square-o-down"></i> <?=$this->getTrans('currentMonth');?></a>
        </div>
    </div>
    <div style="float: right;"><?=$calendar->navigation();?></div>
</div><br><br>

<?=$calendar->getHtml();?>