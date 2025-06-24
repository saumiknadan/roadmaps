@extends('admin.index')

@section('title') Users @endsection

@section('styles')

@endsection

@section('admin-content')
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                        <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                          <h5 class="card-title mb-sm-0 me-2">All Users</h5>
                          <div class="action-btns">
                            <a class="btn btn-primary" href="{{ route('users.create') }}">Create New User</a>
                          </div>
                        </div>
                        <div class="card-body">
    
                          {{-- Table start --}}
                          <div class="table-responsive border-top">
                            <table class="table table-striped table-product text-center" style="width:100%">
                              <thead>
                                <tr>
                                  <th>Sl</th>
                                  <th>Name</th>
                                  <th>Email</th>
                                  <th>User Type</th>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                  @foreach  ($users as $user)
                                  <tr>
                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                      <td>{{ $user->name }}</td>
                                      <td>{{ $user->email }}</td>
                                      <td class="">
                                        @if($user->is_admin==1)
                                          <span class="badge bg-label-success">Admin</span>
                                        @else
                                          <span class="badge bg-label-warning">General User</span>
                                          @endif
                                      </td>
                                      
                                      <td> 
                                        <div class="dropdown">
                                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                              <i class="ti ti-dots-vertical"></i>
                                          </button>
                                          <div class="dropdown-menu">
                                            <a class="dropdown-item edit-btn" href="{{ route('users.edit',$user->id) }}">
                                                <i class="ti ti-pencil me-1"></i> Edit
                                            </a>
    
                                            <form action="{{ route('users.destroy',$user->id) }}" method="post">
                                              @csrf
                                              @method('DELETE')
                                                <button class="dropdown-item delete-btn" type="submit">
                                                    <i class="ti ti-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                          </div>
                                        </div>
                                      </td>
                                    
                                  </tr>
                                  @endforeach
                              
                              </tbody>
                            </table>
                          </div>
                          {{-- Pagination --}}
                          <div class="row mt-4">
                            <span class="mt-2">{{ $users->links('vendor.pagination.bootstrap-5') }}</span>
                          </div>
                        </div>
                      </div>
                </div>
                  </div>
                </div>
@endsection

@section('scripts')
  {{-- delete popup --}}
  <script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this category?")) {
            document.getElementById('deleteForm').submit();
        }else {
          event.preventDefault(); // Cancel the form submission
        }
    }
</script>
@endsection