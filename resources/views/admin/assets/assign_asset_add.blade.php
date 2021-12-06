@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ml-auto mr-auto">
            <h4>Assign Assets</h4>
            <form method="POST" action="{{ url('admin/assign_assets/'.$user->id) }}">
                @csrf
                <div class="row">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                    <div class="col-md-6">
                        <div class="form-text py-2 m-0">{{ $user->name }}</div>
                    </div>
                </div>

                <div class="row">
                    <label for="department" class="col-md-4 col-form-label text-md-end">Department</label>

                    <div class="col-md-6">
                        <div class="form-text py-2 m-0">{{ $user->department->name }}</div>
                    </div>
                </div>

                <div class="row">
                    <label for="email" class="col-md-4 col-form-label text-md-end">E-Mail Address</label>

                    <div class="col-md-6">
                        <div class="form-text py-2 m-0">{{ $user->email }}</div>
                    </div>
                </div>

                <div class="row">
                    <label for="assets" class="col-md-4 col-form-label text-md-end">Assigned Assets</label>

                    <div class="col-md-6 pt-2">
                        @if (count($user->assets) > 0)
                            @foreach ($user->assets as $asset)
                                <div class="asset-content">
                                    <span class="badge bg-primary">{{ $asset->name }}</span> <button type="button" class="btn btn-danger btn-sm py-0 remove" data-id="{{ $asset->id }}"><i class="fa fa-trash"></i></button>
                                </div>
                            @endforeach
                        @else
                            <span class="badge bg-danger">None</span>
                        @endif
                    </div>
                </div>

                <div class="row mt-2">
                    <label for="assign_assets[]" class="col-md-4 col-form-label text-md-end">Assign Assets</label>

                    <div class="col-md-3">
                        <select class="form-select" id="assign_assets" name="assign_assets[]" multiple aria-label="multiple select">
                            @foreach ($available_assets as $available_asset)
                                <option value="{{ $available_asset->id }}">{{ $available_asset->name }}</option>
                            @endforeach
                        </select>
                        <span class="form-text">Use <b>Ctrl</b> to multi select</span>
                    </div>
                </div>

                <div class="row mt-4 mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="{{ url('admin/assign_assets') }}" class="btn btn-danger"><i class="fa fa-undo"></i> Back</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $(".remove").click(function(e) {
            var id = $(this).data('id');
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: base_url+"/admin/assign_assets/destroy/"+id,
                    type: "POST",
                    data: { _token: "{{ csrf_token() }}" },
                    beforeSend: function() {
                    },
                    success: function(response) {
                        if (response == 'success') {
                            location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
@endsection
