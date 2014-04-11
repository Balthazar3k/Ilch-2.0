<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Views\Admin\Index;
use Calendar\Plugins\Cycle as Cycle;

if( $this->get('item') != '' ){
    $item = $this->get('item');
}else{
    $item = new \Calendar\Models\Calendar();
    $item->set_is_Series(true);
    $item->setDateStart(date('Y-m-d H:i'));
    $item->setDateEnds(date('Y-m-d H:i'));
    $item->setMaxDate();
    $item->setMinDate();
    $item->setWeekdays(array());
}
?>
<link href="<?php echo $this->getStaticUrl('../application/modules/calendar/static/css/index.css'); ?>" rel="stylesheet">
<form class="form-horizontal" method="POST" action="<?php echo $this->getUrl(array('action' => 'treat', 'id' => $this->getRequest()->getParam('id'))); ?>">
    <?=$this->getTokenField();?>
    <input type="hidden" name="is_series" value="<?=$item->if_Series('1', '0')?>" />
    <input type="hidden" name="organizer" value="<?=$_SESSION['user_id']?>" />
    <input type="hidden" name="series" value="<?=( ($item != '') ? $item->getSeries() : 0);?>" />
    
    <div class="col-lg-7">
        <legend>
        <?php
            if ($item != '') {
                echo $this->getTrans('menu_action_update_calendar');
            } else {
                echo $this->getTrans('menu_action_insert_calendar');
            }
        ?>
        </legend>

        <div class="form-group">

            <div class="col-lg-12">
                <div class="input-group">
                    <input class="form-control"
                           type="text"
                           name="title"
                           id="title"
                           placeholder="<?php echo $this->getTrans('title'); ?>"
                           value="<?php if ($item != '') { echo $this->escape($item->getTitle()); } ?>" />
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Select a Title <span class="caret"></span></button>
                            <ul class="dropdown-menu pull-right">
                                <?php foreach($this->get('title') as $title ): ?>
                                    <li><a class="select-Title" href="#"><?=$title->getTitle();?></a></li> 
                                <?php endforeach; ?>
                            </ul>
                    </div><!-- /btn-group -->
                </div>
            </div>
         </div>

        <div class="form-group">
            <div class="col-lg-12">
                <textarea class="form-control"
                    type="text"
                    name="message"
                    id="ilch_html"
                    placeholder="<?=$this->getTrans('message')?>"/><?php if ($item != '') { echo $this->escape($item->getMessage()); } ?></textarea>
            </div>
        </div>

        <legend><?=$this->getTrans('time_options')?></legend>


        <div class="form-group">
            <label for="cycle" class="col-lg-2 control-label">
                <?php echo $this->getTrans('cycle'); ?>:
            </label>

            <div class="col-lg-10">
                <select 
                    class="form-control"
                    id="cycle"
                    name="cycle"
                    <?php if( $item != '') { echo $item->if_Series(' ' ,'disabled="disabled"'); } ?>>
                    <?php foreach( Cycle::getArray() as $id => $val ): ?>
                    <option value="<?=$id?>" <?php if( $item != '') { echo ($id === $item->getCycle() ? 'selected="selected"' : '' ); } ?>>
                        <?=$this->getTrans('cycle_'. $val)?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div> 
         </div>

        <div id="weekdays" class="form-group"<?=( ($item != '' && $item->getCycle() == 3 )? '' : 'style="display: none;"');?>>
            <label for="cycle" class="col-lg-2 control-label">
                <?php echo $this->getTrans('cycle_weekdays'); ?>:
            </label>

            <div class="col-lg-10">
                <div class="btn-group">
                <?php foreach($this->getTranslator()->getTranslations()['dayNames'] as $i => $day ): ?>
                    <label class="btn btn-default" style="text-align: center;" for="check_<?=$i?>">
                        <input type="checkbox" name="weekdays[<?=$i?>]" id="check_<?=$i?>" <?php if( in_array($i, $item->getWeekdays())): echo 'checked="checked"'; endif; ?>> 
                        <?=$day[1]?>
                    </label>  
                <?php endforeach; ?>
                </div>
            </div> 
         </div>

        <div class="form-group">
            <label for="time_start" class="col-lg-2 control-label">
                <?php echo $this->getTrans('time_start'); ?>:
            </label>
            <div class="col-lg-2">
                <input class="form-control text-center col-lg-2"
                       type="time"
                       id="time_start"
                       name="time_start"
                       placeholder="HH:MM"
                       max="5" maxlength="5"
                       value="<?php if( $item != '') { echo $item->getStart('H:i'); } ?>" />
            </div>
            <div class="col-lg-2">
                <input class="form-control text-center col-lg-2"
                       type="time"
                       id="time_ends"
                       name="time_ends"
                       placeholder="HH:MM"
                       max="5" maxlength="5"
                       value="<?php if( $item != '') { echo $item->getEnds('H:i'); } ?>" />
            </div>
        </div>

        <div class="form-group">
            <label for="date_start" class="col-lg-2 control-label">
                <?php echo $this->getTrans('date_start'); ?>:
            </label>
            <div class="col-lg-3">
                <input class="form-control text-center"
                       type="date"
                       id="date_start"
                       name="date_start"
                       placeholder="YYYY-MM-TT"
                       value="<?php if( $item != '') { echo $item->if_Series( $item->getMinDate('Y-m-d'), $item->getStart('Y-m-d') ); } ?>" />
            </div>
        </div>

        <div id="endsDatepicker" class="form-group" <?=( ($item != '' && $item->getCycle() > 0 )? '' : 'style="display: none;"');?>>
            <label for="date_ends" class="col-lg-2 control-label">
                <?php echo $this->getTrans('date_ends'); ?>:
            </label>
            <div class="col-lg-3">
                <input class="form-control text-center"
                       type="date"
                       id="date_ends"
                       name="date_ends"
                       placeholder="YYYY-MM-TT"
                       <?=(($item != '' && $item->getCycle() > 0 ) ? '' : 'disabled="disabled"');?>
                       value="<?php if( $item != '') { echo $item->if_Series( $item->getMaxDate('Y-m-d'), $item->getStart('Y-m-d') ); } ?>" />
            </div>
        </div>
    
    </div>
    
    <div class="col-lg-5">
        <legend>
        <?php
            if ($item != '') {
                echo $this->getTrans('menu_action_update_calendar');
            } else {
                echo $this->getTrans('menu_action_insert_calendar');
            }
        ?>
        </legend>
    
    </div>

    <?php
    if ($this->get('event') != '') {
        echo $this->getSaveBar('editButton');
    } else {
        echo $this->getSaveBar('addButton');
    }
    ?>
</form>

<script type="text/javascript">
    $(document).ready(function(){
        
        $('#cycle').change(function(){
            var $val = $(this).val();
            
            if( $val == '3' ){
                $('#weekdays').slideDown(function(){
                    $(this).find('input').prop('disabled', false);
                });
            
                $('#endsDatepicker').fadeIn(function(){
                    $(this).find('input').prop('disabled', false);
                });
            } else {
                $('#weekdays').slideUp(function(){
                    $(this).find('input').prop('disabled', true);
                });
                
                if( $val > 0 ){
                    $('#endsDatepicker').fadeIn(function(){
                        $(this).find('input').prop('disabled', false);
                    });
                }else if( $val == 0 ){
                    $('#endsDatepicker').fadeOut(function(){
                        $(this).find('input').prop('disabled', true);
                    });
                }
            }
        });
        
        $('.select-Title').click(function(event){
            event.preventDefault();
            $('input[name=title]').val($(this).html());
        });
    });
</script>

