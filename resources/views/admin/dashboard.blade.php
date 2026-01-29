@extends('layouts.admin_layout')

@section('header-title', 'Admin Dashboard')

@section('content')

    {{-- 🟢 CSS FOR ANALYTICS BUTTON --}}
    <style>
        .analytics-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #FE4F2D, #d63c1e);
            color: white !important;
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(254, 79, 45, 0.3);
            transition: 0.3s;
            animation: pulse 2s infinite;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .analytics-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(254, 79, 45, 0.5);
            color: white;
        }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(254, 79, 45, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(254, 79, 45, 0); }
            100% { box-shadow: 0 0 0 0 rgba(254, 79, 45, 0); }
        }

        @media (max-width: 768px) {
            .header-actions {
                flex-direction: column; width: 100%; gap: 10px; margin-top: 15px;
            }
            .header-actions a { width: 100%; justify-content: center; }
        }
    </style>

    {{-- 🟢 HEADER SECTION --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap;">
        <h2 style="color: #333; margin: 0; font-weight: 700;">Dashboard Overview</h2>

        <div class="header-actions" style="display: flex; gap: 15px;">
            {{-- Analytics Button --}}
            <a href="{{ route('admin.analytics') }}" class="analytics-btn">
                <i class="fas fa-chart-pie"></i> Master Analytics
            </a>

            {{-- Back Button --}}
            <a href="{{ route('admin.welcome') }}"
                style="background: #015551; color: white; padding: 10px 25px; text-decoration: none; border-radius: 50px; font-weight: 600; display: flex; align-items: center; gap: 10px; box-shadow: 0 4px 10px rgba(1, 85, 81, 0.2); transition: 0.3s;">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div style="display: flex; gap: 20px; margin-bottom: 30px; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 250px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #015551;">
            <h3 style="color: #888; font-size: 14px; margin-top: 0;">Total Books</h3>
            <h2 style="font-size: 24px; color: #333; margin-bottom: 0;">{{ $totalBooks ?? 0 }}</h2>
        </div>

        <div style="flex: 1; min-width: 250px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #FE4F2D;">
            <h3 style="color: #888; font-size: 14px; margin-top: 0;">Total Users</h3>
            <h2 style="font-size: 24px; color: #333; margin-bottom: 0;">{{ $totalUsers ?? 0 }}</h2>
        </div>

        <div style="flex: 1; min-width: 250px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); border-left: 5px solid #dc3545;">
            <h3 style="color: #888; font-size: 14px; margin-top: 0;">Pending Requests</h3>
            <h2 style="font-size: 24px; color: #333; margin-bottom: 0;">{{ $requests->count() ?? 0 }}</h2>
        </div>
    </div>

    {{-- Request Table --}}
    <div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow-x: auto;">
        <h3 style="margin-bottom: 20px; color: #333; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px; margin-top: 0;">
            📚 Book Issue Requests
        </h3>

        @if ($requests->count() > 0)
            <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                <thead>
                    <tr style="background: #f8f9fa; text-align: left;">
                        <th style="padding: 12px; border-bottom: 2px solid #ddd; color: #555;">User Name</th>
                        <th style="padding: 12px; border-bottom: 2px solid #ddd; color: #555;">Book Title</th>
                        <th style="padding: 12px; border-bottom: 2px solid #ddd; color: #555;">Request Date</th>
                        <th style="padding: 12px; border-bottom: 2px solid #ddd; color: #555;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr style="border-bottom: 1px solid #eee;">
                            
                            {{-- 🟢 FIX 1: User Safety Check --}}
                            <td style="padding: 12px; font-weight: 600; color: #015551;">
                                {{ $request->user->name ?? 'Unknown User' }}
                            </td>

                            {{-- 🟢 FIX 2: Book Safety Check (Ye error de raha tha) --}}
                            <td style="padding: 12px;">
                                {{ $request->book->title ?? 'Book Deleted' }}
                            </td>

                            <td style="padding: 12px; color: #777;">
                                {{ $request->created_at->format('d M, Y') }}
                            </td>

                            <td style="padding: 12px;">
                                <a href="{{ route('admin.book.approve', $request->id) }}"
                                    style="background: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-size: 13px; font-weight: bold; transition: 0.3s;">
                                    <i class="fas fa-check"></i> Approve
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; color: #999; margin-top: 20px;">No pending requests found.</p>
        @endif
    </div>

@endsection