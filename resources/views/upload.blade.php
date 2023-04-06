@extends('layouts.master.master')
@section('title', 'DigiOasis')
@section('Heading')
<h3 class="text-themecolor">Upload Json File</h3>

@stop
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="row">
                <div class="col-lg-12">
                    <div style="margin-top:10px; margin-right: 10px;">

                    </div>
                    <div class="card-body">
                        <form id="jsonForm" method="post" class="form-horizontal form-prevent-multiple-submits" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="form-body">

                                <h3 class="box-title">Json File Upload</h3>

                                <hr class="m-t-0 m-b-40">

                                <div class="row">

                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <label class="control-label text-right">Email</label>

                                                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control exempted" data-validation="required email">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-5">
                                        <div class="form-group row">
                                            <center>
                                                <img src="{{asset('Massets/images/document.png')}}" class="img-round picture-container picture-src" id="wizardPicturePreview" title="" width="100">

                                                </input>
                                                <input type="file" name="document" id="view" data-validation="required" class="form-control" hidden>

                                                <h6 id="h6" class="card-title m-t-10">Click On Image to Add Json<span class="text_requried">*</span></h6>
                                            </center>

                                        </div>
                                    </div>

                                </div><!--/End Row-->


                            </div> <!--/End Form Boday-->

                            <hr>

                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button type="submit" class="btn btn-success btn-prevent-multiple-submits"><i class="fa fa-spinner fa-spin" style="font-size:18px"></i>Submit File</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end card body -->
                </div> <!-- end col-lg-12 -->
            </div> <!-- end row -->
        </div> <!-- end card card-outline-info -->
    </div> <!-- end col-lg-12 -->
</div> <!-- end row -->



<script>
    $(document).ready(function() {


        formFunctions();
        $('#jsonForm').on('submit', function(event) {
            event.preventDefault();
            //preventDefault work through formFunctions;
            url = "{{route('json.import')}}";
            $('.fa-spinner').show();
            submitFormAjax(this, url);
        }); //end submit

        //ajax function
        function submitFormAjax(form, url, ) {
            //refresh token on each ajax request if this code not added than sendcond time ajax request on same page show earr token mismatched
            $.ajaxPrefilter(function(options, originalOptions, xhr) { // this will run before each request
                var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
                }
            });

            var data = new FormData(form)

            // ajax request
            $.ajax({
                url: url,
                method: "POST",
                data: data,
                //dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('.fa-spinner').hide();
                    $('#json_message').html('<div id="json_message" class="alert alert-success" align="left"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>' + data.message + '</strong></div>');
                    $("#jsonForm")[0].reset();
                    document.getElementById("h6").innerHTML = "Click On Image to Add Json";

                },
                error: function(jqXHR, textStatus, errorThrown) {


                    var test = jqXHR.responseJSON // this object have two more objects one is errors and other is message.

                    var errorMassage = '';

                    //now saperate only errors object values from test object and store in variable errorMassage;
                    $.each(test.errors, function(key, value) {
                        errorMassage += value + '<br>';
                    });

                    $('#json_message').html('<div id="json_message" class="alert alert-danger" align="left"><a href="#" class="close" data-dismiss="alert">&times;</a><strong>' + errorMassage + '</strong></div>');
                    $('html,body').scrollTop(0);
                    $('.fa-spinner').hide();

                } //end error
            }); //end ajax
        }


        //Image Perview

        $("#view").change(function() {
            var fileName = this.files[0].name;
            var fileType = this.files[0].type;
            var fileSize = this.files[0].size;
            //var fileType = fileName.split('.').pop();
            console.log(fileType);
            //Restrict File Size Less Than 1MB
            if (fileSize > 1024000) {
                alert('File Size is bigger than 1MB');
                $(this).val('');
            } else {
                //Restrict File Type
                if (fileType == 'application/json') {
                    readURL(this); // for Default Image

                    document.getElementById("h6").innerHTML = "Json File is Attached";
                    $('embed').remove();
                } else {
                    alert('Only json file Allowed');
                    $(this).val('');
                }
            }

        });

        function readURL(input) {
            var fileName = input.files[0].name;
            var fileType = input.files[0].type;

            //Read URL if image
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    //$('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow').attr('width', '100%');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#wizardPicturePreview").click(function() {
            $("input[id='view']").click();
        });


    });
</script>

@stop