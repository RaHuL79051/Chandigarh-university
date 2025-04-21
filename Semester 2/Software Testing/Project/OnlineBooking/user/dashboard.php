<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Cards</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <nav>
      <div class="movies-container">
        <a href="#" class="logo">🎬 TicketEase</a>
        <ul class="nav-links">
          <li><a href="#">Home</a></li>
          <li><a href="./recent_booking.php">Recent Booking</a></li>
          <li><a href="./myaccount.php">My Account</a></li>
          <li><a href="./contactus.php">Contact Us</a></li>
        </ul>
        <div class="menu-icon">
          <i class="fas fa-bars"></i>
        </div>
      </div>
    </nav>
    <div class="movies-container" id="movies"></div>
    <script>
      document.addEventListener("DOMContentLoaded", async () => {
        const container = document.getElementById("movies");

        try {
          const res = await fetch("user_dashboard.php");
          if (!res.ok) throw new Error("Failed to fetch movies");

          const movies = await res.json();
          if (movies.error) throw new Error(movies.error);

          movies.forEach((movie) => {
            const card = document.createElement("div");
            card.classList.add("card");
            card.innerHTML = `
            <div class="wrapper">
                <img src="${movie.poster}" alt="${movie.name}">
                <h3>${movie.name}</h3>
                <p>${movie.description}</p>
                <p><strong>Price:</strong> $${movie.price}</p>
                <p><strong>Show Time:</strong> ${movie.show_time}</p>
            </div>
            <button class='BookNowButton' 
                data-id="${movie.id}" 
                data-title="${movie.name}" 
                data-price="${movie.price}" 
                data-showtime="${movie.show_time}">
                Book Now
            </button>
        `;
            container.appendChild(card);
          });

          document.querySelectorAll(".BookNowButton").forEach((button) => {
            button.addEventListener("click", (e) => {
              const movie_id = e.target.getAttribute("data-id");
              const movie_title = encodeURIComponent(
                e.target.getAttribute("data-title")
              );
              const price = e.target.getAttribute("data-price");
              const show_time = encodeURIComponent(
                e.target.getAttribute("data-showtime")
              );

              // Redirect to theater selection page with movie details
              window.location.href = `select_theater.php?movie_id=${movie_id}&title=${movie_title}&price=${price}&show_time=${show_time}`;
            });
          });
        } catch (error) {
          console.error("Error fetching movies:", error);
        }
      });
    </script>
  </body>
</html>
