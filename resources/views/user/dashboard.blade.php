@extends('layouts.user_layout')
@section('title', 'My Dashboard')

@section('content')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
        /* --- 1. UNIVERSAL RESET --- */
        * {
            box-sizing: border-box;
            outline: none;
        }

        body,
        html {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        /* 🟢 CHANGE 1: Background Variable */
        .dashboard-wrapper {
            padding: 15px;
            background: var(--bg-body);
            /* Dark/Light Auto Switch */
            min-height: 90vh;
            font-family: 'Poppins', sans-serif;
            width: 100%;
            transition: background 0.3s;
        }

        .dash-container {
            width: 100%;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 3fr 1fr;
            gap: 20px;
        }

        /* --- 2. WELCOME CARD (Hamesha same rahega) --- */
        .welcome-card {
            background: linear-gradient(rgba(1, 85, 81, 0.85), rgba(0, 61, 58, 0.9)), url('{{ asset('images/menu-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            width: 100%;
            color: white;
            padding: 25px 20px;
            border-radius: 20px;
            margin-bottom: 25px;
            grid-column: 1 / -1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .welcome-text h2 {
            margin: 0;
            font-size: clamp(1.2rem, 4vw, 1.8rem);
            font-weight: 700;
        }

        .welcome-date {
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            margin-top: 5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* --- 3. STATS & CARDS (Dark Mode Ready) --- */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
            width: 100%;
        }

        .mini-stat {
            /* 🟢 CHANGE 2: Card Colors from Variables */
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 15px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            transition: background 0.3s, border-color 0.3s;
        }

        .ms-icon {
            min-width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Icon backgrounds remain same */
        .bg-blue {
            background: #e3f2fd;
            color: #1976d2;
        }

        .bg-orange {
            background: #fff3e0;
            color: #f57c00;
        }

        .bg-green {
            background: #e8f5e9;
            color: #388e3c;
        }

        /* 🟢 CHANGE 3: Text Colors */
        .ms-info h4 {
            margin: 0;
            font-size: 1.2rem;
            color: var(--text-main);
        }

        .ms-info span {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .main-chart-card,
        .sidebar-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 20px;
            border-radius: 20px;
            margin-bottom: 20px;
            width: 100%;
            transition: background 0.3s;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .section-header h5 {
            margin: 0;
            color: var(--text-main);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-header a {
            font-size: 0.8rem;
            color: var(--primary);
            text-decoration: none;
        }

        /* --- TABLE STYLES --- */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table th {
            background: var(--bg-body);
            /* Dark Header */
            padding: 12px;
            text-align: left;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .custom-table td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
            vertical-align: middle;
            color: var(--text-main);
        }

        /* Badges */
        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            display: inline-block;
        }

        .st-pending {
            background: #fff3cd;
            color: #856404;
        }

        .st-issued {
            background: #d1e7dd;
            color: #0f5132;
        }

        .st-rejected {
            background: #f8d7da;
            color: #842029;
        }

        .st-returned {
            background: #e2e3e5;
            color: #383d41;
        }

        /* --- 📱 MOBILE RESPONSIVE --- */
        @media (max-width: 991px) {
            .dash-container {
                display: flex;
                flex-direction: column;
            }

            .stats-row {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .welcome-card {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            /* Table Cards */
            .custom-table thead {
                display: none;
            }

            .custom-table,
            .custom-table tbody,
            .custom-table tr,
            .custom-table td {
                display: block;
                width: 100%;
            }

            .custom-table tr {
                background: var(--bg-card);
                /* Card Background */
                border: 1px solid var(--border-color);
                margin-bottom: 15px;
                border-radius: 10px;
                padding: 15px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            }

            .custom-table td {
                padding: 8px 0;
                text-align: right;
                border-bottom: 1px solid var(--border-color);
                display: flex;
                justify-content: space-between;
                align-items: center;
                color: var(--text-main);
            }

            .custom-table td:last-child {
                border-bottom: none;
            }

            .custom-table td::before {
                content: attr(data-label);
                font-weight: 700;
                color: var(--text-muted);
                font-size: 0.85rem;
                text-transform: uppercase;
            }
        }
    </style>

    <div class="dashboard-wrapper">
        <div class="dash-container">

            {{-- Welcome Card --}}
            <div class="welcome-card">
                <div class="welcome-text">
                    <h2>Welcome back, {{ explode(' ', auth()->user()->name)[0] }}!</h2>
                    <p style="margin: 5px 0 0; opacity: 0.9;">Track your reading journey.</p>
                </div>
                <div class="welcome-date">📅 {{ date('D, d M Y') }}</div>
            </div>

            <div class="left-content">
                {{-- Stats --}}
                <div class="stats-row">
                    <div class="mini-stat">
                        <div class="ms-icon bg-blue"><i class="fas fa-book"></i></div>
                        <div class="ms-info">
                            <h4>{{ $myRequests->count() }}</h4><span>Requests</span>
                        </div>
                    </div>
                    <div class="mini-stat">
                        <div class="ms-icon bg-orange"><i class="fas fa-clock"></i></div>
                        <div class="ms-info">
                            <h4>{{ $myRequests->where('status', 'pending')->count() }}</h4><span>Pending</span>
                        </div>
                    </div>
                    <div class="mini-stat">
                        <div class="ms-icon bg-green"><i class="fas fa-check-circle"></i></div>
                        <div class="ms-info">
                            <h4>{{ $myRequests->where('status', 'issued')->count() }}</h4><span>Active</span>
                        </div>
                    </div>
                </div>

                {{-- Activity Chart --}}
                <div class="main-chart-card">
                    <div class="section-header">
                        <h5><i class="fas fa-chart-line"></i> Reading Activity</h5>
                    </div>
                    <div id="activityChart"></div>
                </div>

                {{-- Recent Requests --}}
                <div class="main-chart-card">
                    <div class="section-header">
                        <h5><i class="fas fa-list"></i> Recent Requests</h5>
                        <a href="{{ route('books.category', 'all') }}">Browse &rarr;</a>
                    </div>

                    @if ($myRequests->count() > 0)
                        <table class="custom-table">
                            <thead>
                                <tr>
                                    <th>Book</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($myRequests->take(5) as $borrow)
                                    <tr>
                                        <td data-label="Book" style="font-weight:600;">
                                            {{ Str::limit($borrow->book->title ?? 'Book Deleted', 20) }}
                                        </td>

                                        <td data-label="Date" style="color:var(--text-muted);">
                                            @if ($borrow->status == 'issued')
                                                {{ $borrow->updated_at->setTimezone('Asia/Karachi')->format('d M, Y') }}
                                            @else
                                                {{ $borrow->created_at->setTimezone('Asia/Karachi')->format('d M') }}
                                            @endif
                                        </td>

                                        <td data-label="Status">
                                            @if ($borrow->status == 'pending')
                                                <span class="status-badge st-pending">Pending</span>
                                            @elseif($borrow->status == 'issued')
                                                <span class="status-badge st-issued">Issued</span>
                                            @elseif($borrow->status == 'rejected')
                                                <span class="status-badge st-rejected">Rejected</span>
                                            @else
                                                <span class="status-badge st-returned">Returned</span>
                                            @endif
                                        </td>

                                        <td data-label="Action">
                                            @if ($borrow->status == 'issued')
                                                <button onclick="openReceipt({{ $borrow->id }})"
                                                    style="border:none; background:none; color:var(--primary); cursor:pointer; font-weight:bold; font-size:0.85rem;">
                                                    <i class="fas fa-receipt"></i> Slip
                                                </button>
                                            @elseif($borrow->status == 'pending')
                                                <form action="{{ route('books.cancel', $borrow->id) }}" method="POST"
                                                    onsubmit="return confirm('Cancel request?');" style="display:inline;">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        style="border:none; background:none; color:#dc3545; cursor:pointer;"><i
                                                            class="fas fa-times"></i> Cancel</button>
                                                </form>
                                            @else
                                                <span style="color:var(--text-muted);">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p style="text-align:center; color:var(--text-muted); padding: 20px;">No recent requests found.</p>
                    @endif
                </div>
            </div>

            <div class="right-widgets">
                <div class="sidebar-card">
                    <div class="section-header">
                        <h5>Overview</h5>
                    </div>
                    <div id="statusChart"></div>
                </div>

                <div class="sidebar-card">
                    <div class="section-header">
                        <h5>Quick Actions</h5>
                    </div>
                    <a href="{{ route('books.category', 'all') }}"
                        style="display:block; padding:12px; background:var(--bg-body); border-radius:10px; text-decoration:none; color:var(--text-main); font-weight:600; text-align:center; margin-bottom:10px; border:1px solid var(--border-color);">🔍
                        Browse Library</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf <button type="submit"
                            style="width:100%; padding:12px; background:#ffe5e5; color:#d32f2f; border:none; border-radius:10px; font-weight:600; cursor:pointer;">🚪
                            Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL (Keep White for contrast or update if needed) --}}
    <div id="receiptModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:white; padding:20px; border-radius:10px; width:90%; max-width:400px; position:relative;">
            <span onclick="$('#receiptModal').hide()"
                style="position:absolute; right:15px; top:10px; cursor:pointer; font-size:20px; color:#333;">&times;</span>
            <div id="receiptContent"
                style="text-align:center; min-height:100px; display:flex; align-items:center; justify-content:center; color:#333;">
                Loading...</div>
            <div style="margin-top:15px; display:flex; gap:10px;">
                <button onclick="printReceipt()"
                    style="flex:1; padding:10px; background:#333; color:white; border:none; border-radius:5px; font-weight:bold;">Print</button>
                <button onclick="payNow()"
                    style="flex:1; padding:10px; background:#28a745; color:white; border:none; border-radius:5px; font-weight:bold;">Pay
                    Now</button>
            </div>
        </div>
    </div>

    <script>
        // Data
        var pending = {{ $myRequests->where('status', 'pending')->count() }};
        var issued = {{ $myRequests->where('status', 'issued')->count() }};
        var returned = {{ $myRequests->where('status', 'returned')->count() }};
        var rejected = {{ $myRequests->where('status', 'rejected')->count() }};

        // Charts
        var commonOptions = {
            chart: {
                foreColor: '#999'
            } // Text color for charts
        };

        new ApexCharts(document.querySelector("#statusChart"), {
            series: [pending, issued, returned, rejected],
            chart: {
                type: 'donut',
                height: 250,
                width: '100%',
                background: 'transparent'
            },
            labels: ['Pending', 'Issued', 'Returned', 'Rejected'],
            colors: ['#ffc107', '#28a745', '#015551', '#dc3545'],
            legend: {
                position: 'bottom',
                labels: {
                    colors: 'var(--text-main)'
                }
            },
            dataLabels: {
                enabled: false
            },
            theme: {
                mode: 'light'
            } // ApexCharts handles theme auto if configured, keeping simple for now
        }).render();

        new ApexCharts(document.querySelector("#activityChart"), {
            series: [{
                name: 'Activity',
                data: [0, 2, 1, 4, 2, {{ $myRequests->count() }}]
            }],
            chart: {
                type: 'area',
                height: 250,
                toolbar: {
                    show: false
                },
                width: '100%',
                background: 'transparent'
            },
            colors: ['#015551'],
            fill: {
                type: 'gradient',
                gradient: {
                    opacityFrom: 0.5,
                    opacityTo: 0.0
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: ['M', 'T', 'W', 'T', 'F', 'S'],
                labels: {
                    style: {
                        colors: '#999'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#999'
                    }
                }
            },
            grid: {
                borderColor: 'var(--border-color)'
            }
        }).render();

        // Modal Functions
        function openReceipt(id) {
            $('#receiptModal').css('display', 'flex');
            $('#receiptContent').html('Loading Slip...');
            $.get('/receipt/' + id, function(res) {
                $('#receiptContent').html(res.html || 'Error loading.');
            }).fail(function() {
                $('#receiptContent').html('Connection Failed.');
            });
        }

        function printReceipt() {
            var c = document.getElementById("receiptContent").innerHTML;
            var w = window.open();
            w.document.write('<html><head><title>Slip</title></head><body>' + c + '</body></html>');
            w.print();
            w.close();
        }

        function payNow() {
            $('#receiptModal').hide();
            setTimeout(() => {
                Swal.fire({
                    title: 'Under Process',
                    text: 'Payment section is under process. Pay at counter.',
                    icon: 'info',
                    confirmButtonColor: '#015551'
                });
            }, 200);
        }
    </script>
@endsection
