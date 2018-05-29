<?php 
if(!empty($types_for_admin_layout) && is_array($types_for_admin_layout)){
foreach ($types_for_admin_layout as $t):
	CmsNav::add('cms.children.content.children.create.children.' . $t['Type']['alias'], array(
				'title' => $t['Type']['title'],
				'url' => array(
					'admin' => true,
					'controller' => 'nodes',
					'action' => 'add',
					$t['Type']['alias'],
				),
	));
endforeach;
}
if(!empty($vocabularies_for_admin_layout) && is_array($vocabularies_for_admin_layout)){
foreach ($vocabularies_for_admin_layout as $v):
	$weight = 9999 + $v['Vocabulary']['weight'];
	CmsNav::add('cms.children.content.children.taxonomy.children.' . $v['Vocabulary']['alias'], array(
			'title' => $v['Vocabulary']['title'],
			'url' => array(
			'admin' => true,
					'controller' => 'terms',
					'action' => 'index',
					$v['Vocabulary']['id'],
			),
			'weight' => $weight,
	));
endforeach;
}
if(!empty($menus_for_admin_layout) && is_array($menus_for_admin_layout)){
foreach ($menus_for_admin_layout as $m):
	$weight = 9999 + $m['Menu']['weight'];
	CmsNav::add('cms.children.menus.children.' . $m['Menu']['alias'], array(
			'title' => $m['Menu']['title'],
			'url' => array(
				'admin' => true,
				'controller' => 'links',
				'action' => 'index',
				$m['Menu']['id'],
			),
			'weight' => $weight,
	));
endforeach;
}
?>

<?php echo $this->Layout->adminMenus(CmsNav::items());?>