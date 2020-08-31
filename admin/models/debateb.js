
jQuery(function() {
  
		

		document.formvalidator.setHandler('message',
        function (value) {

            regex=/^[a-zA-Z0-9\s']+$/;
            return regex.test(value);
        });
		
		   
       
});
