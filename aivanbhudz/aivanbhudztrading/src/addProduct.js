import React, { useState } from "react";
import BrandDropdown from "./brandDropdown";
import "./addProduct.css"; // Import the CSS file

function AddProduct() {
  const [productData, setProductData] = useState({
    brand_id: "", // We will map brand name to brand_id when submitting
    name: "",
    storage: "",
    memory: "",
    color: "",
    price: "",
    serial_number: "",
    notes: "",
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setProductData((prevData) => ({
      ...prevData,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch(
        "/webdev2/Projects/AivanBhudzTrading/api/create.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(productData),
        }
      );
      if (!response.ok) {
        throw new Error("Failed to add product");
      }
      const data = await response.json();
      console.log("Product added:", data);
      // Reset form data after successful submission
      setProductData({
        name: "",
        storage: "",
        memory: "",
        color: "",
        price: "",
        serial_number: "",
        notes: "",
        brand_id: "",
      });
    } catch (error) {
      console.error("Error adding product:", error);
      // Handle error state or display error message
    }
  };

  return (
    <div className="add-product-container">
      <h2>Add Product</h2>
      <form className="add-product-form" onSubmit={handleSubmit}>
        {/* Dropdown for Brand */}
        <label htmlFor="brand">Brand:</label>
        <BrandDropdown
          value={productData.brand_id}
          onChange={(e) =>
            setProductData((prevData) => ({
              ...prevData,
              brand_id: e.target.value,
            }))
          }
        />

        {/* Input fields for product details */}
        <label htmlFor="name">Name:</label>
        <input
          type="text"
          id="name"
          name="name"
          value={productData.name}
          onChange={handleChange}
        />

        <label htmlFor="storage">Storage:</label>
        <input
          type="text"
          id="storage"
          name="storage"
          value={productData.storage}
          onChange={handleChange}
        />

        <label htmlFor="memory">Memory:</label>
        <input
          type="text"
          id="memory"
          name="memory"
          value={productData.memory}
          onChange={handleChange}
        />

        <label htmlFor="color">Color:</label>
        <input
          type="text"
          id="color"
          name="color"
          value={productData.color}
          onChange={handleChange}
        />

        <label htmlFor="price">Price:</label>
        <input
          type="text"
          id="price"
          name="price"
          value={productData.price}
          onChange={handleChange}
        />

        <label htmlFor="serial_number">Serial Number:</label>
        <input
          type="text"
          id="serial_number"
          name="serial_number"
          value={productData.serial_number}
          onChange={handleChange}
        />

        <label htmlFor="notes">Notes:</label>
        <input
          type="text"
          id="notes"
          name="notes"
          value={productData.notes}
          onChange={handleChange}
        />

        <button type="submit">Add Product</button>
      </form>
    </div>
  );
}

export default AddProduct;
