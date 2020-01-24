$(document).ready(function() {

      
    function pageRouting(e) {
    	e.preventDefault();
    	var link = $(this).attr('target-link');
    	var groupId = $(this).attr('href').split('group/');
    	var groupTariffIds = $(this).attr('href').split('/');
	      if(link == 'home') {
	      	$.router.set('#/');
	      }
	      if(link == 'group') {
	      	$.router.set('#/group/'+groupId[1]);
	      }
	      if(link == 'group-tariff') {
	      	$.router.set('#/tariff/'+groupTariffIds[2]+'/'+groupTariffIds[3]);
	      }
	      
    }
  
      
    $.route('/',function(e) {

    	if(e.hash) {
    		$.ajax({
		    	type: 'GET',
		    	url: 'app/',
		    	success: function(data) {
		    		$('#app').html(data);
		    		$('a[target-link]').bind('click', pageRouting);
		    	}
		    });

    	}
   
    });



     $.route('/group/:id', function(e, params) {
	    	 	if(e.hash) {
	    	 	  $.get(
	    	 	  	 'app/',
	    	 	     {
	    	 	     	group_id: params['id']
	    	 	  	 }, onAjaxSuccess);

	    	 	  function onAjaxSuccess(data) {
	    	 	  	 $('#app').html(data);
	    	 	  	 $('a[target-link]').bind('click', pageRouting);
	    	 	  }

	    	 	 
	    	   }
	  });
     $.route('/tariff/:group_id/:tariff_id', function(e, params) {

	     	  	 if(e.hash) {
	     	   	   $.get(
	     	   	   	 'app/',
	     	   	   	 {
	     	   	   	 	g_id: params['group_id'],
	     	   	   	 	t_id: params['tariff_id'] 
	     	   	   	 },
	     	   	   	 onAjaxSuccess
	     	   	   );

	     	   	   function onAjaxSuccess(data) {
	     	   	   	   $('#app').html(data);
	     	   	   	   $('a[target-link]').bind('click', pageRouting);
	     	   	   }
	     	   	   
	     	   }
	  	   
     });



    $.router.init();

    
    $(window).on('load', function() {
    	var urlItemLength = window.location['href'].split('/').length;
     	 if(urlItemLength <= 5) {
     	 	 $.router.set('#/');
     	 }
    });
    

   
  

});