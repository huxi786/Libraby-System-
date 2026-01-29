<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Practice Arena 🧪</title>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <style>
        body {
            font-family: sans-serif;
            padding: 50px;
            text-align: center;
            background: #f4f4f4;
        }

        .box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background: #015551;
            color: white;
            border: none;
            border-radius: 5px;
        }

        button:hover {
            background: #013f3e;
        }

        #result-area {
            margin-top: 20px;
            font-weight: bold;
            color: green;
            font-size: 18px;
        }
    </style>
</head>

<body>

    <div class="box">
        <h1>🧪 Practice Mode</h1>
        <p>Click the button to test connection.</p>

        <button id="test-btn">Hit AJAX Request!</button>

        <div id="result-area"></div>
    </div>

    <script>
        $(document).ready(function() {

            // Button Click Event
            $('#test-btn').click(function() {

                $('#result-area').text('Loading...'); // Loading text

                // --- AJAX START ---
                $.ajax({
                    url: "{{ route('practice.ajax') }}", // Humari banayi hui route
                    type: "GET",
                    success: function(response) {

                        // Server se jawab aane par ye chalega
                        $('#result-area').html(response.message + " <br> Number: " + response
                            .random_number);

                    },
                    error: function() {
                        alert("Error! Route ya Controller check karo.");
                    }
                });
                // --- AJAX END ---

            });

        });
    </script>

</body>

</html>
