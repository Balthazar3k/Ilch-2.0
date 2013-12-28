<?php
/**
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Contact\Controllers\Admin;
use Contact\Mappers\Receiver as ReceiverMapper;
use Contact\Models\Receiver as ReceiverModel;

defined('ACCESS') or die('no direct access');

class Index extends \Ilch\Controller\Admin
{
    public function init()
    {
        $this->getLayout()->addMenu
        (
            'menuReceiver',
            array
            (
                array
                (
                    'name' => 'menuReceivers',
                    'active' => true,
                    'icon' => 'fa fa-th-list',
                    'url' => $this->getLayout()->url(array('controller' => 'index', 'action' => 'index'))
                ),
            )
        );

        $this->getLayout()->addMenuAction
        (
            array
            (
                'name' => 'menuActionNewReceiver',
                'icon' => 'fa fa-plus-circle',
                'url'  => $this->getLayout()->url(array('controller' => 'index', 'action' => 'treat'))
            )
        );
    }

    public function indexAction()
    {
        $receiverMapper = new ReceiverMapper();
        $receivers = $receiverMapper->getReceivers();
        $this->getView()->set('receivers', $receivers);
    }

    public function deleteAction()
    {
        $receiverMapper = new ReceiverMapper();
        $receiverMapper->delete($this->getRequest()->getParam('id'));
        $this->redirect(array('action' => 'index'));
    }

    public function treatAction()
    {
        $receiverMapper = new ReceiverMapper();

        if ($this->getRequest()->getParam('id')) {
            $this->getView()->set('receiver', $receiverMapper->getReceiverById($this->getRequest()->getParam('id')));
        }

        if ($this->getRequest()->isPost()) {
            $model = new ReceiverModel();

            if ($this->getRequest()->getParam('id')) {
                $model->setId($this->getRequest()->getParam('id'));
            }

            $model->setName($this->getRequest()->getPost('name'));
            $model->setEmail($this->getRequest()->getPost('email'));

            $receiverMapper->save($model);
            $this->redirect(array('action' => 'index'));
        }
    }
}
