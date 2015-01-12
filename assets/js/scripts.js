( function( $ ) {
    $(document).ready(function(){

       /* $('.back-to-top').click(function(e){
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, 'slow');
        });*/

    	$(':file').filestyle();

        $('a.prevented').click(function(e){
            e.preventDefault();
        });

        $('.dir-select').click(function(e){
            var selectInput = $(this).attr('id');
            selectInput = selectInput.replace('dir-', '');
            $('select[name="opmitize-directory"]').val(selectInput);
            $('.opmitize-directory-label').text(selectInput);
        });

        $.getJSON("json.php", function (result) {
        	// console.log('result json: ' + result);

        	var chartjsData = [];
        	var arr = [];
        	for (var i = 0; i < result.length; i++) {
        	    chartjsData.push(result[i].value);  
        	    arr.push({
        	        value: result[i].value, 
        	        color: result[i].color,
        	        highlight: result[i].highlight,
        	        label: result[i].label
        	    });
        	}

			tempData = arr;

        	options = {
        	    //Boolean - Show a backdrop to the scale label
        	    scaleShowLabelBackdrop: true,
        	    //String - The colour of the label backdrop
        	    scaleBackdropColor: "rgba(255,255,255,0.75)",
        	    // Boolean - Whether the scale should begin at zero
        	    scaleBeginAtZero: true,
        	    //Number - The backdrop padding above & below the label in pixels
        	    scaleBackdropPaddingY: 2,
        	    //Number - The backdrop padding to the side of the label in pixels
        	    scaleBackdropPaddingX: 2,
        	    //Boolean - Show line for each value in the scale
        	    scaleShowLine: true,
        	    //Boolean - Stroke a line around each segment in the chart
        	    segmentShowStroke: true,
        	    //String - The colour of the stroke on each segement.
        	    segmentStrokeColor: "#fff",
        	    //Number - The width of the stroke value in pixels
        	    segmentStrokeWidth: 2,
        	    //Number - Amount of animation steps
        	    animationSteps: 100,
        	    //String - Animation easing effect.
        	    animationEasing: "easeOutBounce",
        	    //Boolean - Whether to animate the rotation of the chart
        	    animateRotate: true,
        	    //Boolean - Whether to animate scaling the chart from the centre
        	    animateScale: false,
        	    //String - A legend template
        	    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"

        	};
            if( $('#galdariot-chart').length ){
            	// Get context with jQuery - using jQuery's .get() method.
            	var ctx = $('#galdariot-chart').get(0).getContext("2d");
            	// This will get the first returned node in the jQuery collection.
            	var theChart = new Chart(ctx).Doughnut(tempData, options);
            }
    	});
    });

    $(window).load(function() {
        if( $('#table-of-images').length ){
            setTimeout(function(){ 
                $('.loading').hide();; 
                $('#table-of-images').removeClass('loading-list');
                $('html, body').animate({scrollTop: $(document).height()}, 'slow');
            }, 1000);
        }
    });

    /*
     *	Credits to Abandon IE
     *	http://abandon.ie/notebook/simple-file-uploads-using-jquery-ajax
     *
	 */

    // Variable to store your files
    var files;
    var uploadForm = $('#upload-form');
    var inputFile = $('#upload-folder-input');
    var progressBox = $('#progress-box');


    // Add events
    inputFile.on('change', prepareUpload);

    // Check Extension
    function checkFileType(){
    	var ext = inputFile.val().split('.').pop().toLowerCase();
    	if( ext != '' && $.inArray(ext, ['rar','zip']) == -1) {
    	    alert('Invalid extension!');
    	    clearForm();
    	    return false;
    	}else{
    		return true;
    	}
    }

    // Grab the files and set them to our variable
    function prepareUpload(event){
  		if( checkFileType() ){
  			files = event.target.files;
  	  		uploadForm.find('button.btn-upload').addClass('actived');
  	  		$('#progress-box .progress-bar').css('width', '0');

  	  		/*var fileInfo = $(inputFile)[0].files[0];
  	  		console.log( fileInfo.name );*/
  		}

      	// console.log( fileInfo );

    }

    uploadForm.on('submit', uploadFiles);

    // Catch the form submit and upload the files
    function uploadFiles(event){
      	event.stopPropagation(); // Stop stuff happening
        event.preventDefault(); // Totally stop stuff happening

        $('.progress-info, #progress-box .progress-bar').removeClass('sucess');
        $('.progress-info, #progress-box .progress-bar').removeClass('error');

        // Create a formdata object and add the files
        var data = new FormData();
        $.each(files, function(key, value) {
            data.append(key, value);
        });

        $.ajax({
        	xhr: function() {

        		var fileName = $(inputFile)[0].files[0];
        		$('.progress-info .file-name').text( fileName.name );

        		progressBox.addClass('active-bar');
        	    var xhr = new window.XMLHttpRequest();

        	    xhr.upload.addEventListener("progress", function(evt) {
        	      if (evt.lengthComputable) {
        	        var percentComplete = evt.loaded / evt.total;
        	        percentComplete = parseInt(percentComplete * 100);
        	        // console.log(percentComplete);
        	        OnProgress(percentComplete);

        	      }
        	    }, false);

        	    return xhr;
    	  	},
            url: 'upload.php?files',
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false, // Set content type to false as jQuery will tell the server its a query string request
            success: function(data, textStatus, jqXHR) {
                if(typeof data.error === 'undefined') {
                    // Success so call function to process the form
                    submitForm(event, data);
                    $('.progress-info, #progress-box .progress-bar').removeClass('error');
                }
                else {
                    // Handle errors here
                    console.log('ERROR DURING UPLOAD: ' + data.error);
                    $('h5 span.progress-status').text('Transferência de arquivos cancelada');
                    $('.progress-info, #progress-box .progress-bar').addClass('error');
                }
                clearForm();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors here
                console.log('ERROR ON UPLOAD: ' + textStatus);
                console.log('ERROR THROWN: ' + errorThrown);
                clearForm();
            }
        });
    }

    function submitForm(event, data) {
      // Create a jQuery object from the form
        $form = $(event.target);

        // Serialize the form data
        var formData = $form.serialize();

        // You should sterilise the file names
        $.each(data.files, function(key, value) {
            formData = formData + '&filenames[]=' + value;
        });

        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            cache: false,
            dataType: 'json',
            success: function(data, textStatus, jqXHR) {
                if(typeof data.error === 'undefined') {
                    // Success so call function to process the form
                    console.log('SUCCESS: ' + data.success);
                    $('h5 span.progress-status').text('Transferência de arquivos finalizada');
                    $('.progress-info, #progress-box .progress-bar').removeClass('error');
                    $('.progress-info, #progress-box .progress-bar').addClass('sucess');
                    // progressBox.removeClass('active-bar'); progress-status
                }
                else {
                    // Handle errors here
                    console.log('ERROR SUBMITING FORM: ' + data.error);
                    $('h5 span.progress-status').text('Transferência de arquivos cancelada');
                    $('.progress-info, #progress-box .progress-bar').removeClass('sucess');
                    $('.progress-info, #progress-box .progress-bar').addClass('error');
                }
                clearForm();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors here
                console.log('AJAX ERROR: ' + textStatus);
                $('h5 span.progress-status').text('Transferência de arquivos cancelada');
                $('.progress-info, #progress-box .progress-bar').addClass('sucess');
                clearForm();
            },
            complete: function() {
            	console.log('Upload complete!');
            	clearForm();
                // STOP LOADING SPINNER
            }
        });
    }

    function clearForm() {
    	inputFile.filestyle('clear');
    	uploadForm.find('.badge').remove();

    	setTimeout(function() {
    		progressBox.removeClass('active-bar');
		}, 5000);
    }

    function OnProgress(percentComplete) {
        //Progress bar
        // $('#progressbox').show();
        $('#progress-box .progress-bar').width(percentComplete + '%'); //update progressbar percent complete
        $('#statustxt').html(percentComplete + '%'); //update status text
        if(percentComplete>50)
            {
                $('#statustxt').css('color','#000'); //change status text to white after 50%
            }
    }

} )( jQuery );