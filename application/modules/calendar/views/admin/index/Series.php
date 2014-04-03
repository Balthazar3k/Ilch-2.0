<?php
/**
 * @copyright Balthazar3k 2014
 * @package Calendar 1.0
 */
?>

<legend><?=$this->getTrans('action_series_edit');?></legend>
<div align="center">
    <div class="btn-group" align="center">
        <a class="btn btn-default" href="
        <?=$this->getUrl(array(
            'action' => 'treat',
            'id' => $this->getRequest()->getParam('id'),
            'series' => 1
        ));?>   
        ">
            <?=$this->getTrans('action_series_true')?> 
            <i class="fa fa-calendar"></i>
        </a>
        <a class="btn btn-default" href="
        <?=$this->getUrl(array(
            'action' => 'treat',
            'id' => $this->getRequest()->getParam('id'),
            'series' => 0
        ));?>   
        ">
            <i class="fa fa-calendar-o"></i> 
            <?=$this->getTrans('action_series_false')?>
        </a>
    </div>
</div>