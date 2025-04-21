<?php
session_start();
require_once '../config.php';


// Get movie details from URL
if (!isset($_GET['movie_id'], $_GET['title'], $_GET['price'], $_GET['show_time'])) {
    die("Invalid movie selection.");
}

$movie_id = $_GET['movie_id'];
$title = urldecode($_GET['title']);
$price = $_GET['price'];
$show_time = urldecode($_GET['show_time']);

$theaters = [];
$sql = "SELECT id, name, city FROM theaters;";
$result = $conn->query($sql); while ($row = $result->fetch_assoc()) {
$theaters[] = $row; } ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Select Theater</title>
    <style>
      /* General Styles */
      body {
        font-family: "Poppins", sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
      }

      /* Navigation Bar */
      nav {
        background-color: #ff5733;
        padding: 15px;
        text-align: center;
      }

      .logo {
        color: white;
        font-size: 22px;
        text-decoration: none;
        font-weight: bold;
      }

      /* Booking Container */
      .booking-container {
        width: 90%;
        max-width: 600px;
        margin: 30px auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      }

      h2 {
        text-align: center;
        color: #333;
        font-size: 22px;
        margin-bottom: 10px;
      }

      .booking-container p {
        font-size: 16px;
        color: #555;
        text-align: center;
        margin: 5px 0;
      }

      .booking-container strong {
        color: #ff5733;
      }

      /* Form Styles */
      form {
        display: flex;
        flex-direction: column;
        gap: 15px;
      }

      label {
        font-size: 16px;
        font-weight: bold;
        color: #333;
      }

      select,
      input[type="number"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
      }

      select {
        cursor: pointer;
      }

      /* Button */
      button {
        background-color: #ff5733;
        color: white;
        font-size: 18px;
        font-weight: bold;
        border: none;
        padding: 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
      }

      button:hover {
        background-color: #e64a19;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .booking-container {
          width: 95%;
          padding: 20px;
        }

        h2 {
          font-size: 20px;
        }

        button {
          font-size: 16px;
          padding: 10px;
        }
      }
    </style>
  </head>
  <body>
    <nav>
      <div class="movies-container">
        <a href="#" class="logo">🎬 MovieZone</a>
      </div>
    </nav>

    <div class="booking-container">
      <h2>
        Select a Theater for:
        <span><?php echo htmlspecialchars($title); ?></span>
      </h2>
      <p>
        <strong>Show Time:</strong>
        <?php echo htmlspecialchars($show_time); ?>
      </p>
      <p>
        <strong>Ticket Price:</strong> $<?php echo htmlspecialchars($price); ?>
      </p>

      <form action="confirm_booking.php" method="POST">
        <input
          type="hidden"
          name="movie_id"
          value="<?php echo htmlspecialchars($movie_id); ?>"
        />
        <input
          type="hidden"
          name="title"
          value="<?php echo htmlspecialchars($title); ?>"
        />
        <input
          type="hidden"
          name="price"
          value="<?php echo htmlspecialchars($price); ?>"
        />
        <input
          type="hidden"
          name="show_time"
          value="<?php echo htmlspecialchars($show_time); ?>"
        />

        <label for="theater">Choose a Theater:</label>
        <select name="theater_id" id="theater" required>
          <option value="">Select a Theater</option>
          <?php foreach ($theaters as $theater) : ?>
          <option value="<?php echo $theater['id']; ?>">
            <?php echo htmlspecialchars($theater['name']) . " - " . htmlspecialchars($theater['city']); ?>
          </option>
          <?php endforeach; ?>
        </select>

        <label for="seats">Number of Seats:</label>
        <input type="number" name="ticket_count" id="seats" min="1" required />

        <button type="submit">Proceed to Payment</button>
      </form>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const theaterSelect = document.getElementById("theater");
        const userCityDisplay = document.createElement("p");
        userCityDisplay.style.textAlign = "center";
        userCityDisplay.style.fontSize = "16px";
        userCityDisplay.style.color = "#555";
        document
          .querySelector(".booking-container")
          .insertBefore(userCityDisplay, document.querySelector("form"));

        // Function to get user's location
        function getUserLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(async (position) => {
              const lat = position.coords.latitude;
              const lon = position.coords.longitude;

              try {
                // Use reverse geocoding to get city name
                const response = await fetch(
                  `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`
                );
                const data = await response.json();

                if (data && data.address) {
                  const city =
                    data.address.city ||
                    data.address.town ||
                    data.address.village ||
                    "Unknown City";

                  userCityDisplay.innerHTML = `📍 Your Location: <strong>${city}</strong>`;

                  // Fetch and display theaters based on city
                  fetchTheaters(city);
                }
              } catch (error) {
                console.error("Error fetching location:", error);
              }
            });
          } else {
            console.error("Geolocation not supported by this browser.");
          }
        }

        // Fetch theaters based on user's city
        async function fetchTheaters(city) {
          try {
            const response = await fetch(
              `fetch_theaters.php?city=${encodeURIComponent(city)}`
            );
            const theaters = await response.json();

            theaterSelect.innerHTML = `<option value="">Select a Theater</option>`; // Reset dropdown

            if (theaters.length === 0) {
              theaterSelect.innerHTML = `<option value="">No theaters available in your city</option>`;
            } else {
              theaters.forEach((theater) => {
                const option = document.createElement("option");
                option.value = theater.id;
                option.textContent = `${theater.name} - ${theater.city}`;
                theaterSelect.appendChild(option);
              });
            }
          } catch (error) {
            console.error("Error fetching theaters:", error);
          }
        }

        // Call function to get user's location
        getUserLocation();
      });
    </script>
  </body>
</html>
