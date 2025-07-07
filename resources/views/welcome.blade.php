<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>YOURSITA - Where Beauty Begins</title>
  <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
  <style>
    /* Ensure full-page background */
    html, body {
  margin: 0;
  padding: 0;
  height: 100%;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(to bottom right, #ffe3a3, #fbc0c6);
  overflow: hidden; /* 👈 prevents scroll */
}


    /* Central container taking full viewport height */
    .container {
      text-align: center;
      position: relative;
      z-index: 10;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    /* Wordmark styling */
    .wordmark {
      display: flex;
      align-items: flex-end; /* Align elements by the bottom edge */
      justify-content: center;
      margin: 0;
    }

    .logo-icon {
      width: 310px;  /* Larger logo */
      height: auto;
      margin-right: -120px;
      margin-bottom: 100px;  /* Negative value to push text closer */
    }

    .brand-text {
    font-size: 120px;
    color: #d24f55;
    font-weight: bold;
    letter-spacing: 2px;
    line-height: 1;
    margin: 0;
    transform: translateY(-23px); /* Adjusted from -10px to -25px */
    margin-bottom: 100px;
}


    /* Tagline styling */
    .tagline {
      font-size: 38px;
      font-weight: 500;
      color: #333;
      margin-top: -50px;
      margin-left: 100px;
      margin-bottom: 100px;
    }

    /* Buttons styling */
    .buttons {
      margin-top: -50px;
      margin-left: 110px;
      margin-bottom: 100px;
    }

    .buttons a {
      background-color: #f1c40f;
      color: black;
      padding: 20px 28px;
      margin: 10px;
      border: none;
      border-radius: 8px;
      font-size: 20px;
      font-weight: bold;
      text-decoration: none;
      transition: 0.3s;
    }

    .buttons a:hover {
      background-color: #e0ac00;
    }

    /* Bubbles styling */
    .bubbles {
  position: fixed; /* ← this is key */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1; /* lower than container */
  pointer-events: none; /* allow clicks through */
}

    .bubbles img {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  position: absolute;
  object-fit: cover;
  border: 4px solid rgba(255, 255, 255, 0.7);
}


/* Stagger animation delays for each bubble */
.b1 {
  top: 60px;
  left: 80px;
  animation: float 6s ease-in-out infinite;
}

.b2 {
  top: 40px;
  right: 350px;
  animation: floatLeftDown 6s ease-in-out infinite;
}

.b3 {
  bottom: 150px;
  left: 190px;
  animation: floatRightUp 6s ease-in-out infinite;
}

.b4 {
  bottom: 100px;
  right: 200px;
  animation: floatLeftUp 6s ease-in-out infinite;
}

.b5 {
  bottom: 390px;
  right: 10px;
  animation: floatRightDown 6s ease-in-out infinite;
}




    /* Example bubble positions */
    .b1 { top: 60px; left: 80px; }
    .b2 { top: 40px; right: 350px; }
    .b3 { bottom: 150px; left: 190px; }
    .b4 { bottom: 100px; right: 200px; }
    .b5 { bottom: 390px; right: 20px; }

    @keyframes float {
  0% {
    transform: translateY(0) translateX(0);
  }
  50% {
    transform: translateY(-20px) translateX(10px);
  }
  100% {
    transform: translateY(0) translateX(0);
  }
}

@keyframes floatLeftDown {
  0% {
    transform: translate(0, 0);
  }
  50% {
    transform: translate(-20px, 20px); /* Left and down */
  }
  100% {
    transform: translate(0, 0);
  }
}

@keyframes floatRightUp {
  0% {
    transform: translate(0, 0);
  }
  50% {
    transform: translate(20px, -20px); /* Right and up */
  }
  100% {
    transform: translate(0, 0);
  }
}

@keyframes floatLeftUp {
  0% {
    transform: translate(0, 0);
  }
  50% {
    transform: translate(-20px, -20px); /* Left and up */
  }
  100% {
    transform: translate(0, 0);
  }
}

@keyframes floatRightDown {
  0% {
    transform: translate(0, 0);
  }
  50% {
    transform: translate(20px, 20px); /* Right and down */
  }
  100% {
    transform: translate(0, 0);
  }
}
.decor-bubble {
  position: absolute;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.15);
  box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
  z-index: 0;
  pointer-events: none; /* ✅ This line makes them non-interactive */
  animation-name: floatBubble;
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
}


@keyframes floatBubble {
  0% {
    transform: translateY(0) scale(1);
    opacity: 1.5;
  }
  50% {
    transform: translateY(-40px) scale(1.2);
    opacity: 3.5;
  }
  100% {
    transform: translateY(0) scale(1);
    opacity: 1.5;
  }
}


  </style>
</head>
<body>
  <div class="container">
    <div class="wordmark">
      <img src="{{ asset('images/yoursita_logo.png') }}" alt="Y Logo" class="logo-icon">
      <span class="brand-text">OURSITA</span>
    </div>
    <p class="tagline">Where Beauty Begins</p>

    <div class="buttons">
      <a href="{{ route('login') }}">Login</a>
      <a href="{{ route('register') }}">Register</a>
    </div>

    <!-- Bubbles with bride images -->
    <div class="bubbles">
      <img src="{{ asset('images/bride1.jpg') }}" class="b1">
      <img src="{{ asset('images/bride2.jpeg') }}" class="b2">
      <img src="{{ asset('images/bride3.jpeg') }}" class="b3">
      <img src="{{ asset('images/bride4.png') }}" class="b4">
      <img src="{{ asset('images/bride5.webp') }}" class="b5">

    
    </div>
  </div>

  <script>
  const container = document.querySelector('.bubbles');

  for (let i = 0; i < 30; i++) {
    const bubble = document.createElement('div');
    bubble.className = 'decor-bubble';

    // Random position
    bubble.style.top = Math.random() * 100 + 'vh';
    bubble.style.left = Math.random() * 100 + 'vw';

    // Random size
    const size = Math.floor(Math.random() * 60) + 40;
    bubble.style.width = bubble.style.height = size + 'px';

    // Random animation delay and duration
    bubble.style.animationDelay = Math.random() * 5 + 's';
    bubble.style.animationDuration = (6 + Math.random() * 4) + 's';

    container.appendChild(bubble);
  }
</script>

</body>
</html>
