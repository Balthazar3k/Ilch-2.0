<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Views\Index;

$calendar = $this->get('calendar');
$items = $this->get('items');
$date = $this->getRequest()->getParam('date');
?>
<link href="<?=$this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">

<div>
    <div style="float: left;">
       <div class="btn-group">
           <a class="btn btn-default" href="<?=$this->getUrl(array('action' => 'index', 'date' => $date));?>"><i class="fa fa-calendar"></i> <?=$this->getTrans('calendar_view');?></a>
           <a class="btn btn-default btn-warning" href="<?=$this->getUrl(array('action' => 'list', 'date' => $date));?>"><i class="fa fa-th-list"></i> <?=$this->getTrans('list_view');?></a>
        </div>
    </div>
    <div style="float: right;"><?=$calendar->getNaviHtml();?></div>
</div><br><br>

<div class="list-group">
<?php foreach ($items as $item) : ?>
    <a class="list-group-item <?=$item->is_Today('list-group-item-info')?>" href="<?=$this->getUrl(array('action' => 'details', 'id' => $item->getId()));?>">
        <div class="col-lg-2 text-center" align="center">
            <h3><?=$item->getStart('d')?><div class="small" style="border-top: 3px solid black; padding-top: 5px;"><?=$item->getStart('M')?></div></h3>
        </div>
        
        <?php if( $item->getMessage() != '' ) : ?>
        <div class="col-lg-8">
            <h4 class="list-group-item-heading"><b><?=$item->getTitle()?></b></h4>
            <div> 
                <?=substr($item->getMessage(), 0, 264);?>
            </div>
        </div>
        <?php else : ?>
        <div class="col-lg-8 text-center">
            <h3>
                <?=$item->getTitle('H:i')?>
                <div class="small" style="border-top: 3px solid black; padding-top: 5px;"><?=$item->getStart('D d.m.Y H:i')?> - <?=$item->getEnds('H:i');?></div>
            </h3>
        </div>
        <?php endif; ?>
        
        <div class="col-lg-2" align="center">
            <h3>
                <?=$item->getStart('H:i')?>
                <div class="small" style="border-top: 3px solid black; padding-top: 5px;"><?=$item->getEnds('H:i')?></div>
            </h3>
        </div>
        
        <br style="clear: both;">
    </a>
<?php endforeach; ?>
</div>