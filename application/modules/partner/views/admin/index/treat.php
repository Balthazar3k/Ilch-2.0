<form class="form-horizontal" method="POST" action="<?php echo $this->getUrl(array('action' => $this->getRequest()->getActionName(), 'id' => $this->getRequest()->getParam('id'))); ?>">
    <?php echo $this->getTokenField(); ?>
    <legend>
    <?php
        if ($this->get('partner') != '') {
            echo $this->getTrans('menuActionEditPartner');
        } else {
            echo $this->getTrans('menuActionNewPartner');
        }
    ?>
    </legend>
    <div class="form-group">
        <label for="name" class="col-lg-2 control-label">
            <?php echo $this->getTrans('name'); ?>:
        </label>
        <div class="col-lg-4">
            <input class="form-control"
                   type="text"
                   name="name"
                   id="name"
                   placeholder="Name"
                   value="<?php if ($this->get('partner') != '') { echo $this->escape($this->get('partner')->getName()); } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="link" class="col-lg-2 control-label">
            <?php echo $this->getTrans('link'); ?>:
        </label>
        <div class="col-lg-4">
            <input class="form-control"
                   type="text"
                   name="link"
                   id="link"
                   placeholder="http://"
                   value="<?php if ($this->get('partner') != '') { echo $this->escape($this->get('partner')->getLink()); } ?>" />
        </div>
    </div>
    <div class="form-group">
        <label for="banner" class="col-lg-2 control-label">
            <?php echo $this->getTrans('banner'); ?>:
        </label>
        <div class="col-lg-4">
            <input class="form-control"
                   type="text"
                   name="banner"
                   id="banner"
                   placeholder="http://"
                   value="<?php if ($this->get('partner') != '') { echo $this->escape($this->get('partner')->getBanner()); } ?>" />
        </div>
    </div>
    <?php
    if ($this->get('partner') != '') {
        echo $this->getSaveBar('editButton');
    } else {
        echo $this->getSaveBar('addButton');
    }
    ?>
</form>
