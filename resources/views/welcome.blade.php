<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <title>Input Json</title>
</head>

<body>
    <div class="container">
        <div id="json_message" align="left"><strong></strong><i hidden class="fas fa-times float-right"></i>
        </div>
        <h3 align="center">Json File Upload</h3>
        <form id="jsonForm" enctype="multipart/form-data" method="POST" action="{{route('json.import')}}">
            {{ csrf_field() }}
            <div class="form-group">
                <table class="table">
                    <tr>
                        <td width="40%" align="right"><label>Select File for Upload</label></td>
                        <td width="30">
                            <input type="file" name="select_file" />
                        </td>
                        <td width="30%" align="left">
                            <input type="submit" name="upload" class="btn btn-success" value="Upload">
                        </td>
                        <td width="30%" align="left">
                            <input type="email" name="email" class="btn btn-success">
                        </td>
                    </tr>
                    <tr>
                        <td width="40%" align="right"></td>
                        <td width="30"><span class="text-muted">.json File Only</span></td>
                        <td width="30%" align="left"></td>
                    </tr>
                </table>
            </div>
        </form>
    </div>
    <script>
        // $(document).ready(function() {
        //     $('#jsonForm').on('submit', function(event) {
        //         event.preventDefault();
        //         console.log('submit form');
        //         url = "{{route('json.import')}}";
        //         // $('.fa-spinner').show();
        //         submitFormAjax(this, url);
        //     }); //end submit

        //     //ajax function
        //     function submitFormAjax(form, url) {
        //         //refresh token on each ajax request if this code not added than sendcond time ajax request on same page show earr token mismatched
        //         $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
        //             var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

        //             if (token) {
        //                 return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
        //             }
        //         });

        //         var data = new FormData(form)

        //         // ajax request
        //         $.ajax({
        //             url: url,
        //             method: "POST",
        //             data: data,
        //             dataType: 'JSON',
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             success: function(data) {

        //                 $('#json_message').html('<div id="json_message" class="alert alert-success" align="left"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>' + data.message + '</strong></div>');


        //             },
        //             error: function(jqXHR, textStatus, errorThrown) {


        //                 var test = jqXHR.responseJSON // this object have two more objects one is errors and other is message.

        //                 var errorMassage = '';

        //                 //now saperate only errors object values from test object and store in variable errorMassage;
        //                 $.each(test.errors, function(key, value) {
        //                     errorMassage += value + '<br>';
        //                 });

        //                 $('#json_message').html('<div id="json_message" class="alert alert-danger" align="left"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>' + errorMassage + '</strong></div>');
        //                 $('html,body').scrollTop(0);
        //                 $('.fa-spinner').hide();

        //             } //end error
        //         }); //end ajax
        //     }
        // });
    </script>
</body>

</html>