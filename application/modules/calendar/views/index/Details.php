<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
    $user = new User\Mappers\User();
    $event = $this->get('event');
    $eventStatus = json_decode($this->get('config')->get('event_status'), true);
    $reg = $event->getRegistrationByEventId();
    $registrationSwitch = $event->registrationSwitch($message);
?>

<link href="<?php echo $this->getStaticUrl('../application/modules/eventplaner/static/css/index.css'); ?>" rel="stylesheet">

<div class="event">
    <div>
        <h3 style="float: left;"><?=(!empty($event->getTitle()) ? $event->getTitle() : $event->getEvent())?></h3>
        <h3 style="float: right;"><?=(empty($event->getTitle()) ? $event->getTitle() : $event->getEvent())?> <?=$event->getRegistrations();?></h3>
        <br style="clear: both;" />
    </div>
    
    <div class="status status-string" style="<?=$eventStatus[$event->getStatus()]['style'];?>">
        <div style="float:left;">
            <strong>
                <span class="transparent"><?=$this->getTrans(date('w', strtotime($event->getStart())));?></span> 
                <?=$event->getStartDate('d.m.Y')?>
            </strong>
            <span class="transparent"> um </span>
            <strong>
                <?=$event->getStartDate('H:i');?> - 
                <?=$event->getEndsDate('H:i');?> 
            </strong>
            <span class="transparent">: <?=$event->getTimeDiff();?></span>
        </div>
        <div style="font-weight: bold; float:right;"><?=$this->getTrans($eventStatus[$event->getStatus()]['status']);?></div>
        <br style="clear: both;" />
    </div>
    <br>
    <div class="singel-line">
        <div id="progressbar" data-value="<?=$event->numRegistrations();?>" data-max="<?=$event->getRegistrations();?>">
            <div class="progress-label">
                <?=$this->getTrans('registrations')?>: 
                <?=$event->numRegistrations();?>/<?=$event->getRegistrations();?>
            </div>
        </div>
    </div>
  
    <?php if( $event->getMessage() != '' ): ?>
    <hr>
    <div class="singel-line" style="color: #000;">
        <b><?=$event->getOrganizerName();?> <?=$this->getTrans('writes');?>: </b><?=$event->getMessage();?>
    </div>
    <hr>
    <?php endif; ?>
    
    <?php if( $registrationSwitch ) : ?>
    <div>
        <h4 style="float: left;"><?php echo $this->getTrans('registrations'); ?></h4>
        <h4 style="float: right;">
        
            <input type="button" class="btn" id="opener" value="
                <?php 
                    if( is_object($reg) ){
                        echo $this->getTrans('changeRegister');
                    } else {
                        echo $this->getTrans('register');
                    }
                ?>
            " style="color: black">
            <!--<input type="button" class="btn" id="opener" value="Anmeldung L&ouml;schen" style="color: black">-->
        
        </h4>
        <br style="clear: both;" />
    </div>
    <?php else: ?>
    <div class="singel-line" align="center">
        <h4><?=$this->getTrans($message);?></h4>
    </div>
    <?php endif; ?>
    <div class="singel-line" style="font-weight: bold;">
        <?php if(!is_object($event->registrationsList())): ?>
        <div>
            <?php foreach( $event->registrationsList() as $registration):?>
            
            <div title="<?=$registration->getComment()?>" class="registrations" style="border-radius: 5px; <?=$eventStatus[$registration->getStatus()]['style']?>">
                <div class="registered">
                    <div align="center"><?=$this->getTrans($eventStatus[$registration->getStatus()]['regist']);?></div>
                    <div align="center"><?=$registration->getUserName();?></div>
                    <div align="center"><?=date('d.m.y H:i', strtotime($registration->getChanged()));?></div>
                    <div align="center"><?=date('d.m.y H:i', strtotime($registration->getRegistered()));?></div>
                    <br style="clear: both;" />
                </div>
            </div>
                
            <?php endforeach; ?>
        </div>
        <?php else: echo $this->getTrans('noRegistrations'); endif; ?>
    </div>
    <hr>
    
    <div class="singel-line small">
        <div style="float:left;"><?=$this->getTrans('created');?> <?=date('d.m.Y H:i', strtotime($event->getCreated()));?></div>
        <div style="float:right;"><?=$this->getTrans('changed');?> <?=date('d.m.Y H:i', strtotime($event->getChanged()));?></div>
        <br style="clear: both;" />
    </div>

</div>

<?php if( $registrationSwitch ) : ?>

<div id="dialog" title="<?php 
    if( is_object($reg) ){
        echo $this->getTrans('changeRegister');
    } else {
        echo $this->getTrans('register');
    }
    ?>">
    <form action="" class="form-horizontal" method="POST">
        <?php echo $this->getTokenField(); ?>
        <div class="form-group">
            <div>
                <select class="form-control" name="eventRegistration[status]">
                    <option><?=$this->getTrans('choose')?> <?=$this->getTrans('status')?></option>
                    <?php foreach( $eventStatus as $status => $value): ?>
                    <option style="<?=$value['style'];?> padding: 5px 0 0 10px; font-weight: bold;" value="<?=$status?>"
                           <?php if( is_object($reg) ): if( $status == $reg->getStatus() ): echo 'selected="selected"'; endif; endif;?>>
                        &ShortRightArrow; <?=$this->getTrans($value['regist']);?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div>
                <select class="form-control" name="eventRegistration[uid]">
                    <option value="<?=$_SESSION['user_id']?>"><?=$user->getUserById($_SESSION['user_id'])->getName();?></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div>
                <textarea 
                          class="form-control"
                          name="eventRegistration[comment]"
                          ><?php if( is_object($reg) ): echo $reg->getComment(); endif;?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-offset-2 col-lg-8">
                <input type="submit" 
                       name="saveEntry" 
                       class="btn"
                       value="<?php if( is_object($reg) ): echo $this->getTrans('save'); else: echo $this->getTrans('register'); endif;?>" />
            </div>
        </div>
    </form>
</div>

<?php endif; ?>


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