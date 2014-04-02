<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Calendar\Views\Admin\Index;
use Calendar\Plugins\Functions as func;
$config = $this->get('config');
?>

<form class="form-horizontal" method="POST" action="<?php echo $this->getUrl(array('action' => 'treat', 'id' => $this->getRequest()->getParam('id'))); ?>">
    <?php echo $this->getTokenField(); ?>
    <input type="hidden" name="organizer" value="<?=$_SESSION['user_id']?>" />
        
    <legend>
    <?php
        if ($this->get('item') != '') {
            echo $this->getTrans('menu_action_update_calendar');
        } else {
            echo $this->getTrans('menu_action_insert_calendar');
        }
    ?>
    </legend>

    <div class="form-group">

        <div class="col-lg-6">
            <input class="form-control"
                   type="text"
                   name="title"
                   id="title"
                   placeholder="<?php echo $this->getTrans('title'); ?>"
                   value="<?php if ($this->get('item') != '') { echo $this->escape($this->get('item')->getTitle()); } ?>" />
        </div>
     </div>
    
    <div class="form-group">
        <div class="col-lg-6">
            <textarea class="form-control"
                type="text"
                name="message"
                id="ilch_html"
                placeholder="<?=$this->getTrans('message')?>"/><?php if ($this->get('item') != '') { echo $this->escape($this->get('item')->getMessage()); } ?></textarea>
        </div>
    </div>
    
    <legend><?=$this->getTrans('time_options')?></legend>
        

    <div class="form-group">
        <label for="cycle" class="col-lg-1 control-label">
            <?php echo $this->getTrans('cycle'); ?>:
        </label>

        <div class="col-lg-5">
            <select 
                class="form-control"
                id="cycle"
                name="cycle">
                <?php foreach( func::cycleNames() as $id => $val ): ?>
                <option value="<?=$id?>" <?=($id === $this->get('item')->getCycle() ? 'selected="selected"' : '' )?>>
                    <?=$this->getTrans('cycle_'. $val)?>
                </option>
                <?php endforeach; ?>
            </select>
        </div> 
     </div>
    
    <div class="form-group">
        <label for="start" class="col-lg-1 control-label">
            <?php echo $this->getTrans('time_start'); ?>:
        </label>
        <div class="col-lg-5">
            <input class="form-control"
                   type="text"
                   id="time_start"
                   name="time_start"
                   placeholder="HH:MM"
                   max="5" maxlength="5"
                   value="<?php if( $this->get('item') != '') { echo $this->get('item')->getStart('H:i'); } ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="ends" class="col-lg-1 control-label">
            <?php echo $this->getTrans('time_ends'); ?>:
        </label>
        <div class="col-lg-5">
            <input class="form-control"
                   type="text"
                   id="time_ends"
                   name="time_ends"
                   placeholder="HH:MM"
                   max="5" maxlength="5"
                   value="<?php if( $this->get('item') != '') { echo $this->get('item')->getEnds('H:i'); } ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="start" class="col-lg-1 control-label">
            <?php echo $this->getTrans('date_start'); ?>:
        </label>
        <div class="col-lg-5">
            <input class="form-control  datepicker"
                   type="text"
                   id="date_start"
                   name="date_start"
                   placeholder="YYYY-MM-TT"
                   value="<?php if( $this->get('item') != '') { echo $this->get('item')->getStart('Y-m-d'); } ?>" />
        </div>
    </div>

    <div id="endsDatepicker" class="form-group" <?=( $this->get('item')->getCycle() > 0 ? '' : 'style="display: none;"');?>>
        <label for="ends" class="col-lg-1 control-label">
            <?php echo $this->getTrans('date_ends'); ?>:
        </label>
        <div class="col-lg-5">
            <input class="form-control datepicker"
                   type="text"
                   id="date_ends"
                   name="date_ends"
                   placeholder="YYYY-MM-TT"
                   <?=( $this->get('item')->getCycle() > 0 ? '' : 'disabled="disabled"');?>
                   value="<?php if( $this->get('item') != '') { echo $this->get('item')->getMaxDate('Y-m-d'); } ?>" />
        </div>
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

        $( ".datepicker" ).each(function(i){
            $(this).datepicker({ 
                dateFormat: "yy-mm-dd"
            });
        });
        
        $('#cycle').change(function(){
            var $val = $(this).val();
            console.log($val);
            if( $val > 0 ){
                $('#endsDatepicker').fadeIn(function(){
                    $(this).find('input').prop('disabled', false);
                });
            }else if( $val === 'unique' ){
                $('#endsDatepicker').fadeOut(function(){
                    $(this).find('input').prop('disabled', true);
                });
            }
        });
        
        $("input#time_ends, input#time_start").bind("keyup", function(event){
            event.preventDefault();
            var val = $(this).val();
            if( val.length === 2 && event.keyCode !== 8 ){        
                $(this).val(val+":");
            }
            
            if( val.indexOf(':') && val.length === 5 ){
                var time = val.split(':');
                
                if( time[0] > 23 && time[1] > 59 ){
                    $(this).val('23:59');
                }else if( time[0] > 23 ){
                    time[0] = 23;
                    $(this).val('23:'.time[1]);
                }
            }
        });
    
    });
</script>
