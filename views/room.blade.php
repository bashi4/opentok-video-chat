<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <style>
        .message-container {
            width: 100%;
            height: 100vh;
            position: relative;
        }
        .message-form {
            width: 100%;
            position: absolute;
            bottom: 15px;
        }
        .message-list {
            height: 90vh;
            overflow-y: scroll;
        }
        .message-list-item {
            padding: .5rem .75rem;
            border: 1px solid #ececec;
            border-radius: .25rem;
        }
        .message-list-item.mine {
            background-color: #17a2b8;
            color: #fff;
            margin-left: 4rem;
        }
        .message-list-item.theirs {
            background-color: #f8f9fa;
            margin-right: 4rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-9 d-flex">
                <div id="publisher"></div>
                <div id="subscriber"></div>
            </div>
            <div class="col-3 bg-white">
                <div class="message-container">
                    <div class="message-list"></div>
                    <form class="message-form">
                        <div class="input-group">
                            <input type="text" class="form-control">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">送信</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
    <script>
        let params = {!! $params !!};

        initializeSession();

        function handleError(error) {
            if (error) alert(error.message)
        }

        function initializeSession() {
            const session = OT.initSession(params.key, params.sessionId);

            // オプションは下記参考
            // https://tokbox.com/developer/sdks/js/reference/OT.html#initPublisher
            const publisher = OT.initPublisher("publisher", {
                    insertMode: "append",
                    width: "360px",
                    height: "240px",
                }, handleError);

            session.on("streamCreated", function(event) {
                session.subscribe(event.stream, "subscriber", {
                    insertMode: "append",
                    width: "360px",
                    height: "240px",
                }, handleError);
            });

            session.on("sessionDisconnected", function sessionDisconnected(event) {
                console.error("You were disconnected from the session.", event.reason);
            });


            session.connect(params.token, function(error) {
                error ? handleError(error) : session.publish(publisher, handleError);
            });


            const form = document.querySelector('.message-form');
            const formTxt = document.querySelector('.message-form input');

            form.addEventListener('submit', function(event) {
                event.preventDefault();
                session.signal({type: 'msg', data: formTxt.value}, function(error) {});
            });

            session.on('signal:msg', function(event) {
                var msg = document.createElement('p');
                msg.innerText = event.data;
                msg.className = event.from.connectionId === session.connection.connectionId
                    ? 'message-list-item mine' : 'message-list-item theirs';
                const messagelist = document.querySelector('.message-list');
                messagelist.appendChild(msg);
                msg.scrollIntoView();
            });
        }
    </script>
</body>
</html>
