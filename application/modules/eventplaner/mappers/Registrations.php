<?php
/**
 * @copyright Balthazar3k 2014
 * @package Eventplaner 2.0
 */

namespace Eventplaner\Mappers;

defined('ACCESS') or die('no direct access');

class Registrations extends \Ilch\Mapper
{
    public function get($eid)
    {
        $res = $this->db()
            ->selectArray('*')
            ->from('ep_registrations')
            ->where(array('eid' => $eid))
            ->order(array('status' => 'ASC'))
            ->execute();
        
        if (empty($res)) {
            return array();
        }
        
        $return = array();
        
        foreach( $res as $val ){
            $model = new \Eventplaner\Models\Registrations();
            $model->setId($val['id']);
            $model->setStatus($val['status']);
            $model->setEid($val['eid']);
            $model->setUid($val['uid']);
            $model->setCid($val['cid']);
            $model->setComment($val['comment']);
            $model->setChanged($val['changed']);
            $model->setRegistered($val['registered']);
            $return[] = $model;
        }
        
        return $return;
    }
    
    public function numRegistrations($eid)
    {  
        return $this->db()->queryCell('
            SELECT COUNT(`id`) as numRegistrations 
            FROM [prefix]_ep_registrations 
            WHERE eid=\''.$eid.'\' AND status = 1;
        ');
    }
	
    public function save(\Eventplaner\Models\Registrations $model)
    {
        $entry = array();
        $entry['status'] = $model->getStatus();
        $entry['eid'] = $model->getEid();
        $entry['uid'] = $model->getUid();
        $entry['cid'] = $model->getCid();
        $entry['comment'] = $model->getComment();

        $regId = $this->isLogged( $model->getEid() );
        if( $regId ) {
            $this->db()->update('ep_registrations')
                    ->fields($entry)
                    ->where(array('id' => $regId))
                    ->execute();
        } else {
            $this->db()->insert('ep_registrations')
                    ->fields($entry)
                    ->execute();
        }
        
        return;
    }
    
    public function isLogged($eid)
    {
        $userId = (int) $_SESSION['user_id'];
        
        return (int) $this->db()
            ->selectCell('id')
            ->from('ep_registrations')
            ->where(
                array(
                    'eid' => $eid,
                    'uid' => $userId
                )
            )
            ->execute();
    }
    
    public function getRegistrationByEventId($eid)
    {
        $userId = (int) $_SESSION['user_id'];
        
        $val = $this->db()
            ->selectRow('*')
            ->from('ep_registrations')
            ->where(
                array(
                    'eid' => $eid,
                    'uid' => $userId
                )
        )
        ->execute();
        
        if(empty($val)){
            return array();
        }
        
        $model = new \Eventplaner\Models\Registrations();
        $model->setId($val['id']);
        $model->setStatus($val['status']);
        $model->setEid($val['eid']);
        $model->setUid($val['uid']);
        $model->setCid($val['cid']);
        $model->setComment($val['comment']);
        $model->setChanged($val['changed']);
        $model->setRegistered($val['registered']);
        
        return $model;
    }


    public function delete($id)
    {
        return $this->db()->delete('ep_registrations')
            ->where(array('id' => $id))
            ->execute();
    }
}
?>