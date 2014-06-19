// JavaScript Document
$(document).ready(function() {
	$('#new_estimate_section #client_select, #edit_estimate_section #client_select, #new_invoice_section #client_select, #edit_invoice_section #client_select').livequery('change', function() {
		if($(this).find("option[selected]").attr("data-tax1")){
			$("#tax_status").attr('checked','checked').parent().addClass("checked");
			$("#tax").val($(this).find("option[selected]").attr("data-tax1"));	
			$("#tax_name").val($(this).find("option[selected]").attr("data-tax1_name"));
			$('#tax, .tax_display, #tax_name').show();	
			$('.subtotal_display').show();
		}else{
			$("#tax_status").removeAttr('checked').parent().removeClass("checked");
			$("#tax").val('');	
			$("#tax_name").val('');
			$('#tax, .tax_display, #tax_name').hide();	
			verifySubtotal();
		}
		if($(this).find("option[selected]").attr("data-tax2")){
			$("#tax2_status").attr('checked','checked').parent().addClass("checked");
			$("#tax2").val($(this).find("option[selected]").attr("data-tax2"));	
			$("#tax2_name").val($(this).find("option[selected]").attr("data-tax2_name"));
			$('.tax2_display, #tax2_span').show();	
			$('.subtotal_display').show();
		}else{
			$("#tax2_status").removeAttr('checked').parent().removeClass("checked");
			$("#tax2").val('');	
			$("#tax2_name").val('');
			$('.tax2_display, #tax2_span').hide();	
			verifySubtotal();
		}
	});
});