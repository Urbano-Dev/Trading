import React, { useState, useEffect } from "react";

function Update() {
  const [product, setProduct] = useState({
    id: "",
    brand: "",
    product_name: "",
    storage: "",
    memory: "",
    color: "",
    price: "",
    serial_number: "",
    notes: "",
    date: "",
  });

  useEffect(() => {
    const fetchProductDetails = async () => {
      const searchParams = new URLSearchParams(window.location.search);
      console.log("URL Search Params:", searchParams);
      const serialNumber = searchParams.get("serial_number");
      console.log("Serial Number:", serialNumber);
      if (!serialNumber) {
        console.error("Serial number is missing in the URL");
        return;
      }

      try {
        const response = await fetch(
          `http://localhost:31337/webdev2/Projects/AivanBhudzTrading/api/get_product.php?serial_number=${serialNumber}`
        );
        if (!response.ok) {
          throw new Error("Failed to fetch product details");
        }
        const data = await response.json();
        console.log("Fetched Product Details:", data); // Debugging
        setProduct(data); // Set the product data
      } catch (error) {
        console.error("Error fetching product details:", error);
        // Handle error state or display error message
      }
    };

    fetchProductDetails();
  }, []);

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setProduct((prevProduct) => ({
      ...prevProduct,
      [name]: value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await fetch(
        "http://localhost:31337/webdev2/Projects/AivanBhudzTrading/api/update.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(product),
        }
      );
      if (!response.ok) {
        throw new Error("Failed to update product");
      }
      // Handle success, e.g., show a success message
    } catch (error) {
      console.error("Error updating product:", error);
      // Handle error state or display error message
    }
  };

  return (
    <div>
      <h2>Update Product</h2>
      <form onSubmit={handleSubmit}>
        <div>
          <label htmlFor="productName">Product Name:</label>
          <input
            type="text"
            id="productName"
            name="product_name"
            value={product.product_name}
            onChange={handleInputChange}
          />
        </div>
        <div>
          <label htmlFor="brand">Brand:</label>
          <input
            type="text"
            id="brand"
            name="brand"
            value={product.brand}
            onChange={handleInputChange}
          />
        </div>
        <div>
          <label htmlFor="storage">Storage (GB):</label>
          <input
            type="number"
            id="storage"
            name="storage"
            value={product.storage}
            onChange={handleInputChange}
          />
        </div>
        <div>
          <label htmlFor="memory">Memory (GB):</label>
          <input
            type="number"
            id="memory"
            name="memory"
            value={product.memory}
            onChange={handleInputChange}
          />
        </div>
        <div>
          <label htmlFor="color">Color:</label>
          <input
            type="text"
            id="color"
            name="color"
            value={product.color}
            onChange={handleInputChange}
          />
        </div>
        <div>
          <label htmlFor="price">Price:</label>
          <input
            type="number"
            id="price"
            name="price"
            value={product.price}
            onChange={handleInputChange}
          />
        </div>
        <div>
          <label htmlFor="serial_number">Serial Number:</label>
          <input
            type="text"
            id="serial_number"
            name="serial_number"
            value={product.serial_number}
            onChange={handleInputChange}
            disabled // Disable editing of serial number
          />
        </div>
        <div>
          <label htmlFor="notes">Notes:</label>
          <textarea
            id="notes"
            name="notes"
            value={product.notes}
            onChange={handleInputChange}
          ></textarea>
        </div>
        <div>
          <label htmlFor="date">Date:</label>
          <input
            type="date"
            id="date"
            name="date"
            value={product.date}
            onChange={handleInputChange}
          />
        </div>
        <div>
          <button type="submit">Update Product</button>
        </div>
      </form>
    </div>
  );
}

export default Update;
