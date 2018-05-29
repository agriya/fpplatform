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
class HighPerformancesController extends AppController
{
    public $name = 'HighPerformances';
    public function update_content() 
    {
		if(!empty($_GET['jids'])){$jids=$_GET['jids']; $jids=explode(',',$jids);}
		if(!empty($_GET['rids'])){$rids=$_GET['rids']; $rids=explode(',',$rids);}
		if(!empty($_GET['jid'])){$jid=$_GET['jid']; }
		if(!empty($_GET['rid'])){$rid=$_GET['rid']; }
		if(!empty($_GET['uid'])){$uid=$_GET['uid']; }

		$this->disableCache();
		$user_id=$this->Auth->user('id'); 
		// Job list buy now button
		if (isPluginEnabled('Jobs') && !empty($jids)) {
			App::import('Model', 'Jobs.Job');
			$this->Job = new Job();
			$ownjobIds = $conditions = array();
			$conditions['OR']['Job.job_service_location_id'] = ConstServiceLocation::SellerToBuyer;
			$conditions['OR']['Job.is_instruction_requires_attachment'] = '1';
			$conditions['OR']['Job.is_instruction_requires_input'] = '1';
			$job_with_instruction_Id_array[]='';
			foreach($jids as $jid){
				$conditions['AND']['Job.id']=$jid;
				$job_with_instruction_Ids = $this->Job->find('list', array(
					'conditions' => $conditions,
					'fields' => array(
						'Job.id'
					) ,
					'recursive' => -1
				));
				foreach ($job_with_instruction_Ids as $job_with_instruction_Id) {
					$job_with_instruction_Id_array[]=$job_with_instruction_Id;
				}
			}
			$own_job_Ids=array();
			if ($user_id) {
				$own_job_Ids = $this->Job->find('list', array(
					'conditions' => array(
						'Job.user_id' => $user_id,
					),
					'fields' => array(
						'Job.id'
					) ,
					'recursive' => -1
				));
			}
			$this->set('jids', $jids);
			$this->set('job_with_instruction_Id_array', $job_with_instruction_Id_array);
			$this->set('own_job_Ids',$own_job_Ids); 
		}

		$favoritesjobIds = array();
		if (isPluginEnabled('JobFavorites')) {
		App::import('Model', 'Jobs.Job');
		$this->Job = new Job();
			$favoritesjobIds = $this->Job->JobFavorite->find('all', array(
				'conditions' => array(
					'JobFavorite.user_id' => $this->Auth->user('id')
				) ,
				'fields' => array(
					'JobFavorite.job_id'
				) ,
				'recursive' => -1
			));
			$this->set('favoritesjobIds', $favoritesjobIds);
		}

		//request list
		if (isPluginEnabled('Requests') && isPluginEnabled('Jobs') && (!empty($rids) || !empty($rid))) {
			App::import('Model', 'Requests.Request');
			$this->Request = new Request();
			$conditions = array();
			$own_request_Ids=array();
			if ($user_id) {
				$own_request_Ids = $this->Request->find('list', array(
					'conditions' => array(
						'Request.user_id' => $user_id,
					),
					'fields' => array(
						'Request.id'
					) ,
					'recursive' => -1
				));
			}
			if(!empty($rids)) {
				$this->set('rids', $rids);
			} else if(!empty($rid)) {
				$this->set('rid', $rid);
			}
			$this->set('own_request_Ids',$own_request_Ids);
		}

		$favoritesrequestIds = array();
		if (isPluginEnabled('RequestFavorites')) {
		App::import('Model', 'Requests.Request');
		$this->Request = new Request();
			$favoritesrequestIds = $this->Request->RequestFavorite->find('all', array(
				'conditions' => array(
					'RequestFavorite.user_id' => $this->Auth->user('id')
				) ,
				'fields' => array(
					'RequestFavorite.request_id'
				) ,
				'recursive' => -1
			));
			$this->set('favoritesrequestIds', $favoritesrequestIds);
		}

		//job view page
		if (isPluginEnabled('Jobs') && !empty($jid)) {
			App::import('Model', 'Jobs.Job');	
			$this->Job = new Job();
			$contain= array(
				'User' => array(
					'fields' => array(
						'User.is_active',
					),
				),
			);
			$job_details = $this->Job->find('first', array(
				'conditions' => array(
					'Job.id' => $jid
				),
				'fields' => array(
					'Job.user_id',
					'Job.admin_suspend',
					'Job.job_service_location_id',
					'Job.is_instruction_requires_attachment',
					'Job.is_instruction_requires_input',
					'Job.is_system_flagged',

				) ,
				'contain' => $contain,
				'recursive' => 0
			));
			
			$this->set('jid', $jid);
			$this->set('job_details',$job_details);
		}
		//request view page
		if (isPluginEnabled('Requests') && !empty($rid)) {
			App::import('Model', 'Requests.Request');
			$this->Request = new Request();
			$conditions = array();
			$request_details = $this->Request->find('first', array(
				'conditions' => array(
					'Request.id' => $rid,
				),
				'fields' => array(
					'Request.id',
					'Request.user_id'
				) ,
				'recursive' => -1
			));
			$this->set('rid', $rid);
			$this->set('request_details',$request_details);
		}
		//user view
		if(!empty($uid)){
			$this->set('uid', $uid);
		}
    }
    public function admin_check_s3_connection() 
    {
        App::import('Vendor', 'HighPerformance.S3');
        $s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
        $s3->setEndpoint(Configure::read('s3.end_point'));
		$buckets = $s3->listBuckets();
		if (in_array(Configure::read('s3.bucket_name'), $buckets)) {
            $this->Session->setFlash(__l('Bucket name and configuration is ok') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Problem with the configuration') , 'default', null, 'error');
        }
        if (!empty($_GET['f'])) {
            $this->redirect(Router::url('/', true) . $_GET['f']);
        }
    }
    public function admin_copy_static_contents()
    {
        $this->_copy_content(JS, 'js');
        $this->_copy_content(CSS, 'css');
        $this->_copy_content(IMAGES, 'img');
        $this->_copy_content(WWW_ROOT . DS . 'font', 'font');
        App::import('Model', 'Settings');
        if (!empty($_GET['f'])) {
            $this->Session->setFlash(__l('Static content successfully copied.') , 'default', null, 'success');
            $this->redirect(Router::url('/', true) . $_GET['f']);
        }
    }
    public function _copy_content($dir, $current_dir)
    {
        $handle = opendir($dir);
        while (false !== ($readdir = readdir($handle))) {
            if ($readdir != '.' && $readdir != '..') {
                $path = $dir . '/' . $readdir;
                if (is_dir($path)) {
                    @chmod($path, 0777);
                    if (!strstr($path, "_thumb")) {
                        $this->_copy_content($path, $current_dir . "/" . $readdir);
                    }
                }
                if (is_file($path)) {
                    @chmod($path, 0777);
					$s3->putObjectFile($path, Configure::read('s3.bucket_name') , $current_dir . '/' . $readdir, S3::ACL_PUBLIC_READ);
                    flush();
                }
            }
        }
        closedir($handle);
        return true;
    }
	public function remove_s3_file() {
		if(!empty($this->request->data['url'])) {
			App::import('Vendor', 'HighPerformance.S3');
			$s3 = new S3(Configure::read('s3.aws_access_key'), Configure::read('s3.aws_secret_key'));
			$s3->setEndpoint(Configure::read('s3.end_point'));
			$s3->deleteObject(Configure::read('s3.bucket_name'), $this->request->data['url']);
			exit;
		}
	}	
  
}
?>