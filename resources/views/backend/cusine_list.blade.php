@extends('backend.layouts.app')


@section('content')
 <!-- Page Wrapper -->
 <div class="page-wrapper">
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">List of cusinees</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">cusine</li>
                    </ul>
                </div>
               {{-- @if (!Auth::guard('cook')) --}}
                <div class="col-sm-12 col">
                    <a href="#Add_cusine" data-toggle="modal" class="btn btn-otbokhly float-right mt-2 " >Add</a>
                </div>
               {{-- @endif --}}
            </div>

        </div>
        <!-- /Page Header -->


        <div class="row" >
            <div class="col-md-12 d-flex">

                <!-- Recent Orders -->
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h4 class="card-title">cusine List</h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-center mb-0">
                                <thead>
                                    <tr>
                                        <th> #</th>
                                        <th> Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @isset($cusines)
                                   @foreach ($cusines as $index=>$cusine)
                                   <tr>
                                       <td>
                                           {{ $index+1 }}
                                       </td>

                                       <td>{{ $cusine->name }}</td>

                                       <td >
                                           <div class="actions">
                                               <a id="{{ $cusine->id }}" class="link_update bg-success-light mr-2" data-toggle="modal"  href="#edit_cusines_details" >
                                                   <i class="fe fe-pencil"></i> Edit
                                               </a>
                                               <a id="{{ $cusine->id }}" class="link_delete" data-toggle="modal" href="#delete_modal" data-url=""  class="btn btn-sm btn-danger" style="color: #f00">
                                                   <i class="fe fe-trash"></i> Delete
                                               </a>
                                           </div>
                                       </td>
                                   </tr>
                                   @endforeach
                                   @endisset

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /Recent Orders -->

            </div>
        </div>

    </div>
</div>
<!-- /Page Wrapper -->
        <!-- Edit Details Modal -->
        <div class="modal fade" id="edit_cusines_details" aria-hidden="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document" >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit cusines</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formUpdate" method="post" action="" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row form-row">
                                @foreach (config('translatable.locales') as $locale)
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label>@lang('site.'.$locale.'.name')</label>
                                        @isset($cusine)
                                        <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ $cusine->translate($locale)->name }}">
                                        @endisset
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit Details Modal -->
  <!-- Add Modal -->
  <div class="modal fade" id="Add_cusine" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add cusine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('backend.partials.errors')

                <form method="POST" action="{{ route('cusine.store') }}">
                    @csrf
                    <div class="row form-row">
                        @foreach (config('translatable.locales') as $locale)
                        <div class="col-12 col-sm-12">
                            <div class="form-group">
                                <label>{{ trans('site.'.$locale.'.name') }}</label>
                                <input type="text" name="{{ $locale }}[name]" class="form-control" value="{{ old($locale.'.name') }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-otbokhly btn-block">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /ADD Modal -->

      <!-- Delete Modal -->

      <div class="modal fade" id="delete_modal" aria-hidden="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-content p-2">
                        <h4 class="modal-title">Delete</h4>
                        <p class="mb-4">Are you sure want to delete?</p>

                        <form  id="formDelete" action="" method="POST" style="display: inline">
                            @csrf
                            @method('delete')
                            <button class="btn btn-primary btn-delete" type="submit" class="btn btn-primary">Delete </button>
                        </form>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Modal -->


@endsection


@push('scripts')
    <script>
        @if (count($errors) > 0)
                $('#Add_cusine').modal('show');
        @endif

        $('.link_update').on('click',function(){
            var cusine_id=$(this).attr('id');

            $('#formUpdate').attr('action','/{{ Config::get('app.locale') }}/dashboard/cusine/'+cusine_id)

        })
        $('.link_delete').on('click',function(){
            var cusine_id=$(this).attr('id');

            $('#formDelete').attr('action','/{{ Config::get('app.locale') }}/dashboard/cusine/'+cusine_id)

        })


    </script>
@endpush
