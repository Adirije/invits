 
 @if (session('notification'))
    <script>
        let notification = JSON.parse("{!! addslashes(session('notification')) !!}");

        if(notification) PNotify.alert(notification);

    </script>
     
 @endif

