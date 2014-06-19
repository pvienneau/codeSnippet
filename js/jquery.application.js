$(document).ready(function () {
	if ($.browser.opera) {
		$('select').css({
			opacity: 0
		});
	}
	$('.sidebar li a').livequery(function () {
		$(this).after('<span class="tip_holder"><span class="tip" style="display: none"><span class="arrow"></span>' + $(this).text() + '</span></span>');
	});
	$('.title').livequery(function () {
		$(this).after('<span class="indicator"></span>');
	});
	$('.sidebar #new').livequery('click', function () {
		$('.main_section').hide();
		$('.new_section').show();
		return false;
	});
	$('.sidebar #cancel, .message .small_button').livequery('click', function () {
		$('.new_section').hide();
		$('.main_section').show();
		return false;
	});
	/*$('.qty input, .price input, input[name="tax"], input[name="discount"], input[name="shipping"], input[name="amount"], input[name="qty"], input[name="price"], input[name="rate"], input[name="hours"], #rate').livequery('keypress', function (e) {
		if (e.charCode != 46 && e.charCode != 44 && e.charCode != 32) {// && (e.charCode < 48 || e.charCode > 57)) {
			e.preventDefault();
		}
	});*/
	$('a.blank').livequery('click', function () {
		window.open(this.href);
		return false;
	});
	$(window).bind("load resize", function () {
		tips();
	});
	function tips() {
		if ($(this).width() > "1140") {
			$('.tip_holder').show();
			$('.sidebar li a').hover(function () {
				$(this).next('.tip_holder').find('.tip').show();
			},
			function () {
				$(this).next('.tip_holder').find('.tip').fadeOut('fast');
			});
		}
		else {
			$('.tip_holder').hide();
		}
	}
	$('.row').livequery(function () {
		var actions = $(this).find('.actions');
		var address = $(this).find('.show_address');
		$(this).hover(function () {
			$('.actions').hide();
			actions.show();
			address.show();
		},
		function () {
			if ($(this).find('.remove').hasClass('pressed')) {} else {
				actions.hide();
				address.hide();
			}
		});
	});
	$('.remove_from_main .button').livequery('click', function () {
		$(this).attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$('.indicator').fadeIn("slow");
		if ($('.segment').attr('id')) {
			var segment = '/' + $('.segment').attr('id');
		}
		else {
			var segment = '/';
		}
		if ($('#pagination').size() == '1') {
			$.post($('#nav .current').attr('id') + '/remove/' + $(this).attr('id'), function () {
				$('.rows').load($('#nav .current').attr('id') + segment + ' .rows', function () {
					hide_dialog();
					$('.indicator').fadeOut("slow");
				});
			});
		}
		else {
			$('.to_be_removed').remove();
			hide_dialog();
			$('.indicator').fadeOut('slow');
			$('.row').removeClass('alt');
			$('.row:odd').addClass('alt');
			$.post($('#nav .current').attr('id') + '/remove/' + $(this).attr('id'));
			if ($('.row').size() == '0') {
				$('.rows').empty().append('<li class="row"><span class="empty">No ' + $('#nav .current').attr('id') + ' where found.</span></li>');
			}
		}
		return false;
	});
	$('.remove_from_view .button').livequery('click', function () {
		$(this).attr('disabled', 'disabled').addClass('disabled').text('Loading…');
	});
	$('#filter .select').livequery('change', function () {
		var form = $('#filter form');
		$('.indicator').fadeIn('slow');
		$('.rows')[0].innerHTML = '';
		form.ajaxSubmit(function (data, html) {
			
			$('.rows').html($('.rows', data).html());
			$('.indicator').fadeOut('slow');
			/*$('.rows').load(form.attr('action') + ' .rows', function () {
				$('.indicator').fadeOut('slow');
			});*/
		});
		return false;
	});
	/*$('#pagination a').livequery('click', function () {
		$('.indicator').fadeIn('slow');
		$('.rows')[0].innerHTML = '';
		if ($('#users_section').length) {
			$('.rows').load('users/' + $(this).attr('id') + ' .rows', function () {
				$('.indicator').fadeOut("fast");
			});
		}
		else {
			$('.rows').load($('#nav .current').attr('id') + '/' + $(this).attr('id') + ' .rows', function () {
				$('.indicator').fadeOut("fast");
			});
		}
		return false;
	});*/
	$('.checkbox').livequery(function () {
		if ($(this).is(':checked')) {
			$(this).parents('.checkbox_wrapper').addClass('checked')
		}
	});
	$('.checkbox').livequery('click', function () {
		if ($(this).is(':checked')) {
			$(this).parents('.checkbox_wrapper').addClass('checked').removeClass('required');;
		}
		else if ($(this).not(':checked')) {
			$(this).parents('.checkbox_wrapper').removeClass('checked');
		}
	});
	$('#forgot').livequery('click', function () {
		$('#login_part').hide();
		$('#forgot_part').show();
		return false;
	});
	$('#forgot_part .small_button').livequery('click', function () {
		$('#forgot_part').hide();
		$('#login_part').show();
		return false;
	});
	$('#login_part form, #forgot_part form').livequery('submit', function () {
		$('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
	});
	$('#setup_section form').livequery('submit', function () {
		$('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$('.indicator').fadeIn('slow');
	});
	$('.select_wrapper').livequery(function () {
		$(this).prepend('<span>' + $(this).find('.select option:selected').text() + '</span>');
	});
	$('.select').livequery('change', function () {
		$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
	});
	$('#shipping_status, #discount_status').livequery('click', function () {
		verifySubtotal();
	});
	
	$('input[name="tax_status"]').livequery('click', function () {
		if ($(this).is(':checked')) {
			$('.subtotal_display').show();
			$('#tax, .tax_display, #tax_name').show();
			$('#tax').focus();
			calculate();
		}
		else if ($(this).not(':checked')) {
			$('#tax, .tax_display, #tax_name').hide();
			calculate();
		}
		verifySubtotal();
	});
	$('input[name="tax2_status"]').livequery('click', function () {
		if ($(this).is(':checked')) {
			$('.subtotal_display').show();
			$('.tax2_display, #tax2_span').show();
			$('#tax2').focus();
			calculate();
		}
		else if ($(this).not(':checked')) {
			$('.tax2_display, #tax2_span').hide();
			calculate();
		}
		verifySubtotal();
	});
	$('input[name="tax2_cumulative"]').livequery('click', function () {		
		calculate();
	});
	$('input[name="management_status"]').livequery('click', function () {
		if ($(this).is(':checked')) {
			$('#management, .management_display').show().focus();
			calculate();
		}
		else if ($(this).not(':checked')) {
			$('#management, .management_display').hide();
			calculate();
		}
	});
	$('input[name="discount_status"]').livequery('click', function () {
		if ($(this).is(':checked')) {
			$('#discount, .discount_display').show().focus();
			calculate();
		}
		else if ($(this).not(':checked')) {
			$('#discount, .discount_display').hide();
			calculate();
		}
	});
	$('input[name="shipping_status"]').livequery('click', function () {
		if ($(this).is(':checked')) {
			$('#shipping, .shipping_display').show().focus();
			calculate();
		}
		else if ($(this).not(':checked')) {
			$('#shipping, .shipping_display').hide();
			calculate();
		}
	});
	$('.qty input').livequery('change', function () {
		if ($(this).val() == "0" || $(this).val() == "") {
			$(this).val('1');
		}
	});
	$('#currency_symbol').livequery('change', function () {
		/*if ($(this).val() == "none") {
			$('.currency_symbol').hide();
		}
		if ($(this).val() == "dollar") {
			$('.currency_symbol').show().text('$');
		}
		if ($(this).val() == "euro") {
			$('.currency_symbol').show().text('€');
		}
		if ($(this).val() == "pound") {
			$('.currency_symbol').show().text('£');
		}
		if ($(this).val() == "yen") {
			$('.currency_symbol').show().text('￥');
		}*/
		if ($(this).val() == "") {
			$('.currency_symbol').hide();
		} else {
			$('.currency_symbol').show().text($(this).val());
		}
	});
	$('#currency_code').livequery('change', function () {
		if ($(this).val() == "none") {
			$('.currency_code').hide();
		}
		else {
			$('.currency_code').show().text(' ' + $(this).val());
		}
	});
	function remove_zeros(x) {
		var decPos = x.indexOf('.')
		if (decPos > -1) {
			first = x.substring(0, decPos);
			second = x.substring(decPos, x.length);
			while (second.charAt(second.length - 1) == '0')
			second = second.substring(0, second.length - 1);
			if (second.length > 1) return first + second;
			else return first;
		}
		return x;
	}
	$('#tax').livequery('change', function () {
		if ($(this).val() >= '0.1') {
			var tax = parseFloat($(this).val());
			tax = tax.toFixed(2);
			if (tax > 0) {
				tax = remove_zeros(tax);
			}
			$('#tax_rate').show().text(' (' + tax + '%)');
		}
		else {
			$('#tax_rate').hide();
		}
		calculate();
	});
	$('#tax_name').livequery('change', function () {
		$('#tax_name_update').text($(this).val());
	});
	$('#tax2').livequery('change', function () {
		if ($(this).val() >= '0.1') {
			var tax2 = parseFloat($(this).val());
			tax2 = tax2.toFixed(2);
			if (tax2 > 0) {
				tax2 = remove_zeros(tax2);
			}
			$('#tax2_rate').show().text(' (' + tax2 + '%)');
		}
		else {
			$('#tax2_rate').hide();
		}
		calculate();
	});
	$('#tax2_name').livequery('change', function () {
		$('#tax2_name_update').text($(this).val());
	});
	$('#discount').livequery('change', function () {
		if ($(this).val() >= '0.1') {
			var discount = parseFloat($(this).val());
			discount = discount.toFixed(2);
			if (discount > 0) {
				var discount = remove_zeros(discount);
			}
			$('#discount_rate').show().text(' (' + discount + '%)');
		}
		else {
			$('#discount_rate').hide();
		}
	});
	$('#management').livequery('change', function () {
		if ($(this).val() >= '0.1') {
			var management = parseFloat($(this).val());
			management = management.toFixed(2);
			if (management > 0) {
				management = remove_zeros(management);
			}
			$('#management_rate').show().text(' (' + management + '%)');
		}
		else {
			$('#management_rate').hide();
		}
	});
	//$('#new_invoice_section .qty input, #edit_invoice_section .qty input, #new_recurring_section .qty input, #edit_recurring_section .qty input, .price input, #tax, #shipping, #discount, #management').livequery('change', function () {
	$('.qty input, .price input, #tax, #shipping, #discount, #management').livequery('change', function () {
		calculate();
	});
	function calculate() {
		var subtotal_result = 0;
		var shipping = 0;
		$('.line').each(function () {
			var qty = parseFloat($(this).find('.qty input').val().replace(/,| /, ''));
			qty = isNaN(qty) ? 0 : qty;
			var input = $(this).find('.price input');
			var price = parseFloat(input.val().replace(/,| /, ''));
			input.val(price.toFixed(2)); // reformat the price with .00
			price = isNaN(price) ? 0 : price;
			var price = qty * price;
			$(this).find('.total_line').text(price.toFixed(2));
			subtotal_result += price;
		});
		$('#subtotal_result').text(subtotal_result.toFixed(2));
		if ($('#management_status').is(':checked')) {
			var management = $('#management').val() / 100;
			var management_result = parseFloat(subtotal_result * management * 100) / 100;
			$('#management_result').text(management_result.toFixed(2));
		}
		else if ($('#management_status').not(':checked')) {
			var management_result = 0;
		}
		subtotal_result += management_result;
		if ($('#discount_status').is(':checked')) {
			var discount = $('#discount').val() / 100;
			var discount_result = parseFloat(subtotal_result * discount * 100) / 100;
			$('#discount_result').text(discount_result.toFixed(2));
		}
		else if ($('#discount_status').not(':checked')) {
			var discount_result = 0;
		}
		subtotal_result -= discount_result;
		if ($('#tax_status').is(':checked')) {
			var tax = $('#tax').val() / 100;
			var tax_result = parseFloat(subtotal_result * tax * 100) / 100;
			$('#tax_result').text(tax_result.toFixed(2));
		}
		else if ($('#tax_status').not(':checked')) {
			var tax_result = 0;
		}
		if ($('#tax2_status').is(':checked')) {
			var tax2 = $('#tax2').val() / 100;
			var tax2_result = parseFloat((subtotal_result + ($('#tax2_cumulative').is(':checked') ? tax_result:0)) * tax2 * 100) / 100;
			$('#tax2_result').text(tax2_result.toFixed(2));
		}
		else if ($('#tax2_status').not(':checked')) {
			var tax2_result = 0;
		}
		if ($('#shipping_status').is(':checked')) {
			var shipping = $('#shipping').val().replace(/,| /, '');
			var shipping_result = 1 * shipping;
			$('#shipping_result').text(shipping_result.toFixed(2));
		}
		else if ($('#shipping_status').not(':checked')) {
			var shipping_result = 0;
		}
		subtotal_result += tax_result;
		subtotal_result += tax2_result;
		subtotal_result += shipping_result;
		$('#total_result').text(subtotal_result.toFixed(2));
	}
	$('.not_started').livequery('click', function () {
		$('#time').countdown({
			since: '-1S',
			compact: true,
			format: 'HMS'
		});
		$(this).addClass('pause').removeClass('not_started');
	});
	$('.pause').livequery('click', function () {
		$('#time').countdown('pause');
		$(this).addClass('resume').removeClass('pause');
	});
	$('.resume').livequery('click', function () {
		$('#time').countdown('resume');
		$(this).addClass('pause').removeClass('resume');
	});
	$('#reset').livequery('click', function () {
		$('#time').countdown('destroy').text('00:00:00');
		$('#start').addClass('not_started').removeClass('pause').removeClass('resume');
	});
	$('#timer_part .select').livequery('change', function () {
		if ($(this).val() == "new_project") {
			$('#new_project_part_wrapper').fadeIn('slow');
		}
	});
	$('#new_project_part .small_button').livequery('click', function () {
		$('#timer_part .select').val('');
		$('#timer_part .select_wrapper span').replaceWith('');
		$('#new_project_part_wrapper').fadeOut('slow');
	});
	function add_time(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).parents('.select_wrapper').addClass('required');
		}
		if (errorInfo.length == 0) {
			var project = $('#timer_part .select').val();
			$('#time').countdown('pause');
			$('input[name="time"]').val($('#time').text());
			$('#add_time').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			window.opener.$('#projects_section .indicator').fadeIn('slow');
			$('#timer_part form').ajaxSubmit(function () {
				$('#time').text('Added');
				$('#timer_part').load('project/timer #timer_part', function () {
					$('#time').text('Added');
					setTimeout(function () {
						$('#time').text('00:00:00');
					},
					2000)
				});
				window.opener.$('#projects_section').load('project #projects_section');
				setTimeout(function () {
					window.opener.$('#projects_section .indicator').show().fadeOut('slow');
				},
				500)
			});
		}
		return false;
	}
	$('#timer_part form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_time,
			rules: ['required,project,']
		});
	});
	function add_project(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#add_project').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			window.opener.$('#projects_section .indicator').fadeIn('slow');
			$('#new_project_part form').ajaxSubmit(function () {
				$('#selection').load('project/timer #select_project', function () {
					$('#new_project_part_wrapper').fadeOut('slow', function () {
						$('#update_new_project_part').load('project/timer #update_new_project_part');
					});
				});
				window.opener.$('#projects_section').load('project #projects_section');
				setTimeout(function () {
					window.opener.$('.indicator').show().fadeOut('slow');
				},
				500)
			});
		}
		return false;
	}
	$('#new_project_part form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_project,
			rules: ['required,description,', 'required,hours,']
		});
	});
	$('.sidebar #timer, .timer').livequery('click', function () {
		var timer = window.open('', 'timer', 'toolbar=no,menubar=no,status=no,directories=no,scrollbars=no,resizable=no,location=no,copyhistory=no,titlebar=no,width=500,height=420');
		timer.focus();
		if (timer.location && timer.location.href.indexOf('time/timer') == -1) timer.location.href = 'time/timer';
		return false;
	});
	$('.box #invoice_settings').livequery(function () {
		$(this).toggle(function () {
			if ($('#new_recurring_section').length) {
				$('html, body').animate({
					scrollTop: 500
				},
				'slow');
			}
			else if ($('#edit_recurring_section').length) {
				$('html, body').animate({
					scrollTop: 500
				},
				'slow');
			}
			else {
				$('html, body').animate({
					scrollTop: 240
				},
				'slow');
			}
			$('#settings_part').show();
		},
		function () {
			$('#settings_part').hide();
		});
		return false;
	});
	$('#send_invoice_checkbox').livequery('click', function () {
		if ($(this).is(':checked')) {
			$('#update_send').show();
			$('html, body').animate({
				scrollTop: 200
			},
			'slow');
		}
		else if ($(this).not(':checked')) {
			$('#update_send').hide();
		}
	});
	$('#schedule').livequery('change', function () {
		if ($(this).val() == 'other') {
			$('#schedule_other').show();
			$('#schedule_other input').focus()
		}
		else {
			$('#schedule_other').hide();
		}
	});
	$('#schedule_other .field').livequery('change', function () {
		if ($(this).val() <= '1') {
			$('#day').text('day');
			$(this).val('1');
		}
		else {
			$('#day').text('days');
		}
	});
	$('.qty').livequery('change', function () {
		if ($(this).find('.field').val() <= '1') {
			$(this).find('.select option:eq(0)').text('hour');
			$(this).find('.select option:eq(1)').text('day');
			$(this).find('.select option:eq(2)').text('service');
			$(this).find('.select option:eq(3)').text('product');
		}
		else {
			$(this).find('.select option:eq(0)').text('hours');
			$(this).find('.select option:eq(1)').text('days');
			$(this).find('.select option:eq(2)').text('services');
			$(this).find('.select option:eq(3)').text('products');
		}
		$(this).find('.select').prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
	});
	$('.file input').livequery(function () {
		$(this).css({
			opacity: 0
		});
		$(this).css({
			"width": "74px"
		});
		$(this).css({
			"float": "left"
		});
		$(this).css({
			"height": "100%"
		});
		$(this).css({
			"position": "relative"
		});
	});
	$('#send').livequery('click', function () {
		$(this).addClass('pressed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#send_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('#thank_you').livequery('click', function () {
		$(this).addClass('pressed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#thank_you_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('#reminder').livequery('click', function () {
		$(this).addClass('pressed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#reminder_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('#payment').livequery('click', function () {
		$(this).addClass('pressed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#payment_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('#history').livequery('click', function () {
		$(this).addClass('pressed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#history_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('#estimates_section .remove, #invoices_section .remove, #projects_section .remove, #items_section .remove, #clients_section .remove, #recurring_section .remove').livequery('click', function () {
		if ($('#nav .current').attr('id') == 'clients') {
			var client_text = ' By removing this client you will also remove all invoices assigned to this client.';
		}
		else {
			var client_text = '';
		}
		$('.main_section').after('<div class="dialog remove_from_main" id="remove_dialog"><div class="confirm">Are you sure you want to remove this ' + $('#nav .current').attr('id') + '? ' + client_text + '</div><div class="control"><input type="button" class="button yes" id="' + $(this).parents('.row').attr('id') + '" value="Yes" /><a class="small_button">Cancel</a></div></div>');
		$(this).addClass('pressed');
		$('.row').removeClass('to_be_removed');
		$(this).parents('.row').addClass('to_be_removed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#remove_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('#remove').livequery('click', function () {
		$('#view_invoice_section').after('<div class="dialog remove_from_view" id="remove_dialog"><div class="confirm">Are you sure you want to remove this invoice?</div><div class="control"><a href="invoice/remove/' + $('.sidebar').attr('id') + '" class="button yes">Yes</a><a class="small_button">Cancel</a></div></div>');
		$('#view_estimate_section').after('<div class="dialog remove_from_view" id="remove_dialog"><div class="confirm">Are you sure you want to remove this estimate?</div><div class="control"><a href="estimate/remove/' + $('.sidebar').attr('id') + '" class="button yes">Yes</a><a class="small_button">Cancel</a></div></div>');
		
		$(this).addClass('pressed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#remove_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('#overlay, .dialog .small_button, .dialog #close').livequery('click', function () {
		hide_dialog();
		$('.remove, #insert').removeClass('pressed');
		setTimeout(function () {
			$('.actions').hide();
		},
		400)
		return false;
	});
	function hide_dialog() {
		$('#send, #payment, #thank_you, #reminder, #history, #remove, #new_user, #archive, #activate').removeClass('pressed');
		if ($('#client_select').val() == 'new_client') {
			$('#client_select').val('');
			$('#update_clients .select').livequery(function () {
				$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
			});
		}
		if ($('#project_select').val() == 'new_project') {
			$('#project_select').val('');
			$('#update_projects .select').livequery(function () {
				$(this).prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
			});
		}
		$('#overlay').fadeOut('fast', function () {
			$(this).remove();
			$('.dialog').animate({
				top: "-400px"
			},
			'fast', function () {
				$('.dialog').hide();
				$('#remove_dialog').remove();
				$('#insert_project_dialog .button, #insert_item_dialog .button').attr('disabled', 'disabled').val('Insert');
			});
			//$('#invoice_theme_dialog').fadeOut('fast');
		});
	}
	function send_invoice(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
			$(errorInfo[i][0]).parents('.select_wrapper').addClass('required');
			$(errorInfo[i][0]).parents('.more').show();
		}
		if (errorInfo.length == 0) {
			$('#send_dialog .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('#send_dialog form').ajaxSubmit();
			hide_dialog();
			$('#update_send_dialog').load($('.sidebar').attr('id') + ' #update_send_dialog');
			$('#update_history_dialog').load($('.sidebar').attr('id') + ' #update_history_dialog');
			if ($('#badge').hasClass('draft')) {
				$('#badge').removeClass('draft').addClass('sent');
			}
			var parent = $('a#send').parents('li');
			var p = parent.find('p');
			if (p.length) {
				p.text(parseInt(p.text()) + 1);
			}
			else {
				parent.append('<p>Done</p>');
			}
		}
		return false;
	}
	$('#send_dialog form').livequery(function () {
		$(this).RSV({
			customErrorHandler: send_invoice,
			rules: ['required,subject,', 'required,message,']
		});
	});
	function send_thank_you(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#thank_you_dialog .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('#thank_you_dialog form').ajaxSubmit(function () {
				$('#update_thank_you_dialog').load($('.sidebar').attr('id') + ' #update_thank_you_dialog');
				$('#update_history_dialog').load($('.sidebar').attr('id') + ' #update_history_dialog');
			});
			hide_dialog();
			$('.message').hide();
			var parent = $('a#thank_you').parents('li');
			var p = parent.find('p');
			if (p.length) {
				p.text(parseInt(p.text()) + 1);
			}
			else {
				parent.append('<p>Done</p>')
			}
		}
		return false;
	}
	$('#thank_you_dialog form').livequery(function () {
		$(this).RSV({
			customErrorHandler: send_thank_you,
			rules: ['required,subject,', 'required,message,']
		});
	});
	function send_reminder(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#reminder_dialog .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('#reminder_dialog form').ajaxSubmit(function () {
				$('#update_reminder_dialog').load($('.sidebar').attr('id') + ' #update_reminder_dialog');
				$('#update_history_dialog').load($('.sidebar').attr('id') + ' #update_history_dialog');
			});
			hide_dialog();
			$('.message').hide();
			var parent = $('a#reminder').parents('li');
			var p = parent.find('p');
			if (p.length) {
				p.text(parseInt(p.text()) + 1);
			}
			else {
				parent.append('<p>Done</p>')
			}
		}
		return false;
	}
	$('#reminder_dialog form').livequery(function () {
		$(this).RSV({
			customErrorHandler: send_reminder,
			rules: ['required,subject,', 'required,message,']
		});
	});
	function add_payment(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
			$(errorInfo[i][0]).parents('.select_wrapper').addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#payment_dialog .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('#payment_dialog form').ajaxSubmit(function () {
				$('#update_invoice').load('invoice/view/' + $('.sidebar').attr('id') + ' #update_invoice');
				$('#update_sidebar').load('invoice/view/' + $('.sidebar').attr('id') + ' #update_sidebar', function () {
					hide_dialog();
					tips();
					$('#update_thank_you_dialog').load('invoice/view/' + $('.sidebar').attr('id') + ' #update_thank_you_dialog');
					$('#update_history_dialog').load('invoice/view/' + $('.sidebar').attr('id') + ' #update_history_dialog');
					$('#update_payment_dialog').load('invoice/view/' + $('.sidebar').attr('id') + ' #update_payment_dialog');
				});
			});
		}
		return false;
	}
	$('#payment_dialog form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_payment,
			rules: ['required,amount,', 'valid_date,month,day,year,any_date,']
		});
	});
	$('.tags a').livequery('click', function () {
		$(this).parents('.with').find('.field').val($(this).parents('.with').find('.default_subject').val());
		$(this).parents('.with').find('.textarea').text($(this).parents('.with').find('.default_message').text());
		return false;
	});
	$('a.close').livequery('click', function () {
		$(this).parents('.message').fadeOut('slow');
		$.post('/profile/start/hide/' + $('#nav .current').attr('id'));
		return false;
	});
	/*$('a#remove_application_logo').livequery('click', function () {
		$('.image_holder').hide();
		$('h1#logo').attr('style', '')
		$.post('settings/remove_application_logo/');
		return false;
	});
	$('a#remove_invoice_logo').livequery('click', function () {
		$('.image_holder').hide();
		$('h1#logo').attr('style', '')
		$.post('settings/remove_invoice_logo/');
		return false;
	});*/
	function add_invoice(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
			$(errorInfo[i][0]).parents('.select_wrapper').addClass('required');
		}
		if (errorInfo.length == 0) {
			$('.box .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('.indicator').fadeIn('slow');
			return true;
		}
		return false;
	}
	$('#new_recurring_section .box form, #edit_recurring_section .box form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_recurring,
			rules: ['required,name,', 'required,client_id,', 'valid_date,month,day,year,any_date,']
		});
	});
	function add_recurring(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
			$(errorInfo[i][0]).parents('.select_wrapper').addClass('required');
		}
		if (errorInfo.length == 0) {
			$('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('.indicator').fadeIn('slow');
			return true;
		}
		return false;
	}
	$('#new_invoice_section .box form, #edit_invoice_section .box form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_invoice,
			rules: ['required,invoice_id,', 'required,client_id,', 'valid_date,month,day,year,any_date,']
		});
	});
	$('#new_estimate_section .box form, #edit_estimate_section .box form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_invoice,
			rules: ['required,estimate_id,', 'required,client_id,', 'valid_date,month,day,year,any_date,']
		});
	});
	function add_client(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
			$(errorInfo[i][0]).parents('.select_wrapper').addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#new_client_dialog .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('#new_client_dialog form').ajaxSubmit(function () {
				if ($('#new_invoice_section').length) {
					$('#update_clients').load('invoice #update_clients', function () {
						hide_dialog();
					});
					$('#update_new_client_dialog').load('invoice #update_new_client_dialog');
				}
				else if ($('#edit_invoice_section').length) {
					$('#update_clients').load('invoice/edit/' + $('.box').attr('id') + ' #update_clients', function () {
						hide_dialog();
					});
					$('#update_new_client_dialog').load('invoice/edit/' + $('.box').attr('id') + ' #update_new_client_dialog');
				}
				else if ($('#new_recurring_section').length) {
					$('#update_clients').load('recurring #update_clients', function () {
						hide_dialog();
					});
					$('#update_new_client_dialog').load('recurring #update_new_client_dialog');
				}
				else if ($('#edit_recurring_section').length) {
					$('#update_clients').load('recurring/edit/' + $('.box').attr('id') + ' #update_clients', function () {
						hide_dialog();
					});
					$('#update_new_client_dialog').load('recurring/edit/' + $('.box').attr('id') + ' #update_new_client_dialog');
				}
			});
		}
		return false;
	}
	$('#new_client_dialog form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_client,
			rules: ['required,name,', 'required,email,', 'valid_email,email,']
		});
	});
	function add_project(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
			$(errorInfo[i][0]).parents('.select_wrapper').addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#new_project_dialog .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('#new_project_dialog form').ajaxSubmit(function () {
				if ($('#new_invoice_section').length) {
					$('#update_projects').load('invoice #update_projects', function () {
						hide_dialog();
					});
					$('#update_new_project_dialog').load('invoice #update_new_project_dialog');
				}
				else if ($('#edit_invoice_section').length) {
					$('#update_projects').load('invoice/edit/' + $('.box').attr('id') + ' #update_projects', function () {
						hide_dialog();
					});
					$('#update_new_project_dialog').load('invoice/edit/' + $('.box').attr('id') + ' #update_new_project_dialog');
				}
				else if ($('#edit_recurring_section').length) {
					$('#update_projects').load('recurring/edit/' + $('.box').attr('id') + ' #update_projects', function () {
						hide_dialog();
					});
					$('#update_new_project_dialog').load('recurring/edit/' + $('.box').attr('id') + ' #update_new_project_dialog');
				}
			});
		}
		return false;
	}
	$('#new_project_dialog form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_project,
			rules: ['required,name,']
		});
	});
	function add(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
		}
		if (errorInfo.length == 0) {
			$('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('.indicator').fadeIn('slow');
			if ($('.content').hasClass('edit_section')) {
				return true;
			}
			else {
				$('form').ajaxSubmit(function () {
					$('.content').load($('#nav .current').attr('id') + ' .content', function () {
						$('.title').after('<span class="indicator"></span>');
						$('.indicator').show().fadeOut('slow');
						tips();
					});
				});
			}
		}
		return false;
	}
	$('#new_project_section form, #edit_project_section form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add,
			rules: ['required,name,']
		});
	});
	$('#new_item_section form, #edit_item_section form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add,
			rules: ['required,description,', 'required,qty,', 'required,price,']
		});
	});
	$('#new_client_section form, #edit_client_section form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add,
			rules: ['required,name,', 'required,email,', 'valid_email,email,']
		});
	});
	$('#insert_project').livequery('click', function () {
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#insert_project_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		$('#insert_menu').hide();
		return false;
	});
	$('#insert_item').livequery('click', function () {
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#insert_item_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		$('#insert_menu').hide();
		return false;
	});
	$('#insert_option_item').livequery('click', function () {
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#insert_item_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		$('#insert_menu').hide();
		return false;
	});
	$('.show_address').livequery(function () {
		$(this).toggle(function () {
			$(this).addClass('hide');
			/*$(this).parents('.row').css({
				"height": "auto"
			});
			$(this).parents('.company').css({
				"height": "auto"
			});*/
			$(this).next('.address').show();
		},
		function () {
			$(this).removeClass('hide');
			/*$(this).parents('.row').css({
				"height": "18px"
			});
			$(this).parents('.company').css({
				"height": "20px"
			});*/
			$(this).next('.address').hide();
		});
	});
	$('.remove_payment').livequery('click', function () {
		$(this).addClass('pressed');
		var row = $(this).parents('.row');
		$.post('invoice/remove_payment/' + $(this).attr('id'), function () {
			row.fadeOut('slow');
			//$('#update_sidebar').load($('.sidebar').attr('id') + ' #update_sidebar');
			$('#update_invoice').load('invoice/view/' + $('.sidebar').attr('id') + ' #update_invoice');
			$('#update_payment_dialog').load('invoice/view/' + $('.sidebar').attr('id') + ' #update_payment_dialog');
		});
		return false;
	});
	$('#insert_line').livequery('click', function () {
		//var date = new Date();
		var len = $('.line').length;
		var increase = len++;
		var price = $('.line .price:first input').val();
		
		if (len) {
			var line_or_bar = $('.line:last');
		}
		else {
			var line_or_bar = $('li#bar');
		}
		line_or_bar.after('<li class="line"><a href="#" class="remove_line">Remove Line</a><span class="qty"><input type="text" name="line[' + increase + '][qty]" class="field" value="1" /><div class="select_wrapper"><select name="line[' + increase + '][kind]" class="select"><option value="hour">hour</option><option value="day">day</option><option value="service">service</option><option value="product">product</option></select></div></span><span class="description"><textarea name="line[' + increase + '][description]" class="textarea"></textarea></span><span class="price"><input type="text" name="line[' + increase + '][price]" class="field" value="' + price + '"/></span><span class="total"><span class="total_line">0.00</span></span></li>');
		$('#insert').removeClass('pressed');
		$('#insert_menu').hide();
		return false;
	});
	$('#insert_new_option').livequery('click', function () {
		//var date = new Date();
		var len = $('.option').length;
		var increase = len++;
		var price = $('.line .price:first input').val();
		
		if (len) {
			var option_or_bar = $('.option:last');
		}
		else {
			var option_or_bar = $('li#option_bar');
		}
		
		option_or_bar.after('<li class="option"><a href="#" class="remove_option">Remove Option</a><span class="qty"><input type="text" name="option[' + increase + '][qty]" class="field" value="1" /><div class="select_wrapper"><select name="option[' + increase + '][kind]" class="select"><option value="hour">hour</option><option value="day">day</option><option value="service">service</option><option value="product">product</option></select></div></span><span class="description"><textarea name="option[' + increase + '][description]" class="textarea"></textarea></span><span class="price"><input type="text" name="option[' + increase + '][price]" class="field" value="' + price + '"/></span><span class="total"><span class="total_line">0.00</span></span></li>');
		$('#insert_option').removeClass('pressed');
		$('#insert_option_menu').hide();
		return false;
	});
	$('#insert_project_dialog .button').livequery('click', function () {
		$(this).attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$.get('invoice/insert_project/' + $('#insert_project_dialog .select').val(), function (data) {
			$('#line_part ul:first').append(data);
			$('#insert_project_dialog .select').val('');
			$('#insert_project_dialog .select').prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
			hide_dialog();
			calculate();
		});
		return false;
	});
	$('#insert_item_dialog .button').livequery('click', function () {
		$(this).attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$.get('invoice/insert_item/' + $('#insert_item_dialog .select').val() + '/' + $('#line_part li').length, function (data) {
			$('#line_part ul:first').append(data);
			$('#insert_item_dialog .select').val('');
			$('#insert_item_dialog .select').prev('span').replaceWith('<span>' + $(this).find('option:selected').text() + '</span>');
			hide_dialog();
			calculate();
		});
		return false;
	});
	$('#insert_project_dialog .select').livequery('change', function () {
		if ($(this).val() == "") {
			$('#insert_project_dialog .button').addClass('disabled').attr('disabled', 'disabled');
		}
		else {
			$('#insert_project_dialog .button').removeClass('disabled').removeAttr("disabled");
		}
	});
	$('#insert_item_dialog .select').livequery('change', function () {
		if ($(this).val() == "") {
			$('#insert_item_dialog .button').addClass('disabled').attr('disabled', 'disabled');
		}
		else {
			$('#insert_item_dialog .button').removeClass('disabled').removeAttr("disabled");
		}
	});
	$('#insert').livequery('click', function () {
		$(this).addClass('pressed');
		$("#insert_menu").show();
		return false;
	});
	$('#insert_option').livequery('click', function () {
		$(this).addClass('pressed');
		$("#insert_option_menu").show();
		return false;
	});
	$('#insert_menu, #insert_option_menu').livequery('click', function (e) {
		e.stopPropagation();
	});
	$(document).livequery('click', function () {
		$('#insert').removeClass('pressed');
		$('#insert_menu').hide();
		$('#insert_option').removeClass('pressed');
		$('#insert_option_menu').hide();
	});
	$('#color_theme_holder li').livequery('click', function () {
		$('#color_theme_holder li').removeClass('selected');
		$(this).addClass('selected');
		$('#color_theme').val($(this).find('span:eq(1)').attr('id'));
		return false;
	});
	$('#project_select').livequery('change', function () {
		if ($(this).val() == 'new_project') {
			$('#head').before('<div id="overlay"></div>');
			$('#overlay').css({
				opacity: 0
			}).fadeTo('fast', 0.80, function () {
				$('#new_project_dialog').show().animate({
					top: "0px"
				},
				'fast');
			});
		}
	});
	$('#client_select').livequery('change', function () {
		if ($(this).val() == 'new_client') {
			$('#head').before('<div id="overlay"></div>');
			$('#overlay').css({
				opacity: 0
			}).fadeTo('fast', 0.80, function () {
				$('#new_client_dialog').show().animate({
					top: "0px"
				},
				'fast');
			});
		}
	});
	$('#new_client_dialog a.add_more').livequery(function () {
		$(this).toggle(function () {
			$(this).text('Hide more details');
			$('.dialog .more').slideDown('fast');
		},
		function () {
			$(this).text('Add more details…');
			$('.dialog .more').slideUp('fast');
		});
		return false;
	});
	$('#send_dialog a.add_more').livequery(function () {
		$(this).toggle(function () {
			$(this).text('Hide email message');
			$('.dialog .more').slideDown('fast');
		},
		function () {
			$(this).text('Edit email message…');
			$('.dialog .more').slideUp('fast');
		});
		return false;
	});
	$('#due').livequery('change', function () {
		if ($(this).val() == 'other') {
			$('#other').show();
			$('#other input').focus()
		}
		else {
			$('#other').hide();
		}
	});
	$('.remove_line').livequery('click', function () {
		$(this).addClass('pressed');
		var line = $(this).parents('.line');
		setTimeout(function () {
			line.remove();
			calculate();
		},
		60);
		return false;
	});
	$('.remove_option').livequery('click', function () {
		$(this).addClass('pressed');
		var option = $(this).parents('.option');
		setTimeout(function () {option.remove();},60);
		return false;
	});
	
	$('#line_part ul:first').sortable({
		forcePlaceholderSize: true,
		placeholder: 'ui-state-highlight',
		axis: 'y',
		items: 'li.line'
		//start: function() { console.log('start sortable'); }
		//axis: 'y',
		//containment: 'parent'//,
		//items: 'li.line'
	});
	$('#option_part ul:first').sortable({
		forcePlaceholderSize: true,
		placeholder: 'ui-state-highlight',
		axis: 'y',
		items: 'li.option'
		//start: function() { console.log('start sortable'); }
		//axis: 'y',
		//containment: 'parent'//,
		//items: 'li.line'
	});
	$('#options li.option input.checkbox').livequery('change', function () {
		if (this.checked) {
			$.get('estimate/accept_option/' + $(this).attr('value'), function () {
				
			});
		} else {
			$.get('estimate/refuse_option/' + $(this).attr('value'), function () {
				
			});
		}
	});
	/*$('#account_section #tab a:eq(0)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_account_details").show();
		return false;
	});
	$('#account_section #tab a:eq(1)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_subscription_plan").show();
		return false;
	});
	$('#account_section #tab a:eq(2)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_export_data").show();
		return false;
	});
	$('#account_section #tab a:eq(3)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_close_account").show();
		return false;
	});*/
	$('#settings_section #tab a:eq(0)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_account_details").show();
		return false;
	});
	$('#settings_section #tab a:eq(1)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_general_settings").show();
		return false;
	});
	$('#settings_section #tab a:eq(2)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_invoice_settings").show();
		return false;
	});
	$('#settings_section #tab a:eq(3)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_email_message_settings").show();
		return false;
	});
	$('#settings_section #tab a:eq(4)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_paypal_intergration_settings").show();
		return false;
	});
	/*$('#settings_section #tab a:eq(5)').livequery('click', function () {
		$('.box').hide();
		$('#tab a').removeClass('current');
		$(this).addClass('current');
		$("#show_basecamp_intergration_settings").show();
		return false;
	});*/
	var message = '<div class="message" id="green"><p>Your changes were successfully saved.</p></div>';
	$('#show_general_settings form').livequery('submit', function () {
		loading();
		$(this).ajaxSubmit(function () {
			if ($('input[name="application_logo"]').val()) {
				$('#head_inner').load('setting #head_inner');
				$('#application_logo').load('setting #application_logo', function () {
					$('#show_general_settings .information').before(message);
					show_message();
				});
			}
			else {
				$('#show_general_settings .information').before(message);
				show_message();
			}
		});
		return false;
	});
	$('#show_invoice_settings form').livequery('submit', function () {
		loading();
		$(this).ajaxSubmit(function () {
			if ($('input[name="invoice_logo"]').val()) {
				$('#invoice_logo').load('setting #invoice_logo', function () {
					$('#show_invoice_settings .information').before(message);
					show_message();
				});
			}
			else {
				$('#show_invoice_settings .information').before(message);
				show_message();
			}
		});
		return false;
	});
	$('#show_email_message_settings form').livequery('submit', function () {
		loading();
		$(this).ajaxSubmit(function () {
			$('#show_email_message_settings .information').before(message);
			show_message();
		});
		return false;
	});
	$('#show_paypal_intergration_settings form').livequery('submit', function () {
		loading();
		$(this).ajaxSubmit(function () {
			$('#show_paypal_intergration_settings .information').before(message);
			show_message();
		});
		return false;
	});
	/*$('#show_basecamp_intergration_settings form').livequery('submit', function () {
		loading();
		$(this).ajaxSubmit(function () {
			$('#show_basecamp_intergration_settings .information').before(message);
			show_message();
		});
		return false;
	});*/
	function loading() {
		$('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$('.indicator').fadeIn('slow');
	}
	function show_message() {
		$('html, body').animate({
			scrollTop: 0
		},
		'slow');
		$('.message').hide().fadeIn('slow');
		$('.indicator').fadeOut('slow');
		$('.button').removeAttr('disabled', 'disabled').removeClass('disabled').val('Save Changes');
		setTimeout(function () {
			$('.message').fadeOut('slow', function () {
				$(this).remove();
			});
		},
		3000)
	}
	function account_details(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#show_account_details').find('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('.indicator').fadeIn('slow');
			$('#show_account_details form').ajaxSubmit(function () {
				$('#head_inner').load('user/edit #head_inner');
				$('#logo').text($('input[name="name"]').val());
				$('#show_account_details .information').before(message);
				show_message();
			});
		}
		return false;
	}
	$('#show_account_details form').livequery(function () {
		$(this).RSV({
			customErrorHandler: account_details,
			rules: ['required,name,']
		});
	});
	function close_account(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).parents('.checkbox_wrapper').addClass('required');
		}
		if (errorInfo.length == 0) {
			$('#show_close_account .button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			return true;
		}
		return false;
	}
	$('#show_close_account form').livequery(function () {
		$(this).RSV({
			customErrorHandler: close_account,
			rules: ['required,confirmation,']
		});
	});
	$('.message #open_thank_you_dialog').livequery('click', function () {
		$('#thank_you').trigger('click');
		return false;
	});
	$('.message #send_no_thank_you').livequery('click', function () {
		$(this).parents('.message').fadeOut('slow');
		$.post('invoice/no_thank_you/' + $('.sidebar').attr('id'));
		return false;
	});
	$('.message #open_send_reminder_dialog').livequery('click', function () {
		$('#reminder').trigger('click');
		return false;
	});
	$('.message #send_no_reminder').livequery('click', function () {
		$(this).parents('.message').fadeOut('slow');
		$.post('invoice/no_reminder/' + $('.sidebar').attr('id'));
		return false;
	});
	$('.slider_wrapper').livequery(function () {
		$(this).slider({
			handle: '.handle',
			animate: true,
			slide: function () {
				$(this).find('.on, .off').css('opacity', 0.6);
				if ($(this).find('.handle').position().left > 31) {
					$(this).addClass('ison');
					$(this).find('.on').css('opacity', 1);
				}
				else {
					$(this).removeClass('ison');
					$(this).find('.on').css('opacity', 0.6);
				}
			},
			stop: function () {
				if ($(this).find('.handle').hasClass('left')) {
					if ($(this).find('.handle').position().left == 0) {
						$(this).find('.handle').removeClass('left');
						$(this).find('.on, .off').css('opacity', 1);
						$('.indicator').fadeIn("slow");
						$.post('recurring/off/' + $(this).parents('.row').attr('id'), function () {
							$('.indicator').fadeOut("slow");
						});
					}
					else {
						$(this).find('.handle').animate({
							left: 32
						},
						'fast');
						$(this).find('.on, .off').css('opacity', 1);
					}
				}
				else {
					if ($(this).find('.handle').position().left == 32) {
						$(this).find('.handle').addClass('left');
						$(this).find('.on, .off').css('opacity', 1);
						$('.indicator').fadeIn("slow");
						$.post('recurring/on/' + $(this).parents('.row').attr('id'), function () {
							$('.indicator').fadeOut("slow");
						});
					}
					else {
						$(this).find('.handle').animate({
							left: 0
						},
						'fast');
						$(this).find('.handle').removeClass('left');
						$(this).find('.on, .off').css('opacity', 1);
					}
				}
			}
		});
	});
	function add_user(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
		}
		if (errorInfo.length == 0) {
			$('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('.indicator').fadeIn('slow');
			if ($('.content').hasClass('edit_section')) {
				return true;
			}
			else {
				$('form').ajaxSubmit(function () {
					$('.content').load('user .content', function () {
						$('.title').after('<span class="indicator"></span>');
						$('.indicator').show().fadeOut('slow');
						tips();
					});
				});
			}
		}
		return false;
	}
	/*$('#new_user_section form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_user,
			rules: ['required,name,', 'required,email,', 'valid_email,email,', 'required,username,', 'required,password,']
		});
	});
	$('#edit_user_section form').livequery(function () {
		$(this).RSV({
			customErrorHandler: add_user,
			rules: ['required,name,', 'required,email,', 'valid_email,email,', 'required,username,']
		});
	});*/
	$('#users_section .remove').livequery('click', function () {
		$('.main_section').after('<div class="dialog remove_from_users" id="remove_dialog"><div class="confirm">Are you sure you want to remove this user?</div><div class="control"><input type="button" class="button yes" id="' + $(this).parents('.row').attr('id') + '" value="Yes" /><a class="small_button">Cancel</a></div></div>');
		$(this).addClass('pressed');
		$('.row').removeClass('to_be_removed');
		$(this).parents('.row').addClass('to_be_removed');
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#remove_dialog').show().animate({
				top: "0px"
			},
			'fast');
		});
		return false;
	});
	$('.remove_from_users .button').livequery('click', function () {
		$(this).attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$('.indicator').fadeIn("slow");
		if ($('.segment').attr('id')) {
			var segment = '/' + $('.segment').attr('id');
		}
		else {
			var segment = '/';
		}
		document.location  = 'user/remove/' + $(this).attr('id');
		
		/*if ($('#pagination').size() == '1') {
			$.post('user/remove/' + $(this).attr('id'), function () {
				$('.rows').load('user' + segment + ' .rows', function () {
					hide_dialog();
					$('.indicator').fadeOut("slow");
				});
			});
		}
		else {
			$('.to_be_removed').remove();
			hide_dialog();
			$('.indicator').fadeOut('slow');
			$('.row').removeClass('alt');
			$('.row:odd').addClass('alt');
			$.post('user/remove/' + $(this).attr('id'));
			if ($('.row').size() == '0') {
				$('.rows').empty().append('<li class="row"><span class="empty">No users where found.</span></li>');
			}
		}*/
		return false;
	});
	function profile(f, errorInfo) {
		for (var i = 0; i < errorInfo.length; i++) {
			$(errorInfo[i][0]).focus().addClass('required');
		}
		if (errorInfo.length == 0) {
			$('.button').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$('.indicator').fadeIn('slow');
			$('#profile_section form').ajaxSubmit(function () {
				$('.inline:first').before(message);
				show_message();
			});
		}
		return false;
	}
	$('#profile_section form').livequery(function () {
		$(this).RSV({
			customErrorHandler: profile,
			rules: ['required,name,', 'required,email,', 'valid_email,email,', 'required,username,']
		});
	});
	/*$('#new_client_dialog #import_from_basecamp').livequery('click', function () {
		$('#update_new_client').empty().append('<span class="loading">Loading companies…</span>');
		$.get('client/company/', function (data) {
			$('#update_new_client').empty().append(data);
		});
		return false;
	});
	$('#select_company').livequery('change', function () {
		if ($(this).val() == '') {
			$('#import_basecamp_client').attr('disabled', 'disabled').addClass('disabled');
			$('#update_contact').empty();
		}
		else {
			$('#import_basecamp_client').attr('disabled', 'disabled').addClass('disabled');
			$('#update_contact').empty().append('<span class="loading space">Loading contacts…</span>');
			$.get('client/contact/' + $(this).val(), function (data) {
				$('#update_contact').empty().append(data);
			});
		}
		return false;
	});
	$('#select_contact').livequery('change', function () {
		if ($(this).val() == '') {
			$('#import_basecamp_client').attr('disabled', 'disabled').addClass('disabled');
		}
		else {
			$('#import_basecamp_client').removeAttr('disabled', 'disabled').removeClass('disabled');
		}
		return false;
	});
	$('#import_basecamp_client').livequery('click', function () {
		$(this).attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$.get('client/import_client_dialog/' + $('#select_company').val() + '/' + $('#select_contact').val(), function (data) {
			$('#update_new_client').empty().append(data);
		});
		return false;
	});
	$('.basecamp_cancel').livequery('click', function () {
		if ($('#new_client_section').length) {
			hide_dialog();
		}
		else if ($('#edit_client_section').length) {
			hide_dialog();
		}
		else {
			$('#update_new_client').empty().append('<span class="loading">Loading…</span>');
			$('#update_new_client').load('invoice #update_new_client');
		}
		return false;
	});
	$('#insert_basecamp').livequery('click', function () {
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#insert_from_basecamp_dialog').show().animate({
				top: "0px"
			},
			'fast');
			$('#update_project').empty().append('<span class="loading">Loading projects…</span>');
			$.get('invoice/project/', function (data) {
				$('#update_project').empty().append(data);
			});
		});
		$('#insert_menu').hide();
		return false;
	});
	$('#select_project').livequery('change', function () {
		if ($(this).val() == '') {
			$('#insert_from_basecamp_dialog .button').attr('disabled', 'disabled').addClass('disabled');
			$('#update_time_entry').empty();
		}
		else {
			$('#insert_from_basecamp_dialog .button').attr('disabled', 'disabled').addClass('disabled');
			$('#update_time_entry').empty().append('<span class="loading space">Loading time entries…</span>');
			$.get('invoice/time_entry/' + $(this).val(), function (data) {
				$('#update_time_entry').empty().append(data);
			});
		}
		return false;
	});
	$('#select_time_entry').livequery('change', function () {
		if ($(this).val() == '') {
			$('#insert_basecamp_project').attr('disabled', 'disabled').addClass('disabled');
		}
		else {
			$('#insert_basecamp_project').removeAttr('disabled', 'disabled').removeClass('disabled');
		}
		return false;
	});
	$('#insert_basecamp_project').livequery('click', function () {
		if ($('#select_time_entry').val() == 'all') {
			$('#insert_basecamp_project').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$.get('invoice/insert_all_entries/' + $('#select_project').val() + '/' + $('#rate').val().replace(/ | /, '').replace(/,| /, ''), function (data) {
				$('#line_part ul:first').append(data);
				hide_dialog();
				calculate();
			});
		}
		else {
			$('#insert_basecamp_project').attr('disabled', 'disabled').addClass('disabled').val('Loading…');
			$.get('invoice/insert_entry/' + $('#select_time_entry').val() + '/' + $('#rate').val().replace(/ | /, '').replace(/,| /, ''), function (data) {
				$('#line_part ul:first').append(data);
				hide_dialog();
				calculate();
			});
		}
		return false;
	});
	$('#import_from_basecamp').livequery('click', function () {
		$('#head').before('<div id="overlay"></div>');
		$('#overlay').css({
			opacity: 0
		}).fadeTo('fast', 0.80, function () {
			$('#import_from_basecamp_dialog').show().animate({
				top: "0px"
			},
			'fast');
			$('#update_company').empty().append('<span class="loading">Loading companies…</span>');
			$.get('client/company/', function (data) {
				$('#update_company').empty().append(data);
			});
		});
		return false;
	});
	$('#select_company').livequery('change', function () {
		if ($(this).val() == '') {
			$('#import_from_basecamp_dialog .button').attr('disabled', 'disabled').addClass('disabled');
			$('#update_contact').empty();
		}
		else {
			$('#import_from_basecamp_dialog .button').attr('disabled', 'disabled').addClass('disabled');
			$('#update_contact').empty().append('<span class="loading space">Loading contacts…</span>');
			$.get('client/contact/' + $(this).val(), function (data) {
				$('#update_contact').empty().append(data);
			});
		}
		return false;
	});
	$('#select_contact').livequery('change', function () {
		if ($(this).val() == '') {
			$('#import_from_basecamp_dialog .button').attr('disabled', 'disabled').addClass('disabled');
		}
		else {
			$('#import_from_basecamp_dialog .button').removeAttr('disabled', 'disabled').removeClass('disabled');
		}
		return false;
	});
	$('#import_from_basecamp_dialog .button').livequery('click', function () {
		$(this).attr('disabled', 'disabled').addClass('disabled').val('Loading…');
		$('.indicator').fadeIn("slow");
		$.get('client/import_client/' + $('#select_company').val() + '/' + $('#select_contact').val(), function (data) {
			$('#update_client').empty().append(data);
			$('.indicator').fadeOut("slow");
			hide_dialog();
			setTimeout(function () {
				$('#import_from_basecamp_dialog .button').val('Import');
			},
			2000)
		});
		return false;
	});*/
	$('.box #estimate_option').livequery(function () {
		$(this).toggle(function () {
			$('#option_part').show();
		},
		function () {
			$('#option_part').hide();
		});
		return false;
	});
});
function verifySubtotal(){
		if ($('#tax_status').is(':checked')) {
			$('.subtotal_display').show();
		}
		else if ($('#tax2_status').is(':checked')) {
			$('.subtotal_display').show();
		}
		else if ($('#shipping_status').is(':checked')) {
			$('.subtotal_display').show();
		}
		else if ($('#discount_status').is(':checked')) {
			$('.subtotal_display').show();
		}
		else {
			$('.subtotal_display').hide();
		}
	}