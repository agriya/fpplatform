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
class PagesController extends AppController
{
    function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Page.id',
            'Page.Update',
            'Page.Add',
            'Page.Preview'
        );
        parent::beforeFilter();
    }
    function admin_add()
    {
        if (!empty($this->request->data)) {
            $this->Page->set($this->request->data);
            if ($this->Page->validates()) {
                $this->request->data['Page']['draft'] = $this->request->data['Page']['status_option_id'];
                $this->Page->save($this->request->data);
                $this->Session->setFlash(__l('Page has been created') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Page could not be added. Please, try again.') , 'default', null, 'error');
            }
        }
        $templates = array();
        $template_files = glob(APP . 'views' . DS . 'pages' . DS . 'themes' . DS . '*.ctp');
        if (!empty($template_files)) {
            foreach($template_files as $template_file) {
                $templates[basename($template_file) ] = basename($template_file);
            }
        }
        $statusOptions = $this->Page->statusOptions;
        $parentIdOptions = $this->Page->getListThreaded();
        $this->set(compact('parentIdOptions', 'templates', 'statusOptions'));
    }
    function admin_edit($id = null)
    {
        if (!empty($this->request->data)) {
            $this->Page->set($this->request->data);
            if ($this->Page->validates()) {
                $this->Page->save($this->request->data);
                $this->Session->setFlash(__l('Page has been Updated') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Page could not be Updated. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Page->read(null, $id);
        }
    }
    function admin_index()
    {
        $this->pageTitle = __l('Pages');
        $this->Page->recursive = -1;
        $this->paginate = array(
            'order' => array(
                'id' => 'DESC'
            )
        );
        $this->set('pages', $this->paginate());
    }
    function admin_delete($id = null, $cancelled = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Page->delete($id)) {
            $this->Session->setFlash(__l('Page Deleted Successfully') , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index',
                $cancelled
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function admin_view($slug = null)
    {
        $this->Page->recursive = -1;
        if (!empty($slug)) {
            $page = $this->Page->findBySlug($slug);
        } else {
            $page = $this->Page->find('first', array(
                'conditions' => array(
                    'Page.is_default' => 1
                )
            ));
        }
        if (Configure::read('job.commission_type') == ConstCommsisionType::Amount) {
            $commission_amount = Configure::read('site.currency') . Configure::read('job.commission_amount');
        } else {
            $commission_amount = (Configure::read('job.commission_amount')) . '%';
        }
        $job_table = '';
        $formattedAmounts = $this->jobFormatAmount(Configure::read('job.price') , Configure::read('job.commission_amount'));
        if (count($formattedAmounts['job_amount']) == 1) {
            $job_table.= __l('Work prices are fixed at') . ' ' . $formattedAmounts['job_amount'][0] . ' ' . __l('For each of your works that was ordered and delivered, your net share will be the deducted amount from commission amount of') . ' ' . $formattedAmounts['job_amount'][0];
            if (Configure::read('job.commission_type') != ConstCommsisionType::Amount) $job_table.= '%';
            else $job_table.= Configure::read('site.currency');
        } else {
            $job_table.= '<table class ="list">';
            $job_table.= '<tr>';
            $job_table.= '<th>' . jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Amount') . ' (' . Configure::read('site.currency') . ')</th>';
            $job_table.= '<th>' . jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Commission') . ' (' . Configure::read('site.currency') . ')</th>';
            $job_table.= '<th>' . __l('Seller Amount') . ' (' . Configure::read('site.currency') . ')</th>';
            $job_table.= '</tr>';
            for ($i = 0; $i < count($formattedAmounts['job_amount']); $i++) {
                $comm_amount = (count($formattedAmounts['commission_amount']) == 1) ? $formattedAmounts['commission_amount'][0] : $formattedAmounts['commission_amount'][$i];
                if (Configure::read('job.commission_type') != ConstCommsisionType::Amount) $comm_amount = $formattedAmounts['job_amount'][$i]*0.01*$formattedAmounts['commission_amount'][$i];
                $job_table.= '<tr>';
                $job_table.= '<td>' . $formattedAmounts['job_amount'][$i] . '</td>';
                $job_table.= '<td>' . $comm_amount . '</td>';
                $job_table.= '<td>' . ($formattedAmounts['job_amount'][$i]-$comm_amount) . '</td>';
                $job_table.= '</tr>';
            }
            $job_table.= '</table>';
        }
        $pageFindReplace = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##SITE_CURRENCY##' => Configure::read('site.currency') ,
            '##JOB_PRICE##' => $this->Page->siteJobAmount('or') ,
            '##JOB_TRANSFER_AMOUNT##' => (Configure::read('job.price') -Configure::read('job.commission_amount')) ,
            '##COMMISSION_AMOUNT##' => $commission_amount,
            '##JOB_MINIMUM_WITHDRAW_AMOUNT##' => Configure::read('user.minimum_withdrawal_amount') ,
            '##JOB_CLEARING_PERIOD##' => Configure::read('job.days_after_amount_withdraw') ,
            '##JOB_REVIEW_COMPLETE##' => (Configure::read('job.auto_review_complete') *24) ,
            '##JOB_EXPIRE##' => (Configure::read('job.auto_expire') *24) ,
            '##JOB_ALT_NAME_PLURAL_FIRST_CAPS##' => jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) ,
            '##JOB_ALT_NAME_FIRST_CAPS##' => jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) ,
            '##JOB_ALT_NAME##' => jobAlternateName() ,
            '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
            '##JOB_PRICE_TABLE##' => $job_table,
            '##CONTACT_US##' => Configure::read('site.admin_email') ,
            '##ORDER_PAGE_LINK##' => Router::url(array(
                'controller' => 'job_orders',
                'action' => 'index',
                'type' => 'myorders',
                'status' => 'waiting_for_acceptance'
            ) , true) ,
            '##CREATE_JOB_LINK##' => Router::url(array(
                'controller' => 'jobs',
                'action' => 'add',
            ) , true) ,
            '##AUP_LINK##' => "<a href='" . Router::url(array(
                'controller' => 'pages',
                'action' => 'view',
                'aup'
            ) , true) . "' title='" . __l('Acceptable Use Policy') . "'>" . __l('Acceptable Use Policy') . "</a>"
        );
        if ($page) {
            $page['Page']['title'] = strtr($page['Page']['title'], $pageFindReplace);
            $page['Page']['content'] = strtr($page['Page']['content'], $pageFindReplace);
            $this->pageTitle = $page[$this->modelClass]['title'];
            $this->set('page', $page);
            $this->set('currentPageId', $page[$this->modelClass]['id']);
            $this->set('isPage', true);
            $this->_chooseTemplate($page);
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function view($slug = null)
    {
        $this->Page->recursive = -1;
        if (!empty($slug)) {
            $page = $this->Page->findBySlug($slug);
        } else {
            $page = $this->Page->find('first', array(
                'conditions' => array(
                    'Page.is_default' => 1
                )
            ));
        }
        $logged_user_check = $this->Auth->user('id');
        if (!empty($slug) && ($slug == 'order-purchase-completed') && (empty($logged_user_check))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (Configure::read('job.commission_type') == ConstCommsisionType::Amount) {
            $commission_amount = Configure::read('site.currency') . Configure::read('job.commission_amount');
        } else {
            $commission_amount = (Configure::read('job.commission_amount')) . '%';
        }
        $job_table = '';
        $formattedAmounts = $this->jobFormatAmount(Configure::read('job.price') , Configure::read('job.commission_amount'));
        if (count($formattedAmounts['job_amount']) == 1) {
            $job_table.= __l('Work prices are fixed at') . ' ' . $formattedAmounts['job_amount'][0] . ' ' . __l('For each of your works that was ordered and delivered, your net share will be the deducted amount from commission amount of') . ' ' . $formattedAmounts['job_amount'][0];
            if (Configure::read('job.commission_type') != ConstCommsisionType::Amount) $job_table.= '%';
            else $job_table.= Configure::read('site.currency');
        } else {
            $job_table.= '<table class ="list">';
            $job_table.= '<tr>';
            $job_table.= '<th>' . jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Amount') . ' (' . Configure::read('site.currency') . ')</th>';
            $job_table.= '<th>' . jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) . ' ' . __l('Commission') . ' (' . Configure::read('site.currency') . ')</th>';
            $job_table.= '<th>' . __l('Seller Amount') . ' (' . Configure::read('site.currency') . ')</th>';
            $job_table.= '</tr>';
            for ($i = 0; $i < count($formattedAmounts['job_amount']); $i++) {
                $comm_amount = (count($formattedAmounts['commission_amount']) == 1) ? $formattedAmounts['commission_amount'][0] : $formattedAmounts['commission_amount'][$i];
                if (Configure::read('job.commission_type') != ConstCommsisionType::Amount) $comm_amount = $formattedAmounts['job_amount'][$i]*0.01*$formattedAmounts['commission_amount'][$i];
                $job_table.= '<tr>';
                $job_table.= '<td>' . $formattedAmounts['job_amount'][$i] . '</td>';
                $job_table.= '<td>' . $comm_amount . '</td>';
                $job_table.= '<td>' . ($formattedAmounts['job_amount'][$i]-$comm_amount) . '</td>';
                $job_table.= '</tr>';
            }
            $job_table.= '</table>';
        }
        $pageFindReplace = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##SITE_CURRENCY##' => Configure::read('site.currency') ,
            '##JOB_PRICE##' => $this->Page->siteJobAmount('or') ,
            '##JOB_TRANSFER_AMOUNT##' => (Configure::read('job.price') -Configure::read('job.commission_amount')) ,
            '##COMMISSION_AMOUNT##' => $commission_amount,
            '##JOB_MINIMUM_WITHDRAW_AMOUNT##' => Configure::read('user.minimum_withdrawal_amount') ,
            '##JOB_CLEARING_PERIOD##' => Configure::read('job.days_after_amount_withdraw') ,
            '##JOB_REVIEW_COMPLETE##' => (Configure::read('job.auto_review_complete') *24) ,
            '##JOB_EXPIRE##' => (Configure::read('job.auto_expire') *24) ,
            '##JOB_ALT_NAME_PLURAL_FIRST_CAPS##' => jobAlternateName(ConstJobAlternateName::Plural, ConstJobAlternateName::FirstLeterCaps) ,
            '##JOB_ALT_NAME_FIRST_CAPS##' => jobAlternateName(ConstJobAlternateName::Singular, ConstJobAlternateName::FirstLeterCaps) ,
            '##JOB_ALT_NAME##' => jobAlternateName() ,
            '##JOB_ALT_NAME_PLURAL##' => jobAlternateName(ConstJobAlternateName::Plural) ,
            '##JOB_PRICE_TABLE##' => $job_table,
            '##CONTACT_US##' => Configure::read('site.admin_email') ,
            '##CONTACT_US_LINK##' => "<a href ='" . Router::url(array(
                'controller' => 'contacts',
                'action' => 'add',
            ) , true) . "' target='_blank'>" . __l("Contact Us") . "</a>",
            '##ORDER_PAGE_LINK##' => Router::url(array(
                'controller' => 'job_orders',
                'action' => 'index',
                'type' => 'myorders',
                'status' => 'waiting_for_acceptance'
            ) , true) ,
            '##CONTINUE_LINK##' => "<a href='" . Router::url(array(
                'controller' => 'job_orders',
                'action' => 'index',
                'type' => 'myorders',
                'status' => 'waiting_for_acceptance'
            ) , true) . "'>" . __l('Continue') . "</a>",
            '##CREATE_JOB_LINK##' => Router::url(array(
                'controller' => 'jobs',
                'action' => 'add',
            ) , true) ,
            '##AUP_LINK##' => "<a href='" . Router::url(array(
                'controller' => 'pages',
                'action' => 'view',
                'aup'
            ) , true) . "' title='" . __l('Acceptable Use Policy') . "'>" . __l('Acceptable Use Policy') . "</a>"
        );
        if (!empty($this->request->params['isAjax'])) {
            $pageFindReplace['##CONTINUE_LINK##'] = "<a class=\"js-close-colorbox\">" . __l('Continue') . "</a>";
        }
        if ($page) {
            $page['Page']['title'] = strtr($page['Page']['title'], $pageFindReplace);
            $page['Page']['content'] = strtr($page['Page']['content'], $pageFindReplace);
            $this->pageTitle = $page[$this->modelClass]['title'];
            $this->set('page', $page);
            $this->set('currentPageId', $page[$this->modelClass]['id']);
            $this->set('isPage', true);
            $this->_chooseTemplate($page);
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    private function _chooseTemplate($page)
    {
        $render = 'view';
        if (!empty($page[$this->modelClass]['template'])) {
            $possibleThemeFile = APP . 'views' . DS . 'pages' . DS . 'themes' . DS . $page[$this->modelClass]['template'];
            if (file_exists($possibleThemeFile)) {
                $render = $possibleThemeFile;
            }
        }
        return $this->render($render);
    }
    function display()
    {
        $path = func_get_args();
        $count = count($path);
        if (!$count) {
            $this->redirect('/');
        }
        $page = $subpage = $title = null;
        if (!empty($path[0])) {
            $page = $path[0];
        }
        if ($path[0] == 'tools' && (!$this->Auth->user('id') || $this->Auth->user('role_id') != ConstUserTypes::Admin)) {
            throw new NotFoundException(__l('Invalid request'));
        } elseif ($path[0] == 'tools') {
            $this->layout = 'admin';
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count-1])) {
            $title = Inflector::humanize($path[$count-1]);
        }
        $this->set(compact('page', 'subpage', 'title'));
        $this->render(join('/', $path));
    }
    function admin_display($page)
    {
        $this->setAction('display', $page);
    }
    function jobFormatAmount($job_amount, $commission_amount)
    {
        $job_amounts = explode(',', $job_amount);
        foreach($job_amounts as $job_amount) {
            $job_amount = trim($job_amount);
            if (!empty($job_amount) && ($job_amount > 0)) {
                $formatedAmount['job_amount'][] = $job_amount;
            }
        }
        $commission_amounts = explode(',', $commission_amount);
        foreach($commission_amounts as $commission_amount) {
            $commission_amount = trim($commission_amount);
            if (!empty($commission_amount) && ($commission_amount > 0)) {
                $formatedAmount['commission_amount'][] = $commission_amount;
            }
        }
        return $formatedAmount;
    }
}
?>