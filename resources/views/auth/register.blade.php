@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('profile.Register') }}</h1>

        <form action="/register" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('profile.Username') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                <span class="text-danger">@error('name'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
                <label for="email">{{ __('profile.Email address') }}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
                <label for="password">{{ __('profile.Password') }}</label>
                <input type="password" class="form-control" id="password" name="password">
                <span class="text-danger">@error('password'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
                <label for="password_confirmation">{{ __('profile.Confirm Password') }}</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                <span class="text-danger">@error('password_confirmation'){{ $message }} @enderror</span>
            </div>

            <div class="form-group">
            <!-- Consent Modal Trigger -->
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#consentModal">
                Read Consent Form
            </button>

            <!-- Consent Checkbox -->
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="consent" {{ old('consent') ? 'checked' : '' }}> I agree to the consent form
                </label>
                <span class="text-danger">@error('consent'){{ $message }} @enderror</span>
            </div>
        </div>


            <button type="submit" class="btn btn-primary">{{ __('profile.Submit') }}</button>

        </form>
    </div>

    <div class="modal fade" id="consentModal" tabindex="-1" role="dialog" aria-labelledby="consentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">  <!-- Using modal-lg for larger modal -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="consentModalLabel">Consent and Privacy Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="consent-tab" data-toggle="tab" href="#consent" role="tab" aria-controls="consent" aria-selected="true">Consent Form</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="privacy-tab" data-toggle="tab" href="#privacy" role="tab" aria-controls="privacy" aria-selected="false">Privacy Policy</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="consent" role="tabpanel" aria-labelledby="consent-tab">
                        <h6>Data Usage Agreement</h6>
                        <p>By registering, you agree to allow us to store and process the information you provide according to our privacy policy.</p>
                        <h6>Terms of Service</h6>
                        <p>You agree to abide by our terms of service, including any restrictions on content and behavior.</p>
                        <h6>Marketing Permissions</h6>
                        <p>You agree that we may send you promotional emails about new products, special offers, and other information which we think you may find interesting using the email address you have provided.</p>
                        <h6>Third-Party Sharing</h6>
                        <p>Your information will not be shared with third parties without your explicit consent, except as necessary to provide the services you have requested.</p>
                    </div>
                    <div class="tab-pane fade" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                        <h6>Handling of Sensitive Mental Health Information</h6>
                        <p>We collect mental health information that you voluntarily provide. This information is used to tailor support and services specific to your needs. We do not collect any personally identifying information unless you provide it.</p>
                        <p>In the event that we assess you as being at risk to yourself or others, we reserve the right to contact authorities using the information provided.</p>
                        <h6>Collection of Comments</h6>
                        <p>We collect comments and feedback during your use of our services to improve the support and services we offer. This information is crucial in helping us understand and meet your needs.</p>
                        <h6>Data Protection Compliance</h6>
                        <p>We adhere strictly to the General Data Protection Regulation (GDPR). This includes taking the necessary precautions to protect your data against unauthorized access or breaches.</p>
                        <h6>Your Rights Under GDPR</h6>
                        <p>You have the right to access, update, or delete your personal information at any time. This can be done by contacting our support team through the methods listed on our website.</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
