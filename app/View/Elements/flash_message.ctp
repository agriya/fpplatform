<?php
	if ($this->Session->check('Message.error')):
		$this->Session->flash('error');
	endif;
	if ($this->Session->check('Message.success')):
		$this->Session->flash('success');
	endif;
	if ($this->Session->check('Message.flash')):
			$this->Session->flash();
	endif;//view_compact
?>