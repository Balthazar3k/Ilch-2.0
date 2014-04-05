<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

namespace Calendar\Views\Admin\Index;
use Calendar\Plugins\Cycle as Cycle;

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
    <li>
        <a href="
            <?=$this->getUrl(
                array(
                    'action' => 'delete',
                    'd' => $this->getRequest()->getParam('id'),
                    'series' => $item->getSeries()
                )
            );?>   
        "><i class="fa fa-trash-o fa-fw"></i> <?=$this->getTrans('action_series_delete')?></a>
    </li>
  </ul>
</div>
<br /><br />
<div class="row">
    <div class="col-xs-12 col-md-7">
        <div class="panel panel-default">

            <div class="panel-heading">
              <h3 class="panel-title"><?=$item->getTitle()?></h3>
            </div>
            
            <div class="panel-body">
                
                <div class="list-group">
                    <div class="list-group-item alert-info" align="center"> 
                        <i class="fa fa-calendar fa-fw"></i>
                        <?=$this->getTrans(
                                'begin_datetime', 
                                $item->getStart('D d.M.Y'),
                                $item->getStart('H:i'), 
                                $item->getEnds('H:i')
                            );
                        ?>
                    </div>
                    
                    <div class="list-group-item">
                        <div class="col-md-6">
                            <?=$this->getTrans('cycle');?>: <?=$this->getTrans('cycle_'.Cycle::Name($item->getCycle()));?>
                        </div>
                        <div class="col-md-6" align="right">
                            <?=$item->is_Cycle($this->getTrans('cycle_from_to', $item->getMinDate(), $item->getMaxDate()), ' ');?>
                        </div>
                        <br style="clear: both;" />
                    </div>

                    <?php if( $item->getMessage() != '' ): ?>
                    <div class="list-group-item">
                      <i class="fa fa-quote-left fa-2x fa-fw pull-left"></i> 
                      <i class="fa fa-quote-right fa-2x fa-fw pull-right"></i> 
                        <?=$item->getMessage();?>

                    </div>
                    <?php endif; ?>

                    <div class="list-group-item">
                        <div><?=$this->getTrans('created');?> <?=$item->getCreated();?></div>
                        <div><?=$this->getTrans('changed');?> <?=$item->getChanged();?></div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xs-6 col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><?=$this->getTrans('list_series', (count($item->getSeriesList())-1));?></h3>
            </div>
            <div class="panel-body calendar-details">
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
                    <?php if( $item->getId() != $series->getId()) : ?>
                    <a href="
                        <?=$this->getUrl(
                            array(
                                'action' => 'delete',
                                'id' => $this->getRequest()->getParam('id'),
                                'd' => $series->getId()
                            )
                        );?>   
                    " aria-hidden="true" class="close" type="button"><i class="fa fa-trash-o  fa-fw"></i></a>
                    <?php endif; ?>
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
                    <?=$this->getTrans(
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
          </div>
            
        </div>
    </div>
