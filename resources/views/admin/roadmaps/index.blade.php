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
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                <h5 class="card-title mb-sm-0 me-2">Roadmap</h5>
                <div class="action-btns">
                    <a class="btn btn-primary" href="{{ route('roadmaps.create') }}">Create Roadmap</a>
                </div>
            </div>
            
            <div class="container m-3">
                <div class="row">
                    <form action="" class="form-inline">
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="SEARCH Roadmap Title"
                                    value="{{ request()->search }}" name="search" />

                                <button class="btn btn-outline-primary" type="submit">Search</button>
                                <a href="{{ route('roadmaps.index') }}" class="btn btn-outline-secondary">Reset</a>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @include('admin.partials.message')
            <div class="card-body">
                {{-- Modal for Delete --}}
                <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalCenterTitle">Confirm Delete</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this item?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button id="confirmDeleteButton" type="button" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Table start --}}
                <div class="table-responsive border-top">
                    <table class="table table-striped table-product text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($roadmaps->count() > 0)
                                @foreach ($roadmaps as $roadmap)
                                    <tr>
                                        <td>{{ ($roadmaps->currentPage() - 1) * $roadmaps->perPage() + $loop->iteration }}</td>
                                        <td>{{ $roadmap->title }}</td>
                                        <td>{{ Str::limit(strip_tags($roadmap->description), 100) }}</td>
                                        <td>
                                            @php
                                                switch ($roadmap->status) {
                                                    case 'pending':
                                                        $badgeClass = 'bg-label-warning';
                                                        break;
                                                    case 'in-progress':
                                                        $badgeClass = 'bg-label-info';
                                                        break;
                                                    case 'completed':
                                                        $badgeClass = 'bg-label-success';
                                                        break;
                                                    case 'cancelled':
                                                        $badgeClass = 'bg-label-danger';
                                                        break;
                                                    default:
                                                        $badgeClass = 'bg-label-secondary';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}" style="font-size: 0.9rem;">
                                                {{ ucfirst(str_replace('_', ' ', $roadmap->status)) }}
                                            </span>
                                        </td>
                                        
                                        <td>{{ $roadmap->category }}</td>

                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu">

                                                    
                                                    <a class="dropdown-item" href="{{ route('roadmaps.edit', $roadmap->id) }}">
                                                        <i class="ti ti-pencil me-1"></i> Edit
                                                    </a>

                                                    <form id="deleteForm-{{ $roadmap->id }}" action="{{ route('roadmaps.destroy', $roadmap->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item delete-btn" type="button" data-id="{{ $roadmap->id }}">
                                                            <i class="ti ti-trash me-1"></i> Delete
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                       

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No Roadmaps Found</td>
                                </tr>
                            @endif

                        </tbody>

                    </table>
                </div>
                {{-- Pagination --}}
                <div class="row mt-4">
                    <span class="mt-2">{{ $roadmaps->links('vendor.pagination.bootstrap-5') }}</span>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('.delete-btn');
        var confirmDeleteButton = document.getElementById('confirmDeleteButton');
        var deleteFormId;
        var deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));

        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                deleteFormId = 'deleteForm-' + button.getAttribute('data-id');
                deleteConfirmationModal.show();
            });
        });

        confirmDeleteButton.addEventListener('click', function() {
            var deleteForm = document.getElementById(deleteFormId);
            deleteForm.submit();
        });
    });
</script>

@endsection
