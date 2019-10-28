@extends('template')

@section('title', 'Battle.net API Usage Information')

@section('content')
    <div id="app">
        <header class="container-fluid bg-ironforge py-7 text-light">
            <div class="content">
                <h1 class="text-center">Usage of the Blizzard Community Platform API</h1>
            </div>
        </header>
        <div class="container py-6 text-light">
            <p>
                Some of the services provided by The Order use data obtained from the Blizzard Developer API, and is subject to the <a href="https://www.blizzard.com/en-us/legal/a2989b50-5f16-43b1-abec-2ae17cc09dd6/blizzard-developer-api-terms-of-use" target="_blank">Blizzard Developer API Terms of Use</a>.
            </p>

            <p>
                Use of this data is subject to our <a href="{{ url('privacy') }}">privacy policy</a> and that of <a href="https://www.blizzard.com/en-us/legal/a4380ee5-5c8d-4e3b-83b7-ea26d01a9918/blizzard-entertainment-online-privacy-policy">Blizzard Entertainment, Inc.</a>. You have the right to decide how Blizzard processes your personal data and object to providing us information through the API.
            </p>

            <p>
                If you have any questions about this statement please do not hesitate to contact us.
            </p>

            <p>
                Email us at: <a href="mailto:innercircle@theorder.gg?subject=Privacy%20Policy%20Query">innercircle@theorder.gg</a>
            </p>
        </div>
    </div>
@endsection
