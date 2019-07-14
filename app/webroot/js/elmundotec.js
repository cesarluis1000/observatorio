 $(function () {
    var date_input=$('input[placeholder="YYYY-MM-DD HH:mm:ss"]'); //our date input has the name "date"
    var options={
    	format: 'YYYY-MM-DD HH:mm:ss',
    	locale: 'es'
      };
    date_input.datetimepicker(options);
    
    var date_input=$('input[placeholder="YYYY-MM-DD"]'); //our date input has the name "date"
    var options={
    	format: 'YYYY-MM-DD',
    	locale: 'es'
      };
    date_input.datetimepicker(options);   
});