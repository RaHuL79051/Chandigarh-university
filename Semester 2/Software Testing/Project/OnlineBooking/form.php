<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Movie Booking - Signup/Login</title>
    <style>
      /* General Styles */
        body {
          font-family: Arial, sans-serif;
          background: #1c1c1c;
          color: white;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
        }

        /* Container */
        .container {
          background: #2a2a2a;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
          width: 350px;
          text-align: center;
          transition: all 0.3s ease-in-out;
        }

        /* Form Styling */
        .form-container h2 {
          text-align: center;
          margin-bottom: 15px;
        }

        input {
          width: 90%;
          padding: 10px;
          margin: 8px 0;
          border: none;
          border-radius: 5px;
          background: #333;
          color: white;
          outline: none;
          transition: all 0.3s ease;
        }

        input:focus {
          background: #444;
          box-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
        }

        input::placeholder {
          color: #aaa;
        }

        button {
          width: 100%;
          padding: 10px;
          margin-top: 10px;
          border: none;
          border-radius: 5px;
          background: crimson;
          color: white;
          cursor: pointer;
          font-weight: bold;
          transition: all 0.3s ease;
        }

        button:hover {
          background: darkred;
          transform: scale(1.05);
        }

        /* Checkbox Styling */
        label {
          display: block;
          margin: 10px 0;
          font-size: 14px;
        }

        input[type="checkbox"] {
          margin-right: 5px;
        }

        /* Toggle Buttons */
        .Switch,
        .SwitchBack {
          background: transparent;
          color: #fff;
          border: none;
          cursor: pointer;
          font-size: 14px;
          margin-top: 10px;
          text-decoration: underline;
          transition: color 0.3s ease;
        }

        .Switch:hover,
        .SwitchBack:hover {
          color: crimson;
        }

        h5 {
          margin: 10px 0;
          padding: 0;
          color: #888;
        }

        /* Hide login form by default */
        .hidden {
          display: none;
          opacity: 0;
          transition: opacity 0.5s ease-in-out;
        }

    </style>
  </head>
  <body>
    <div class="container">
      <div class="form-container">
        <!-- Signup Form -->
        <form action="signup.php" method="POST" id="signup-form">
          <h2>Signup</h2>
          <input type="text" name="name" placeholder="Full Name" required />
          <input type="text" name="username" placeholder="Username" required />
          <input type="email" name="email" placeholder="Email" required />
          <input type="text" name="phone" placeholder="Phone Number" required />
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
            autocomplete="current-password"
          />
          <input type="hidden" name="special_permission" value="0" />
          <label
            ><input type="checkbox" required /> Accept Terms & Conditions</label
          >
          <button type="submit">Signup</button>
          <h5>OR</h5>
        </form>
        <button class="Switch">Already Have an Account? Login Here</button>

        <!-- Login Form -->
        <form action="login.php" method="POST" id="login-form" class="hidden">
          <h2>Login</h2>
          <input type="text" name="username" placeholder="Username" required />
          <input
            type="password"
            name="password"
            placeholder="Password"
            required
          />
          <button type="submit">Login</button>
          <h5>OR</h5>
        </form>
        <button class="SwitchBack hidden">
          Don't Have an Account? Signup Here
        </button>
      </div>
    </div>
    <script>
      const switchButton = document.querySelector(".Switch");
      const switchBackButton = document.querySelector(".SwitchBack");
      const signupForm = document.querySelector("#signup-form");
      const loginForm = document.querySelector("#login-form");

      switchButton.addEventListener("click", () => {
        switchButton.classList.add("hidden");
        signupForm.classList.add("hidden");
        loginForm.classList.remove("hidden");
        switchBackButton.classList.remove("hidden");
      });

      switchBackButton.addEventListener("click", () => {
        switchBackButton.classList.add("hidden");
        loginForm.classList.add("hidden");
        signupForm.classList.remove("hidden");
        switchButton.classList.remove("hidden");
      });
    </script>
  </body>
</html>
