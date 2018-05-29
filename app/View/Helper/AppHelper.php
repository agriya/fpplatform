<?php
App::uses('Helper', 'View');
class AppHelper extends Helper
{
    public function assetUrl($path, $options = array() , $cdn_path = '')
    {
        $assetURL = Cms::dispatchEvent('Helper.HighPerformance.getAssetUrl', $this->_View, array(
            'options' => $options,
            'assetURL' => '',
        ));
        return parent::assetUrl($path, $options, $assetURL->data['assetURL']);
    }
    function parse_youtube_url($url, $return = 'embed', $width = '', $height = '', $rel = 0)
    {
        $urls = parse_url($url);
        //url is http://youtu.be/xxxx
        if ($urls['host'] == 'youtu.be') {
            $id = ltrim($urls['path'], '/');
        }
        //url is http://www.youtube.com/embed/xxxx
        else if (strpos($urls['path'], 'embed') == 1) {
            $id = end(explode('/', $urls['path']));
        }
        //url is xxxx only
        else if (strpos($url, '/') === false) {
            $id = $url;
        }
        //http://www.youtube.com/watch?feature=player_embedded&v=m-t4pcO99gI
        //url is http://www.youtube.com/watch?v=xxxx
        else {
            parse_str($urls['query']);
            $id = $v;
            if (!empty($feature)) {
                $id = end(explode('v=', $urls['query']));
            }
        }
        //return embed iframe
        if ($return == 'embed') {
            return '
	<iframe src="http://www.youtube.com/embed/' . $id . '?rel=' . $rel . '" frameborder="0" width="' . ($width ? $width : 680) . '" height="' . ($height ? $height : 380) . '"></iframe>
	';
        }
        //return normal thumb
        else if ($return == 'thumb') {
            return 'http://i1.ytimg.com/vi/' . $id . '/default.jpg';
        }
        //return hqthumb
        else if ($return == 'hqthumb') {
            return 'http://i1.ytimg.com/vi/' . $id . '/hqdefault.jpg';
        }
        // else return id
        else {
            return $id;
        }
    }
    function getUserAvatar($user_details, $dimension = 'medium_thumb', $is_link = true, $anonymous = '', $from = '', $isAttachment = '', $from_model = '')
    {
        $width = Configure::read('thumb_size.' . $dimension . '.width');
        $height = Configure::read('thumb_size.' . $dimension . '.height');
        if (!empty($from) && $from == 'layout') {
            $width = '16';
            $height = '16';
        }
        $tooltipClass = 'js-tooltip';
        $title = '';
        if (!$is_link) {
            $tooltipClass = '';
            if (isset($user_details['username'])) {
                $title = $this->cText($user_details['username'], false);
            }
            if (!empty($anonymous) && ($anonymous == 'anonymous')) {
                $title = 'Anonymous';
            }
        }
        if (!empty($from_model) && $from_model == 'modal') {
            $tooltipClass = '';
        }
        if (!empty($from) && $from == 'layout') {
            $tooltipClass = '';
        }
        if (!empty($anonymous) && ($anonymous == 'anonymous')) {
            $username = __l('Anonymous');
            $user_image = $this->showImage('Anonymous', '', array(
                'dimension' => $dimension,
                'class' => $tooltipClass,
                'alt' => sprintf(__l('[Image: %s]') , $this->cText($username, false)) ,
                'title' => (!$is_link) ? $this->cText($username, false) : '',
            ) , null, null, false);
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Facebook) {
            $user_image = $this->getFacebookAvatar($user_details['facebook_user_id'], $height, $width, $user_details['username'], $is_link, $from);
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Linkedin) {
            if (!empty($user_details['linkedin_avatar_url'])) {
                $user_image = $this->image($user_details['linkedin_avatar_url'], array(
                    'title' => $title,
                    'width' => $width,
                    'height' => $height,
                    'border' => 0,
                    'class' => $tooltipClass
                ));
            } else {
                $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
                $user_image = $this->image(getImageUrl('UserAvatar', '', array(
                    'dimension' => $dimension
                )) , array(
                    'width' => $width,
                    'height' => $height,
                    'class' => $tooltipClass,
                    'alt' => sprintf(__l('[Image: %s]') , $this->cText($user_details['username'], false)) ,
                    'title' => (!$is_link) ? $this->cText($user_details['username'], false) : '',
                ));
            }
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Twitter) {
            $user_image = $this->image($user_details['twitter_avatar_url'], array(
                'title' => $title,
                'width' => $width,
                'height' => $height,
                'border' => 0,
                'class' => $tooltipClass
            ));
        } else {
            if (empty($user_details['UserAvatar'])) {
                if (!empty($user_details['id'])) {
                    App::uses('User', 'Model');
                    $this->User = new User();
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $user_details['id'],
                        ) ,
                        'contain' => array(
                            'UserAvatar'
                        ) ,
                        'recursive' => 0
                    ));
                    if (!empty($user['UserAvatar']['id'])) {
                        $user_details['UserAvatar'] = $user['UserAvatar'];
                    }
                }
            }
            $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
            $user_image = $this->image(getImageUrl('UserAvatar', (!empty($user_details['UserAvatar'])) ? $user_details['UserAvatar'] : '', array(
                'dimension' => $dimension
            )) , array(
                'width' => $width,
                'height' => $height,
                'class' => $tooltipClass,
                'alt' => sprintf(__l('[Image: %s]') , $this->cText($user_details['username'], false)) ,
                'title' => (!$is_link) ? $this->cText($user_details['username'], false) : '',
            ));
        }
        $before_span = $after_span = '';
        if ($from != 'facebook') {
            $span_class = '';
            if ($dimension == 'micro_thumb' && $from != 'admin') {
                $span_class = ' span1';
            }
            $pr_class = 'pr';
            if (($this->request->params['controller'] == 'blogs' && !empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'activity') || (!empty($this->request->params['named']['load_type']) && $this->request->params['named']['load_type'] == 'modal')) {
                $pr_class = '';
            }
            $before_span = '<span class="' . $pr_class . '"><span class="avtar-box pull-left pr mob-clr">';
            $after_span = '</span></span>';
        }
        if (Configure::read('site.friend_ids') && !empty($user_details['id']) && empty($anonymous)) {
            if (in_array($user_details['id'], Configure::read('site.friend_ids'))) {
                $user_image.= '<span class="strip-bot pa dc trans-bg">' . __l('Friend') . '</span>';
            }
        }
        $image = (!$is_link) ? $user_image : $this->link($user_image, array(
            'controller' => 'users',
            'action' => 'view',
            $user_details['username'],
            'admin' => false
        ) , array(
            'title' => $this->cText($user_details['username'], false) ,
            'class' => $tooltipClass . ' show no-pad',
            'escape' => false
        ));
        return $before_span . $image . $after_span;
    }
    function getUserAvatarLink($user_details, $dimension = 'medium_thumb', $is_link = true, $linkclass = '', $imgclass = '')
    {
        $width = Configure::read('thumb_size.' . $dimension . '.width');
        $height = Configure::read('thumb_size.' . $dimension . '.height');
        $user_image = '';
        if ((!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Facebook)) {
            $user_image = $this->getFacebookAvatar($user_details['facebook_user_id'], $height, $width);
        } elseif (!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Linkedin) {
            if (!empty($user_details['linkedin_avatar_url'])) {
                $user_image = $this->image($user_details['linkedin_avatar_url'], array(
                    'title' => $this->cText($user_details['username'], false) ,
                    'width' => $width,
                    'height' => $height,
                    'class' => $imgclass
                ));
            } else {
                $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
                $user_image = $this->Html->Image(getImageUrl('UserAvatar', '', array(
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username'],
                    'class' => $imgclass
                )) , array(
                    'width' => $width,
                    'height' => $height
                ));
            }
        } elseif ((!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Twitter)) {
            $user_image = $this->image($user_details['twitter_avatar_url'], array(
                'title' => $this->cText($user_details['username'], false) ,
                'width' => $width,
                'height' => $height,
                'class' => $imgclass
            ));
        } else {
            if (empty($user_details['UserAvatar'])) {
                if (!empty($user_details['id'])) {
                    App::uses('User', 'Model');
                    $this->User = new User();
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $user_details['id'],
                        ) ,
                        'contain' => array(
                            'UserAvatar'
                        ) ,
                        'recursive' => 0
                    ));
                    if (!empty($user['UserAvatar']['id'])) {
                        $user_details['UserAvatar'] = $user['UserAvatar'];
                    }
                }
            }
            if (!empty($user_details['UserAvatar'])) {
                $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
                $user_image = $this->Html->Image(getImageUrl('UserAvatar', $user_details['UserAvatar'], array(
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username'],
                    'class' => $imgclass
                )) , array(
                    'width' => $width,
                    'height' => $height,
                    'class' => $imgclass
                ));
            } else {
                $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
                $user_image = $this->Html->Image(getImageUrl('UserAvatar', '', array(
                    'dimension' => $dimension,
                    'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                    'title' => $user_details['username'],
                    'class' => $imgclass
                )) , array(
                    'width' => $width,
                    'height' => $height
                ));
            }
        }
        //return image to user
        return (!$is_link) ? $user_image : $this->link($user_image, array(
            'controller' => 'users',
            'action' => 'view',
            $user_details['username'],
            'admin' => false
        ) , array(
            'title' => $this->cText($user_details['username'], false) ,
            'escape' => false,
            'class' => $linkclass
        ));
    }
    public function getFacebookAvatar($fbuser_id, $height = 35, $width = 35, $username = '', $is_link = '', $from = '')
    {
        $tooltipClass = '';
        $title = '';
        if (!$is_link) {
            $tooltipClass = 'js-tooltip';
            $title = $username;
        }
        if (!empty($from) && $from == 'layout') {
            $tooltipClass = '';
        }
        return $this->image("http://graph.facebook.com/{$fbuser_id}/picture?type=normal&amp;width=$width&amp;height=$height", array(
            'width' => $width,
            'height' => $height,
            'border' => 0,
            'class' => $tooltipClass,
            'title' => $title
        ));
    }
    function getLanguage()
    {
        if (isPluginEnabled('Translation')) {
            App::import('Model', 'Translation.Translation');
            $this->Translation = new Translation();
            $languages = $this->Translation->find('all', array(
                'conditions' => array(
                    'Language.id !=' => 0
                ) ,
                'fields' => array(
                    'DISTINCT(Translation.language_id)',
                    'Language.name',
                    'Language.iso2'
                ) ,
                'order' => array(
                    'Language.name' => 'ASC'
                )
            ));
            $languageList = array();
            if (!empty($languages)) {
                foreach($languages as $language) {
                    $languageList[$language['Language']['iso2']] = $language['Language']['name'];
                }
            }
            return $languageList;
        }
    }
    function displayPercentageRating($total_rating, $possitive_rating)
    {
        if (!$total_rating) {
            return __l('Not Rated Yet');
        } else {
            if ($possitive_rating) {
                return floor(($possitive_rating/$total_rating) *100) . '% ' . __l('Positive');
            } else {
                return '100% ' . __l('Negative');
            }
        }
    }
    function getUserRatingDetails($user_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.job_feedback_count',
                'User.positive_feedback_count'
            ) ,
            'recursive' => -1
        ));
        return $user;
    }
    function getUserUnReadMessages($user_id = null, $auto)
    {
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $conditions = array(
            'Message.is_read' => '0',
            'Message.user_id' => $user_id,
            'Message.is_sender' => '0',
            'Message.message_folder_id' => ConstMessageFolder::Inbox,
            'MessageContent.is_system_flagged' => 0,
            'Message.is_auto' => $auto
        );
        if ($auto == '1') {
            $conditions['Message.id >'] = $user['User']['activity_message_id'];
        }
        $unread_count = $this->Message->find('count', array(
            'conditions' => $conditions,
            'recursive' => 1
        ));
        return $unread_count;
    }
    function getUserNewOrder($user_id = null)
    {
        App::import('Model', 'Jobs.Job');
        $this->Job = new Job();
        $new_order_count = $this->Job->JobOrder->find('count', array(
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::WaitingforAcceptance,
                'Job.user_id' => (!empty($user_id)) ? $user_id : ''
            ) ,
            'contain' => array(
                'Job'
            )
        ));
        return $new_order_count;
    }
    function getUserNewReview($user_id = null)
    {
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder();
        $new_review_count = $this->JobOrder->find('count', array(
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::WaitingforReview,
                'JobOrder.user_id' => (!empty($user_id)) ? $user_id : '',
                'JobOrder.is_under_dispute' => 0,
            ) ,
        ));
        return $new_review_count;
    }
    function getUserNewRedeliver($user_id = null)
    {
        App::import('Model', 'Job');
        $this->Job = new Job();
        $new_redeliver_count = $this->Job->JobOrder->find('count', array(
            'conditions' => array(
                'JobOrder.job_order_status_id' => ConstJobOrderStatus::Redeliver,
                'Job.user_id' => (!empty($user_id)) ? $user_id : ''
            ) ,
            'contain' => array(
                'Job'
            )
        ));
        return $new_redeliver_count;
    }
    function getSellerMutualCancelRequest($user_id = null)
    {
        App::import('Model', 'Job');
        $this->Job = new Job();
        $mutual_count = $this->Job->JobOrder->find('count', array(
            'conditions' => array(
                'JobOrder.is_buyer_request_for_cancel' => 1,
                'JobOrder.is_seller_request_for_cancel' => 0,
                'Job.user_id' => (!empty($user_id)) ? $user_id : ''
            ) ,
            'contain' => array(
                'Job'
            )
        ));
        return $mutual_count;
    }
    function getBuyerMutualCancelRequest($user_id = null)
    {
        App::import('Model', 'Job');
        $this->Job = new Job();
        $mutual_count = $this->Job->JobOrder->find('count', array(
            'conditions' => array(
                'JobOrder.is_seller_request_for_cancel' => 1,
                'JobOrder.is_buyer_request_for_cancel' => 0,
                'JobOrder.user_id' => (!empty($user_id)) ? $user_id : ''
            ) ,
            'contain' => array(
                'Job'
            )
        ));
        return $mutual_count;
    }
    function callOutImage($amount = null)
    {
        $callout = '<span>';
        if (!empty($amount)) {
            $callout.= $this->siteCurrencyFormat($amount);
        } else {
            $callout.= $this->siteCurrencyFormat(Configure::read('job.price'));
        }
        $callout.= '</span>';
        return $callout;
    }
    function clearedAmount($id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id,
            ) ,
            'recursive' => -1
        ));
        return $user['User']['cleared_amount'];
    }
    function userJobCount($user_id = null)
    { // used in default layout - for tabs -> 'start selling' or 'My Jobs'
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'recursive' => -1
        ));
        return $user['User']['job_count'];
    }
    function JobCount($job_category = null)
    {
        App::import('Model', 'Job');
        $this->Job = new Job();
        $jobcategory_count = $this->Job->find('count', array(
            'conditions' => array(
                'Job.job_category_id' => $job_category,
            ) ,
            'recursive' => -1
        ));
        return $jobcategory_count;
    }
    function RequestCount($job_category = null)
    {
        App::import('Model', 'Request');
        $this->Request = new Request();
        $jobcategory_count = $this->Request->find('count', array(
            'conditions' => array(
                'Request.job_category_id' => $job_category,
            ) ,
            'recursive' => -1
        ));
        return $jobcategory_count;
    }
    function transactionDescription($transaction)
    {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        $transactionReplace = array(
            '##BUYER##' => !empty($transaction['JobOrder']['User']) ? $this->link($transaction['JobOrder']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['JobOrder']['User']['username'],
                'admin' => false
            )) : '',
            '##SELLER##' => $this->link($transaction['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['User']['username'],
                'admin' => false
            )) ,
            '##AFFILIATE_USER##' => $this->link($transaction['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['User']['username'],
                'admin' => false
            )) ,
            '##JOB##' => !empty($transaction['JobOrder']['Job']) ? $this->link($transaction['JobOrder']['Job']['title'], array(
                'controller' => 'jobs',
                'action' => 'view',
                $transaction['JobOrder']['Job']['slug'],
                'admin' => false
            )) : '',
            '##ORDER_NO##' => !empty($transaction['JobOrder']) ? $transaction['JobOrder']['id'] : '',
            '##JOB_AMOUNT##' => !empty($transaction['JobOrder']['amount']) ? $this->siteCurrencyFormatWithoutSup($transaction['JobOrder']['amount']) : '',
            '##JOB_RECIEVED_AMOUNT##' => !empty($transaction['Joborder']['amount']) ? $this->siteCurrencyFormat(($transaction['JobOrder']['amount']-$transaction['JobOrder']['commission_amount'])) : '',
            '##USER##' => !empty($transaction['SecondUser']['username']) ? $this->link($transaction['SecondUser']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['SecondUser']['username'],
                'admin' => false
            )) : '',
            '##JOB_ALT_NAME##' => jobAlternateName(ConstJobAlternateName::Singular)
        );
        return strtr($transaction['TransactionType']['message'], $transactionReplace);
    }
    function conversationDescription($conversation)
    {
        $conversationReplace = array(
            '##BUYER##' => !empty($conversation['JobOrder']) ? $this->link($conversation['JobOrder']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $conversation['JobOrder']['User']['username'],
                'admin' => false
            )) : '',
            '##SELLER##' => $this->link($conversation['Job']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $conversation['Job']['User']['username'],
                'admin' => false
            )) ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##CREATED_DATE##' => $this->cDateTime($conversation['JobOrder']['created']) ,
            '##ACCEPTED_DATE##' => $this->cDateTime($conversation['JobOrder']['accepted_date']) ,
            '##DELIVERY_DATE##' => $conversation['Job']['no_of_days'] . __l('days') ,
        );
        return strtr($conversation['JobOrderStatus']['description'], $conversationReplace);
    }
    function filterSuspiciousWords($replace = null, $filtered_words = null)
    {
        $bad_words = unserialize($filtered_words);
        foreach($bad_words as $bad_word) {
            $replace = str_replace($bad_word, "<span class='filtered'>" . $bad_word . "</span>", $replace);
        }
        return $replace;
    }
    function siteJobAmount($verb = 'and', $style = 'with-style')
    {
        $amount = explode(',', Configure::read('job.price'));
        if (count($amount) > 1) {
            $last_value = $amount[count($amount) -1];
            unset($amount[count($amount) -1]);
            foreach($amount as $amt) {
                $arr[] = $this->siteCurrencyFormat($amt, 'span', $style);
            }
            $amount = implode(', ', $arr);
            $amount = $amount . ' ' . __l($verb) . ' ' . $this->siteCurrencyFormat($last_value, 'span', $style);
        } else {
            $amount = $this->siteCurrencyFormat($amount['0'], 'span', $style);
        }
        return $amount;
    }
    function cCurrency($str, $wrap = 'span', $title = false, $currency_code = null)
    {
        if (empty($currency_code)) {
            $currency_code = Configure::read('site.currency_code');
        }
        $_precision = 0;
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $Numbers_Words = new Numbers_Words();
                $title = ucwords($Numbers_Words->toCurrency($r, 'en_US', $currency_code));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, '.', ',') . '</' . $wrap . '>';
        }
        return $r;
    }
    function siteCurrencyFormat($amount, $wrap = 'span', $style = 'with-style')
    {
        if ($style == 'no-style') {
            return $this->siteCurrencyFormatWithoutSup($amount);
        }
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return '<sup class="text-14">' . Configure::read('site.currency') . '</sup>' . '<span class="text-24 textb">' . $this->cCurrency($amount, $wrap) . '</span>';
        } else {
            return '<span class="text-24 textb">' . $this->cCurrency($amount) . '</span>' . '<sup class="text-14">' . Configure::read('site.currency') . '</sup>';
        }
    }
    function siteCurrencyFormatWithoutSup($amount)
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $amount;
        } else {
            return $amount . Configure::read('site.currency');
        }
    }
    function makeUrl($url)
    {
        return ((preg_match("/http/", $url, $matches)) ? '' : 'http://') . $url;
    }
    public function formGooglemap($jobdetails = array() , $size = '320x320')
    {
        if ((!(is_array($jobdetails))) || empty($jobdetails)) {
            return false;
        }
        $mapurl = 'http://maps.google.com/maps/api/staticmap?center=';
        $mapcenter[] = str_replace(' ', '+', $jobdetails['latitude']) . ',' . $jobdetails['longitude'];
        $mapcenter[] = 'zoom=' . (!empty($jobdetails['zoom_level']) ? $jobdetails['zoom_level'] : 8);
        $mapcenter[] = 'size=' . $size;
        $mapcenter[] = 'markers=color:pink|label:M|' . $jobdetails['latitude'] . ',' . $jobdetails['longitude'];
        $mapcenter[] = 'sensor=false';
        return $mapurl . implode('&amp;', $mapcenter);
    }
    function requesterChoosenJob($request_id, $requestor_id)
    {
        App::import('Model', 'JobsRequest');
        $modelObj = new JobsRequest();
        App::import('Model', 'JobOrder');
        $this->JobOrder = new JobOrder();
        $requests = $modelObj->find('list', array(
            'conditions' => array(
                'JobsRequest.request_id' => $request_id,
            ) ,
            'fields' => array(
                'job_id'
            ) ,
            'recursive' => -1
        ));
        $request_choosed = array();
        if (!empty($requests)) {
            foreach($requests as $key => $value) {
                $request_choosen = $this->JobOrder->find('first', array(
                    'conditions' => array(
                        'JobOrder.job_id' => $value,
                        'JobOrder.user_id' => $requestor_id
                    ) ,
                    'contain' => array(
                        'Job' => array(
                            'User' => array(
                                'fields' => array(
                                    'User.username'
                                )
                            ) ,
                            'Attachment',
                            'fields' => array(
                                'Job.id',
                                'Job.title',
                                'Job.slug',
                                'Job.amount',
                            )
                        ) ,
                    ) ,
                    'recursive' => 2
                ));
                if (!empty($request_choosen)) {
                    $request_choosed[] = $request_choosen;
                }
            }
        }
        return $request_choosed;
    }
    function isWalletEnabled()
    {
        App::import('Model', 'PaymentGateway');
        $this->PaymentGateway = new PaymentGateway();
        $PaymentGateway = $this->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => ConstPaymentGateways::Wallet
            ) ,
            'recursive' => -1
        ));
        if (!empty($PaymentGateway['PaymentGateway']['is_active'])) {
            return true;
        }
        return false;
    }
    function getCurrUserInfo($id)
    {
        App::uses('User', 'Model');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id,
            ) ,
            'recursive' => -1
        ));
        return $user;
    }
    function isPurchasedUser($job_id, $user_id)
    {
        App::import('Model', 'Jobs.JobOrder');
        $this->JobOrder = new JobOrder();
        $conditions = array(
            'JobOrder.job_id' => $job_id,
            'JobOrder.user_id' => $user_id,
        );
        $conditions['Not']['JobOrder.job_order_status_id'] = array(
            ConstJobOrderStatus::WaitingforAcceptance,
            ConstJobOrderStatus::Cancelled,
            ConstJobOrderStatus::Rejected,
            ConstJobOrderStatus::Expired,
            ConstJobOrderStatus::CancelledDueToOvertime,
            ConstJobOrderStatus::CancelledByAdmin,
            ConstJobOrderStatus::PaymentPending,
            ConstJobOrderStatus::MutualCancelled,
        );
        $user = $this->JobOrder->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        if (!empty($user)) {
            return 1;
        } else {
            return 0;
        }
    }
    function _userActAs()
    {
        $_seller = array(
            'jobs/add',
            'jobs/index/manage_jobs',
            'job_orders/index/myworks',
            'job_orders/index/gain',
            'requests/index',
            'requests/view',
            'messages/activities/myworks',
            'messages/compose/deliver'
        );
        $_buyer = array(
            'jobs/index',
            'jobs/view',
            'requests/add',
            'requests/index/manage_requests',
            'job_orders/index/myorders',
            'job_orders/track_order',
            'messages/activities/myorders',
            'job_orders/index/history',
            'job_feedbacks/add'
        );
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
        if (isset($this->request->params['named']['type'])) {
            $cur_page.= '/' . $this->request->params['named']['type'];
        }
        if (isset($this->request->params['named']['order'])) {
            $cur_page.= '/' . $this->request->params['named']['order'];
        }
        if (in_array($cur_page, $_seller)) {
            return 'selling-bg';
        } elseif (in_array($cur_page, $_buyer)) {
            return 'buying-bg';
        }
    }
    function timeToDays($time)
    {
        $days = floor($time/(60*60*24));
        $hours = floor(($time-($days*(60*60*24))) /3600);
        $return = ($days > 1) ? $days . __l(' days') : $days . __l(' day');
        if ($hours > 1) {
            $return.= ', ' . $hours . __l(' hours');
        }
        return $return;
    }
    function getBuyerOrderStatuses($user_id)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $filter_count = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $all_count = ($filter_count['User']['buyer_waiting_for_acceptance_count']+$filter_count['User']['buyer_in_progress_count']+$filter_count['User']['buyer_in_progress_overtime_count']+$filter_count['User']['buyer_review_count']+$filter_count['User']['buyer_completed_count']+$filter_count['User']['buyer_cancelled_count']+$filter_count['User']['buyer_rejected_count']+$filter_count['User']['buyer_cancelled_late_order_count']+$filter_count['User']['buyer_expired_count']+$filter_count['User']['buyer_payment_pending_count']);
        $status = array(
            __l('Active') . ' (' . ($filter_count['User']['buyer_in_progress_count']+$filter_count['User']['buyer_in_progress_overtime_count']+$filter_count['User']['buyer_review_count']) . ')' => 'active',
            __l('Payment Pending') . ' (' . $filter_count['User']['buyer_payment_pending_count'] . ')' => 'payment_pending',
            __l('Pending Seller Accept') . ' (' . $filter_count['User']['buyer_waiting_for_acceptance_count'] . ')' => 'waiting_for_acceptance',
            __l('In Progress') . ' (' . $filter_count['User']['buyer_in_progress_count'] . ')' => 'in_progress',
            __l('In Progress Overtime') . ' (' . $filter_count['User']['buyer_in_progress_overtime_count'] . ')' => 'in_progress_overtime',
            __l('Waiting For Your Review') . ' (' . $filter_count['User']['buyer_review_count'] . ')' => 'waiting_for_review',
            __l('Completed') . ' (' . $filter_count['User']['buyer_completed_count'] . ')' => 'completed',
            __l('Cancelled') . ' (' . $filter_count['User']['buyer_cancelled_count'] . ')' => 'cancelled',
            __l('Seller Rejected') . ' (' . $filter_count['User']['buyer_rejected_count'] . ')' => 'rejected',
            __l('Cancelled Late Orders') . ' (' . $filter_count['User']['buyer_cancelled_late_order_count'] . ')' => 'cancelled_late_orders',
            __l('Expired') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' (' . $filter_count['User']['buyer_expired_count'] . ')' => 'expired',
            __l('Rework') . ' ' . jobAlternateName(ConstJobAlternateName::Plural) . ' (' . $filter_count['User']['buyer_redeliver_count'] . ')' => 'rework',
        );
        $return_array = array(
            'all_count' => $all_count,
            'status' => $status
        );
        if (!empty($filter_count)) {
            return $return_array;
        }
    }
    function getAffiliateCount($user_id = null)
    {
        App::import('Model', 'Affiliates.Affiliate');
        $this->Affiliate = new Affiliate();
        $affiliate_count = $this->Affiliate->find('count', array(
            'conditions' => array(
                'Affiliate.affliate_user_id' => $user_id
            ) ,
        ));
        return $affiliate_count;
    }
    public function beforeLayout($layoutFile)
    {
        if ($this instanceof HtmlHelper && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {
            $url = Router::url(array(
                'controller' => 'high_performances',
                'action' => 'update_content',
                'ext' => 'css'
            ) , true);
            if (Configure::read('highperformance.jids') && ($this->request->params['controller'] == 'jobs' || $this->request->params['controller'] == 'nodes' || $this->request->params['controller'] == 'requests')) {
                $jids = implode(',', Configure::read('highperformance.jids'));
                Configure::write('highperformance.jids', '');
                echo $this->Html->css($url . '?jids=' . $jids, null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            }
            if (Configure::read('highperformance.jid') && $this->request->params['controller'] == 'jobs') {
                echo $this->Html->css($url . '?jid=' . Configure::read('highperformance.jid') , null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            }
            if (Configure::read('highperformance.uids')) {
                echo $this->Html->css($url . '?uids=' . Configure::read('highperformance.uids') , null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            }
            if (Configure::read('highperformance.rids') && $this->request->params['controller'] == 'requests') {
                $rids = implode(',', Configure::read('highperformance.rids'));
                Configure::write('highperformance.jids', '');
                echo $this->Html->css($url . '?rids=' . $rids, null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            }
            if (Configure::read('highperformance.rid') && $this->request->params['controller'] == 'requests') {
                echo $this->Html->css($url . '?rid=' . Configure::read('highperformance.rid') , null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            }
            if (!empty($_SESSION['Auth']['User']['id']) && $_SESSION['Auth']['User']['id'] == ConstUserIds::Admin && empty($this->request->params['prefix'])) {
                echo $this->Html->css($url . '?uids=' . $_SESSION['Auth']['User']['id'], null, array(
                    'inline' => false,
                    'block' => 'highperformance'
                ));
            }
            parent::beforeLayout($layoutFile);
        }
    }
    function getBgImage()
    {
        App::import('Model', 'Attachment');
        $this->Attachment = new Attachment();
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.class = ' => 'Setting'
            ) ,
            'fields' => array(
                'Attachment.id',
                'Attachment.dir',
                'Attachment.foreign_id',
                'Attachment.filename',
                'Attachment.width',
                'Attachment.height',
            ) ,
            'recursive' => -1
        ));
        return $attachment;
    }
    function getPluginChildren($plugin, $depth, $image_title_icons)
    {
        if (!empty($plugin['Children'])) {
            foreach($plugin['Children'] as $key => $subPlugin) {
                if (empty($subPlugin['name'])) {
                    echo $this->_View->element('plugin_head', array(
                        'key' => $key,
                        'image_title_icons' => $image_title_icons,
                        'depth' => $depth
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                } else {
                    echo $this->_View->element('plugin', array(
                        'pluginData' => $subPlugin,
                        'depth' => $depth
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                }
                if (!empty($subPlugin['Children'])) {
                    $depth++;
                    $this->getPluginChildren($subPlugin, $depth, $image_title_icons);
                    $depth = 0;
                }
            }
        }
    }
    public function getUserNotification($user_id = null)
    {
        App::import('Model', 'Jobs.Message');
        $this->Message = new Message();
        $conditions = array();
        App::import('Model', 'Jobs.User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.activity_message_id'
            ) ,
            'recursive' => -1
        ));
        if (empty($this->request->params['prefix'])) {
            $conditions['Job.is_active'] = 1;
        }
        if (!empty($this->request->params['named']['project_id'])) {
            $conditions['Message.job_id'] = $this->request->params['named']['job_id'];
        }
        if (isPluginEnabled('SocialMarketing') && empty($this->request->params['prefix']) && empty($this->request->params['named']['project_id'])) {
            App::import('Model', 'SocialMarketing.UserFollower');
            $this->UserFollower = new UserFollower();
            if (empty($this->request->params['named']['user_id'])) {
                $userFollowers = $this->UserFollower->find('list', array(
                    'conditions' => array(
                        'UserFollower.user_id' => $user_id
                    ) ,
                    'fields' => array(
                        'UserFollower.followed_user_id'
                    ) ,
                    'recursive' => -1,
                ));
                $conditions['OR']['Message.user_id'] = array_values($userFollowers);
            }
        }
        $conditions['Message.id >'] = $user['User']['activity_message_id'];
        $notificationCount = $this->Message->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
        return $notificationCount;
    }
    function getUserInvitedFriendsRegisteredCount($id)
    {
        App::import('Model', 'Subscription');
        $this->Subscription = new Subscription();
        $count = $this->Subscription->find('count', array(
            'conditions' => array(
                'Subscription.invite_user_id' => $id,
                'Subscription.user_id !=' => '',
            ) ,
            'recursive' => -1
        ));
        return $count;
    }
}
?>