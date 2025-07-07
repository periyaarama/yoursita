<x-app-layout>
  <div style="background: linear-gradient(to right, #ffe3a3, #fbc0c6);">

    <style>
      @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap');

      @font-face {
        font-family: 'AnandaBlack';
        src: url('{{ asset('fonts/AnandaBlack.ttf') }}') format('truetype');
        font-weight: normal;
        font-style: normal;
      }

      .dashboard-wrapper {
        max-width: 1000px;
        margin: 0 auto;
        padding: 50px 20px 50px 20px;
      }

      .hero-section {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-family: 'Georgia', serif;
        gap: 30px;
        flex-wrap: wrap;
      }

      .hero-text {
        max-width: 500px;
      }

      .hero-text h1 {
        margin-bottom: 10px;
      }

      .hero-text .welcome-text {
        font-family: 'Playfair Display', serif;
        font-size: 32px;
        font-weight: 700;
        color: #000;
        display: block;
      }

      .hero-text .brand-name {
        font-family: 'Brush Script MT', cursive;
        font-size: 90px;
        color: #000;
        display: block;
        margin-top: -5px;
      }

      .hero-text p {
        font-size: 20px;
        color: #333;
        margin-bottom: 25px;
        margin-left: 12px;
      }

      .hero-text a {
        padding: 12px 24px;
        background-color: #f1c40f;
        color: black;
        text-decoration: none;
        border-radius: 25px;
        font-weight: bold;
      }

      .hero-img img {
        max-width: 360px;
        border-radius: 16px;
      }

      @media (max-width: 768px) {
        .hero-section {
          flex-direction: column;
          text-align: center;
        }

        .hero-img img {
          margin-top: 30px;
          max-width: 90%;
        }
      }
    </style>

    <div class="dashboard-wrapper">
      <div class="hero-section">
        <div class="hero-text">
          <h1>
            <span class="welcome-text">Welcome to</span>
            <span class="brand-name">YOURSITA</span>

          </h1>
          <p>
            Bringing elegance to your special day. <br>
            Bridal makeup, personal glam sessions, <br>
            henna artistry, and the finest accessories — <br>
            designed for your dream look.
          </p>

          <a href="{{ route('portfolio') }}">View Portfolio</a>
        </div>

        <div class="hero-img">
          <img src="{{ asset('images/yosita.jpg') }}" alt="Bridal Makeup">
        </div>
      </div>
    </div>
  </div>

  <!-- About Section -->
  <section id="about" style="background-color: #fff4dc; padding: 60px 20px;">
    <style>
      .about-wrapper {
        max-width: 1100px;
        margin: 0 auto;
        display: flex;
        gap: 30px;
        align-items: center;
        flex-wrap: wrap;
      }

      .about-image {
        flex: 1;
      }

      .about-image img {
        width: 100%;
        max-width: 450px;
        border-radius: 16px;
      }

      .about-text {
        flex: 1;
        font-family: 'Georgia', serif;
      }

      .about-text h2 {
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #d24f55;
      }

      .about-text p {
        font-size: 18px;
        color: #333;
        line-height: 1.7;
      }

      @media (max-width: 768px) {
        .about-wrapper {
          flex-direction: column;
          text-align: center;
        }

        .about-text {
          margin-top: 20px;
        }
      }
    </style>

    <div class="about-wrapper">
      <div class="about-image">
        <img src="{{ asset('images/about_image.jpeg') }}" alt="About Yoursita">
      </div>
      <div class="about-text text-justify text-left">
        <h2>About YOURSITA</h2>
        <p>
          <strong>YOURSITA</strong> is a dedicated bridal booking service offering personalized makeup artistry for
          <strong>Indian and Chinese bridal looks</strong>. We specialize in <strong>custom henna designs</strong>
          for brides and group events like family functions, provide <strong>hair styling for personal
            makeovers</strong>,
          and offer expert <strong>saree draping services</strong> to complete your traditional ensemble.Additionally,
          we
          offer a <strong>complete bridal package</strong> tailored for Indian weddings, ensuring every detail from
          makeup to attire is flawlessly taken care of.
        </p>
      </div>
    </div>
  </section>

  <!-- Service Section -->
  <section id="services" style="background: linear-gradient(to right, #ffe3a3, #fbc0c6); padding: 80px 20px;">
    <style>
      .services-container {
        max-width: 1100px;
        margin: 0 auto;
        text-align: center;
        font-family: 'Georgia', serif;
      }

      .services-title {
        font-size: 40px;
        color: #3b2f2f;
        margin-bottom: 50px;
      }

      .bubble-grid {
        display: flex;
        justify-content: center;
        /* Center the bubbles */
        gap: 20px;
        flex-wrap: wrap;
        /* Allow wrapping to the next line instead of scrolling */
      }


      .service-bubble {
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 50%;
        width: 165px;
        height: 165px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
      }


      .service-bubble:hover {
        transform: scale(1.05);
      }

      .service-bubble span {
        font-size: 29px;
      }

      .service-bubble p {
        margin-top: 6px;
        font-size: 15px;
        font-weight: bold;
        color: #3a2e2e;
      }

      @media (max-width: 768px) {
        .service-bubble {
          width: 110px;
          height: 110px;
        }

        .service-bubble span {
          font-size: 20px;
        }

        .service-bubble p {
          font-size: 13px;
        }
      }
    </style>


    <div class="services-container">
      <h2 class="services-title"><strong>Services</strong></h2>
      <div class="bubble-grid">
        <a href="{{ route('makeover.details') }}" class="service-bubble">
          <span>💅</span>
          <p>Personal Makeover</p>
        </a>

        <a href="{{ route('bridal.details') }}" class="service-bubble">
          <span>👰</span>
          <p>Bridal Package</p>
        </a>

        <a href="{{ route('makeup.details') }}" class="service-bubble">
          <span>💄</span>
          <p>Makeup</p>
        </a>

        <a href="{{ route('hairdo.details') }}" class="service-bubble">
          <span>💇‍♀️</span>
          <p>Hairdo</p>
        </a>

        <a href="{{ route('saree.details') }}" class="service-bubble">
          <span>🧣</span>
          <p>Saree Drapping</p>
        </a>


        <a href="{{ route('services.henna') }}" class="service-bubble">
          <span>🖌️</span>
          <p>Henna Drawing</p>
        </a>



      </div>
    </div>
  </section>


  <!-- Customer Feedback Section -->
  <section id="feedback" style="background-color: #fff4dc; padding: 60px 20px;">
    <style>
      .feedback-section {
        max-width: 1100px;
        margin: 0 auto;
        font-family: 'Georgia', serif;
        text-align: center;
      }

      .feedback-section h2 {
        font-size: 36px;
        margin-bottom: 40px;
        color: #d24f55;
      }

      .feedback-carousel {
        position: relative;
        background-color: #fff9f2;
        padding: 40px 20px;
        border-radius: 20px;
        margin-bottom: 60px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
      }

      .feedback-slide {
        display: none;
        font-size: 18px;
        color: #444;
        max-width: 700px;
        margin: 0 auto;
        min-height: 80px;
      }

      .feedback-slide.active {
        display: block;
        transition: all 0.5s ease-in-out;
      }

      .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: #f1c40f;
        border: none;
        width: 45px;
        height: 45px;
        border-radius: 50%;
        font-size: 20px;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        cursor: pointer;
      }

      .nav-btn:hover {
        background-color: #e0b808;
      }

      .prev-btn {
        left: 20px;
      }

      .next-btn {
        right: 20px;
      }

      .feedback-form {
        max-width: 700px;
        margin: 0 auto;
        text-align: center;
      }

      .feedback-form form {
        display: flex;
        flex-direction: column;
        gap: 20px;
      }

      .feedback-form input,
      .feedback-form textarea {
        padding: 14px;
        font-size: 16px;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
        background-color: #fffdf8;
      }

      .feedback-form input:focus,
      .feedback-form textarea:focus {
        border-color: #f1c40f;
      }

      .feedback-form button {
        background-color: #f1c40f;
        border: none;
        padding: 12px 20px;
        border-radius: 25px;
        font-weight: bold;
        color: #000;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      .feedback-form button:hover {
        background-color: #ddb90c;
      }
    </style>

    <div class="feedback-section">
      <h2><strong>Customer Feedback</strong></h2>

      <div class="feedback-carousel">
        @php $first = true; @endphp
        @foreach ($feedbacks as $feedback)
      <div class="feedback-slide {{ $first ? 'active' : '' }}">
        "{{ $feedback->message }}" – {{ $feedback->name }}
      </div>
      @php $first = false; @endphp
    @endforeach


        <button class="nav-btn prev-btn" onclick="plusSlide(-1)">←</button>
        <button class="nav-btn next-btn" onclick="plusSlide(1)">→</button>
      </div>

      <div class="feedback-form">
        <h2><strong>Leave Your Feedback</strong></h2>

        @if (session('success'))
      <div style="margin-bottom: 20px; color: green; font-weight: bold;">
        {{ session('success') }}
      </div>
    @endif

        <form method="POST" action="{{ route('feedback.store') }}">
          @csrf
          <input type="text" name="name" placeholder="Your Name" required>
          <input type="email" name="email" placeholder="Your Email" required>
          <textarea name="message" rows="5" placeholder="Your feedback..." required></textarea>
          <button type="submit">Submit Feedback</button>
        </form>
      </div>


      <script>
        let currentSlide = 0;
        const slides = document.querySelectorAll(".feedback-slide");

        function showSlide(index) {
          slides.forEach((slide, i) => {
            slide.classList.toggle("active", i === index);
          });
        }

        function plusSlide(n) {
          currentSlide = (currentSlide + n + slides.length) % slides.length;
          showSlide(currentSlide);
        }

        setInterval(() => plusSlide(1), 5000); // Auto slide every 5s
      </script>
  </section>

  <!-- FAQ section -->
  <section id="faq" style="background: linear-gradient(to right, #ffe3a3, #fbc0c6); padding: 60px 20px;">
    <style>
      .faq-container {
        max-width: 900px;
        margin: 0 auto;
        font-family: 'Georgia', serif;
      }

      .faq-container h2 {
        text-align: center;
        font-size: 36px;
        margin-bottom: 40px;
        color: #d24f55;
        font-weight: bold;
      }

      .faq-item {
        background-color: #fff;
        border-radius: 12px;
        margin-bottom: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.4s ease;
      }

      .faq-question {
        padding: 20px 24px;
        font-weight: bold;
        font-size: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
      }

      .faq-answer {
        max-height: 0;
        overflow: hidden;
        padding: 0 24px;
        font-size: 16px;
        color: #444;
        line-height: 1.6;
        transition: max-height 0.4s ease, padding 0.3s ease;
      }

      .faq-item.open .faq-answer {
        max-height: 500px;
        padding: 16px 24px 24px;
      }

      .faq-icon {
        font-size: 24px;
        transition: transform 0.3s ease;
      }

      .faq-item.open .faq-icon {
        transform: rotate(45deg);
      }
    </style>

    <div class="faq-container">
      <h2>Frequently Asked Questions (FAQs)</h2>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(this)">
          How will payment be done in YOURSITA?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
          Payments are accepted via online payment gateway for deposit and cash or bank transfer for full payment.
          A deposit is required to secure your booking.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(this)">
          Is the deposit refundable if the client decides to cancel or is late for the appointment?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
          The deposit is non-refundable to compensate for the reserved slot and preparation time.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(this)">
          Can I pay the balance only by the end of the day or when I have the time to do so?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
          All payments need to be settled during or after the session. End-of-day payment is allowed.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(this)">
          Do the prices change over time?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
          Prices may vary depending on season, style requested, and add-ons. You'll be informed of any updates during
          further discusion with Yosita.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(this)">
          What is the difference between a bridal and personal look?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
          Bridal looks include full package prep (accessories, glam, etc.), while personal looks are lighter for events
          or photoshoots.
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-question" onclick="toggleFAQ(this)">
          How early should I book for my wedding?
          <span class="faq-icon">+</span>
        </div>
        <div class="faq-answer">
          We recommend booking at least 2–3 months in advance to secure your desired date and avoid peak season
          conflicts.
        </div>
      </div>
    </div>

    <script>
      function toggleFAQ(element) {
        const item = element.closest('.faq-item');
        item.classList.toggle('open');
      }
    </script>
  </section>


  <!-- Contact Section -->
  <section id="contact" style="background-color: #fff4dc; padding: 60px 20px;">
    <style>
      .contact-section {
        max-width: 1000px;
        margin: 0 auto;
        font-family: 'Georgia', serif;
        text-align: center;
      }

      .contact-section h2 {
        font-size: 36px;
        margin-bottom: 10px;
        color: #d24f55;
      }

      .contact-section p {
        font-size: 16px;
        color: #555;
        margin-bottom: 40px;
      }

      .whatsapp-button {
        display: inline-block;
        background-color: #25D366;
        color: white;
        padding: 14px 28px;
        border-radius: 30px;
        font-weight: bold;
        text-decoration: none;
        font-size: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: background-color 0.3s ease;
      }

      .whatsapp-button:hover {
        background-color: #1ebe5d;
      }

      .contact-info {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 50px;
      }

      .contact-box {
        flex: 1;
        min-width: 250px;
        background-color: #ffffff;
        padding: 50px 20px 30px;
        border-radius: 16px;
        position: relative;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      }

      .contact-box .icon {
        background-color: #f1c40f;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #fff;
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      }

      .contact-box h4 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 5px;
        color: #000;
        margin-top: 20px;
      }

      .contact-box p,
      .contact-box a {
        font-size: 17px;
        color: #555;
        line-height: 1.6;
        text-decoration: none;
      }

      .social-icons {
        display: flex;
        justify-content: center;
        gap: 30px;
        margin-top: 10px;
      }

      .social-icons a {
        color: #d24f55;
        font-size: 22px;
        transition: color 0.3s ease;
      }

      .social-icons a:hover {
        color: #b0303d;
      }
    </style>

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <div class="contact-section">
      <h2><strong>Contact Me</strong></h2>
      <p>Have any questions? Tap the button below to message me directly on WhatsApp.</p>

      <a class="whatsapp-button"
        href="https://wa.me/60165194721?text=Hi%20YOURSITA!%20I'm%20interested%20in%20your%20bridal%20services."
        target="_blank">
        💬 Send Message on WhatsApp
      </a>

      <div class="contact-info">
        <!-- PHONE -->
        <div class="contact-box">
          <div class="icon">📞</div>
          <h4>PHONE</h4>
          <p>+60 16-519 4721</p>
        </div>

        <!-- SOCIAL MEDIA -->
        <div class="contact-box">
          <div class="icon">📱</div>
          <h4>SOCIAL MEDIA</h4>
          <div class="social-icons">
            <a href="https://www.instagram.com/sita.hairandmakeup/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@sita.hairandmakeup?lang=en" target="_blank"><i class="fab fa-tiktok"></i></a>
          </div>
        </div>

        <!-- EMAIL -->
        <div class="contact-box">
          <div class="icon">📧</div>
          <h4>EMAIL</h4>
          <p>yosita.rama11@gmail.com</p>
        </div>
      </div>
    </div>
  </section>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Smooth scroll if landing with hash
      if (window.location.hash === "#services") {
        const target = document.querySelector("#services");
        if (target) {
          setTimeout(() => {
            target.scrollIntoView({ behavior: "smooth" });
          }, 200);
        }
      }

      // Smooth scroll on click for the nav link
      const serviceLink = document.querySelector('a[href="#services"]');
      if (serviceLink) {
        serviceLink.addEventListener("click", function (e) {
          e.preventDefault();
          const section = document.querySelector("#services");
          if (section) {
            section.scrollIntoView({ behavior: "smooth" });
          }
        });
      }
    });
  </script>



</x-app-layout>