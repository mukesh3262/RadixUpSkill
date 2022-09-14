@extends('layouts.admin')
@section('content')
    <h4 class="fw-bold py-3 mb-4">
        <a href="{{ route('home') }}">
            <span class="text-muted fw-light">Home /</span>
        </a>
        Notification
    </h4>
    <div class="row w-50">
        <div class="col-xl">
            {{-- <center>
                <button id="btn-nft-enable" onclick="initFirebaseMessagingRegistration()"
                    class="btn btn-danger btn-xs btn-flat">Allow for Notification</button>
            </center> --}}
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{ route('send.notification') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Title</label>
                            <div class="input-group input-group-merge">
                                <input type="text" name="title" class="form-control" id="title"
                                    placeholder="Enter Title">
                                @if ($errors->has('title'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Body</label>
                            <div class="input-group input-group-merge">
                                <textarea type="text" name="body" class="form-control" id="body" placeholder="Enter Description"></textarea>
                                @if ($errors->has('body'))
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    
    <script>

        function onLoadFirebaseMessage() {
            let fcmToken = $.cookie("FCM_Token");
            if (!fcmToken) {
                getFCMPermissionAndStoreDeviceId();
            }
        }

        onLoadFirebaseMessage();

        function getFCMPermissionAndStoreDeviceId() {
           
            if (!FIREBASE_MESSAGE) {
                console.log("Firebase instance is not found!");
                return false;
            }
            FIREBASE_MESSAGE.requestPermission()
            .then(function () {
                console.log(FIREBASE_MESSAGE.getToken());
                return FIREBASE_MESSAGE.getToken()
            })
            .then(function (token) {
                $.ajax({
                    url: "{{ route('save-token') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        token: token
                    },
                    success: function(response) {
                        if (response.success) {
                            setCookie("FCM_Token", token);
                        } else {
                            showFlash({class: "alert alert-danger", message: response.message || "Fail to setup project!"});
                        }
                    }
                });
            }).catch(function (error) {
                console.log(error);
            });
        }

        function sendFCMNotification() {
            let fcmToken = checkCookie("FCM_Token");
            if (!fcmToken) {
                showFlash({class: "alert alert-danger", message: "Unable to identify device token!"});
                return false;
            }

            let fields = document.querySelectorAll("#fcm-notification [data-validate]");
            let errorMessage = validateFields(fields);

            if (errorMessage) {
                showFlash({class: "alert alert-danger", message: errorMessage});
                return false;
            }

            let form = document.querySelector("#fcm-notification");
            let formData = new FormData(form);
            $(".loading").show();
            $.ajax({
                url: APP_URL + '/send-fcm-notification',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Nothing
                    } else {
                        showFlash({class: "alert alert-danger", message: response.message || "Fail to send FCM notification!"});
                    }
                    $(".loading").hide();
                }
            });
        }
    </script>
@endpush
