@extends('admin.dashboard')
@section('title', 'Transport Agency | Social Icon Settings')
@section('admin_content')
<div class="page-content">
    <!--end breadcrumb-->
    <div class="row">
        <div class="col-xl-12">

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="mb-4">Social Icon Settings</h5>
                    <form class="row g-3" id="socialIconUpdateForm" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="col-md-12">
                            <label for="facebook_url" class="form-label">Facebook</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx  bx-link'></i> </span>
                                <input type="text" name="facebook_url" itemid="facebook_url"
                                    class="form-control @error('facebook_url') is-invaild @enderror" id="input25"
                                    placeholder="Facebook Url" value="{{ $socialIcon->facebook_url ?? '' }}">
                            </div>
                            @error('facebook_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="instagram_url" class="form-label">Instagram</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx  bx-link'></i> </span>
                                <input type="text" name="instagram_url" itemid="instagram_url"
                                    class="form-control @error('instagram_url') is-invaild @enderror" id="input25"
                                    placeholder="Instagram Url" value="{{ $socialIcon->instagram_url ?? '' }}">
                            </div>
                            @error('instagram_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="col-md-12">
                            <label for="linkedin_url" class="form-label">Linkedin</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx  bx-link'></i> </span>
                                <input type="text" name="linkedin_url" itemid="linkedin_url"
                                    class="form-control @error('linkedin_url') is-invaild @enderror" id="input25"
                                    placeholder="Linkedin Url" value="{{ $socialIcon->linkedin_url ?? '' }}">
                            </div>
                            @error('linkedin_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="col-md-12">
                            <label for="twitter_url" class="form-label">Twitter</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx  bx-link'></i> </span>
                                <input type="text" name="twitter_url" itemid="twitter_url"
                                    class="form-control @error('twitter_url') is-invaild @enderror" id="input25"
                                    placeholder="Facebook Url" value="{{ $socialIcon->twitter_url ?? '' }}">
                            </div>
                            @error('twitter_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="youtube_url" class="form-label">Youtube</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx  bx-link'></i> </span>
                                <input type="text" name="youtube_url" itemid="youtube_url"
                                    class="form-control @error('youtube_url') is-invaild @enderror" id="input25"
                                    placeholder="Youtube Url" value="{{ $socialIcon->youtube_url ?? '' }}">
                            </div>
                            @error('youtube_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="google_plus_url" class="form-label">Google Plus</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx  bx-link'></i> </span>
                                <input type="text" name="google_plus_url" itemid="google_plus_url"
                                    class="form-control @error('google_plus_url') is-invaild @enderror" id="input25"
                                    placeholder="Google plus Url" value="{{ $socialIcon->google_plus_url ?? '' }}">
                            </div>
                            @error('google_plus_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>


                        <div class="col-md-12">
                            <label for="tiktok_url" class="form-label">Tiktok</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class='bx  bx-link'></i> </span>
                                <input type="text" name="tiktok_url" itemid="tiktok_url"
                                    class="form-control @error('tiktok_url') is-invaild @enderror" id="input25"
                                    placeholder="Tiktok Url" value="{{ $socialIcon->tiktok_url ?? '' }}">
                            </div>
                            @error('tiktok_url')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <div class="d-md-flex d-grid align-items-center gap-3">
                                <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                                    <span id="btnText">Submit</span>
                                    <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2"></span>
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>


        </div>
    </div>
    <!--end row-->
</div>
@endsection
@push('scripts')

<script>
    
    $(document).ready(function () {
        $('#socialIconUpdateForm').submit(function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            // Spinner show
            $('#btnText').text('Processing...');
            $('#btnSpinner').removeClass('d-none');
            $('#submitBtn').prop('disabled', true);

            $.ajax({
                url: "{{ route('admin.social.icon.update') }}",
                type: "POST",
                data: formData,
                success: function (response) {
                    $('#socialIconUpdateForm')[0].reset();
                    if (response.status === 'success') {
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message ?? 'Something went wrong!');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error('An unexpected error occurred. Please try again.');
                    }
                },
                complete: function () {
                    // Spinner hide & button reset
                    $('#btnText').text('Submit');
                    $('#btnSpinner').addClass('d-none');
                    $('#submitBtn').prop('disabled', false);
                }
            });
        });
    });
</script>


@endpush
