// Home.js

import React from "react";

function Home({ isLoggedIn, userData }) {
  console.log(userData);
  return (
    <div>
      <h2>Welcome to Home</h2>
      {isLoggedIn &&
        userData && ( // Check if user is logged in and userData is available
          <div>
            <p>Name: {userData.name}</p>
            <p>Rank: {userData.rank ? userData.rank : "user"}</p>
          </div>
        )}
    </div>
  );
}

export default Home;
