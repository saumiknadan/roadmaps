@extends('admin.index')

@section('title')
    Roadmap | Create
@endsection

@section('styles')
    
    
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css')}}" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
    
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css')}}" />
    

@endsection

@section('admin-content')

    <div class="row">
        <div class="container" id="top">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row mb-5">
                        <h5 class="card-title mb-sm-0 me-2">Add New Roadmap Item</h5>
                        <div class="action-btns">
                            <a class="btn btn-label-primary me-3" href="{{ route('roadmaps.index') }}" >
                            <span class="align-middle"> Back</span>
                            </a>
                        </div>
                    </div>
                    @include('admin.partials.message')

                    <div class="card-body" >
                        <div class="row">
                            <div class="col-lg-12 mx-auto">
                                <form id="forms_data" action="{{ route('roadmaps.store') }}" method="POST" enctype="multipart/form-data">
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
                                                        value="{{ old('title',isset($roadmap)?$roadmap->title:null) }}"
                                                        name="title" 
                                                        placeholder="Enter Title title" />
                                                    </div>

                                                    {{-- Description --}}
                                                    <div class="mb-4">
                                                        <label for="description" class="form-label">Roadmap Description</label>
                                                        <textarea
                                                        type="text"
                                                        class="ckeditor form-control "
                                                        name="description"
                                                        id="description" 
                                                        placeholder="Enter Description"
                                                        aria-describedby="defaultFormControlHelp">{{ old('description',isset($roadmap)?$roadmap->description:null) }}</textarea>
                                                        
                                                    </div>


                                                    <div class="mb-4">
                                                        <label for="status" class="form-label">Status</label>
                                                        <select
                                                            id="status"
                                                            class="select2 form-select w-100"
                                                            data-style="btn-default"
                                                            data-live-search="true"
                                                            name="status"
                                                            required >
                                                            <option value="" selected disabled>Select Status</option>
                                                            <option value="planned">Planned</option>
                                                            <option value="in-progress">In Progress</option>
                                                            <option value="completed">Completed</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="mb-4">
                                                        <label for="category" class="form-label">Category</label>
                                                        <select
                                                            id="category"
                                                            class="select2 form-select w-100"
                                                            data-style="btn-default"
                                                            data-live-search="true"
                                                            name="category"
                                                            required >
                                                            <option value="" selected disabled>Select Category</option>
                                                            <option value="UI">UI</option>
                                                            <option value="Backend">Backend</option>
                                                            <option value="API">API</option>
                                                            <option value="Feature">Feature</option>
                                                        </select>
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

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script src="{{ asset('assets/vendor/js/helpers.js')}}"></script>


<!-- Page JS -->
<script src="{{ asset('assets/js/forms-pickers.js')}}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js')}}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
<!-- Page JS -->

<script src="{{ asset('assets/js/forms-selects.js')}}"></script>
<script src="{{ asset('assets/ckeditor/ckeditor.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<!-- Page JS -->

{{-- Submit --}}
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

{{-- Ceditor --}}
<script>
    ClassicEditor
        .create( document.querySelector( '#description' ) )
        .catch( error => {
            console.error( error );
        } );

</script>

<script>
    $(document).ready(function() {
    $('#status').select2({
        placeholder: "Select Status", 
        allowClear: true
    });

    $('#category').select2({
        placeholder: "Select Category", 
        allowClear: true
    });
});
</script>
@endsection
