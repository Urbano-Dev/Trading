import React, { useState } from "react";

function Login({ onLogin }) {
  const [username, setUsername] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const handleLogin = async (e) => {
    e.preventDefault();

    // Basic client-side validation
    if (!username.trim() || !password.trim()) {
      setError("Username and password are required.");
      return;
    }

    try {
      const response = await fetch(
        `http://localhost:31337/webdev2/Projects/test/login.php`,
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: username,
            password: password,
          }),
        }
      );

      const data = await response.json();
      console.log(data); // Log the response from PHP

      if (data.success) {
        // Trigger the onLogin callback passed from the parent component
        onLogin(data.user);
      } else {
        // Display error message from backend
        setError(data.message);
      }

      // Reset the form after login attempt
      setUsername("");
      setPassword("");
    } catch (error) {
      console.error("Error:", error);
      setError("An error occurred. Please try again.");
    }
  };

  return (
    <div>
      <h2>Login</h2>
      {error && <p className="error">{error}</p>}
      <form onSubmit={handleLogin}>
        <label htmlFor="username">Username/Email:</label>
        <input
          type="text"
          id="username"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
        />
        <label htmlFor="password">Password:</label>
        <input
          type="password"
          id="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <button type="submit">Login</button>
      </form>
    </div>
  );
}

export default Login;
