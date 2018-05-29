<?php /* SVN FILE: $Id: default.ctp 4216 2010-04-21 12:14:26Z siva_063at09 $ */ ?>
<?php
header('Content-Disposition: inline; filename="' . str_replace('/', '_', $this->request->params['url']['url']) . '"');
?>
<?php echo $content_for_layout; ?>