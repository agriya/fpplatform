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
class TermsController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Terms';
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->vocabularyId = null;
        if (isset($this->request->params['named']['vocabulary'])) {
            $this->vocabularyId = $this->request->params['named']['vocabulary'];
        }
        $this->set('vocabulary', $this->vocabularyId);
    }
    public function admin_index($vocabularyId = null)
    {
        if (!$vocabularyId) {
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $vocabulary = $this->Term->Vocabulary->findById($vocabularyId);
        if (!isset($vocabulary['Vocabulary']['id'])) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Vocabulary')) , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $this->pageTitle = sprintf(__l('Vocabulary - %s') , $vocabulary['Vocabulary']['title']);
        $termsTree = $this->Term->Taxonomy->getTree($vocabulary['Vocabulary']['alias'], array(
            'key' => 'id',
            'value' => 'title',
        ));
        $terms = $this->Term->find('all', array(
            'conditions' => array(
                'Term.id' => array_keys($termsTree) ,
            ) ,
        ));
        $terms = Set::combine($terms, '{n}.Term.id', '{n}.Term');
        $this->set(compact('termsTree', 'vocabulary', 'terms'));
    }
    public function admin_add($vocabularyId = null)
    {
        if (!$vocabularyId) {
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $vocabulary = $this->Term->Vocabulary->find('first', array(
            'conditions' => array(
                'Vocabulary.id' => $vocabularyId,
            ) ,
        ));
        if (!isset($vocabulary['Vocabulary']['id'])) {
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $this->pageTitle = sprintf(__l('%s - Add Term') , $vocabulary['Vocabulary']['title']);
        if (!empty($this->request->data)) {
            $termId = $this->Term->saveAndGetId($this->request->data['Term']);
            if ($termId) {
                $termInVocabulary = $this->Term->Taxonomy->hasAny(array(
                    'Taxonomy.vocabulary_id' => $vocabularyId,
                    'Taxonomy.term_id' => $termId,
                ));
                if ($termInVocabulary) {
                    $this->Session->setFlash(__l('Term with same slug already exists in the vocabulary.') , 'default', null, 'error');
                } else {
                    $this->Term->Taxonomy->Behaviors->attach('Tree', array(
                        'scope' => array(
                            'Taxonomy.vocabulary_id' => $vocabularyId,
                        ) ,
                    ));
                    $taxonomy = array(
                        'parent_id' => $this->request->data['Taxonomy']['parent_id'],
                        'term_id' => $termId,
                        'vocabulary_id' => $vocabularyId,
                    );
                    if ($this->Term->Taxonomy->save($taxonomy)) {
                        $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Term')) , 'default', null, 'success');
                        $this->redirect(array(
                            'action' => 'index',
                            $vocabularyId,
                        ));
                    } else {
                        $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Term')) , 'default', null, 'error');
                    }
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Term')) , 'default', null, 'error');
            }
        }
        $parentTree = $this->Term->Taxonomy->getTree($vocabulary['Vocabulary']['alias'], array(
            'taxonomyId' => true
        ));
        $this->set(compact('vocabulary', 'parentTree', 'vocabularyId'));
    }
    public function admin_edit($id = null, $vocabularyId = null)
    {
        if (!$vocabularyId) {
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $vocabulary = $this->Term->Vocabulary->find('first', array(
            'conditions' => array(
                'Vocabulary.id' => $vocabularyId,
            ) ,
        ));
        if (!isset($vocabulary['Vocabulary']['id'])) {
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $term = $this->Term->find('first', array(
            'conditions' => array(
                'Term.id' => $id,
            ) ,
        ));
        if (!isset($term['Term']['id'])) {
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $taxonomy = $this->Term->Taxonomy->find('first', array(
            'conditions' => array(
                'Taxonomy.term_id' => $id,
                'Taxonomy.vocabulary_id' => $vocabularyId,
            ) ,
        ));
        if (!isset($taxonomy['Taxonomy']['id'])) {
            $this->redirect(array(
                'controller' => 'vocabularies',
                'action' => 'index',
            ));
        }
        $this->pageTitle = sprintf(__l('%s - Edit Term') , $vocabulary['Vocabulary']['title']);
        if (!empty($this->request->data)) {
            if ($term['Term']['slug'] != $this->request->data['Term']['slug']) {
                if ($this->Term->hasAny(array(
                    'Term.slug' => $this->request->data['Term']['slug']
                ))) {
                    $termId = false;
                } else {
                    $termId = $this->Term->saveAndGetId($this->request->data['Term']);
                }
            } else {
                $this->Term->id = $term['Term']['id'];
                if (!$this->Term->save($this->request->data['Term'])) {
                    $termId = false;
                } else {
                    $termId = $term['Term']['id'];
                }
            }
            if ($termId) {
                $termInVocabulary = $this->Term->Taxonomy->hasAny(array(
                    'Taxonomy.id !=' => $taxonomy['Taxonomy']['id'],
                    'Taxonomy.vocabulary_id' => $vocabularyId,
                    'Taxonomy.term_id' => $termId,
                ));
                if ($termInVocabulary) {
                    $this->Session->setFlash(__l('Term with same slug already exists in the vocabulary.') , 'default', null, 'error');
                } else {
                    $this->Term->Taxonomy->Behaviors->attach('Tree', array(
                        'scope' => array(
                            'Taxonomy.vocabulary_id' => $vocabularyId,
                        ) ,
                    ));
                    $taxonomy = array(
                        'id' => $taxonomy['Taxonomy']['id'],
                        'parent_id' => $this->request->data['Taxonomy']['parent_id'],
                        'term_id' => $termId,
                        'vocabulary_id' => $vocabularyId,
                    );
                    if ($this->Term->Taxonomy->save($taxonomy)) {
                        $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Term')) , 'default', null, 'success');
                        $this->redirect(array(
                            'action' => 'index',
                            $vocabularyId,
                        ));
                    } else {
                        $this->Session->setFlash(sprintf(__l('%s could not be added to the vocabulary. Please, try again.') , __l('Term')) , 'default', null, 'error');
                    }
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Term')) , 'default', null, 'error');
            }
        } else {
            $this->request->data['Taxonomy'] = $taxonomy['Taxonomy'];
            $this->request->data['Term'] = $term['Term'];
        }
        $this->pageTitle.= ' - ' . $this->request->data['Term']['title'];
        $parentTree = $this->Term->Taxonomy->getTree($vocabulary['Vocabulary']['alias'], array(
            'taxonomyId' => true
        ));
        $this->set(compact('vocabulary', 'parentTree', 'term', 'taxonomy', 'vocabularyId'));
    }
    public function admin_delete($id = null, $vocabularyId = null)
    {
        if (is_null($id) || is_null($vocabularyId)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $taxonomyId = $this->Term->Taxonomy->termInVocabulary($id, $vocabularyId);
        if (!$taxonomyId) {
            $this->redirect(array(
                'action' => 'index',
                $vocabularyId,
            ));
        }
        $this->Term->Taxonomy->Behaviors->attach('Tree', array(
            'scope' => array(
                'Taxonomy.vocabulary_id' => $vocabularyId,
            ) ,
        ));
        if ($this->Term->Taxonomy->delete($taxonomyId)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Term')) , 'default', null, 'success');
        } else {
            $this->Session->setFlash(sprintf(__l('%s could not be deleted. Please, try again.') , __l('Term')) , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index',
            $vocabularyId,
        ));
    }
    public function admin_moveup($id = null, $vocabularyId = null, $step = 1)
    {
        if (!$id || !$vocabularyId) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Term')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index',
                $vocabularyId,
            ));
        }
        $taxonomyId = $this->Term->Taxonomy->termInVocabulary($id, $vocabularyId);
        if (!$taxonomyId) {
            $this->redirect(array(
                'action' => 'index',
                $vocabularyId,
            ));
        }
        $this->Term->Taxonomy->Behaviors->attach('Tree', array(
            'scope' => array(
                'Taxonomy.vocabulary_id' => $vocabularyId,
            ) ,
        ));
        if ($this->Term->Taxonomy->moveUp($taxonomyId, $step)) {
            $this->Session->setFlash(__l('Moved up successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Could not move up') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index',
            $vocabularyId,
        ));
    }
    public function admin_movedown($id = null, $vocabularyId = null, $step = 1)
    {
        if (!$id || !$vocabularyId) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Term')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index',
                $vocabularyId,
            ));
        }
        $taxonomyId = $this->Term->Taxonomy->termInVocabulary($id, $vocabularyId);
        if (!$taxonomyId) {
            $this->redirect(array(
                'action' => 'index',
                $vocabularyId,
            ));
        }
        $this->Term->Taxonomy->Behaviors->attach('Tree', array(
            'scope' => array(
                'Taxonomy.vocabulary_id' => $vocabularyId,
            ) ,
        ));
        if ($this->Term->Taxonomy->moveDown($taxonomyId, $step)) {
            $this->Session->setFlash(__l('Moved down successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Could not move down') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index',
            $vocabularyId,
        ));
    }
}
