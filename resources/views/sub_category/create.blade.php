@extends('admin.layouts.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="subcategory.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->

        <form action="" id="subcategoryFrom" name="subcategoryFrom">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="categoryId" id="category" class="form-control">
                                        @if ($category->isNotEmpty())
                                        <option value="">Select Category here</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @endforeach
                                        @else
                                            No data found
                                        @endif

                                        {{-- <option value="">Mobile</option> --}}
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">active</option>
                                        <option value="0">blocked</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="subcategory.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->

@endsection

@section('customJs')
    <script>
        $(document).ready(function () {
            $('#subcategoryFrom').on('submit', function (e) {
                e.preventDefault();
                var element = $(this);
                $('button[type="submit"]').attr('disabled', true);
                console.log("form submitted", element);

                $.ajax({
                    url: '{{route("subcategories.store") }}',
                    type: 'post',
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
                             $('#category').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback')
                                .html('');
                            window.location.href = "{{ route('subcategories.list') }}";
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

                             if (errors['categoryId']) {
                                $('#category').addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errors['categoryId'])
                            }
                            else {
                                $('#category').removeClass('is-invalid')
                                    .siblings('p')
                                    .removeClass('invalid-feedback')
                                    .html('')
                            }



                        }

                    },
                    error: function (jqXHR, exception) {

                        console.log("something went wrong");

                    }
                });
            });
        });

        $('#name').on('change',function(e){
            e.preventDefault();
             $('button[type="submit"]').attr('disabled', true);
            let name = $(this).val();
            console.log(name);

            $.ajax({
                url:'{{ route("getSlug") }}',
                tpye:'get',
                data: {name:name},
                dataType:'json',
                success:function(req){
                     $('button[type="submit"]').attr('disabled', false);
                    if(req.status == true){
                        $('#slug').val(req.slug);

                    }
                    // console.log(req.status);

                },
                error:function(jqXHR,exception){
                     $('#slug').val('');
                    console.log("Slug error found");

                }
            })
        })


    </script>
@endsection