import React from "react";

function Header({ isLoggedIn, onNavigate, onLogout }) {
  return (
    <header>
      <nav>
        <button onClick={() => onNavigate("home")}>Home</button>
        <button onClick={() => onNavigate("products")}>Products</button>
        {isLoggedIn && (
          <>
            <button onClick={() => onNavigate("add")}>Add Product</button>
            <button onClick={() => onNavigate("update")}>Update</button>
          </>
        )}
        {isLoggedIn ? (
          <button onClick={onLogout}>Logout</button>
        ) : (
          <>
            <button onClick={() => onNavigate("login")}>Login</button>
            <button onClick={() => onNavigate("register")}>Register</button>
          </>
        )}
      </nav>
    </header>
  );
}

export default Header;
