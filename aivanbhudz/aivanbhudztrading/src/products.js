// product.js

import React, { useState, useEffect } from "react";
import "./products.css"; // Import the CSS file

// ProductItem component to display each product
const ProductItem = ({ product, onItemClick }) => (
  <div className="product-card" onClick={() => onItemClick(product)}>
    <h3>{product.product_name}</h3>
    <p>ID: {product.id}</p>
    <p>Brand: {product.brand}</p>
    <p>Storage: {product.storage} GB</p>
    <p>Memory: {product.memory} GB</p>
    <p>Color: {product.color}</p>
    <p>Price: ${product.price}</p>
    <p>Serial Number: {product.serial_number}</p>
    <p>Notes: {product.notes}</p>
    <p>Date: {product.date}</p>
  </div>
);

function Products({ onSelectProduct }) {
  const [products, setProducts] = useState([]);
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedProduct, setSelectedProduct] = useState(null);

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchProducts = async () => {
    try {
      const response = await fetch(
        "http://localhost:31337/webdev2/Projects/AivanBhudzTrading/api/read.php"
      );
      if (!response.ok) {
        throw new Error("Failed to fetch products");
      }
      const data = await response.json();
      setProducts(data.data); // Assuming the response contains a "data" array
    } catch (error) {
      console.error("Error fetching products:", error);
      // Handle error state or display error message
    }
  };

  const handleSearch = (e) => {
    setSearchTerm(e.target.value);
  };

  const handleItemClick = (selectedProduct) => {
    setSelectedProduct(selectedProduct); // Set selected product
    onSelectProduct(selectedProduct); // Pass selected product to parent
  };

  const filteredProducts = products.filter((product) =>
    product.product_name.toLowerCase().includes(searchTerm.toLowerCase())
  );

  return (
    <div>
      <h2>Products</h2>
      <div className="search-bar">
        <input
          type="text"
          placeholder="Search products..."
          value={searchTerm}
          onChange={handleSearch}
        />
      </div>
      <div className="product-list">
        {filteredProducts.map((product) => (
          <ProductItem
            key={product.id}
            product={product}
            onItemClick={handleItemClick}
          />
        ))}
      </div>
    </div>
  );
}

export default Products;
