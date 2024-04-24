import React, { useState } from "react";
import Header from "./header"; // Make sure to import the correct Header component path
import Home from "./home"; // Assuming these are the correct component paths
import Products from "./products";
import Login from "./login";
import AddProduct from "./addProduct";
import Update from "./update";
import Register from "./register";

function App() {
  const [currentPage, setCurrentPage] = useState("home");
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [userData, setUserData] = useState(null);
  const [selectedProduct, setSelectedProduct] = useState(null);

  const handleNavigation = (page) => {
    setCurrentPage(page);
  };

  const handleLogin = (userData) => {
    setIsLoggedIn(true);
    setUserData(userData);
    setCurrentPage("home");
  };

  const handleLogout = () => {
    setIsLoggedIn(false);
    setUserData(null);
    setCurrentPage("login");
  };

  const handleSelectProduct = (product) => {
    console.log(product);
    setSelectedProduct(product);
    setCurrentPage("update");
  };

  let currentPageComponent;
  switch (currentPage) {
    case "home":
      currentPageComponent = (
        <Home isLoggedIn={isLoggedIn} userData={userData} />
      );
      break;
    case "products":
      currentPageComponent = <Products onSelectProduct={handleSelectProduct} />;
      break;
    case "login":
      currentPageComponent = <Login onLogin={handleLogin} />;
      break;
    case "add":
      currentPageComponent = <AddProduct />;
      break;
    case "update":
      currentPageComponent = <Update />;
      break;
    case "register":
      currentPageComponent = <Register />;
      break;
    default:
      currentPageComponent = (
        <Home isLoggedIn={isLoggedIn} userData={userData} />
      );
  }

  return (
    <div className="App">
      <Header
        isLoggedIn={isLoggedIn}
        onNavigate={handleNavigation}
        onLogout={handleLogout}
      />
      {currentPageComponent}
    </div>
  );
}

export default App;
