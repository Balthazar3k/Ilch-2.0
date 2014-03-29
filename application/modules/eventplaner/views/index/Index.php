<?php
/**
 * @copyright Balthazar3k 2014
 * @package Eventplaner 2.0
 */
 
namespace Eventplaner\Views\Admin;
use User\Mappers\User as UserMapper;


$calendar = $this->get('calendar');
$date = $this->getRequest()->getParam('date');

$status = (array) json_decode($this->get('config')->get('event_status'), true);
$user = new UserMapper;
?>

<link href="<?php echo $this->getStaticUrl('../application/modules/eventplaner/static/css/index.css'); ?>" rel="stylesheet">

<div>
    <div style="float: left;">
       <div class="btn-group">
            <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'index', 'date' => $date));?>"><i class="fa fa-th-list"></i> <b><?=$this->getTrans('listView');?></b></a>
            <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'calendar', 'date' => $date));?>"><i class="fa fa-calendar"></i> <?=$this->getTrans('calendarView');?></a>
            <a class="btn btn-default" href="<?=$this->getUrl(array('date' => false));?>"><i class="fa fa-caret-square-o-down"></i> <?=$this->getTrans('currentMonth');?></a>
        </div>
    </div>
    <div style="float: right;"><?=$calendar->navigation();?></div>
</div><br><br>

<?php
if(empty($this->get('eventList'))){
    echo $this->getTrans('noEventsMonth');
    return;
}
?>

<link href="<?php echo $this->getStaticUrl('../application/modules/eventplaner/static/css/index.css'); ?>" rel="stylesheet">

<?php foreach( $this->get('eventList') as $event ): ?>
<a href="<?=$this->getURL(array('action' => 'details', 'id' => $event->getId() ));?>">
    <div class="event">
        <div>
            <h3 style="float: left;"><?=(!empty($event->getTitle()) ? $event->getTitle() : $event->getEvent())?></h3>
            <h3 style="float: right;"><?=(empty($event->getTitle()) ? $event->getTitle() : $event->getEvent())?> <?=$event->getRegistrations();?></h3>
            <br style="clear: both;" />
        </div>
        <div class="status status-string" style="<?=$status[$event->getStatus()]['style'];?>">
            <div style="float:left;">
                <strong>
                    <span class="transparent"><?=$this->getTrans(date('w', strtotime($event->getStart())));?></span> 
                    <?=$event->getStartDate('d.m.Y')?>
                </strong>
                <span class="transparent"> um </span>
                <strong>
                    <?=$event->getStartDate('H:i');?> - 
                    <?=$event->getEndsDate('H:i');?> 
                </strong>
                <span class="transparent">: <?=$event->getTimeDiff();?></span>
            </div>
            <div style="font-weight: bold; float:right;"><?=$this->getTrans($status[$event->getStatus()]['status']);?></div>
            <br style="clear: both;" />
        </div>
        <br>
        <div class="singel-line">
            <div id="progressbar" data-value="<?=$event->numRegistrations();?>" data-max="<?=$event->getRegistrations();?>">
                <div class="progress-label">
                    <?=$this->getTrans('registrations')?>: 
                    <?=$event->numRegistrations();?>/<?=$event->getRegistrations();?>
                </div>
            </div>
        </div>
        <div>
            <div style="font-weight: bold; float:left;"></div>
            <div style="float:right;"></div>
            <br style="clear: both;" />
        </div>
    </div>
</a>
<?php endforeach; ?>

<div>
    <div style="float: left;">
       <div class="btn-group">
            <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'index', 'date' => $date));?>"><i class="fa fa-th-list"></i> <b><?=$this->getTrans('listView');?></b></a>
            <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'calendar', 'date' => $date));?>"><i class="fa fa-calendar"></i> <?=$this->getTrans('calendarView');?></a>
            <a class="btn btn-default" href="<?=$this->getUrl(array('date' => false));?>"><i class="fa fa-caret-square-o-down"></i> <?=$this->getTrans('currentMonth');?></a>
        </div>
    </div>
    <div style="float: right;"><?=$calendar->navigation();?></div>
</div>


<script type="text/javascript">
$(function() {
    
    $( "div#progressbar" ).each(function(){
        var max = parseInt($(this).attr('data-max'));
        var value = parseInt($(this).attr('data-value'));
        $(this).progressbar({
            max: max,
            value: value
        });
    });
});
</script>