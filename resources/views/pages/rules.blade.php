@extends('layouts.user_layout')

@section('title', 'Library Rules & Policies - LibraryPRO')

@section('content')

<style>
    /* --- PAGE WRAPPER --- */
    .rules-wrapper {
        background-color: #f4f7f6;
        padding: 60px 20px;
        min-height: 80vh;
        font-family: 'Poppins', sans-serif;
    }

    .rules-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* --- HEADER --- */
    .page-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .page-header h1 {
        color: #015551;
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .page-header p {
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* --- POLICY CARDS --- */
    .policy-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .policy-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-top: 5px solid #015551;
        transition: 0.3s;
        position: relative;
        overflow: hidden;
    }

    .policy-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(1, 85, 81, 0.15);
        border-top-color: #FE4F2D;
    }

    .policy-icon {
        width: 60px; height: 60px; background: #e0f2f1; color: #015551;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; margin-bottom: 20px; transition: 0.3s;
    }

    .policy-card:hover .policy-icon { background: #FE4F2D; color: white; }

    .policy-card h3 { font-weight: 700; color: #333; margin-bottom: 15px; }

    .policy-list { list-style: none; padding: 0; margin: 0; }
    .policy-list li { position: relative; padding-left: 20px; margin-bottom: 10px; color: #555; font-size: 0.95rem; line-height: 1.6; }
    .policy-list li::before { content: '•'; color: #FE4F2D; font-weight: bold; position: absolute; left: 0; }

    /* --- FINE TABLE SECTION --- */
    .fine-section {
        margin-top: 60px; background: white; padding: 40px;
        border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .fine-section h2 { color: #015551; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }

    /* --- TABLE RESPONSIVE --- */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .custom-table {
        width: 100%; border-collapse: collapse; margin-top: 20px;
        min-width: 600px; /* Mobile par width maintain karega */
    }

    .custom-table th, .custom-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
    .custom-table th { background: #f4f7f6; color: #333; font-weight: 700; white-space: nowrap; }
    .custom-table tr:hover { background: #fafafa; }
    .amount { color: #FE4F2D; font-weight: bold; }

    /* --- 🟢 SCROLL HINT (MOBILE ONLY) --- */
    .scroll-hint {
        display: none; /* Desktop par hide */
        text-align: center;
        font-size: 0.9rem;
        color: #FE4F2D;
        margin-top: 15px;
        font-weight: 500;
        animation: fadeIn 1s infinite alternate; /* Halki si blinking animation */
    }

    /* Mobile Styles */
    @media (max-width: 768px) {
        .fine-section { padding: 20px; }
        .page-header h1 { font-size: 2rem; }
        
        /* Mobile par hint dikhao */
        .scroll-hint { display: block; }
    }

    @keyframes fadeIn { from { opacity: 0.6; } to { opacity: 1; } }
</style>

<div class="rules-wrapper">
    <div class="rules-container">
        
        <div class="page-header">
            <h1>Rules & Regulations</h1>
            <p>To ensure a smooth experience for everyone, please adhere to the following library policies.</p>
        </div>

        <div class="policy-grid">
            {{-- CARD 1 --}}
            <div class="policy-card">
                <div class="policy-icon"><i class="fas fa-id-card"></i></div>
                <h3>Membership Policy</h3>
                <ul class="policy-list">
                    <li>Membership is mandatory for borrowing books.</li>
                    <li>Library cards are non-transferable.</li>
                    <li>Lost cards must be reported immediately.</li>
                    <li>Admin approval is required for account activation.</li>
                </ul>
            </div>

            {{-- CARD 2 --}}
            <div class="policy-card">
                <div class="policy-icon"><i class="fas fa-book-reader"></i></div>
                <h3>Borrowing Rules</h3>
                <ul class="policy-list">
                    <li>Members can borrow up to <strong>3 books</strong> at a time.</li>
                    <li>Books must be returned within <strong>14 days</strong>.</li>
                    <li>Re-issuing is allowed only if the book is not reserved by others.</li>
                    <li>Reference books cannot be taken outside the library.</li>
                </ul>
            </div>

            {{-- CARD 3 --}}
            <div class="policy-card">
                <div class="policy-icon"><i class="fas fa-volume-mute"></i></div>
                <h3>Code of Conduct</h3>
                <ul class="policy-list">
                    <li>Maintain silence in the reading area.</li>
                    <li>Eating and drinking are strictly prohibited inside.</li>
                    <li>Use of mobile phones is not allowed in reading halls.</li>
                    <li>Handle books with care; do not mark or fold pages.</li>
                </ul>
            </div>
        </div>

        {{-- FINE STRUCTURE --}}
        <div class="fine-section">
            <h2><i class="fas fa-exclamation-circle"></i> Fines & Penalties</h2>
            <p style="color:#666; margin-bottom:20px;">Late returns or damage to property will incur the following charges:</p>
            
            {{-- Table Wrapper --}}
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Violation Type</th>
                            <th>Details</th>
                            <th>Charges</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Late Return</td>
                            <td>Per day after due date</td>
                            <td class="amount">$0.50 / day</td>
                        </tr>
                        <tr>
                            <td>Damaged Book</td>
                            <td>Torn pages, water damage, writing</td>
                            <td class="amount">100% of Book Cost</td>
                        </tr>
                        <tr>
                            <td>Lost Book</td>
                            <td>Replacement required</td>
                            <td class="amount">Current Market Price + $10 Fee</td>
                        </tr>
                        <tr>
                            <td>Lost Membership Card</td>
                            <td>Re-issuing duplicate card</td>
                            <td class="amount">$5.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- 🟢 SCROLL HINT TEXT (Neeche) --}}
            <p class="scroll-hint">
                <i class="fas fa-arrows-alt-h"></i> Scroll right to see charges
            </p>
            
        </div>

    </div>
</div>

{{-- @include('partials.footer') --}}

@endsection