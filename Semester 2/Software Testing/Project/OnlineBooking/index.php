<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MovieZone - Book Your Tickets</title>
    <link rel="stylesheet" href="styles.css" />
    <script defer src="script.js"></script>
    <script
      src="https://kit.fontawesome.com/b5b6622958.js"
      crossorigin="anonymous"
    ></script>
  </head>
  <body>
    <header>
      <div class="logo">🎬 Ticket<span>Ease</span></div>
      <nav>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="#movies">Movies</a></li>
          <li><a href="#Works">How it works?</a></li>
          <li><a href="#Contact">Contact Us</a></li>
          <li><a href="form.php">Sign Up</a></li>
        </ul>
        <div class="menu-icon">&#9776;</div>
      </nav>
    </header>

    <section class="hero">
      <div class="hero-content">
        <h1>🎟️ Experience Cinema Like Never Before</h1>
        <p>Book your tickets for the latest blockbuster movies, hassle-free!</p>
        <a href="#movies" class="btn">Browse Movies</a>
      </div>
    </section>

    <section class="movies-section" id="movies">
      <h2>🍿 Featured Movies</h2>
      <div class="movies-container">
        <div class="movie">
          <img src="assets/image/fastX.jpeg" alt="Fast & Furious 10" />
          <h3>Fast & Furious 10</h3>
          <p>Experience the ultimate high-speed action adventure.</p>
          <a href="login.html" class="btn small">Book Now</a>
        </div>
        <div class="movie">
          <img src="assets/image/darkknight.jpeg" alt="The Dark Knight Rises" />
          <h3>The Dark Knight Rises</h3>
          <p>The legendary Batman fights for Gotham once again.</p>
          <a href="login.html" class="btn small">Book Now</a>
        </div>
        <div class="movie">
          <img src="assets/image/intesteler.jpeg" alt="Interstellar" />
          <h3>Interstellar</h3>
          <p>A space adventure that will leave you in awe.</p>
          <a href="login.html" class="btn small">Book Now</a>
        </div>
      </div>
    </section>

    <section class="how-it-works" id="Works">
      <h2>🎥 How It Works</h2>
      <div class="steps">
        <div class="step">
          <img src="assets/image/magnifying-glass.gif" alt="" />
          <h3>Find Your Movie</h3>
          <p>Browse the latest releases and select your favorite show.</p>
        </div>
        <div class="step">
          <img src="assets/image/recommendation.gif" alt="" />
          <h3>Book Your Ticket</h3>
          <p>
            Choose seats, pay securely, and receive an instant confirmation.
          </p>
        </div>
        <div class="step">
          <img src="assets/image/cinema.gif" alt="" />
          <h3>Enjoy The Show</h3>
          <p>Get your e-ticket and experience cinema magic.</p>
        </div>
      </div>
    </section>

    <section class="reviews">
      <h2>⭐ What Our Customers Say</h2>
      <div class="review-cards">
        <div class="review">
          <img src="assets/image/User1.avif " alt="User" />
          <p>"Super easy booking! The process was smooth and fast."</p>
          <h4>- Rahul Saxena</h4>
        </div>
        <div class="review">
          <img src="assets/image/user2.avif" alt="User" />
          <p>"Best way to book movie tickets! Highly recommended."</p>
          <h4>- Priya Sharma</h4>
        </div>
        <div class="review">
          <img src="assets/image/user4.avif" alt="User" />
          <p>"Amazing service! I got my tickets in seconds!"</p>
          <h4>- Ankit Verma</h4>
        </div>
        <div class="review">
          <img src="assets/image/user3.avif" alt="User" />
          <p>"Loved the experience! Seamless booking process."</p>
          <h4>- Sneha Gupta</h4>
        </div>
        <div class="review">
          <img src="assets/image/user5.avif" alt="User" />
          <p>"Incredible UI and very easy to use!"</p>
          <h4>- Aman Mehta</h4>
        </div>
        <div class="review">
          <img src="assets/image/user6.avif" alt="User" />
          <p>"Booking was a breeze! Highly recommend."</p>
          <h4>- Nisha Kapoor</h4>
        </div>
        <div class="review">
          <img src="assets/image/user7.avif" alt="User" />
          <p>"Never had such a smooth ticket booking experience!"</p>
          <h4>- Kunal Joshi</h4>
        </div>
        <div class="review">
          <img src="assets/image/user8.avif" alt="User" />
          <p>"Customer support was fantastic!"</p>
          <h4>- Ritu Sharma</h4>
        </div>
        <div class="review">
          <img src="assets/image/user9.avif" alt="User" />
          <p>"Fast, simple, and secure booking."</p>
          <h4>- Rohit Sen</h4>
        </div>
        <div class="review">
          <img src="assets/image/user10.avif" alt="User" />
          <p>"The best movie ticket booking platform ever!"</p>
          <h4>- Meera Jain</h4>
        </div>
      </div>
    </section>

    <div id="footer-placeholder"></div>
    <script>
      fetch("footer.html")
        .then((response) => response.text())
        .then((data) => {
          document.getElementById("footer-placeholder").innerHTML = data;
        })
        .catch((error) => console.error("Error loading footer:", error));
    </script>
    <div class="GoTop">
      <i class="fa-solid fa-arrow-up"></i>
    </div>
    <div id="progress-bar"></div>
    <link rel="stylesheet" href="styles.css" />
  </body>
</html>