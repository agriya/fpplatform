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
class UserAddWalletAmount extends AppModel
{
    public $name = 'UserAddWalletAmount';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'amount' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            )
        );
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account = '')
    {
        $UserAddWalletAmount = $this->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id' => $foreign_id
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        $return['receiverEmail'] = array(
            $payee_account
        );
        $return['amount'] = array(
            $UserAddWalletAmount['UserAddWalletAmount']['amount']
        );
        /* $return['fees_payer'] = 'buyer';
        if (Configure::read('wallet.wallet_fee_payer') == 'Site') {*/
        $return['fees_payer'] = 'merchant';
        //}
        $return['sudopay_gateway_id'] = $UserAddWalletAmount['UserAddWalletAmount']['sudopay_gateway_id'];
        $return['buyer_email'] = $UserAddWalletAmount['User']['email'];
        return $return;
    }
}
?>