@extends('layouts.user_layout')

@section('title', 'Frequently Asked Questions - LibraryPRO')

@section('content')

{{-- @include('partials.header') --}}

<style>
    /* --- PAGE STYLING (Desktop Default) --- */
    .faq-wrapper {
        background-color: #f4f7f6;
        padding: 60px 20px;
        min-height: 80vh;
        font-family: 'Poppins', sans-serif;
    }

    .faq-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .faq-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .faq-header h1 {
        color: #015551;
        font-weight: 700;
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .faq-header p {
        color: #666;
        font-size: 1.1rem;
    }

    /* --- ACCORDION STYLES --- */
    .faq-item {
        background: white;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        overflow: hidden;
        transition: 0.3s;
        border: 1px solid transparent;
    }

    .faq-item:hover {
        box-shadow: 0 10px 25px rgba(1, 85, 81, 0.1);
        border-color: #b2dfdb;
    }

    .faq-question {
        padding: 20px 25px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
        font-weight: 600;
        color: #333;
        font-size: 1.1rem;
        transition: 0.3s;
    }

    .faq-question:hover {
        color: #015551;
    }

    .faq-question.active {
        background: #015551;
        color: white;
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease-out;
        background: #fafafa;
        color: #555;
        line-height: 1.6;
    }

    .faq-answer p {
        padding: 25px;
        margin: 0;
    }

    /* Icon Rotation */
    .faq-icon {
        transition: transform 0.3s ease;
        font-size: 1.2rem;
        margin-left: 10px; /* Thoda gap icon ke liye */
    }

    .faq-question.active .faq-icon {
        transform: rotate(180deg);
    }

    /* Contact Box */
    .contact-box {
        background: #e0f2f1;
        border-radius: 15px;
        padding: 30px;
        text-align: center;
        margin-top: 50px;
        border: 2px dashed #015551;
    }

    .contact-box h3 {
        color: #015551;
        margin-bottom: 10px;
    }

    .contact-btn {
        display: inline-block;
        background: #FE4F2D;
        color: white;
        padding: 10px 25px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: bold;
        margin-top: 15px;
        transition: 0.3s;
    }

    .contact-btn:hover {
        background: #d63c1f;
        transform: translateY(-2px);
    }

    /* ========================================= */
    /* 📱 MOBILE RESPONSIVE STYLES (Max Width 768px) */
    /* ========================================= */
    @media (max-width: 768px) {
        
        /* Wrapper Padding Kam karein */
        .faq-wrapper {
            padding: 30px 15px;
        }

        /* Header Chota Karein */
        .faq-header {
            margin-bottom: 30px;
        }

        .faq-header h1 {
            font-size: 1.8rem; /* 2.5rem se chota */
        }

        .faq-header p {
            font-size: 0.95rem;
        }

        /* FAQ Item Compact Karein */
        .faq-question {
            padding: 15px; /* Padding kam */
            font-size: 1rem; /* Text size adjust */
        }

        .faq-answer p {
            padding: 15px; /* Answer padding kam */
            font-size: 0.95rem;
        }

        .faq-item {
            margin-bottom: 15px; /* Items ke beech gap kam */
        }

        /* Contact Box Compact */
        .contact-box {
            padding: 20px;
            margin-top: 30px;
        }

        .contact-box h3 {
            font-size: 1.3rem;
        }
    }
</style>

<div class="faq-wrapper">
    <div class="faq-container">
        
        <div class="faq-header">
            <h1>Frequently Asked Questions</h1>
            <p>Everything you need to know about LibraryPRO services.</p>
        </div>

        {{-- FAQ 1 --}}
        <div class="faq-item">
            <div class="faq-question">
                <span>How do I request a book?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>
                    Simply browse the library collection from the 'Browse Library' page. Click on the "Request Book" button next to any available book. The admin will review your request and approve it.
                </p>
            </div>
        </div>

        {{-- FAQ 2 --}}
        <div class="faq-item">
            <div class="faq-question">
                <span>How long can I keep a book?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>
                    Standard borrowing time is <strong>14 days</strong>. If you need more time, please contact the admin or return the book and request it again. Late returns may incur a small fee.
                </p>
            </div>
        </div>

        {{-- FAQ 3 --}}
        <div class="faq-item">
            <div class="faq-question">
                <span>Why is my account status "Pending"?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>
                    When you first register, your account requires Admin approval for security reasons. Once the admin verifies your details, your status will change to "Active" and you can start borrowing.
                </p>
            </div>
        </div>

        {{-- FAQ 4 --}}
        <div class="faq-item">
            <div class="faq-question">
                <span>Can I request a book not in the library?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>
                    Yes! You can use the "Contact Us" page to send a message to the admin suggesting a new book. We love adding new titles based on user recommendations.
                </p>
            </div>
        </div>

        {{-- FAQ 5 --}}
        <div class="faq-item">
            <div class="faq-question">
                <span>How do I contact the Librarian?</span>
                <i class="fas fa-chevron-down faq-icon"></i>
            </div>
            <div class="faq-answer">
                <p>
                    You can use the built-in messaging system. Go to your Dashboard and click on "Support" or "Contact". You can also view your message history and admin replies there.
                </p>
            </div>
        </div>

        {{-- Contact CTA --}}
        <div class="contact-box">
            <h3>Still have questions?</h3>
            <p>Can't find the answer? Chat with our team.</p>
            <a href="{{ route('contact') }}" class="contact-btn">Get in Touch</a>
        </div>

    </div>
</div>

{{-- @include('partials.footer') --}}

<script>
    // Simple Accordion Script
    const questions = document.querySelectorAll('.faq-question');

    questions.forEach(question => {
        question.addEventListener('click', () => {
            const answer = question.nextElementSibling;
            
            // Toggle Active Class
            question.classList.toggle('active');

            // Toggle Height
            if (question.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + "px";
            } else {
                answer.style.maxHeight = 0;
            }

            // Close others when one opens (Auto-Collapse)
            questions.forEach(otherQuestion => {
                if (otherQuestion !== question && otherQuestion.classList.contains('active')) {
                    otherQuestion.classList.remove('active');
                    otherQuestion.nextElementSibling.style.maxHeight = 0;
                }
            });
        });
    });
</script>

@endsection