@extends('layouts.admin_layout')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        /* CSS Styles */
        .inbox-container {
            display: flex;
            height: 85vh;
            background: #fff;
            max-width: 1400px;
            margin: 20px auto;
            border-radius: 15px;
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }

        .inbox-sidebar {
            width: 350px;
            background: #f8f9fa;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 20px;
            background: #015551;
            color: white;
            font-weight: bold;
        }

        .user-list {
            overflow-y: auto;
            flex-grow: 1;
        }

        /* Sidebar Item - Converted to Link */
        .user-item {
            display: flex;
            gap: 15px;
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .user-item:hover,
        .user-item.active {
            background: white;
            border-left: 4px solid #FE4F2D;
        }

        .u-avatar {
            width: 45px;
            height: 45px;
            background: #ddd;
            color: #555;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .chat-area {
            flex-grow: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px 25px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .chat-body {
            flex-grow: 1;
            padding: 30px;
            overflow-y: auto;
            background: #fdfdfd;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Chat Bubbles */
        .msg-row {
            display: flex;
            width: 100%;
        }

        .msg-row.admin {
            justify-content: flex-end;
        }

        .msg-row.admin .msg-bubble {
            background: #fff3e0;
            color: #e65100;
            border: 1px solid #ffe0b2;
            border-radius: 10px 10px 0 10px;
        }

        .msg-row.admin .msg-label {
            text-align: right;
            color: #e65100;
        }

        .msg-row.user {
            justify-content: flex-start;
        }

        .msg-row.user .msg-bubble {
            background: #e0f2f1;
            color: #004d40;
            border: 1px solid #b2dfdb;
            border-radius: 10px 10px 10px 0;
        }

        .msg-row.user .msg-label {
            text-align: left;
            color: #015551;
        }

        .msg-bubble {
            max-width: 70%;
            padding: 15px;
            position: relative;
            word-wrap: break-word;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .msg-time {
            font-size: 10px;
            margin-top: 5px;
            opacity: 0.6;
            display: block;
            text-align: right;
        }

        .msg-label {
            font-size: 11px;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            opacity: 0.8;
        }

        .reply-box {
            padding: 20px;
            border-top: 1px solid #eee;
        }

        .reply-box textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            outline: none;
            resize: none;
        }

        .send-btn {
            margin-top: 10px;
            background: #015551;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            float: right;
            cursor: pointer;
        }
    </style>

    {{-- Show Success Message if exists --}}
    @if (session('success'))
        <div
            style="padding: 10px 20px; background: #d4edda; color: #155724; border-bottom: 1px solid #c3e6cb; text-align: center;">
            {{ session('success') }}
        </div>
    @endif

    <div class="inbox-container">

        {{-- SIDEBAR: USER LIST --}}
        <div class="inbox-sidebar">
            <div class="sidebar-header"><span>Inbox ({{ $users->count() }})</span></div>
            <div class="user-list">
                @foreach ($users as $u)
                    {{-- Converted div to 'a' tag for standard linking --}}
                    <a href="{{ route('admin.messages', $u->id) }}"
                        class="user-item {{ isset($selectedUser) && $selectedUser->id == $u->id ? 'active' : '' }}">

                        <div class="u-avatar">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                        <div>
                            <h4 style="margin: 0; font-size: 16px;">{{ $u->name }}</h4>
                            <small style="color: #777;">{{ $u->email }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- MAIN CHAT AREA --}}
        <div class="chat-area">

            @if (isset($selectedUser))
                {{-- HEADER --}}
                <div class="chat-header">
                    <div class="u-avatar" style="background:#015551; color:white;">
                        {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 style="margin:0;">{{ $selectedUser->name }}</h4>
                        <small>{{ $selectedUser->email }}</small>
                    </div>
                </div>

                {{-- MESSAGES BODY --}}
                <div class="chat-body" id="chatBox">
                    @if ($chat->count() > 0)
                        @foreach ($chat as $msg)
                            <div class="msg-row {{ $msg->sender == 'admin' ? 'admin' : 'user' }}">
                                <div class="msg-bubble">
                                    <span
                                        class="msg-label">{{ $msg->sender == 'admin' ? 'Admin (You)' : $selectedUser->name }}</span>
                                    {{ $msg->message }}
                                    <div class="msg-time">
                                        {{ $msg->created_at->timezone('Asia/Karachi')->format('h:i A, M d') }}</div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div style="text-align:center; margin-top:50px; color:#ccc;">
                            <i class="far fa-comments" style="font-size: 40px; margin-bottom: 10px;"></i>
                            <p>No messages yet.</p>
                        </div>
                    @endif
                </div>

                {{-- REPLY FORM --}}
                <div class="reply-box">
                    <form action="{{ route('admin.reply', $selectedUser->id) }}" method="POST">
                        @csrf
                        <textarea name="message" rows="2" placeholder="Type a message..." required></textarea>
                        <button type="submit" class="send-btn">Send</button>
                    </form>
                </div>
            @else
                {{-- EMPTY STATE --}}
                <div
                    style="display:flex; justify-content:center; align-items:center; height:100%; color:#ccc; flex-direction:column;">
                    <i class="far fa-comments" style="font-size: 50px; margin-bottom: 20px;"></i>
                    <h3>Select a user to chat</h3>
                </div>
            @endif

        </div>
    </div>

    {{-- Simple Auto-Scroll Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chatBox = document.getElementById("chatBox");
            if (chatBox) {
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        });
    </script>
@endsection
