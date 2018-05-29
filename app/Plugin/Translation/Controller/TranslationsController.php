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
class TranslationsController extends AppController
{
    public $name = 'Translations';
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Translation.googleTranslate',
            'Translation.manualTranslate',
            'Translation.from_language',
            'Translation.makeUpdate',
            'Translation.makeSubmit'
        );
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Translations');
        if (!empty($this->request->params['named']['remove_language_id'])) {
            $this->Translation->deleteAll(array(
                'Translation.language_id' => $this->request->params['named']['remove_language_id']
            ));
            $lang_code = $this->Translation->Language->find('first', array(
                'conditions' => array(
                    'Language.id' => $this->request->params['named']['remove_language_id']
                ) ,
                'fields' => array(
                    'Language.iso2'
                ) ,
                'recursive' => - 1
            ));
            Cache::delete($lang_code['Language']['iso2'] . '_translations');
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Translation')), 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $translations_verified = $this->Translation->find('all', array(
            'fields' => array(
                'Translation.language_id',
                'COUNT(Translation.is_verified) as counts',
                'Translation.is_verified',
            ) ,
            'conditions' => array(
                'Translation.language_id !=' => 0
            ) ,
            'contain' => array(
                'Language' => array(
                    'fields' => array(
                        'Language.name'
                    ) ,
                )
            ) ,
			'recursive' => 0,
            'group' => 'Translation.language_id, Translation.is_verified, Language.id, Language.name'
        ));
        $languageArr = array();
        foreach($translations_verified as $transaltion) {
            if (!array_key_exists($transaltion['Translation']['language_id'], $languageArr)) {
                $languageArr[$transaltion['Translation']['language_id']] = array(
                    'name' => $transaltion['Language']['name'],
                    'verified' => 0,
                    'not_verified' => 0
                );
            }
            if ($transaltion['Translation']['is_verified']) {
                $languageArr[$transaltion['Translation']['language_id']]['verified'] = $transaltion[0]['counts'];
            } else {
                $languageArr[$transaltion['Translation']['language_id']]['not_verified'] = $transaltion[0]['counts'];
            }
        }
        $this->set('translations', $languageArr);
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_view($id = null)
    {
        $pageTitle = __l('Translation');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $translation = $this->Translation->find('first', array(
            'conditions' => array(
                'Translation.id = ' => $id
            ) ,
            'fields' => array(
                'Translation.id',
                'Translation.created',
                'Translation.modified',
                'Translation.language_id',
                'Translation.name',
                'Translation.lang_text',
            ) ,
            'contain' => array(
                'Language' => array(
                    'fields' => array(
                        'Language.id',
                        'Language.created',
                        'Language.modified',
                        'Language.name',
                        'Language.iso2',
                        'Language.iso3',
                    ) ,
                )
            ) ,
            'recursive' => 0,
        ));
        if (empty($translation)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $pageTitle.= ' - ' . $translation['Translation']['id'];
        $this->set('translation', $translation);
        $this->set('title_for_layout', $pageTitle);
        $this->set('pageTitle', $pageTitle);
    }
    public function admin_add_text()
    {
        $this->pageTitle = sprintf(__l('Add %s'), __l('Language Variable'));
        if (!empty($this->request->data)) {
            $valid = true;
            $key = $this->request->data['Translation']['key'];
            unset($this->request->data['Translation']['key']);
            foreach($this->request->data['Translation'] as $translation_id => $translation_vars) {
                $data = array();
                $data['Translation']['language_id'] = $translation_id;
                $data['Translation']['name'] = $key;
                $data['Translation']['lang_text'] = $translation_vars['lang_text'];
                $this->Translation->set($data);
                if (!$this->Translation->validates()) {
                    $valid = false;
                    if ($this->Translation->validationErrors['lang_text'] == 'Required') {
                        $this->Translation->validationErrors[$translation_id]['lang_text'] = 'Required';
                    }
                }
            }
            if ($valid) {
                foreach($this->request->data['Translation'] as $translation_id => $translation_vars) {
                    $data = array();
                    $data['Translation']['language_id'] = $translation_id;
                    $data['Translation']['name'] = $key;
                    $data['Translation']['lang_text'] = $translation_vars['lang_text'];
                    $data['Translation']['is_translated'] = 1;
                    $data['Translation']['is_verified'] = 1;
                    $this->Translation->create();
                    $this->Translation->set($data);
                    $this->Translation->save($data);
                }
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Language variables')), 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Language variables')), 'default', null, 'error');
            }
        }
        $translations = $this->Translation->find('all', array(
            'fields' => array(
                'DISTINCT(Translation.language_id)',
            ) ,
            'contain' => array(
                'Language' => array(
                    'fields' => array(
                        'Language.name'
                    ) ,
                )
            ) ,
            'conditions' => array(
                'Translation.language_id !=' => 0
            ) ,
            'recursive' => 0
        ));
        if (!empty($key)) {
            $this->request->data['Translation']['key'] = $key;
        }
        foreach($translations as $translation) {
            $languages[$translation['Translation']['language_id']] = $translation['Language']['name'];
        }
        $this->set(compact('languages'));
    }
    public function admin_add()
    {
        $this->pageTitle = $pageTitle = __l('Add Translation');
        $translations = $this->Translation->find('all', array(
            'conditions' => array(
                'Language.iso2' => 'en'
            ) ,
            'recursive' => 0
        ));
        if (empty($translations)) {
            $this->Session->setFlash(__l('Default English variable is missing') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Translation']['googleTranslate']) && !empty($this->request->data['Translation']['language_id'])) {
                $new_language = $this->Translation->Language->find('first', array(
                    'conditions' => array(
                        'Language.id' => $this->request->data['Translation']['language_id']
                    ) ,
                    'fields' => array(
                        'Language.iso2'
                    ) ,
                    'recursive' => - 1
                ));
                for ($i = 0; $i < count($translations); $i+= 20) {
                    $key = '';
                    for ($j = $i; $j < $i + 20; $j++) {
                        if (isset($translations[$j]['Translation']['name'])) {
                            $key.= 'q=' . urlencode($translations[$j]['Translation']['name']) . '&';
                        }
                    }
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&' . $key . 'langpair=en%7C' . $new_language['Language']['iso2'] . '&key=' . Configure::read('google.translation_api_key'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $out = curl_exec($ch);
                    if (!curl_errno($ch)) {
                        $var = json_decode($out);
                        curl_close($ch);
                    } else {
                        $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Translation')), 'default', null, 'error');
                        $this->redirect(array(
                            'action' => 'add',
                        ));
                    }
                    if ($var->responseStatus == 200) {
                        $j = $i;
                        foreach($var->responseData as $translated_arr) {
                            if ($translated_arr->responseStatus == 200) {
                                $this->request->data['Translation']['language_id'] = $this->request->data['Translation']['language_id'];
                                $this->request->data['Translation']['name'] = $translations[$j]['Translation']['name'];
                                $this->request->data['Translation']['lang_text'] = $translated_arr->responseData->translatedText;
                                $this->request->data['Translation']['is_translated'] = 1;
                                $this->request->data['Translation']['is_google_translate'] = 1;
                                $this->Translation->create();
                                $this->Translation->save($this->request->data);
                            }
                            $j++;
                        }
                    } else {
                        $this->Session->setFlash(__l('Translation could not be updated. Please check iso2 of this language and try again') , 'default', null, 'error');
                        $this->redirect(array(
                            'action' => 'add',
                        ));
                    }
                }
            } elseif (!empty($this->request->data['Translation']['manualTranslate']) && !empty($this->request->data['Translation']['language_id'])) {
                foreach($translations as $translation) {
                    unset($translation['Translation']['id']);
                    $translation['Translation']['language_id'] = $this->request->data['Translation']['language_id'];
                    $translation['Translation']['lang_text'] = '';
                    $translation['Translation']['is_translated'] = 1;
                    $this->Translation->create();
                    $this->Translation->save($translation['Translation'], false);
                }
            }
            $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Translation')), 'default', null, 'success');
            $this->redirect(array(
                'action' => 'manage',
                'language_id' => $this->request->data['Translation']['language_id']
            ));
        }
        $existTranslations = $this->Translation->find('all', array(
            'fields' => array(
                'DISTINCT(Translation.language_id)',
            ) ,
            'contain' => array(
                'Language' => array(
                    'fields' => array(
                        'Language.name'
                    ) ,
                )
            ) ,
            'recursive' => 0
        ));
        $languages = $this->Translation->Language->find('list', array(
            'conditions' => array(
                'Language.is_active' => 1
            ),
			'order' => array(
				'Language.name' => 'ASC'
			)
        ));
        $exists = array();
        if (!empty($existTranslations)) {
            foreach($existTranslations as $existTranslation) {
                $exists[] = $existTranslation['Translation']['language_id'];
                unset($languages[$existTranslation['Translation']['language_id']]);
            }
            $exists[] = array_search('English', $languages);
            unset($languages[array_search('English', $languages) ]);
        }
        $this->set(compact('languages'));
        $this->set('title_for_layout', $pageTitle);
        $this->set('pageTitle', $pageTitle);
    }
    public function admin_edit($id = null)
    {
        $pageTitle = sprintf(__l('Edit %s'), __l('Translation'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Translation->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Translation')), 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Translation')), 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Translation->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $pageTitle.= ' - ' . $this->request->data['Translation']['id'];
        $languages = $this->Translation->Language->find('list', array(
            'conditions' => array(
                'Language.is_active' => 1
            )
        ));
        $this->set(compact('languages'));
        $this->set('title_for_layout', $pageTitle);
        $this->set('pageTitle', $pageTitle);
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Translation->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Translation')), 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_manage()
    {
        $this->pageTitle = sprintf(__l('Edit %s'), __l('Translation'));
        if (empty($this->request->params['named']['language_id']) and empty($this->request->data['Translation']['language_id'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['language_id'])) {
            $this->request->data['Translation']['language_id'] = $this->request->params['named']['language_id'];
        }
        if (!empty($this->request->params['named']['filter'])) {
            $this->request->data['Translation']['filter'] = $this->request->params['named']['filter'];
        }
        if (!empty($this->request->params['named']['page'])) {
            $page = $this->request->params['named']['page'];
			unset($this->request->params['named']['page']);
        }
		if(isset($this->request->data['Translation']['page'])){
			$page = $this->request->data['Translation']['page'];
			unset($this->request->data['Translation']['page']);
		}
		$conditions = array();
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Translation']['language_id'])) {
                $this->request->params['named']['language_id'] = $this->request->data['Translation']['language_id'];
            }
            if (!empty($this->request->data['Translation']['filter'])) {
                $this->request->params['named']['filter'] = $this->request->data['Translation']['filter'];
            }
            if (!empty($this->request->data['Translation']['q'])) {
                $this->request->params['named']['q'] = $this->request->data['Translation']['q'];
            }
            if (!empty($this->request->data['Translation']['makeUpdate'])) {
                unset($this->request->data['Translation']['makeUpdate']);
                unset($this->request->data['Translation']['language_id']);
                unset($this->request->data['Translation']['filter']);
                unset($this->request->data['Translation']['q']);
                foreach($this->request->data['Translation'] as $key => $value) {
                    $this->Translation->id = $key;
                    $data['Translation']['lang_text'] = $value['lang_text'];
                    $data['Translation']['is_verified'] = $value['is_verified'];
                    $this->Translation->save($data);
                }
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Translation')), 'default', null, 'success');
                if (!empty($page)) {
                    $this->redirect(array(
                        'controller' => 'translations',
                        'action' => 'manage',
                        'page' => $page,
                        'language_id' => $this->request->params['named']['language_id']
                    ));
                }
            }
            if (!empty($this->request->params['named']['language_id'])) {
                $conditions['Translation.language_id'] = $this->request->params['named']['language_id'];
                $this->request->data['Translation']['language_id'] = $this->request->params['named']['language_id'];
            }
            if (!empty($this->request->params['named']['filter'])) {
                if ($this->request->params['named']['filter'] == 'verified') {
                    $conditions['Translation.is_verified'] = 1;
                    $this->pageTitle.= ' - ' . __l('Verified');
                } else if ($this->request->params['named']['filter'] == 'unverified') {
                    $conditions['Translation.is_verified'] = 0;
                    $this->pageTitle.= ' - ' . __l('Unverified');
                }
                $this->request->data['Translation']['filter'] = $this->request->params['named']['filter'];
            }
            if (!empty($this->request->params['named']['q'])) {
                $conditions['OR']['Translation.name LIKE '] = '%' . $this->request->params['named']['q'] . '%';
                $conditions['OR']['Translation.lang_text LIKE '] = '%' . $this->request->params['named']['q'] . '%';
                $this->request->data['Translation']['q'] = $this->request->params['named']['q'];
            }
            $lang_code = $this->Translation->Language->find('first', array(
                'conditions' => array(
                    'Language.id' => $this->request->data['Translation']['language_id']
                ) ,
                'fields' => array(
                    'Language.iso2'
                ) ,
                'recursive' => - 1
            ));
            Cache::delete($lang_code['Language']['iso2'] . '_translations');
        }
		$this->Translation->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'Translation.id',
                'Translation.language_id',
                'Translation.name',
                'Translation.lang_text',
                'Translation.is_verified'
            ) ,
        );
		$this->set('translations', $this->paginate());
        $this->set('verified_count', $this->Translation->find('count', array(
            'conditions' => array(
                'Translation.language_id' => $this->request->data['Translation']['language_id'],
                'Translation.is_verified' => 1
            ) ,
            'recursive' => - 1
        )));
        $this->set('unverified_count', $this->Translation->find('count', array(
            'conditions' => array(
                'Translation.language_id' => $this->request->data['Translation']['language_id'],
                'Translation.is_verified' => 0
            ) ,
            'recursive' => - 1
        )));
        $translations = $this->Translation->find('all', array(
            'fields' => array(
                'DISTINCT(Translation.language_id)',
				'Translation.language_id'
            ) ,
            'conditions' => array(
                'Translation.language_id !=' => 0
            ) ,
            'contain' => array(
                'Language' => array(
                    'fields' => array(
                        'Language.name'
                    ) ,
                )
            ) ,
            'recursive' => 0
        )); 
		foreach($translations as $translation) {
		    $languages[$translation['Translation']['language_id']] = $translation['Language']['name'];
        }
		$this->set(compact('languages'));
        $this->set('pageTitle', $this->pageTitle);
		unset($this->Translation->validate['lang_text']);
    }
}
