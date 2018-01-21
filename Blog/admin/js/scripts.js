$('#selectAllBoxes').click(function(event){
   if(this.checked){
       $('.checkBoxes').each(function(){
           this.checked=true;
       });
   }else{
       $('.checkBoxes').each(function(){
           this.checked=false;
       });
   }
});

//validation for form using bootstrapValidator
$(document).ready(function() {
    $('#addPost').bootstrapValidator({
        container:"#messages",
        //options for forms 
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {//needs name not id
            title: {
                validators: {
                    notEmpty: {
                        message: 'The title is required and should not be empty'
                    },
                    stringLength: {
                        max: 100,
                        message: 'The title must be less than 100 characters long'
                    },
                }
            },
            post_category_id: {
                validators: {
                    notEmpty: {
                        message: 'Select a category'
                    }
                }
            },
            status: {
                validators: {
                    notEmpty: {
                        message: 'Select Status'
                    }
                }
            },
            image: {
                validators: {
                    notEmpty: {
                        message: 'Select an Image'
                    }
                }
            },
            tags: {
                validators: {
                    notEmpty: {
                        message: 'Enter the appropriate tags'
                    }
                }
            },
            post_content: {
                validators: {
                    notEmpty: {
                        message: 'Enter content'
                    }
                }
            }
        }
    });
});

function loadUsersOnline(){
    //this is ajax call just to refresh the part of page
    $.get("functions.php?onlineusers=result",function(data){
       $('.usersonline').text(data); 
    });
}

setInterval(function(){
   loadUsersOnline(); 
},500);