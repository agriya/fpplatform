jQuery(document).ready(function($) {
	jQuery(document).on('click', '.js-show-details', function(e) {
		$this=$(this);
		classes = $this.attr('class');
        classes = classes.split(' ');
		if ($.inArray('down-arrow', classes) != -1) {
			$this.removeClass('down-arrow');
			$this.addClass('up-arrow');
		}
		else{
			$this.removeClass('up-arrow');
			$this.addClass('down-arrow');
		}
		$('.' + $this.attr('id')).toggle();
	}).on('click', '.js-ajax-link', function(e) {
		$this = $(this);
        $parent = $this.parent();
        $parent.block();
        $.get($this.attr('href'), function(data) {
            $('.js-response').append(data);
            $this.hide();
            $parent.unblock();
        });
        return false;
	}).on('click', '.js-generate', function(e) {
		return window.confirm(__l('Are you sure you want to generate actions?'));
	});
});