@extends('layouts.admin_layout')
@section('title', 'Master Analytics')

{{-- ApexCharts CDN --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

@section('content')

    <style>
        /* --- ANIMATIONS --- */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(1, 85, 81, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(1, 85, 81, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(1, 85, 81, 0);
            }
        }

        .analytics-wrapper {
            padding: 30px;
            font-family: 'Poppins', sans-serif;
            background: #f4f7f6;
            min-height: 100vh;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            animation: slideUp 0.5s ease-out;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: #015551;
        }

        .page-subtitle {
            color: #666;
        }

        /* --- KPI CARDS --- */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .kpi-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            animation: slideUp 0.6s ease-out;
            border-bottom: 4px solid transparent;
        }

        .kpi-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .kpi-card.users:hover {
            border-bottom-color: #015551;
        }

        .kpi-card.revenue:hover {
            border-bottom-color: #FE4F2D;
        }

        .kpi-card.books:hover {
            border-bottom-color: #007bff;
        }

        .kpi-card.active:hover {
            border-bottom-color: #ffc107;
        }

        .kpi-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 3rem;
            opacity: 0.1;
            transform: rotate(-15deg);
        }

        .kpi-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #333;
            margin-bottom: 5px;
        }

        .kpi-label {
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        /* --- CHARTS SECTION --- */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .chart-box {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            animation: slideUp 0.8s ease-out;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .chart-title {
            font-weight: 700;
            color: #015551;
            font-size: 1.2rem;
        }

        /* --- RECENT ACTIVITY TABLE --- */
        .activity-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            animation: slideUp 1s ease-out;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .custom-table th {
            text-align: left;
            padding: 15px;
            color: #888;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .custom-table td {
            padding: 15px;
            border-top: 1px solid #eee;
            color: #555;
            vertical-align: middle;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: #015551;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.8rem;
            margin-right: 10px;
        }

        .status-dot {
            height: 10px;
            width: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .dot-green {
            background: #28a745;
            box-shadow: 0 0 5px #28a745;
        }

        .dot-orange {
            background: #FE4F2D;
            box-shadow: 0 0 5px #FE4F2D;
        }

        @media (max-width: 900px) {
            .charts-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .kpi-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="analytics-wrapper">

        {{-- Header --}}
        <div class="page-header">
            <div>
                <div class="page-title">Master Overview</div>
                <div class="page-subtitle">Real-time insights of LibraryPRO</div>
            </div>
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm"><i class="fas fa-download"></i> Export
                Report</button>
        </div>

        {{-- KPI Cards --}}
        <div class="kpi-grid">
            <div class="kpi-card users">
                <i class="fas fa-users kpi-icon"></i>
                <div class="kpi-value">{{ $totalUsers }}</div>
                <div class="kpi-label">Total Users</div>
            </div>
            <div class="kpi-card revenue">
                <i class="fas fa-coins kpi-icon"></i>
                <div class="kpi-value">${{ number_format($totalRevenue) }}</div>
                <div class="kpi-label">Revenue Generated</div>
            </div>
            <div class="kpi-card books">
                <i class="fas fa-book kpi-icon"></i>
                <div class="kpi-value">{{ $totalBooks }}</div>
                <div class="kpi-label">Total Books</div>
            </div>
            <div class="kpi-card active">
                <i class="fas fa-exchange-alt kpi-icon"></i>
                <div class="kpi-value">{{ $activeBorrows }}</div>
                <div class="kpi-label">Active Circulations</div>
            </div>
        </div>

        {{-- Charts Section --}}
        <div class="charts-grid">
            <div class="chart-box">
                <div class="chart-header">
                    <div class="chart-title">Revenue & Traffic Analysis</div>
                    <select class="form-select form-select-sm" style="width: 100px;">
                        <option>Yearly</option>
                        <option>Monthly</option>
                    </select>
                </div>
                <div id="mainChart"></div>
            </div>
            <div class="chart-box">
                <div class="chart-header">
                    <div class="chart-title">User Demographics</div>
                </div>
                <div id="pieChart"></div>
            </div>
        </div>

        {{-- Recent Activity Table --}}
        <div class="activity-section">
            <div class="chart-title">Recent System Activities</div>
            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Action</th>
                            <th>Book Title</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentActivities as $activity)
                            <tr>
                                <td style="display:flex; align-items:center;">
                                    {{-- 🟢 FIX 1: User Safety Check --}}
                                    <div class="user-avatar">{{ substr($activity->user->name ?? 'U', 0, 1) }}</div>
                                    {{ $activity->user->name ?? 'Unknown User' }}
                                </td>
                                <td>
                                    @if ($activity->status == 'issued')
                                        <span style="color:#28a745; font-weight:bold;">Borrowed</span>
                                    @elseif($activity->status == 'returned')
                                        <span style="color:#015551; font-weight:bold;">Returned</span>
                                    @else
                                        <span style="color:#FE4F2D;">Requested</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- 🟢 FIX 2: Book Safety Check (Ye crash rokega) --}}
                                    {{ $activity->book->title ?? 'Book Deleted' }}
                                </td>
                                <td>{{ $activity->created_at->diffForHumans() }}</td>
                                <td>
                                    @if ($activity->status == 'issued')
                                        <span class="status-dot dot-green"></span> Active
                                    @else
                                        <span class="status-dot dot-orange"></span> Pending/Done
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- 👇 GRAPH LOGIC (ApexCharts) 👇 --}}
    <script>
        // 1. Main Bar Chart (Revenue/Traffic)
        var options1 = {
            series: [{
                name: 'Books Borrowed',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66] // Dummy Data
            }, {
                name: 'Revenue ($)',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            colors: ['#015551', '#FE4F2D'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct']
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        };
        var chart1 = new ApexCharts(document.querySelector("#mainChart"), options1);
        chart1.render();

        // 2. Pie Chart
        var options2 = {
            series: [{{ $totalUsers }}, 5, 12],
            chart: {
                type: 'donut',
                height: 350
            },
            labels: ['Students', 'Staff', 'Guests'],
            colors: ['#015551', '#FE4F2D', '#ffc107'],
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom'
            }
        };
        var chart2 = new ApexCharts(document.querySelector("#pieChart"), options2);
        chart2.render();
    </script>

@endsection
