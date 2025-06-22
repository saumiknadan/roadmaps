@extends('admin.index')

@section('title')
    Roadmap | Edit
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
                    <h5 class="card-title mb-sm-0 me-2">Edit Roadmap Item</h5>
                    <div class="action-btns">
                        <a class="btn btn-label-primary me-3" href="{{ route('roadmaps.index') }}">
                            <span class="align-middle"> Back</span>
                        </a>
                    </div>
                </div>

                @include('admin.partials.message')

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mx-auto">
                            <form id="forms_data" action="{{ route('roadmaps.update', $roadmap->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card mb-4" id="roadmap_card">
                                            <div class="card-body">

                                                {{-- Title --}}
                                                <div class="mb-4">
                                                    <label for="title" class="form-label">Title</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="title"
                                                        value="{{ old('title', isset($roadmap) ? $roadmap->title : '') }}"
                                                        name="title"
                                                        placeholder="Enter Title" />
                                                </div>

                                                {{-- Description --}}
                                                <div class="mb-4">
                                                    <label for="description" class="form-label">Roadmap Description</label>
                                                    <textarea
                                                        class="ckeditor form-control"
                                                        name="description"
                                                        id="description"
                                                        placeholder="Enter Description">{{ old('description', isset($roadmap) ? $roadmap->description : '') }}</textarea>
                                                </div>

                                                {{-- Status --}}
                                                <div class="mb-4">
                                                    <label for="status" class="form-label">Status</label>
                                                    <select
                                                        id="status"
                                                        class="select2 form-select w-100"
                                                        name="status"
                                                        required>
                                                        <option value="" disabled>Select Status</option>
                                                        <option value="planned" {{ $roadmap->status == 'planned' ? 'selected' : '' }}>Planned</option>
                                                        <option value="in-progress" {{ $roadmap->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                                        <option value="completed" {{ $roadmap->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                        <option value="cancelled" {{ $roadmap->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </div>

                                                {{-- Category --}}
                                                <div class="mb-4">
                                                    <label for="category" class="form-label">Category</label>
                                                    <select
                                                        id="category"
                                                        class="select2 form-select w-100"
                                                        name="category"
                                                        required>
                                                        <option value="" disabled>Select Category</option>
                                                        <option value="UI" {{ $roadmap->category == 'UI' ? 'selected' : '' }}>UI</option>
                                                        <option value="Backend" {{ $roadmap->category == 'Backend' ? 'selected' : '' }}>Backend</option>
                                                        <option value="API" {{ $roadmap->category == 'API' ? 'selected' : '' }}>API</option>
                                                        <option value="Feature" {{ $roadmap->category == 'Feature' ? 'selected' : '' }}>Feature</option>
                                                    </select>
                                                </div>

                                                <div class="action-btns">
                                                    <a class="btn btn-label-primary me-3" href="{{ route('roadmaps.index') }}">
                                                        <span class="align-middle">Cancel</span>
                                                    </a>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4">Update</button>

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
    $(function() {
        $("#forms_data").on('submit', function(e) {
            e.preventDefault();
            $('#forms_data button[type="submit"]').prop('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(document).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        var errorsHtml = '<div class="alert alert-danger">';
                        errorsHtml += '<div>';
                        $.each(data.error, function(field, messages) {
                            $.each(messages, function(index, message) {
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
