<?php 
$display_none_arr=array('') ;
$display_block_arr=array('') ;
// Jobs buy now button
if (isPluginEnabled('Jobs')) {
	if(!empty($jids)) {
		$own_job_Id_array[]='';
		foreach($own_job_Ids as $own_job_Id){
			$own_job_Id_array[]=$own_job_Id;
		}
		for($i=0;$i<count($jids); $i++) {
			if(!$this->Auth->user('id')) {
				$display_block_arr[] = 'bl-buy-'.$jids[$i];
				$display_none_arr[] = 'al-buy-'.$jids[$i];
				$display_none_arr[] = 'al-buy-instr-' . $jids[$i];
			}
			else
			{
				$display_none_arr[] = 'bl-buy-' . $jids[$i];
				if(in_array($jids[$i], $own_job_Id_array)){
					$display_none_arr[] = 'al-buy-instr-'.$jids[$i];
					$display_none_arr[] = 'al-buy-' . $jids[$i];
					$display_block_arr[] = 'al-edit-' . $jids[$i];
				} else {
					if (in_array($jids[$i], $job_with_instruction_Id_array)) {
						$display_block_arr[] = 'al-buy-instr-'.$jids[$i];
						$display_none_arr[] = 'al-buy-' . $jids[$i];
						$display_none_arr[] = 'al-edit-' . $jids[$i];
					} else {
						$display_none_arr[] = 'al-buy-instr-'.$jids[$i];
						$display_block_arr[] = 'al-buy-' . $jids[$i];
						$display_none_arr[] = 'al-edit-' . $jids[$i];
					}
				}
			}
		}
	}
}

//--Job Favorites starts here--//
if (isPluginEnabled('JobFavorites')) {

//View page
if(!empty($_GET['jid'])) {
	$fid[]=array('');
	$jid=$_GET['jid'];
	if($this->Auth->user('id')) {
		foreach ($favoritesjobIds as $favoritesjobs) {
			$fid[]=$favoritesjobs['JobFavorite']['job_id'];
		}
	}
	if(!$this->Auth->user('id')) {
			$display_none_arr[] = 'al-jobunfav-'.$jid;
			$display_none_arr[] = 'al-jobfav-'.$jid;
			$display_block_arr[] = 'bl-jobfav-'.$jid;
		}
	else
	{	
		if($job_details['Job']['user_id']!=$this->Auth->user('id')){
			$display_none_arr[] = 'bl-jobfav-' . $jid;
			if (!in_array($jid,$fid)) {
				$display_block_arr[] = 'al-jobfav-' . $jid;
				$display_none_arr[] = 'al-jobunfav-' . $jid;
			}
			else
			{
				$display_none_arr[] = 'al-jobfav-' . $jid;
				$display_block_arr[] = 'al-jobunfav-' . $jid;
			}
		}
	}

}
//Listing page
if(!empty($_GET['jids'])) {
	$fid[]=array('');
	if($this->Auth->user('id')) {
		foreach ($favoritesjobIds as $favoritesjobs) {
			$fid[]=$favoritesjobs['JobFavorite']['job_id'];
		}
	}

	for($i=0;$i<count($jids); $i++) {

		if(!$this->Auth->user('id')) {
			$display_none_arr[] = 'al-jobunfav-'.$jids[$i];
			$display_none_arr[] = 'al-jobfav-'.$jids[$i];
			$display_block_arr[] = 'bl-jobfav-'.$jids[$i];
		}
		else
		{
			$display_none_arr[] = 'bl-jobfav-' . $jids[$i];
			if (!in_array($jids[$i],$fid)) {
				$display_block_arr[] = 'al-jobfav-' . $jids[$i];
				$display_none_arr[] = 'al-jobunfav-' . $jids[$i];
			}
			else
			{
				$display_none_arr[] = 'al-jobfav-' . $jids[$i];
				$display_block_arr[] = 'al-jobunfav-' . $jids[$i];
			}
		}
	}
}
}
//--Job Favorites ends here--//


//--admin user and project control panel--//
if ($this->Auth->sessionValid() && $this->Auth->user('role_id') == ConstUserTypes::Admin) {
	$display_block_arr[] = 'alab';
} else {
	$display_none_arr[] = 'alab';
}

// Request Apply/post job button

