@extends('admin.index')

@section('title')
    App Info | Create
@endsection

@section('styles')
        

@endsection

@section('admin-content')

    <div class="row">
        <div class="container" id="top">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                        <h5 class="card-title mb-sm-0 me-2">Create App Info</h5>
                    </div>
                    @include('admin.partials.message')

                    <div class="card-body" >
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                <form id="forms_data" action="{{ route('app-info.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                
                                    <div class="row">
                                        
                                        <div class="col-md-12">
                                            <div class="card mb-4" id="roadmap_card">
                                                <div class="card-body">
                                                    
                                                    <div class="mb-4">
                                                        <label for="title" class="form-label">Title</label>
                                                        <input
                                                        type="text"
                                                        class="form-control"
                                                        id="title"
                                                        name="app_name" 
                                                        placeholder="Enter App Name" />
                                                    </div>

                                                    <div class="col-md-12 mb-4">
                                                        <label for="formFile" class="form-label">Logo</label>
                                                        <input class="form-control" type="file" id="formFile" accept="image/*"
                                                            name="logo" />
                                                    </div>
                                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Submit</button>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')

<script>
    $(function () {
        $("#forms_data").on('submit', function (e) {
            e.preventDefault();
            $('#forms_data button[type="submit"]').prop('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (data) {
                    if (data.status == 0) {
                        var errorsHtml = '<div class="alert alert-danger">';
                        errorsHtml += '<div>';
                        $.each(data.error, function (field, messages) {
                            $.each(messages, function (index, message) {
                                errorsHtml += '<p>' + message + '</p>';
                            });
                        });
                        errorsHtml += '</div></div>';
                        $('#forms_data .alert-danger').remove();
                        $('#forms_data').prepend(errorsHtml);
                        $('html, body').animate({
                            scrollTop: $('#top').offset().top
                        }, 'slow');
                    } else {
                        if (data.status == 2) {
                            toastr.success(data.success);
                        } else {
                            $('#forms_data')[0].reset();
                            $('#forms_data .alert-danger').remove();
                            toastr.success(data.success);
                        }
                    }
                    $('#forms_data button[type="submit"]').prop('disabled', false);
                }
            });
        });
    });
</script>

@endsection
