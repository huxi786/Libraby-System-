@extends('layouts.user_layout')

@section('title', 'Contact Us - LibraryPRO')

{{-- Favicon --}}
<link rel="icon" href="{{ asset('images/library-logo.png') }}" type="image/png">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')

    <style>
        /* --- PAGE WRAPPER --- */
        .contact-page-wrapper {
            background-color: var(--bg-body);
            /* 🌑 Variable */
            padding: 40px 15px;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
            transition: background-color 0.3s ease;
        }

        .contact-card {
            background: var(--bg-card);
            /* 🌑 Variable */
            max-width: 1000px;
            width: 100%;
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s ease-out;
            min-height: 650px;
            border: 1px solid var(--border-color);
            /* 🌑 Variable */
        }

        /* --- LEFT SIDE (Brand Color - Always Dark) --- */
        .contact-info {
            flex: 1;
            background: linear-gradient(135deg, #015551, #013f3c);
            /* Brand Gradient */
            color: white;
            /* Always White */
            padding: 50px 40px;
            min-width: 300px;
            position: relative;
        }

        .contact-info h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 700;
            color: white;
        }

        .info-text {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }

        .info-icon {
            background: rgba(255, 255, 255, 0.1);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
            color: #FE4F2D;
            flex-shrink: 0;
        }

        /* --- RIGHT SIDE --- */
        .contact-right-panel {
            flex: 1.5;
            padding: 40px;
            background: var(--bg-card);
            /* 🌑 Variable */
            min-width: 300px;
            display: flex;
            flex-direction: column;
        }

        /* TABS */
        .tabs-container {
            display: flex;
            background: var(--bg-body);
            /* 🌑 Variable */
            padding: 5px;
            border-radius: 50px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            border: 1px solid var(--border-color);
        }

        .tab-btn {
            flex: 1;
            border: none;
            padding: 12px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            color: var(--text-muted);
            /* 🌑 Variable */
            background: transparent;
            transition: 0.3s;
            white-space: nowrap;
        }

        .tab-btn.active {
            background: var(--bg-card);
            /* 🌑 Variable */
            color: var(--primary);
            /* 🌑 Variable */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* SECTIONS & FORM */
        .content-section {
            display: none;
            animation: fadeIn 0.5s;
            height: 100%;
        }

        .content-section.active {
            display: block;
        }

        .form-group {
            position: relative;
            margin-bottom: 25px;
        }

        .form-label {
            position: absolute;
            top: -10px;
            left: 15px;
            background: var(--bg-card);
            /* 🌑 Matches Card BG */
            padding: 0 5px;
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid var(--border-color);
            /* 🌑 Variable */
            border-radius: 10px;
            font-size: 1rem;
            transition: 0.3s;
            background: var(--bg-body);
            /* 🌑 Input BG Dark */
            color: var(--text-main);
            /* 🌑 Input Text */
            outline: none;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: var(--primary);
            background: var(--bg-card);
            box-shadow: 0 5px 15px rgba(1, 85, 81, 0.08);
        }

        textarea.form-input {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            background: var(--primary);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            box-shadow: 0 10px 20px rgba(1, 85, 81, 0.2);
        }

        .submit-btn:hover {
            background: #FE4F2D;
            transform: translateY(-3px);
        }

        /* HISTORY & MESSAGES */
        .history-scroll {
            max-height: 500px;
            overflow-y: auto;
            padding-right: 5px;
        }

        .history-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .history-scroll::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 10px;
        }

        .msg-card {
            border: 1px solid var(--border-color);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            background: var(--bg-card);
            /* 🌑 Variable */
            transition: 0.3s;
        }

        .msg-card:hover {
            border-color: var(--primary);
        }

        .msg-date {
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 5px;
            display: block;
        }

        .msg-subject {
            font-weight: 700;
            color: var(--text-main);
            font-size: 1.1rem;
            margin-bottom: 8px;
            display: block;
        }

        .msg-body {
            background: var(--bg-body);
            /* 🌑 Message Inner BG */
            padding: 10px;
            border-radius: 8px;
            color: var(--text-main);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Admin Reply Box - Adaptive */
        .admin-reply-box {
            margin-bottom: 20px;
            background: rgba(1, 85, 81, 0.1);
            /* Transparent tint works on both */
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid var(--primary);
            animation: fadeIn 0.5s;
        }

        .status-badge {
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 20px;
            font-weight: bold;
            float: right;
        }

        .badge-pending {
            background: #fff3cd;
            color: #856404;
        }

        .badge-replied {
            background: #d1e7dd;
            color: #0f5132;
        }

        /* KEYFRAMES */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* 📱 MOBILE RESPONSIVE */
        @media (max-width: 768px) {
            .contact-page-wrapper {
                padding: 20px 10px;
                align-items: flex-start;
            }

            .contact-card {
                flex-direction: column;
                height: auto;
            }

            .contact-info,
            .contact-right-panel {
                padding: 30px 20px;
                min-width: 100%;
                width: 100%;
            }

            .contact-info h2 {
                font-size: 1.8rem;
            }

            .tabs-container {
                flex-direction: row;
                justify-content: space-between;
                gap: 5px;
            }

            .tab-btn {
                font-size: 12px;
                padding: 10px 5px;
            }
        }
    </style>

    <div class="contact-page-wrapper">
        <div class="contact-card">

            {{-- LEFT SIDE: CONTACT INFO --}}
            <div class="contact-info">
                <h2>Get in Touch</h2>
                <p class="info-text">Have an inquiry? Fill out the form or check 'My History' for replies.</p>
                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div><strong style="display:block;">Address</strong><span>Gulberg III, Lahore</span></div>
                </div>
                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div><strong style="display:block;">Phone</strong><span>+92 3217079965</span></div>
                </div>
                <div class="info-item">
                    <div class="info-icon">✉️</div>
                    <div><strong style="display:block;">Email</strong><span>support@librarypro.com</span></div>
                </div>
            </div>

            {{-- RIGHT SIDE: FORM & HISTORY --}}
            <div class="contact-right-panel">

                {{-- TABS --}}
                <div class="tabs-container">
                    <button class="tab-btn active" onclick="openTab('form')">✍️ Send Message</button>
                    <button class="tab-btn" onclick="openTab('history')">📂 My History</button>
                </div>

                {{-- FORM SECTION --}}
                <div id="tab-form" class="content-section active">
                    <h3 style="color: var(--primary); margin-bottom: 25px; font-weight: 700;">New Message</h3>

                    @if (session('success'))
                        <div
                            style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold; border: 1px solid #c3e6cb;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-input" value="{{ auth()->user()->name }}" readonly
                                style="opacity: 0.7; cursor: not-allowed;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-input" value="{{ auth()->user()->email }}" readonly
                                style="opacity: 0.7; cursor: not-allowed;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-input"
                                placeholder="Book Inquiry / Technical Issue" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Message</label>
                            <textarea name="message" class="form-input" placeholder="Write your message here..." required></textarea>
                        </div>

                        <button type="submit" class="submit-btn">Send Message <span>🚀</span></button>
                    </form>
                </div>

                {{-- HISTORY SECTION --}}
                <div id="tab-history" class="content-section">
                    <div style="display:flex; justify-content:space-between; margin-bottom:20px; align-items:center;">
                        <h3 style="color: var(--primary); font-weight: 700; margin:0;">Inbox</h3>
                        <span style="font-size:12px; color:var(--text-muted);">Total: {{ $messages->count() }}</span>
                    </div>

                    <div class="history-scroll">
                        @if ($messages->count() > 0)
                            @foreach ($messages as $msg)
                                @if ($msg->sender == 'user')
                                    <div class="msg-card">
                                        <div style="display:flex; justify-content:space-between;">
                                            <span class="msg-date">📅 {{ $msg->created_at->format('h:i A, M d, Y') }}</span>
                                            <span class="status-badge badge-pending">User</span>
                                        </div>
                                        <span class="msg-subject">{{ $msg->subject }}</span>
                                        <div class="msg-body">{{ $msg->message }}</div>
                                    </div>
                                @elseif($msg->sender == 'admin')
                                    <div class="admin-reply-box">
                                        <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                                            <div style="font-size:0.85rem; font-weight:bold; color:var(--primary);">
                                                <i class="fas fa-user-shield"></i> Admin Response:
                                            </div>
                                            <span class="msg-date">{{ $msg->created_at->format('h:i A, M d') }}</span>
                                        </div>
                                        <div style="font-size:0.95rem; color:var(--text-main);">{{ $msg->message }}</div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div style="text-align:center; padding:50px; color:var(--text-muted);">
                                <i class="fas fa-inbox" style="font-size:40px; margin-bottom:10px;"></i>
                                <p>No messages found.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Footer is already in layout, removed explicit include --}}

    <script>
        function openTab(tabName) {
            $('.content-section').removeClass('active');
            $('.tab-btn').removeClass('active');
            $('#tab-' + tabName).addClass('active');

            if (tabName === 'form') {
                $('.tab-btn:eq(0)').addClass('active');
            } else {
                $('.tab-btn:eq(1)').addClass('active');
            }
        }
    </script>

@endsection
