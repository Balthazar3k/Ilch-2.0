<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Views\Admin\Index;
use Calendar\Plugins\Functions as func;

$item = $this->get('item');
?>

<link href="<?php echo $this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">

<div class="btn-group">
  <a class="btn btn-primary" href="#"><i class="fa fa-user fa-fw"></i> <?=$this->getTrans('action_series_edit');?></a>
  <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#">
    <span class="fa fa-caret-down"></span></a>
  <ul class="dropdown-menu">
    <li class="divider"></li>
    <li>
        <a href="
            <?=$this->getUrl(
                array(
                    'action' => 'treat',
                    'id' => $this->getRequest()->getParam('id'),
                    'series' => 1
                )
            );?>   
        "><i class="fa fa-calendar fa-fw"></i> <?=$this->getTrans('action_series_true')?></a>
    </li>
    <li>
        <a href="
            <?=$this->getUrl(
                array(
                    'action' => 'treat',
                    'id' => $this->getRequest()->getParam('id'),
                    'series' => 0
                )
            );?>   
        "><i class="fa fa-calendar-o fa-fw"></i> <?=$this->getTrans('action_series_false')?></a>
    </li>
    <li class="divider"></li>
  </ul>
</div>
<br style="clear:both;" />

<div class="left calendar-details">
    <h1 class="title"><?=$this->getTrans('list_series', (count($item->getSeriesList())-1));?></h1>
    <?php foreach($item->getSeriesList() as $series ): ?>
    <div class="<?php if( $item->getId() == $series->getId()) : echo 'alert-info'; else: echo 'well'; endif; ?> well-sm liberation">
        <a href="
            <?=$this->getUrl(
                array(
                    'action' => 'series',
                    'id' => $series->getId()
                )
            );?>   
        " aria-hidden="true" class="close"><i class="fa fa-info-circle fa-fw"></i></a>
        <a href="" aria-hidden="true" class="close" type="button"><i class="fa fa-trash-o  fa-fw"></i></a>
        <a href="
            <?=$this->getUrl(
                array(
                    'action' => 'treat',
                    'id' => $series->getId(),
                    'series' => 0
                )
            );?>   
        " aria-hidden="true" class="close" type="button"><i class="fa fa-cog fa-fw"></i></a>
        <i class="fa fa-calendar-o fa-fw"></i>
        <?=$this->getTranslator()->trans(
                'series_listing', 
                $series->getStart('D d.M.Y'),
                $series->getStart('H:i'), 
                $series->getEnds('H:i'), 
                substr($series->getTitle(), 0, 15) . '...'
            );
        ?>
    </div>
    <?php endforeach; ?>
</div>

<div class="left" style="position: fixed; margin-left: 30%; width: 50%;">
    <div class="calendar-details">
        <h1 class="title"><?=$item->getTitle()?></h1>


        <div class="alert alert-info well-sm" align="center">
            <i class="fa fa-calendar fa-fw"></i>
            <?=$this->getTranslator()->trans(
                    'begin_datetime', 
                    $series->getStart('D d.M.Y'),
                    $series->getStart('H:i'), 
                    $series->getEnds('H:i')
                );
            ?>
        </div>

        <?php if( $item->getMessage() != '' ): ?>
        <div class="well well-sm">
          <i class="fa fa-quote-left fa-2x fa-fw pull-left"></i> 
          <i class="fa fa-quote-right fa-2x fa-fw pull-right"></i> 
            <?=$item->getMessage();?>

        </div>
        <?php endif; ?>

        <div class="well well-sm small">
            <div><?=$this->getTrans('cycle');?>: <?=$this->getTrans('cycle_'.func::cycleNames($item->getCycle()));?></div>
            <div><?=$this->getTrans('created');?> <?=$item->getCreated();?></div>
            <div><?=$this->getTrans('changed');?> <?=$item->getChanged();?></div>
        </div>
    </div>
</div>
<br style="clear:both;" />
