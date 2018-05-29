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
class NodesController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Nodes';
    public $permanentCacheAction = array(
        'admin' => array(
            'home',
            'how_it_works',
            'view',
            'index',
            'term',
            'promoted',
            'search',
        )
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Meta',
            '_wysihtml5_mode',
        );
        parent::beforeFilter();
        if (isset($this->request->params['slug'])) {
            $this->request->params['named']['slug'] = $this->request->params['slug'];
        }
        if (isset($this->request->params['type'])) {
            $this->request->params['named']['type'] = $this->request->params['type'];
        }
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
    public function admin_index()
    {
        $this->_redirectPOST2Named(array(
            'q',
        ));
        $conditions = array();
        $this->pageTitle = __l('Content');
        $this->Node->recursive = 0;
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['conditions'] = array();
        $plugins = explode(',', Configure::read('Hook.bootstraps'));
        array_push($plugins, '');
        $types = $this->Node->Taxonomy->Vocabulary->Type->find('all');
        $typeAliases = Set::extract('/Type/alias', $types);
        $this->paginate['Node']['conditions']['Node.type'] = $typeAliases;
        $conditions['Node.plugin_name'] = $plugins;
        $this->request->params['named']['filter'] = '';
        if (!empty($this->request->params['named']['type'])) {
            $this->request->params['named']['filter'].= 'type:' . $this->request->params['named']['type'] . ';';
        }
        if (isset($this->request->params['named']['status'])) {
            $this->request->params['named']['filter'].= 'status:' . $this->request->params['named']['status'] . ';';
        }
        if (!empty($this->request->params['named']['filter'])) {
            $filters = $this->Cms->extractFilter();
            foreach($filters as $filterKey => $filterValue) {
                if (strpos($filterKey, '.') === false) {
                    $filterKey = 'Node.' . $filterKey;
                }
                $this->paginate['Node']['conditions'][$filterKey] = $filterValue;
            }
            $this->set('filters', $filters);
        }
        if (!empty($this->request->params['named']['content_filter_id'])) {
            if ($this->request->params['named']['content_filter_id'] == constContentType::Page) {
                $conditions['Node.type_id'] = constContentType::Page;
                $this->pageTitle.= ' - ' . __l('Page');
            }
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Publish) {
                $conditions['Node.status'] = 1;
                $this->pageTitle.= ' - ' . __l('Publish');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Unpublish) {
                $conditions['Node.status'] = 0;
                $this->pageTitle.= ' - ' . __l('Unpublish');
            }
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions['AND']['OR'][]['Node.title LIKE'] = '%' . $this->request->params['named']['q'] . '%';
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->paginate = array(
            'conditions' => $conditions,
        );
        if (!empty($this->request->data['Node']['q'])) {
            $this->paginate = array_merge($this->paginate, array(
                'search' => $this->request->data['Node']['q']
            ));
        }
        $this->set('nodes', $this->paginate());
        $this->set(compact('types', 'typeAliases'));
        $moreActions = $this->Node->moreActions;
        $this->set('moreActions', $moreActions);
        if (!empty($this->request->params['named']['links'])) {
            if (empty($this->request->params['named']['from'])) {
                $this->layout = 'ajax';
            }
            $this->render('admin_links');
        }
        $this->set('content_type', $this->Node->find('count', array(
            'conditions' => array(
                'Node.type_id = ' => constContentType::Page,
                'Node.plugin_name' => $plugins
            )
        )));
        if (!empty($this->request->params['named']['content_filter_id']) && $this->request->params['named']['content_filter_id'] == constContentType::Page && !empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Publish) {
            $publishCountConditions['Node.type_id'] = constContentType::Page;
        }
        $publishCountConditions['Node.status'] = 1;
        $publishCountConditions['Node.plugin_name'] = $plugins;
        $this->set('publish', $this->Node->find('count', array(
            'conditions' => $publishCountConditions
        )));
        if (!empty($this->request->params['named']['content_filter_id']) && $this->request->params['named']['content_filter_id'] == constContentType::Page && !empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Publish) {
            $unpublishCountConditions['Node.type_id'] = constContentType::Page;
        }
        $unpublishCountConditions['Node.status'] = 0;
        $unpublishCountConditions['Node.plugin_name'] = $plugins;
        $this->set('unpublish', $this->Node->find('count', array(
            'conditions' => $unpublishCountConditions
        )));
    }
    public function admin_create()
    {
        $this->pageTitle = __l('Create Content');
        $types = $this->Node->Taxonomy->Vocabulary->Type->find('all', array(
            'order' => array(
                'Type.alias' => 'ASC',
            ) ,
        ));
        $this->set(compact('types'));
    }
    public function admin_add($typeAlias = 'node')
    {
        $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
        if (!isset($type['Type']['alias'])) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content Type')));
            $this->redirect(array(
                'action' => 'create'
            ));
        }
        $this->pageTitle = sprintf(__l('Add %s') , __l('Content')) . ' - ' . $type['Type']['title'];
        $this->Node->type = $type['Type']['alias'];
        $this->Node->Behaviors->attach('Tree', array(
            'scope' => array(
                'Node.type' => $this->Node->type,
            ) ,
        ));
        if (!empty($this->request->data)) {
            if (isset($this->request->data['TaxonomyData'])) {
                $this->request->data['Taxonomy'] = array(
                    'Taxonomy' => array() ,
                );
                foreach($this->request->data['TaxonomyData'] as $vocabularyId => $taxonomyIds) {
                    if (is_array($taxonomyIds)) {
                        $this->request->data['Taxonomy']['Taxonomy'] = array_merge($this->request->data['Taxonomy']['Taxonomy'], $taxonomyIds);
                    }
                }
            }
            $this->Node->create();
            $this->request->data['Node']['path'] = $this->Cms->getRelativePath(array(
                'admin' => false,
                'controller' => 'nodes',
                'action' => 'view',
                'type' => $this->Node->type,
                'slug' => $this->request->data['Node']['slug'],
            ));
			if(empty($this->request->data['Node']['type_id'])) {
				$this->request->data['Node']['type_id'] = constContentType::Page;
			}
            if ($this->Node->saveWithMeta($this->request->data)) {
                Cms::dispatchEvent('Controller.Nodes.afterAdd', $this, array(
                    'data' => $this->request->data
                ));
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Content')) , 'default', null, 'success');
                if (isset($this->request->data['apply'])) {
                    $this->redirect(array(
                        'action' => 'edit',
                        $this->Node->id
                    ));
                } else {
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Content')) , 'default', null, 'error');
            }
        } else {
            $this->request->data['Node']['user_id'] = $this->Session->read('Auth.User.id');
        }
        $nodes = $this->Node->generateTreeList();
        $users = $this->Node->User->find('list');
        $taxonomy = $vocabularies = array();
        if (!empty($type['Vocabulary'])) {
            $vocabularies = Set::combine($type['Vocabulary'], '{n}.id', '{n}');
            foreach($type['Vocabulary'] as $vocabulary) {
                $vocabularyId = $vocabulary['id'];
                $taxonomy[$vocabularyId] = $this->Node->Taxonomy->getTree($vocabulary['alias'], array(
                    'taxonomyId' => true
                ));
            }
        }
        $this->set(compact('typeAlias', 'type', 'nodes', 'vocabularies', 'taxonomy', 'users'));
    }
    public function admin_edit($id = null)
    {
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->Node->id = $id;
        $typeAlias = $this->Node->field('type');
        $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
        if (!isset($type['Type']['alias'])) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content Type')) , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'create'
            ));
        }
        $this->pageTitle = sprintf(__l('Edit Content - %s') , $type['Type']['title']);
        $this->Node->type = $type['Type']['alias'];
        $this->Node->Behaviors->attach('Tree', array(
            'scope' => array(
                'Node.type' => $this->Node->type
            )
        ));
        if (!empty($this->request->data)) {
            if (isset($this->request->data['TaxonomyData'])) {
                $this->request->data['Taxonomy'] = array(
                    'Taxonomy' => array() ,
                );
                foreach($this->request->data['TaxonomyData'] as $vocabularyId => $taxonomyIds) {
                    if (is_array($taxonomyIds)) {
                        $this->request->data['Taxonomy']['Taxonomy'] = array_merge($this->request->data['Taxonomy']['Taxonomy'], $taxonomyIds);
                    }
                }
            }
            $this->request->data['Node']['path'] = $this->Cms->getRelativePath(array(
                'admin' => false,
                'controller' => 'nodes',
                'action' => 'view',
                'type' => $this->Node->type,
            ));
            if ($this->Node->saveWithMeta($this->request->data)) {
                Cms::dispatchEvent('Controller.Nodes.afterEdit', $this, array(
                    'data' => $this->request->data
                ));
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Content')) , 'default', null, 'success');
                if (isset($this->request->data['apply'])) {
                    $this->redirect(array(
                        'action' => 'edit',
                        $this->Node->id
                    ));
                } else {
                    $this->redirect(array(
                        'action' => 'index'
                    ));
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Content')) , 'default', null, 'error');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Node->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $nodes = $this->Node->generateTreeList();
        $users = $this->Node->User->find('list');
        $vocabularies = !empty($type['Vocabulary']) ? Set::combine($type['Vocabulary'], '{n}.id', '{n}') : '';
        $taxonomy = array();
        if (!empty($type['Vocabulary'])) {
            foreach($type['Vocabulary'] as $vocabulary) {
                $vocabularyId = $vocabulary['id'];
                $taxonomy[$vocabularyId] = $this->Node->Taxonomy->getTree($vocabulary['alias'], array(
                    'taxonomyId' => true
                ));
            }
        }
        $this->set(compact('typeAlias', 'type', 'nodes', 'vocabularies', 'taxonomy', 'users'));
    }
    public function admin_update_paths()
    {
        $types = $this->Node->Taxonomy->Vocabulary->Type->find('list', array(
            'fields' => array(
                'Type.id',
                'Type.alias',
            ) ,
        ));
        $typesAlias = array_values($types);
        $nodes = $this->Node->find('all', array(
            'conditions' => array(
                'Node.type' => $typesAlias,
            ) ,
            'fields' => array(
                'Node.id',
                'Node.slug',
                'Node.type',
                'Node.path',
            ) ,
            'recursive' => '-1',
        ));
        foreach($nodes as $node) {
            $node['Node']['path'] = $this->Cms->getRelativePath(array(
                'admin' => false,
                'controller' => 'nodes',
                'action' => 'view',
                'type' => $node['Node']['type'],
                'slug' => $node['Node']['slug'],
            ));
            $this->Node->id = false;
            $this->Node->save($node);
        }
        $this->Session->setFlash(__l('Paths updated.') , 'default', null, 'success');
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Node->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Content')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_delete_meta($id = null)
    {
        $success = false;
        if ($id != null && $this->Node->Meta->delete($id)) {
            $success = true;
        }
        $this->set('json', array(
            'success' => $success
        ));
        $this->view = 'Json';
    }
    public function admin_add_meta()
    {
        $this->layout = 'ajax';
    }
    public function admin_process()
    {
        $action = $this->request->data['Node']['action'];
        $ids = array();
        foreach($this->request->data['Node'] as $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }
        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__l('No items selected.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($action == 'delete' && $this->Node->deleteAll(array(
            'Node.id' => $ids
        ) , true, true)) {
            Cms::dispatchEvent('Controller.Nodes.afterDelete', $this, compact($ids));
            $this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
        } elseif ($action == 'publish' && $this->Node->updateAll(array(
            'Node.status' => 1
        ) , array(
            'Node.id' => $ids
        ))) {
            Cms::dispatchEvent('Controller.Nodes.afterPublish', $this, compact($ids));
            $this->Session->setFlash(__l('Checked records has been published') , 'default', null, 'success');
        } elseif ($action == 'unpublish' && $this->Node->updateAll(array(
            'Node.status' => 0
        ) , array(
            'Node.id' => $ids
        ))) {
            Cms::dispatchEvent('Controller.Nodes.afterUnpublish', $this, compact($ids));
            $this->Session->setFlash(__l('Checked records has been unpublished') , 'default', null, 'success');
        } elseif ($action == 'promote' && $this->Node->updateAll(array(
            'Node.promote' => 1
        ) , array(
            'Node.id' => $ids
        ))) {
            Cms::dispatchEvent('Controller.Nodes.afterPromote', $this, compact($ids));
            $this->Session->setFlash(__l('Checked records has been promoted') , 'default', null, 'success');
        } elseif ($action == 'unpromote' && $this->Node->updateAll(array(
            'Node.promote' => 0
        ) , array(
            'Node.id' => $ids
        ))) {
            Cms::dispatchEvent('Controller.Nodes.afterUnpromote', $this, compact($ids));
            $this->Session->setFlash(__l('Checked records has been depromoted') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('An error occurred.') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function index()
    {
        if (!isset($this->request->params['named']['type'])) {
            $this->request->params['named']['type'] = 'node';
        }
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['conditions'] = array(
            'Node.status' => 1,
        );
        $this->paginate['Node']['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ) ,
            'User',
        );
        if (isset($this->request->params['named']['type'])) {
            $type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $this->request->params['named']['type'],
                ) ,
                'cache' => array(
                    'name' => 'type_' . $this->request->params['named']['type'],
                    'config' => 'nodes_index',
                ) ,
            ));
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content Type')) , 'default', null, 'error');
                $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['Node']['conditions']['Node.type'] = $type['Type']['alias'];
            $this->pageTitle = $type['Type']['title'];
        }
        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_index_' . Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix.= '_' . $type['Type']['alias'];
            }
            $this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'];
            $cacheNamePaging = $cacheNamePrefix . '_' . $this->request->params['named']['type'] . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'] . '_paging';
            $cacheConfig = 'nodes_index';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate('Node');
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->request->params['paging'] = $paging;
                $this->helpers[] = 'Paginator';
            }
        } else {
            $nodes = $this->paginate('Node');
        }
        $this->set(compact('type', 'nodes'));
        $this->_viewFallback(array(
            'index_' . $type['Type']['alias'],
        ));
    }
    public function term()
    {
        $term = $this->Node->Taxonomy->Term->find('first', array(
            'conditions' => array(
                'Term.slug' => $this->request->params['named']['slug'],
            ) ,
            'cache' => array(
                'name' => 'term_' . $this->request->params['named']['slug'],
                'config' => 'nodes_term',
            ) ,
        ));
        if (!isset($term['Term']['id'])) {
            $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Term')) , 'default', null, 'error');
            $this->redirect('/');
        }
        if (!isset($this->request->params['named']['type'])) {
            $this->request->params['named']['type'] = 'node';
        }
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['conditions'] = array(
            'Node.status' => 1,
            'Node.terms LIKE' => '%"' . $this->request->params['named']['slug'] . '"%',
        );
        $this->paginate['Node']['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ) ,
            'User',
        );
        if (isset($this->request->params['named']['type'])) {
            $type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
                'conditions' => array(
                    'Type.alias' => $this->request->params['named']['type'],
                ) ,
                'cache' => array(
                    'name' => 'type_' . $this->request->params['named']['type'],
                    'config' => 'nodes_term',
                ) ,
            ));
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content Type')) , 'default', null, 'error');
                $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['Node']['conditions']['Node.type'] = $type['Type']['alias'];
            $this->pageTitle = $term['Term']['title'];
        }
        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_term_' . $this->request->params['named']['slug'] . '_' . Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix.= '_' . $type['Type']['alias'];
            }
            $this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'];
            $cacheNamePaging = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'] . '_paging';
            $cacheConfig = 'nodes_term';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate('Node');
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->request->params['paging'] = $paging;
                $this->helpers[] = 'Paginator';
            }
        } else {
            $nodes = $this->paginate('Node');
        }
        $this->set(compact('term', 'type', 'nodes'));
        $this->_viewFallback(array(
            'term_' . $term['Term']['id'],
            'term_' . $type['Type']['alias'],
        ));
    }
    public function promoted()
    {
        $this->pageTitle = __l('Nodes');
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['conditions'] = array(
            'Node.status' => 1,
            'Node.promote' => 1,
        );
        $this->paginate['Node']['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ) ,
            'User',
        );
        if (isset($this->request->params['named']['type'])) {
            $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($this->request->params['named']['type']);
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content Type')) , 'default', null, 'error');
                $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['Node']['conditions']['Node.type'] = $type['Type']['alias'];
            $this->pageTitle = $type['Type']['title'];
            $this->set(compact('type'));
        }
        if ($this->usePaginationCache) {
            $cacheNamePrefix = 'nodes_promoted_' . Configure::read('Config.language');
            if (isset($type)) {
                $cacheNamePrefix.= '_' . $type['Type']['alias'];
            }
            $this->paginate['page'] = isset($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1;
            $cacheName = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'];
            $cacheNamePaging = $cacheNamePrefix . '_' . $this->paginate['page'] . '_' . $this->paginate['Node']['limit'] . '_paging';
            $cacheConfig = 'nodes_promoted';
            $nodes = Cache::read($cacheName, $cacheConfig);
            if (!$nodes) {
                $nodes = $this->paginate('Node');
                Cache::write($cacheName, $nodes, $cacheConfig);
                Cache::write($cacheNamePaging, $this->request->params['paging'], $cacheConfig);
            } else {
                $paging = Cache::read($cacheNamePaging, $cacheConfig);
                $this->request->params['paging'] = $paging;
                $this->helpers[] = 'Paginator';
            }
        } else {
            $nodes = $this->paginate('Node');
        }
        $this->set(compact('nodes'));
    }
    public function search($typeAlias = null)
    {
        if (!isset($this->request->params['named']['q'])) {
            $this->redirect('/');
        }
        App::uses('Sanitize', 'Utility');
        $q = Sanitize::clean($this->request->params['named']['q']);
        $this->paginate['Node']['order'] = 'Node.created DESC';
        $this->paginate['Node']['conditions'] = array(
            'Node.status' => 1,
            'AND' => array(
                array(
                    'OR' => array(
                        'Node.title LIKE' => '%' . $q . '%',
                        'Node.excerpt LIKE' => '%' . $q . '%',
                        'Node.body LIKE' => '%' . $q . '%',
                        'Node.terms LIKE' => '%"' . $q . '"%',
                    ) ,
                )
            ) ,
        );
        $this->paginate['Node']['contain'] = array(
            'Meta',
            'Taxonomy' => array(
                'Term',
                'Vocabulary',
            ) ,
            'User',
        );
        if ($typeAlias) {
            $type = $this->Node->Taxonomy->Vocabulary->Type->findByAlias($typeAlias);
            if (!isset($type['Type']['id'])) {
                $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content Type')) , 'default', null, 'error');
                $this->redirect('/');
            }
            if (isset($type['Params']['nodes_per_page'])) {
                $this->paginate['Node']['limit'] = $type['Params']['nodes_per_page'];
            }
            $this->paginate['Node']['conditions']['Node.type'] = $typeAlias;
        }
        $nodes = $this->paginate('Node');
        $this->pageTitle = sprintf(__l('Search Results - %s') , $q);
        $this->set(compact('q', 'nodes'));
        if ($typeAlias) {
            $this->_viewFallback(array(
                'search_' . $typeAlias,
            ));
        }
    }
    public function view($id = null)
    {
        if (Configure::read('site.launch_mode') == 'Pre-launch' && (($this->request->params['named']['slug'] != 'privacy-policy') && ($this->request->params['named']['slug'] != 'home-banner'))) {
            throw new ForbiddenException(__l('Invalid request'));
        } else {
            if (isset($this->request->params['named']['slug']) && isset($this->request->params['named']['type'])) {
                $this->Node->type = $this->request->params['named']['type'];
                $type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
                    'conditions' => array(
                        'Type.alias' => $this->Node->type,
                    ) ,
                    'cache' => array(
                        'name' => 'type_' . $this->Node->type,
                        'config' => 'nodes_view',
                    ) ,
                ));
                $node = $this->Node->find('first', array(
                    'conditions' => array(
                        'Node.slug' => $this->request->params['named']['slug'],
                        'Node.type' => $this->request->params['named']['type'],
                        'Node.status' => 1,
                    ) ,
                    'contain' => array(
                        'Meta',
                        'Taxonomy' => array(
                            'Term',
                            'Vocabulary',
                        ) ,
                        'User',
                    ) ,
                    'cache' => array(
                        'name' => 'node_' . $this->request->params['named']['type'] . '_' . $this->request->params['named']['slug'],
                        'config' => 'nodes_view',
                    ) ,
                    'recursive' => 2
                ));
            } elseif ($id == null) {
                $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content')) , 'default', null, 'error');
                $this->redirect('/');
            } else {
                $node = $this->Node->find('first', array(
                    'conditions' => array(
                        'Node.id' => $id,
                        'Node.status' => 1,
                    ) ,
                    'contain' => array(
                        'Meta',
                        'Taxonomy' => array(
                            'Term',
                            'Vocabulary',
                        ) ,
                        'User',
                    ) ,
                    'cache' => array(
                        'name' => 'node_' . $id,
                        'config' => 'nodes_view',
                    ) ,
                    'recursive' => 2
                ));
                $this->Node->type = $node['Node']['type'];
                $type = $this->Node->Taxonomy->Vocabulary->Type->find('first', array(
                    'conditions' => array(
                        'Type.alias' => $this->Node->type,
                    ) ,
                    'cache' => array(
                        'name' => 'type_' . $this->Node->type,
                        'config' => 'nodes_view',
                    ) ,
                ));
            }
            if (!isset($node['Node']['id'])) {
                $this->Session->setFlash(sprintf(__l('Invalid %s') , __l('Content')) , 'default', null, 'error');
                $this->redirect('/');
            }
            if ($node['Node']['comment_count'] > 0) {
                $comments = $this->Node->Comment->find('threaded', array(
                    'conditions' => array(
                        'Comment.node_id' => $node['Node']['id'],
                        'Comment.status' => 1,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'cache' => array(
                        'name' => 'comment_node_' . $node['Node']['id'],
                        'config' => 'nodes_view',
                    ) ,
                    'recursive' => 1
                ));
            } else {
                $comments = array();
            }
            $this->pageTitle = $node['Node']['title'];
            $this->set(compact('node', 'type', 'comments'));
            $this->_viewFallback(array(
                'view_' . $node['Node']['id'],
                'view_' . $type['Type']['alias'],
            ));
            if (!empty($node['Node']['meta_keywords'])) {
                Configure::write('meta.keywords', $node['Node']['meta_keywords']);
            }
            if (!empty($node['Node']['meta_description'])) {
                Configure::write('meta.description', $node['Node']['meta_description']);
            }
        }
    }
    protected function _viewFallback($views)
    {
        if (is_string($views)) {
            $views = array(
                $views
            );
        }
        if ($this->theme) {
            $viewPaths = App::path('View');
            foreach($views as $view) {
                foreach($viewPaths as $viewPath) {
                    $viewPath = $viewPath . 'Themed' . DS . $this->theme . DS . $this->name . DS . $view . $this->ext;
                    if (file_exists($viewPath)) {
                        return $this->render($view);
                    }
                }
            }
        }
    }
    public function admin_tools()
    {
        $this->pageTitle = __l('Tools');
    }
    public function home()
    {
        $this->pageTitle = __l('Home');
    }
    public function how_it_works()
    {
        $this->pageTitle = __l('How it Works');
    }
}
