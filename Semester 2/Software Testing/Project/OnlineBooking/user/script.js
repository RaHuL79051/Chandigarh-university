document.addEventListener('DOMContentLoaded', async () => {
  const container = document.getElementById('movies');

  try {
    const res = await fetch('user_dashboard.php');
    const movies = await res.json();

    movies.forEach(movie => {
      const card = document.createElement('div');
      card.classList.add('card');
      card.innerHTML = `
              <div class="wrapper">
                  <img src="${movie.poster}" alt="${movie.name}">
                  <h3>${movie.name}</h3>
                  <p>${movie.description}</p>
                  <p><strong>Price:</strong> $${movie.price}</p>
                  <p><strong>Show Time:</strong> ${movie.show_time}</p>
              </div>
              <button class='BookNowButton'>Book Now</button>
          `;
      container.appendChild(card);
    });
  } catch (error) {
    console.error('Error fetching movies:', error);
  }
});
