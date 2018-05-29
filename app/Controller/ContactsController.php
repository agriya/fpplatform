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
class ContactsController extends AppController
{
    public $name = 'Contacts';
    public $components = array(
        'Email',
        'RequestHandler'
    );
    public $uses = array(
        'Contact',
        'EmailTemplate'
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            '_wysihtml5_mode',
            'adcopy_response',
            'adcopy_challenge'
        );
        parent::beforeFilter();
    }
    function add()
    {
        if (!empty($this->request->data)) {
            $this->Contact->set($this->request->data);
            if ($this->Contact->validates()) {
                $ip = $this->Contact->toSaveIP();
                $this->request->data['Contact']['ip_id'] = $ip;
                $this->request->data['Contact']['user_id'] = $this->Auth->user('id');
                if ($this->Contact->save($this->request->data, false)) {
                    if (empty($this->data['Contact']['subject'])) {
                        $get_contact_types = $this->Contact->ContactType->find('first', array(
                            'conditions' => array(
                                'ContactType.id' => $this->data['Contact']['contact_type_id']
                            ) ,
                            'recursive' => -1
                        ));
                        $this->request->data['Contact']['subject'] = $get_contact_types['ContactType']['name'];
                    }
                    $email = $this->EmailTemplate->selectTemplate('Contact Us');
                    $emailFindReplace = array(
                        '##SITE_NAME##' => Configure::read('site.name') ,
                        '##FIRST_NAME##' => $this->request->data['Contact']['first_name'],
                        '##LAST_NAME##' => !empty($this->request->data['Contact']['last_name']) ? ' ' . $this->request->data['Contact']['last_name'] : '',
                        '##FROM_EMAIL##' => (strstr($email['from'], '##FROM_EMAIL##')) ? str_replace('##FROM_EMAIL##', Configure::read('site.from_email') , $email['from']) : $email['from'],
                        '##FROM_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add'
                        ) , true) ,
                        '##SITE_ADDR##' => gethostbyaddr($this->RequestHandler->getClientIP()) ,
                        '##IP##' => $ip,
                        '##TELEPHONE##' => $this->request->data['Contact']['telephone'],
                        '##MESSAGE##' => $this->request->data['Contact']['message'],
                        '##SUBJECT##' => $this->request->data['Contact']['subject'],
                        '##POST_DATE##' => date('F j, Y g:i:s A (l) T (\G\M\TP)') ,
                        '##CONTACT_URL##' => Router::url(array(
                            'controller' => 'contacts',
                            'action' => 'add'
                        ) , true) ,
                        '##SITE_URL##' => Router::url('/', true) ,
                        '##CONTACT_FROM_EMAIL##' => $this->request->data['Contact']['email']
                    );
                    // send to contact email
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    $template = $this->EmailTemplate->selectTemplate('Contact Us');
                    $this->Contact->_sendEmail($template, $emailFindReplace, Configure::read('site.admin_email'));
                    // reply email
                    $template = $this->EmailTemplate->selectTemplate('Contact Us Auto Reply');
                    $this->Contact->_sendEmail($template, $emailFindReplace, $this->request->data['Contact']['email']);
                    $this->Session->setFlash(__l('Thank you, we received your message and will get back to you as soon as possible.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'contacts',
                        'action' => 'add',
                    ));
                    $this->set('success', 1);
                }
            } else {
                $this->Session->setFlash(__l('Contact could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        if ((!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'report')) || (!empty($this->request->data['Contact']['type']) && ($this->request->data['Contact']['type'] == 'report'))) {
            $this->request->data['Contact']['contact_type_id'] = ConstContatctType::ConflictWithSellerOrBuyer;
            if (!empty($this->request->data['Contact']['job_order_id'])):
                $this->request->params['named']['order'] = $this->request->data['Contact']['job_order_id'];
            endif;
            if (!empty($this->request->params['named']['order']) || (!empty($this->request->data['Contact']['job_order_id']))) {
                $job = $this->Contact->Job->JobOrder->find('first', array(
                    'conditions' => array(
                        'JobOrder.id' => $this->request->params['named']['order']
                    ) ,
                    'contain' => array(
                        'Job' => array(
                            'fields' => array(
                                'Job.id',
                                'Job.title',
                                'Job.user_id',
                                'Job.amount',
                            ) ,
                            'User' => array(
                                'fields' => array(
                                    'User.id',
                                    'User.username',
                                    'User.email',
                                    'User.available_balance_amount',
                                    'User.blocked_amount',
                                    'User.cleared_amount',
                                    'User.available_purchase_amount',
                                )
                            )
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.id',
                                'User.username',
                                'User.email',
                                'User.available_balance_amount',
                                'User.blocked_amount',
                                'User.cleared_amount',
                                'User.available_purchase_amount',
                            )
                        )
                    ) ,
                    'recursive' => 2
                ));
                if (!empty($job)) {
                    $this->request->data['Contact']['contact_type_id'] = ConstContatctType::ConflictWithSellerOrBuyer;
                    $contact['job_id'] = $job['Job']['id'];
                    $contact['job_title'] = $job['Job']['title'];
                    $contact['job_order_id'] = $job['JobOrder']['id'];
                    $this->set('contacts', $contact);
                }
            }
        }
        $contact_types = $this->Contact->ContactType->find('list', array(
            'conditions' => array(
                'ContactType.is_active' => 1
            ) ,
            'order' => array(
                'ContactType.id' => 'asc'
            )
        ));
        unset($this->request->data['Contact']['captcha']);
        $users = $this->Contact->User->find('list', array(
            'conditions' => array(
                'User.is_active' => '1'
            )
        ));
        $this->set(compact('contact_types', 'users'));
        $this->pageTitle = __l('Feedback ');
    }
    function admin_index()
    {
        $this->pageTitle = __l('Contacts');
        $conditions = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Contact']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Contact']['filter_id'])) {
            if ($this->request->data['Contact']['filter_id'] == ConstMoreAction::IsReplied) {
                $conditions['Contact.is_replied'] = 1;
                $this->pageTitle.= __l(' - Replied ');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Contact']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['Contact.created <= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' -  today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['Contact.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' -  in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['Contact.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' -  in this month');
        }
        $this->set('page_title', $this->pageTitle);
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'ContactType'
            ) ,
            'recursive' => 1,
            'order' => array(
                'Contact.id' => 'DESC'
            )
        );
        $this->set('contacts', $this->paginate());
        $moreActions = $this->Contact->moreActions;
        $this->set('moreActions', $moreActions);
    }
    function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Contact->delete($id)) {
            $this->Session->setFlash(__l('Contact deleted') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>