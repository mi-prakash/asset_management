@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 ml-auto mr-auto">
            <h4>Edit Assets</h4>
            <form method="POST" action="{{ url('admin/assets/update/'.$asset->id) }}">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $asset->name }}" autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>

                    <div class="col-md-6">
                        <input id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ $asset->category }}" autocomplete="category" autofocus>

                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <a href="{{ url('admin/assets') }}" class="btn btn-danger"><i class="fa fa-undo"></i> Back</a>
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

    });
</script>
@endsection
