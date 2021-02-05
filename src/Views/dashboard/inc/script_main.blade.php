<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="{{asset('plugins/izitoast/iziToast.min.js')}}"></script>
@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

<script>
    notif = "";
    function iziNotif(data) {
        if(data.hasOwnProperty('notification')){
            notification = data.notification;
        }else if(data.hasOwnProperty('type') && data.hasOwnProperty('message')){
            notification = data;
        }
        else{
            return;
        }
        notifType = notification['type'];
        delete notification['type'];
        options = {};
        for (key in notification){
            options[key] = notification[key]
        }
        window["iziToast"][notifType](options);
    }
    @if(session('notification'))
    $(window).on('load',function() {
        notif = JSON.parse(`{!! json_encode(session('notification')) !!}`);
        iziNotif(notif);
    });
    @endif
</script>
