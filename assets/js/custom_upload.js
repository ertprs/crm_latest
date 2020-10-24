var fileobj;
function upload_file(e) {
    e.preventDefault();
    ajax_file_upload(e.dataTransfer.files);
}
 
function file_explorer() {
    document.getElementById('selectfile').click();
    document.getElementById('selectfile').onchange = function() {
        files = document.getElementById('selectfile').files;
        ajax_file_upload(files);
    };
}
 
function ajax_file_upload(file_obj) {
    if(file_obj != undefined) {
        var form_data = new FormData();
        for(i=0; i<file_obj.length; i++) {  
            form_data.append('file[]', file_obj[i]);  
        }
		 var count = $('.container .content').length;
                                count = Number(count) + 1;
								//alert(count);
		form_data.append('request', '1');  
		form_data.append('count', count); 
        $.ajax({
            type: 'POST',
            url: ''+BASE_URL+'/estimations/drop_file',
            contentType: false,
            processData: false,
            data: form_data,
            success:function(response) {
               // alert(response);
			   //$('#imageupload').append(response);
			   $('.container').append(response);
                $('#selectfile').val('');

            }
        });
		
		
    }
}

 // Remove file
                $('.container').on('click','.content .delete',function(){
                   
                    var id = this.id;
                    var split_id = id.split('_');
                    var num = split_id[1];

                     // Get image source
                    var imgElement_src = $( '.content_img_'+num+' img' ).attr("src");
                     
                    var deleteFile = confirm("Do you really want to Delete?");
                    if (deleteFile == true) {
                        // AJAX request
                        $.ajax({
                           url: ''+BASE_URL+'/estimations/drop_file',
                           type: 'post',
                           data: {path: imgElement_src,request: 2},
                           success: function(response){
                         
                                // Remove <div >
                                if(response == 1){
                                    $('#content_'+num).remove();
                                }

                           }
                        });
                    }
                });

