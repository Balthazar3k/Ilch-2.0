<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
$config = $this->get('config');
?>

<form class="form-horizontal" method="POST" action="<?php echo $this->getUrl(array('action' => 'treat', 'id' => $this->getRequest()->getParam('id'))); ?>">
    <?php echo $this->getTokenField(); ?>
    <input type="hidden" name="organizer" value="<?=$_SESSION['user_id']?>" />
        
    <legend>
    <?php
        if ($this->get('event') != '') {
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
                <option value="unique"><?=$this->getTrans('cycle_unique')?></option>
                <option value="daily"><?=$this->getTrans('cycle_daily')?></option>
                <option value="weekly"><?=$this->getTrans('cycle_weekly')?></option>
                
                <!--<option value="2"><?=$this->getTrans('cycle_2_days')?></option>
                <option value="3"><?=$this->getTrans('cycle_3_days')?></option>
                <option value="4"><?=$this->getTrans('cycle_4_days')?></option>
                <option value="5"><?=$this->getTrans('cycle_5_days')?></option>
                <option value="6"><?=$this->getTrans('cycle_6_days')?></option>-->
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
                   value="<?php if( $this->get('item') != '') { echo ( empty($this->get('item')->getDateStart()) ? '' : $this->get('item')->getDateStart() ); } ?>" />
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
                   value="<?php if( $this->get('item') != '') { echo ( empty($this->get('item')->getEnds()) ? '' : $this->get('item')->getEnds() ); } ?>" />
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
                   value="<?php if( $this->get('item') != '') { echo ( empty($this->get('item')->getDateStart()) ? '' : $this->get('item')->getDateStart() ); } ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="ends" class="col-lg-1 control-label">
            <?php echo $this->getTrans('date_ends'); ?>:
        </label>
        <div class="col-lg-5">
            <input class="form-control datepicker"
                   type="text"
                   id="date_ends"
                   name="date_ends"
                   placeholder="YYYY-MM-TT"
                   value="<?php if( $this->get('item') != '') { echo ( empty($this->get('item')->getEnds()) ? '' : $this->get('item')->getEnds() ); } ?>" />
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
    
    });
</script>
