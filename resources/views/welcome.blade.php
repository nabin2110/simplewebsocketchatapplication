<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pusher Test</title>
  <style>
    .btn {
      background: red;
      padding: 5px;
      cursor: pointer;
      color: white;
    }
  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('4516ffb03a4b682d9de4', {
      cluster: 'ap2'
    });
    console.log('pusher connected')
    var channel = pusher.subscribe('message-send');
    channel.bind('message-event', function(data) {
       $('.message_container').append(`<div>${data.message.message}</div>`)
    });
  </script>
</head>
<body>
  <h1>Pusher Test</h1>
  <p>
    Try publishing an event to channel <code>message-send</code> with event name <code>message-event</code><br>
    <div class="message_container">

    </div>
    <form action="{{ route('send-message') }}" method="post" id="form_submit">
        @csrf
        <input type="text" name="message" id="message" placeholder="Type your message">
        <button type="button" id="submit_message">Submit</button> <!-- Changed to type="button" -->
    </form>
  </p>

  <script>
    $(function(){
        $("#submit_message").on('click', function(e){
            e.preventDefault(); // Prevent the default form submission
            var message = $('#message').val();
            if(message !== ""){
                $.ajax({
                    url: "{{ route('send-message') }}",
                    method: 'POST',
                    data: {
                        "message": message,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(resp) {
                        console.log('Message sent:', resp);
                        // Optionally, clear the input field after successful message send
                        $('#message').val('');
                    },
                    error: function(err) {
                        console.log('Error:', err);
                    }
                });
            }
        });
    });
  </script>

</body>
</html>
