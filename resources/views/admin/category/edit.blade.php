@extends('admin.layouts.app')

@section('content')

    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('categories.list') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                <form id="categoryEdit" name="categoryEdit">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" value="{{ $singleCategoryData->name }}" class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" readonly name="slug" id="slug"  value="{{ $singleCategoryData->name }}"class="form-control"
                                        placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <div id="image" class="dropzone">
                                        <div class="dz-message needsclick">
                                            <br>Drop File here or Click to Uplaod <br><br>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{ $singleCategoryData->image_id  }}" name="image_id" id="image_id">
                                </div>
                                <img width="250px" src="{{ asset('./uploads/category/'.$singleCategoryData->image)}}" alt="image"/>
                            </div>
                            

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($singleCategoryData->status == 1)?'selected':'' }} value="1">Active</option>
                                        <option {{ ($singleCategoryData->status == 0)?'selected':'' }} value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('categories.list') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
            </form>
        </div>
        <!-- /.card -->
    </section>

@endsection

@section('customJs')
    <script>
        $(document).ready(function () {
            $('#categoryEdit').submit(function (e) {
                e.preventDefault();
                var element = $(this);
                console.log("form Submitted", element.serialize());
                $('button[type="submit"]').attr('disabled', true);
                $.ajax({
                    url: '{{ route("categories.update", $singleCategoryData->id) }}',
                    type: 'put',
                    data: element.serialize(),
                    dataType: 'json',
                    success: function (response) {
                        $('button[type="submit"]').attr('disabled', false);

                        if (response['status'] == true) {

                            $('#name').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');

                            $('#slug').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                            window.location.href = "{{ route('categories.list') }}";
                        }
                        else {
                            var errors = response['errors'];
                            console.log(errors['name']);
                            if (errors['name']) {
                                $('#name').addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors['name'])
                            }
                            else {
                                $('#name').removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('')
                            }


                            if (errors['slug']) {
                                $('#slug').addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors['slug'])
                            }
                            else {
                                $('#slug').removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('')
                            }

                        }


                    },
                    error: function (jqXHR, exception) {
                        console.log("something went wrong");
                    }
                })
            })
        })


        $('#name').change(function () {
            var name = $(this).val();
            console.log(name);
            $('button[type="submit"]').attr('disabled', true);

            $.ajax({

                url: '{{route("getSlug")}}',
                type: 'get',
                data: { name: name },
                dataType: 'json',
                success: function (response) {
                    $('button[type="submit"]').attr('disabled', false);

                    if (response['status'] == true) {
                        $('#slug').val(response['slug']);
                    }

                },
                error: function (jqXHR, exception) {
                    $('#slug').val('');
                    console.log("Slug error found");
                }

            });

        });

        // DropZone setup js

        Dropzone.autoDiscover = false;
        const dropzone = $('#image').dropzone({
            init: function () {
                this.on('addedfile', function (file) {
                    if(this.files.length > 1){
                        this.removeFile(this.files[0]);
                    }
                })
            },
            url: "{{ route('temp-images.create')}}",
            maxFiles:1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers : {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (file, response) {
                $('#image_id').val(response.image_id);
            }
        })

    </script>


@endsection