if (isPluginEnabled('Requests')) {
	if(!empty($rids)) {
		$own_request_Id_array[]='';
		foreach($own_request_Ids as $own_request_Id){
			$own_request_Id_array[]=$own_request_Id;
		}
		for($i=0;$i<count($rids); $i++) {
			if(!isPluginEnabled('Jobs') ){
				$display_none_arr[] = 'al-apply-post-'.$rids[$i];
				$display_none_arr[] = 'bl-apply-post-'.$rids[$i];
			} else {
				if(!$this->Auth->user('id')) {
					$display_block_arr[] = 'bl-apply-post-'.$rids[$i];
					$display_none_arr[] = 'al-apply-post-'.$rids[$i];
				} else {
					if(in_array($rids[$i], $own_request_Id_array)){
						$display_none_arr[] = 'al-apply-post-'.$rids[$i];
						$display_none_arr[] = 'bl-apply-post-'.$rids[$i];
					} else {
						$display_block_arr[] = 'al-apply-post-'.$rids[$i];
						$display_none_arr[] = 'bl-apply-post-'.$rids[$i];
					}
				}
			}
		}
	}
	//View page
	if(!empty($rid)) {
		$own_request_Id_array[]='';
		foreach($own_request_Ids as $own_request_Id){
			$own_request_Id_array[]=$own_request_Id;
		}
		$rid=$_GET['rid'];
		if(!$this->Auth->user('id')) {
			$display_block_arr[] = 'bl-apply-post-'.$rid;
			$display_none_arr[] = 'al-apply-post-'.$rid;
			$display_none_arr[] = 'al-edit-request-'.$rid;
		} else {
			if(in_array($rid, $own_request_Id_array)){
				$display_none_arr[] = 'al-apply-post-'.$rid;
				$display_none_arr[] = 'bl-apply-post-'.$rid;
				$display_block_arr[] = 'al-edit-request-'.$rid;
			} else {
				$display_block_arr[] = 'al-apply-post-'.$rid;
				$display_none_arr[] = 'bl-apply-post-'.$rid;
				$display_none_arr[] = 'al-edit-request-'.$rid;
			}
		}

	}
}
//--Request Favorites starts here--//
if (isPluginEnabled('RequestFavorites')) {

//View page
if(!empty($_GET['rid'])) {
	$fid[]=array('');
	$rid=$_GET['rid'];
	if($this->Auth->user('id')) {
		foreach ($favoritesrequestIds as $favoritesrequests) {
			$fid[]=$favoritesrequests['RequestFavorite']['request_id'];
		}
	}
	if(!$this->Auth->user('id')) {
			$display_none_arr[] = 'al-requnfav-'.$rid;
			$display_none_arr[] = 'al-reqfav-'.$rid;
			$display_block_arr[] = 'bl-reqfav-'.$rid;
		}
	else
	{
		$display_none_arr[] = 'bl-reqfav-' . $rid;
		if (!in_array($rid,$fid)) {
			$display_block_arr[] = 'al-reqfav-' . $rid;
			$display_none_arr[] = 'al-requnfav-' . $rid;
		}
		else
		{
			$display_none_arr[] = 'al-reqfav-' . $rid;
			$display_block_arr[] = 'al-requnfav-' . $rid;
		}
	}

}
//Listing page
if(!empty($_GET['rids'])) {
	$fid[]=array('');
	if($this->Auth->user('id')) {
		foreach ($favoritesrequestIds as $favoritesrequests) {
			$fid[]=$favoritesrequests['RequestFavorite']['request_id'];
		}
	}

	for($i=0;$i<count($rids); $i++) {

		if(!$this->Auth->user('id')) {
			$display_none_arr[] = 'al-requnfav-'.$rids[$i];
			$display_none_arr[] = 'al-reqfav-'.$rids[$i];
			$display_block_arr[] = 'bl-reqfav-'.$rids[$i];
		}
		else
		{
			$display_none_arr[] = 'bl-reqfav-' . $rids[$i];
			if (!in_array($rids[$i],$fid)) {
				$display_block_arr[] = 'al-reqfav-' . $rids[$i];
				$display_none_arr[] = 'al-requnfav-' . $rids[$i];
			}
			else
			{
				$display_none_arr[] = 'al-reqfav-' . $rids[$i];
				$display_block_arr[] = 'al-requnfav-' . $rids[$i];
			}
		}
	}
}
}
//--Job Favorites ends here--//
// Job view page
if (isPluginEnabled('Jobs')) {
	if(!empty($jid)) {
// Contact seller button
		if($this->Auth->user('id')) {
			$display_none_arr[] = 'bl-contact-seller-'.$jid;
			if($job_details['Job']['user_id']==$this->Auth->user('id')) {
				$display_none_arr[] = 'al-contact-seller-'.$jid;
			} else {
				$display_block_arr[] = 'al-contact-seller-'.$jid;
			}
		} else {
			$display_block_arr[] = 'bl-contact-seller-'.$jid;
			$display_none_arr[] = 'al-contact-seller-'.$jid;
		}
// Seller Edit button

		if(!$job_details['Job']['admin_suspend'] && $job_details['Job']['user_id']==$this->Auth->user('id')){
			$display_block_arr[] = 'job-edit-'.$jid;
		} else {
			$display_none_arr[] = 'job-edit-'.$jid;
		}
// Buy button

		if($this->Auth->user('id')) {
			$display_none_arr[] = 'bl-buy-'.$jid;
			if($job_details['Job']['user_id'] != $this->Auth->user('id')) {
				if($job_details['Job']['job_service_location_id'] == ConstServiceLocation::SellerToBuyer || !empty($job_details['Job']['is_instruction_requires_attachment']) || !empty($job_details['Job']['is_instruction_requires_input'])){
					$display_block_arr[] = 'al-buy-moreinfo-'.$jid;
					$display_none_arr[] = 'al-buy-'.$jid;
					$display_none_arr[] = 'al-edit-'.$jid;
				} else {
					$display_block_arr[] = 'al-buy-'.$jid;
					$display_none_arr[] = 'al-buy-moreinfo-'.$jid;
					$display_none_arr[] = 'al-edit-'.$jid;
				}
			} else {
				$display_none_arr[] = 'al-buy-'.$jid;
				$display_none_arr[] = 'al-buy-moreinfo-'.$jid;
				$display_block_arr[] = 'al-edit-'.$jid;
			}
		} else {
			$display_block_arr[] = 'bl-buy-'.$jid;
		}
// Admin action in highlight block above the description
		if($this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin)){
			$display_block_arr[] = 'admin-action-block';
			if(!empty($job_details['Job']['is_system_flagged']) && (isPluginEnabled('JobFlags'))) { 
				$display_block_arr[] = 'suspend-block'; 
			} else {
				$display_none_arr[] = 'suspend-block'; 
			}
			if(!empty($job_details['Job']['JobFlag']) && (isPluginEnabled('JobFlags'))) { 
				$display_block_arr[] = 'flag-list-block'; 
			} else { 
				$display_none_arr[] = 'flag-list-block'; 
			}
			if($job_details['User']['is_active']) { 
				$display_block_arr[] = 'user-deactivate-block';
				$display_none_arr[] = 'user-activate-block';
			} else { 
				$display_block_arr[] = 'user-activate-block';
				$display_none_arr[] = 'user-deactivate-block'; 
			}
			if($job_details['Job']['is_system_flagged'] && (isPluginEnabled('JobFlags'))) { 
				$display_block_arr[] = 'clear-flag-block';
				$display_none_arr[] = 'flag-block';
			} else { 
				$display_block_arr[] = 'flag-block';
				$display_none_arr[] = 'clear-flag-block'; 
			}
		} else {
			$display_none_arr[] = 'admin-action-block';
		}
// Report flag block
		if($this->Auth->sessionValid() && ($this->Auth->user('id') != $job_details['Job']['user_id']) && (isPluginEnabled('JobFlags'))){
			$display_block_arr[] = 'report-flag-block';
		} else {
			$display_none_arr[] = 'report-flag-block';
		}

	}

