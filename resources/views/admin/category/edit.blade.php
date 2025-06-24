@extends('admin.index')
@section('title')
Edit Category | {{ $category->name }}  
@endsection

@section('admin-content')
    <div class="row">
        <div class="container">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                        <h5 class="card-title mb-sm-0 me-2">Create New Category</h5>
                        <div class="action-btns">
                            <a class="btn btn-label-primary me-3" href="{{ route('categories.index') }}">
                            <span class="align-middle"> Back</span>
                            </a>
                            
                        </div>
                    </div>
                    <div class="card-body" id="top">
                        <div class="row">
                            <div class="col-lg-10 mx-auto">
                                <form id="forms_data" action="{{ route('categories.update', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    {{-- Name --}}
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" 
                                            class="form-control" 
                                            id="name" 
                                            name="name" 
                                            value="{{ old('name',isset($category)?$category->name:null) }}"
                                            placeholder="Enter a Category Name"
                                            required>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update</button>
                                
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
                            $('#forms_data .alert-danger').remove();
                            toastr.success(data.success);
                            location.reload();
                        }
                    }
                    $('#forms_data button[type="submit"]').prop('disabled', false);
                }
            });
        });
    });

</script>
@endsection