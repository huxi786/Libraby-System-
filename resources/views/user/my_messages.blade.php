@extends('layouts.user_layout')

@section('content')
<div class="container" style="max-width: 900px; margin: 40px auto;">
    <h2 style="margin-bottom: 30px; color: #015551;">💬 My Inquiries</h2>

    @foreach($messages as $msg)
        <div style="background: white; border: 1px solid #eee; border-radius: 10px; margin-bottom: 20px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.03);">
            
            <div style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                <div style="display:flex; justify-content:space-between;">
                    <h5 style="color: #333; margin:0;">{{ $msg->subject }}</h5>
                    <small style="color:#999">{{ $msg->created_at->format('M d, Y') }}</small>
                </div>
                <p style="color: #555; margin-top: 10px;">{{ $msg->message }}</p>
            </div>

            @if($msg->reply)
                <div style="background: #e0f2f1; padding: 15px; border-radius: 8px; border-left: 4px solid #00695c;">
                    <strong style="color: #00695c; display:block; margin-bottom:5px;">Admin Replied:</strong>
                    <p style="margin:0; color: #004d40;">{{ $msg->reply }}</p>
                </div>
            @else
                <div style="background: #fff3e0; padding: 10px; border-radius: 8px; color: #e65100; font-size: 13px;">
                    ⏳ Waiting for Admin response...
                </div>
            @endif

        </div>
    @endforeach
</div>
@endsection