@extends('layouts.user_layout')

@section('content')

<style>
    /* --- GENERAL STYLES --- */
    .receipt-wrapper {
        background: #f4f6f9;
        padding: 50px 20px;
        min-height: 80vh;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .receipt-card {
        background: white;
        width: 100%;
        max-width: 600px;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        margin: 0 auto;
    }

    /* Top Color Bar */
    .receipt-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 8px;
        background: linear-gradient(to right, #015551, #FE4F2D);
    }

    .receipt-header { text-align: center; margin-bottom: 30px; }
    .receipt-title { color: #015551; margin: 0; font-size: 28px; font-weight: 700; }
    .receipt-id { color: #888; margin-top: 5px; font-size: 14px; }
    
    .status-badge {
        background: #e6fffa;
        color: #00796b;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        display: inline-block;
        margin-top: 10px;
    }

    .divider { border: 0; border-top: 1px dashed #ddd; margin: 25px 0; }

    /* Item Details */
    .item-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .book-title { margin: 0; color: #333; font-size: 18px; font-weight: 600; }
    .book-author { margin: 5px 0; color: #666; font-size: 14px; }
    .price-label { margin: 0; color: #888; font-size: 12px; }
    .price-value { margin: 0; color: #FE4F2D; font-size: 20px; font-weight: 700; }

    /* Date Box */
    .date-box {
        background: #f9f9f9;
        padding: 15px 20px;
        border-radius: 10px;
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
    }
    .date-label { color: #888; font-size: 12px; display: block; margin-bottom: 5px; }
    .date-val { margin: 0; font-weight: 600; color: #333; font-size: 15px; }
    .date-val.due { color: #d32f2f; }

    /* Total Section */
    .total-row {
        display: flex; justify-content: space-between; align-items: center;
        margin-top: 30px; padding-top: 20px; border-top: 2px solid #eee;
    }
    .total-label { margin: 0; color: #333; font-size: 20px; font-weight: bold; }
    .total-amount { margin: 0; color: #015551; font-size: 28px; font-weight: 800; }

    /* Buttons */
    .action-buttons { margin-top: 40px; display: flex; gap: 15px; }
    
    .btn {
        padding: 15px; border-radius: 8px; font-weight: bold; cursor: pointer; border: none; font-size: 15px; transition: 0.3s;
    }
    .btn-print { flex: 1; background: #eee; color: #333; }
    .btn-print:hover { background: #e0e0e0; }
    
    .btn-pay {
        flex: 2; background: #FE4F2D; color: white;
        box-shadow: 0 5px 15px rgba(254, 79, 45, 0.4);
    }
    .btn-pay:hover { background: #d93d1e; transform: translateY(-2px); }

    .back-link {
        display: block; text-align: center; margin-top: 20px;
        color: #888; text-decoration: none; font-size: 14px;
    }
    .back-link:hover { color: #555; }

    /* --- 🖨️ PRINT LOGIC (JADOO) --- */
    @media print {
        /* 1. Sab kuch chhupa do */
        body * {
            visibility: hidden;
        }

        /* 2. Sirf Receipt Card aur uske andar ka maal dikhao */
        #printable-area, #printable-area * {
            visibility: visible;
        }

        /* 3. Receipt ko page ke top par set karo */
        #printable-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 20px; /* Thoda padding taake kate na */
            box-shadow: none; /* Shadow print me gandi lagti hai */
            border: 1px solid #ddd; /* Clean border print ke liye */
        }

        /* 4. Buttons aur Links ko pakka gayab karo */
        .no-print {
            display: none !important;
        }
        
        /* Background colors print karne ke liye */
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
</style>

<div class="receipt-wrapper">
    
    <div class="receipt-card" id="printable-area">
        
        <div class="receipt-header">
            <h1 class="receipt-title">BOOK RECEIPT</h1>
            <p class="receipt-id">Transaction ID: #INV-{{ $borrow->id }}{{ rand(100,999) }}</p>
            <span class="status-badge">STATUS: ISSUED (UNPAID)</span>
        </div>

        <hr class="divider">

        <div class="item-row">
            <div>
                <h3 class="book-title">{{ $borrow->book->title }}</h3>
                <p class="book-author">Author: {{ $borrow->book->author }}</p>
            </div>
            <div style="text-align: right;">
                <p class="price-label">Price</p>
                <h3 class="price-value">${{ number_format($borrow->book->price, 2) }}</h3>
            </div>
        </div>

        <div class="date-box">
            <div>
                <span class="date-label">Issue Date</span>
                <p class="date-val">{{ \Carbon\Carbon::parse($borrow->issued_date)->format('d M, Y') }}</p>
            </div>
            <div style="text-align: right;">
                <span class="date-label">Due Date</span>
                <p class="date-val due">{{ \Carbon\Carbon::parse($borrow->due_date)->format('d M, Y') }}</p>
            </div>
        </div>

        <div class="total-row">
            <h2 class="total-label">Total to Pay</h2>
            <h1 class="total-amount">${{ number_format($borrow->book->price, 2) }}</h1>
        </div>

        <div class="action-buttons no-print">
            <button onclick="window.print()" class="btn btn-print">
                🖨️ Print
            </button>

            <button onclick="alert('Payment Gateway will be integrated soon!')" class="btn btn-pay">
                💳 Pay Now
            </button>
        </div>

        <a href="{{ route('user.dashboard') }}" class="back-link no-print">&larr; Back to Dashboard</a>

    </div>
</div>

@endsection