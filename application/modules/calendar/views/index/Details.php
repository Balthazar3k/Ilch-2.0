<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */

$item = $this->get('item');
?>

<link href="<?php echo $this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">

<div class="calendar-details">
    <h1 class="title"><?=$item->getTitle()?></h1>

    
    <div class="alert alert-info well-sm" align="center">
      <i class="fa fa-calendar fa-fw"></i>
      <?=$this->getTrans('of_the');?>
      <b><?=$item->getStart('d.m.Y H:i');?></b>
      <?=$this->getTrans('to');?>
      <b><?=$item->getEnds('d.m.Y H:i');?></b>
    </div>
  
    <?php if( $item->getMessage() != '' ): ?>
    <div class="well well-sm">
      <i class="fa fa-quote-left fa-2x fa-fw pull-left"></i> 
      <i class="fa fa-quote-right fa-2x fa-fw pull-right"></i> 
        <?=$item->getMessage();?>
      
    </div>
    <?php endif; ?>
  
    <div class="small" align="right">
         <?=$this->getTrans('created');?> <?=date('d.m.Y H:i', strtotime($item->getCreated()));?> <i class="fa fa-file"></i><br />
         <?=$this->getTrans('changed');?> <?=date('d.m.Y H:i', strtotime($item->getChanged()));?> <i class="fa fa-file-text"></i>
    </div>
</div>

<script type="text/javascript">
$(function() {
     $( "#dialog" ).dialog({
        autoOpen: false,
        modal: true
    });
        
    $( "#opener" ).click(function() {
        $( "#dialog" ).dialog( "open" );
    });

    
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