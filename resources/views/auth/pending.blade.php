<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval</title>
    
    {{-- CSS Styles --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .pending-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 450px;
            width: 90%;
            border-top: 5px solid #ffc107;
        }
        h1 { color: #333; margin-bottom: 10px; }
        p { color: #666; line-height: 1.6; }
        .spinner {
            margin: 20px auto;
            width: 40px; height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ffc107;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .btn-logout {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #d9534f;
            font-weight: bold;
            border: 1px solid #d9534f;
            padding: 8px 20px;
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-logout:hover { background: #d9534f; color: white; }
    </style>
</head>
<body>

    <div class="pending-card">
        <div class="spinner"></div>
        <h1>Account Pending</h1>
        <p>Your account is currently waiting for administrator approval.</p>
        <p>Please wait here. This page will <strong>automatically refresh</strong> once you are approved.</p>
        
        <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
    </div>

   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(document).ready(function() {
        console.log("🚀 Status monitor started...");

        // Har 2 second baad check karega
        setInterval(function() {
            checkFreshStatus();
        }, 2000);

        function checkFreshStatus() {
            // ?t=... lagane se browser har baar nayi request bhejta hai (Cache nahi uthata)
            let uniqueUrl = "{{ route('check.fresh.status') }}?t=" + new Date().getTime();

            $.ajax({
                url: uniqueUrl,
                type: "GET",
                success: function(response) {
                    // Console me dekhein ke server kya bol raha hai
                    console.log("Server DB Status: " + response.status);

                    if (response.status === 'active') {
                        console.log("✅ User is Active! Redirecting...");
                        
                        // Force Redirect
                        window.location.href = "{{ route('home') }}"; 
                    }
                },
                error: function(xhr) {
                    console.log("Check failed");
                }
            });
        }
    });
</script>

</body>
</html>     