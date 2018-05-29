<?php
/**
 * FP Platform
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    FPPlatform
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class UserLogin extends AppModel
{
    public $name = 'UserLogin';
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    function insertUserLogin($user_id)
    {
        $this->data['UserLogin']['user_id'] = $user_id;
        $this->data['UserLogin']['ip_id'] = $this->toSaveIp();
        $this->data['UserLogin']['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $this->save($this->data);
        if (!empty($_COOKIE['PHPSESSID'])) {
            $hashed_val = md5($_SESSION['Auth']['User']['id'] . session_id() . PERMANENT_CACHE_GZIP_SALT);
            $hashed_val = substr($hashed_val, 0, 7);
            $form_cookie = $_SESSION['Auth']['User']['id'] . '|' . $hashed_val;
            setcookie('_gz', $form_cookie, time() +60*60*24, '/');
        }
    }
    function afterSave($is_created)
    {
        $this->User->updateAll(array(
            'User.last_login_ip' => '\'' . RequestHandlerComponent::getClientIP() . '\'',
            'User.last_logged_in_time' => '\'' . date('Y-m-d H:i:s') . '\'',
        ) , array(
            'User.id' => $_SESSION['Auth']['User']['id']
        ));
    }
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
}
?>