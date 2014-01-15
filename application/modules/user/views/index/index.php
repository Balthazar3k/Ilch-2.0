<div class="row">
    <?php foreach ($this->get('userList') as $userlist) { ?>        
        <div class="col-lg-4">
            <div class="user">
                <img src="http://www.ilch.de/include/images/avatars/noavatar.jpg" alt="">
                <h3><a href="<?php echo $this->url(array('module' => 'user', 'controller' => 'profil', 'action' => 'index', 'user' => $userlist->getId())); ?>" title="<?php echo $this->escape($userlist->getName()); ?>s <?php echo $this->trans('profile'); ?>"><?php echo $this->escape($userlist->getName()); ?></a></h3>
                <div class="userInfo">
                    <i class="fa fa-star" title="<?php echo $this->trans('rank'); ?>"></i> {Rangname]
                    <br />
                    <i class="fa fa-sign-in" title="<?php echo $this->trans('regist'); ?>"></i> <?php echo $this->escape($userlist->getDateCreated()) ?>
                </div>
                <div class="userLinks">
                    <?php echo $this->trans('contact'); ?>:
                    <br>
                    <a href="<?php echo $this->url(array('module' => 'user', 'controller' => 'profil', 'action' => 'index', 'user' => $userlist->getId())); ?>" class="fa fa-user" title="<?php echo $this->escape($userlist->getName()); ?>s <?php echo $this->trans('profile'); ?>"></a>
                    <a href="mailto:<?php echo $this->escape($userlist->getEmail()); ?>" class="fa fa-envelope" title="E-Mail"></a>
                    <a href="#" class="fa fa-globe" title="<?php echo $this->trans('website'); ?>"></a>                    
                    <a href="#" class="fa fa-comment" title="ICQ"></a>
                    <a href="#" class="fa fa-skype" title="Skype"></a>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>