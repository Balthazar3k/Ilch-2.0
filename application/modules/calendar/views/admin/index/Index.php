<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
namespace Eventplaner\Views\Admin;
use User\Mappers\User as UserMapper;
$user = new UserMapper;

$config = $this->get('config');
$status = (array) json_decode($config->get('event_status'), true);
?>
<h4><?=$this->getTrans('listView');?></h4>

<?php
if(empty($this->get('eventList'))){
    echo $this->getTrans('noEvents');
    return;
}
?>

<link href="<?php echo $this->getStaticUrl('../application/modules/eventplaner/static/css/index.css'); ?>" rel="stylesheet">

<table class="table table-hover table-striped">
    <thead>
        <tr valign="middle">
            <th><center><?=$this->getTrans('status');?></center></th>
            <th><?=$this->getTrans('options');?></th>
            <th><?=$this->getTrans('start');?>, <?=$this->getTrans('ends');?> & <?=$this->getTrans('duration');?></th>
            <th><?=$this->getTrans('event');?></th>
            <th><center><?=$this->getTrans('registrations');?></center></th>
            <th><center><?=$this->getTrans('organizer');?></center></th>
            <th><center><?=$this->getTrans('created');?></center></th>
            <th><center><?=$this->getTrans('changed');?></center></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach( $this->get('eventList') as $event ): ?>
        <tr>

            <td>
                <div align="center" style="<?=$status[$event->getStatus()]['style'];?>" class="status"><?=$this->getTrans($status[$event->getStatus()]['status']);?></div>
            </td>

            <td>
                <div class="btn-group">
                    <a class="btn btn-default" href="<?=$this->getURL(array( 'action' => 'treat', 'id' => $event->getId(), ));?>"><i class="fa fa-pencil-square-o"></i> </a>
                    <a class="btn btn-default" data-toggle="dropdown" href="#">
                        <span class="fa fa-caret-down"></span>
                    </a>

                    <ul class="dropdown-menu">
                    <?php foreach($status as $statusId => $val ): ?>

                        <li><a href="<?=$this->getURL(array(
                        'action' => 'status', 
                        'id' => $event->getId(),
                        'status' => $statusId,
                        'page' => $this->getRequest()->getParam('page')

                            ));?>"><?=$this->getTrans($val['status'])?></a></li>

                    <?php endforeach; ?>
                    </ul>

                </div>
            </td>

            <td>
                <?=$this->getTrans(date('w', $event->getStartTS()));?>, <?=date('d.m.Y', $event->getStartTS());?> 
                <b><?=date('H:i', $event->getStartTS());?> - <?=date('H:i', $event->getEndsTS());?></b> ...(<?=$event->getTimeDiff('H:i');?>h)
            </td>

            <td>
                <?=$event->getEvent()?>
                <!--<?=(!empty($event->getTitle()) ? $event->getTitle() : $event->getEvent())?>-->
            </td>

            <td align="center">
                <b><?=$event->numRegistrations()?> / <?=$event->getRegistrations()?></b>
            </td>

            <td align="center">
                <center><?=$event->getOrganizerName();?></center>
            </td>

            <td align="center">
                <center><?=date('d.m.Y H:i', strtotime($event->getCreated()));?></center>
            </td>

            <td align="center">
                <center><?=date('d.m.Y H:i', strtotime($event->getChanged()));?></center>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<center><?=$this->get('pagination')->getHtml($this, array('action' => 'index'));?></center>