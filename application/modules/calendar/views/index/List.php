<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Views\Index;
use Calendar\Plugins\Cycle as Cycle;

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

<?php foreach ($items as $item) : ?>
<div class="row">
    <div class="col-sm-5 better-fill">
        <div class="well well-sm">
            <i class="fa fa-calendar-o fa-fw"></i>
            <?=$this->getTranslator()->trans(
                    'begin_datetime', 
                    $item->getStart('d.M.Y'),
                    $item->getStart('H:i'), 
                    $item->getEnds('H:i')
                );
            ?>
        </div>
    </div>
    <div class="col-sm-4 better-fill" align="center"><div class="well well-sm"><b><?=$item->getTitle()?></b></div></div>
    <div class="col-sm-2 better-fill" align="center"><div class="well well-sm"><?=$this->getTrans('cycle_'.Cycle::Name($item->getCycle()));?></div></div>
    <div class="col-sm-1 better-fill" align="center">
        <a href="<?=$this->getUrl(array('action' => 'details', 'id' => $item->getId()));?>">
            <div class="well well-sm"><i class="fa fa-info-circle"></i> </div>
        </a>
    </div>
</div>
<?php endforeach; ?>