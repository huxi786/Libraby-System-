<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<footer class="pro-footer">
    <div class="footer-container">
        
        <div class="footer-col">
            <div class="footer-logo">
                <i class="fas fa-book-reader"></i> Library<span>PRO</span>
            </div>
            <p class="footer-text">
                Manage your books, track issues, and organize authors with our premium Library Management System. 
                Efficient, Fast, and Secure.
            </p>
            
            <div class="social-links">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <div class="footer-col">
            <h4 class="footer-heading">Quick Links</h4>
            <ul class="footer-links">
                <li><a href="{{ route('admin.welcome') }}"><i class="fas fa-chevron-right"></i> Home</a></li>
                
                @auth
                    <li><a href="{{ route('books.category', 'all') }}"><i class="fas fa-chevron-right"></i> Browse Books</a></li>
                    {{-- 👇👇 UPDATED LINE (Icon added) 👇👇 --}}
                    <li><a href="{{ route('faq') }}"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                    <li><a href="{{ route('rules') }}"><i class="fas fa-chevron-right"></i> Library Rules</a></li>
                @else
                    <li><a href="{{ route('login') }}"><i class="fas fa-chevron-right"></i> Login</a></li>
                    <li><a href="{{ route('register') }}"><i class="fas fa-chevron-right"></i> Register</a></li>
                    {{-- Agar guest user ko bhi FAQ dikhana hai to ye line yahan bhi add kar sakte hain --}}
                    <li><a href="{{ route('faq') }}"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                @endauth
            </ul>
        </div>

        <div class="footer-col">
            <h4 class="footer-heading">Contact Us</h4>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Gulberg III, Lahore, Pakistan</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <span>+92 321 7079965</span>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <span>support@librarypro.com</span>
            </div>
        </div>

    </div>
</footer>

<style>
    /* Footer Base */
    .pro-footer {
        background: linear-gradient(135deg, #015551 0%, #002b29 100%);
        color: #FDFBEE;
        padding-top: 60px;
        margin-top: 50px;
        font-family: 'Segoe UI', sans-serif;
        box-shadow: 0 -5px 20px rgba(0,0,0,0.1);
        border-top: 5px solid #FE4F2D; /* Orange Line Top */
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px 40px 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
    }

    .footer-col {
        flex: 1;
        min-width: 250px;
    }

    /* Branding */
    .footer-logo {
        font-size: 28px;
        font-weight: 800;
        color: #fff;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .footer-logo span { color: #FE4F2D; }
    .footer-text { font-size: 14px; line-height: 1.6; opacity: 0.8; margin-bottom: 20px; }

    /* Social Icons (Rotation Effect) */
    .social-links { display: flex; gap: 10px; }
    .social-links a {
        width: 40px; height: 40px;
        background: rgba(255,255,255,0.1);
        display: flex; align-items: center; justify-content: center;
        color: white; border-radius: 50%;
        text-decoration: none; transition: 0.4s;
    }
    .social-links a:hover {
        transform: rotate(360deg) scale(1.1); /* Ghumne wala effect */
    }

    /* Headings */
    .footer-heading {
        font-size: 20px; font-weight: 700; margin-bottom: 20px;
        position: relative; padding-bottom: 10px;
    }
    .footer-heading::after {
        content: ''; position: absolute; left: 0; bottom: 0;
        width: 50px; height: 3px; background: #FE4F2D; border-radius: 2px;
    }

    /* Quick Links (Slide Effect) */
    .footer-links { list-style: none; padding: 0; }
    .footer-links li { margin-bottom: 12px; }
    .footer-links a {
        color: #ddd; text-decoration: none; font-size: 15px;
        transition: 0.3s; display: inline-block;
    }
    /* Icon style for links */
    .footer-links a i { font-size: 12px; margin-right: 8px; color: #FE4F2D; transition: 0.3s; }
    
    .footer-links a:hover {
        transform: translateX(10px); /* Right Slide Effect */
    }
    .footer-links a:hover i { margin-right: 12px; }

    /* Contact Info */
    .contact-item {
        display: flex; align-items: center; gap: 15px; margin-bottom: 15px; font-size: 15px;
    }
    .contact-item i {
        color: #FE4F2D; font-size: 18px; width: 20px; text-align: center;
    }

    /* Bottom Copyright Bar */
    .footer-bottom {
        background: rgba(0, 0, 0, 0.2);
        padding: 20px;
        text-align: center;
        font-size: 14px;
        color: #bbb;
        border-top: 1px solid rgba(255,255,255,0.05);
        display: flex;
        justify-content: space-between;
        padding-left: 50px; padding-right: 50px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer-bottom { flex-direction: column; gap: 10px; }
    }
</style>