// Request view page

	if (isPluginEnabled('Requests')) {
		if(!empty($rid)) {
			if($this->Auth->user('id') && ($request_details['Request']['user_id']!=$this->Auth->user('id')) ) {
				$display_block_arr[] = 'apply-post-'.$rid;
				$display_block_arr[] = 'contact-buyer';
				$display_none_arr[] = 'report-request-block';
				
			} else {
				$display_none_arr[] = 'apply-post-'.$rid;
				$display_none_arr[] = 'contact-buyer';
				$display_none_arr[] = 'report-request-block';
			}
		}
	}

//User view page

	
	if(!empty($uid)) {
		if($this->Auth->user('id') && ($this->Auth->user('id')!=$uid) ) {
			$display_none_arr[] = 'contact-seller';
			$display_block_arr[] = 'edit-seller';
		} else {
			$display_block_arr[] = 'contact-seller';
			$display_none_arr[] = 'edit-seller';
		}
	}

}



$none_style=implode(', .',$display_none_arr);
$none_style = substr($none_style, 1); //to remove 1st ',' from the array
$none_style=$none_style.' { display: none; }';

$block_style=implode(', .',$display_block_arr);
$block_style = substr($block_style, 1); //to remove 1st ',' from the array
$block_style=$block_style.' { display: block; }';


echo preg_replace('/(\>)\s+(<?)/', '$1$2', $block_style);
echo preg_replace('/(\>)\s+(<?)/', '$1$2', $none_style);

?>