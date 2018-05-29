<?php
	$css_files = array(
        CSS . 'flag.css',
		CSS . 'dev1bootstrap.less',
		CSS . 'responsive.less',
		CSS . 'bootstrap-wysihtml5-0.0.2.css',
		CSS . 'bootstrap-datetimepicker.min.css',
		CSS . 'jquery.autocomplete.css',
		CSS . 'jquery.fileupload-ui.css',
		CSS . 'jquery-ui-1.10.3.custom.css',
		CSS . 'bootstro.css',

	);
	$css_files = Set::merge($css_files, Configure::read('site.default.css_files'));
?>