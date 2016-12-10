jQuery(document).ready(function(e){
	 convertor = new KanaMaker();
	 jQuery("#billing_last_name").keyup(function(e){
		if(convertor != null){
            convertor.eval(e);
            jQuery("#billing_kana_lastname").val(convertor.Kana());            
        }else if($("#billing_last_name").val() == ""){
            convertor = new KanaMaker(); //reset
        }
	 });
	  jQuery("#billing_first_name").keyup(function(e){
		if(convertor != null){
            convertor.eval(e);
            jQuery("#billing_kana_firstname").val(convertor.Kana());            
        }else if($("#billing_first_name").val() == ""){
            convertor = new KanaMaker(); //reset
        }
	 });
	 
	  jQuery("#shipping_last_name").keyup(function(e){
		if(convertor != null){
            convertor.eval(e);
            jQuery("#shipping_kana_lastname").val(convertor.Kana());            
        }else if($("#shipping_last_name").val() == ""){
            convertor = new KanaMaker(); //reset
        }
	 });
	  jQuery("#shipping_first_name").keyup(function(e){
		if(convertor != null){
            convertor.eval(e);
            jQuery("#shipping_kana_firstname").val(convertor.Kana());            
        }else if($("#shipping_first_name").val() == ""){
            convertor = new KanaMaker(); //reset
        }
	 });
});