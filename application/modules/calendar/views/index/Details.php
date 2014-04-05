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
      <h3 class="panel-title"><?=$item->getTitle()?></h3>
    </div>

    <div class="panel-body">

        <div class="list-group">
            <div class="list-group-item " align="center"> 
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
                    <?=$this->getTrans('cycle');?>: <?=$this->getTrans('cycle_'.cycle::Name($item->getCycle()));?>
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
            <?php else: ?>
            <div class="list-group-item">
              <i class="fa fa-quote-left fa-2x fa-fw pull-left"></i> 
              <i class="fa fa-quote-right fa-2x fa-fw pull-right"></i> 
                <?=$item->getTitle();?>

            </div>
            <?php endif; ?>

            <div class="list-group-item">
                <div><?=$this->getTrans('created');?> <?=$item->getCreated();?></div>
                <div><?=$this->getTrans('changed');?> <?=$item->getChanged();?></div>
            </div>

        </div>
    </div>
    
</div>
<script type="text/javascript">

</script>