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

<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title"><center><?=$item->getTitle()?></center></div>
    </div>

    <div class="panel-body">

        <div class="list-group">
            <div class="list-group-item" align="center"> 
                <?=$this->getTrans(
                        'begin_datetime', 
                        $item->getStart('D d.M.Y'),
                        $item->getStart('H:i'), 
                        $item->getEnds('H:i')
                    );
                ?>
            </div>

            <div class="list-group-item">
                <i class="fa fa-repeat fa-fw"></i>
                <?=$this->getTrans('cycle_'.cycle::Name($item->getCycle()));?>: 
                <?=$item->is_Cycle($this->getTrans('cycle_from_to', $item->getMinDate(), $item->getMaxDate()), ' ');?>
            </div>

            <?php if( $item->getMessage() != '' ): ?>
            <div class="list-group-item">
              <i class="fa fa-quote-left fa-1x fa-fw pull-left"></i> 
              <i class="fa fa-quote-right fa-1x fa-fw pull-right"></i> 
                <?=$item->getMessage();?>

            </div>
            <?php else: ?>
            <div class="list-group-item">
              <i class="fa fa-quote-left fa-1x fa-fw pull-left"></i> 
              <i class="fa fa-quote-right fa-1x fa-fw pull-right"></i> 
                <?=$item->getTitle();?>

            </div>
            <?php endif; ?>

            <div class="list-group-item">
                <div class="col-lg-6"><?=$this->getTrans('created');?> <?=$item->getCreated();?></div>
                <div class="col-lg-6" align="right"><?=$this->getTrans('changed');?> <?=$item->getChanged();?></div>
                <br style="clear: both;" />
            </div>

        </div>
    </div>
    
</div>
<script type="text/javascript">

</script>