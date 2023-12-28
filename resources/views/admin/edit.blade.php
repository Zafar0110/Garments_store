<!-- include parant layouts -->
@extends('admin.layouts.app')

@section('contant')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="POST" id="categoryform" name="categoryform">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" value="{{ $cateid->name }}" name="name" id="name" class="form-control"
                                    placeholder="Name">
                                <p></p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Slug">Slug</label>
                                <input type="text" value="{{ $cateid->slug }}" name="slug" id="slug" class="form-control"
                                    placeholder="Slug">
                                <p></p>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <input type="hidden" id="image_id" name="image_id">
                                <label for="image">Image</label>
                                <div class="dropzone dz-clickable" id="image">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to Upload <br><br>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($cateid->image))
                             <div>
                                <img width="250" src="{{ asset('uploads/category/'.$cateid->image)}}" alt="">
                             </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="Stats">Stats</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" {{ ($cateid->status == 1) ? 'selected' : '' }}   >Active</option>
                                    <option value="0" {{ ($cateid->status == 0) ? 'selected' : '' }}   >Block</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button class="btn btn-primary" type="submit">Update</button>
                <a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('custamjs')
<script>
$("#categoryform").submit(function(event) {
    event.preventDefault();
    var element = $(this);
    $("button[type=submit]").prop('disabled', true);

    $.ajax({
        url: '{{ route("categories.update",$cateid->id) }}',
        type: 'put',
        data: element.serializeArray(),
        datatype: 'json',
        success: function(response) {
            $("button[type=submit]").prop('disabled', false);
            var errors = response['errors'];
            if (response["status"] == true) {
                window.location.href = "{{ route('categories.index')}}";


                $("#name").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

                $("#slug").removeClass('is-invalid')
                    .siblings('p')
                    .removeClass('invalid-feedback').html("");

            } else {

                if (errors['name']) {
                    $("#name").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['name']);
                } else {
                    $("#name").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");

                }
                if (errors['slug']) {
                    $("#slug").addClass('is-invalid')
                        .siblings('p')
                        .addClass('invalid-feedback').html(errors['slug']);
                } else {
                    $("#slug").removeClass('is-invalid')
                        .siblings('p')
                        .removeClass('invalid-feedback').html("");
                }

            }



        },
        error: function(jqXHR, exception) {
            console.log("Something Wrong");
        }
    })
});

// $("#name").change(function(){        ///==>sluging pangaaa not changaa
//     element = $(this);
//     $.ajax({
//         url: ',
//         type: 'get',
//         data: {title: element.val()},
//         dataType: 'json',
//         success: function(response){
//             if(response["status"] == true){
//                 $("#slug").val(response["slug"]);
//             }
//         }
//     });
// });
// for image uploading code
    Dropzone.autoDiscover = false;
    const dropzone = $("#image").dropzone({
        init: function() {
            this.on('addedfile', function(file) {
                if (this.files.length > 1) {
                    this.removeFile(this.files[0]);
                }
            });
        },
        url: "{{ route('temp-images.create') }}",
        maxFiles: 1,
        paramName: 'image',
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(file, response) {
            $("#image_id").val(response.image_id);
            //console.log(response)
        }
    });
</script>
@endsection