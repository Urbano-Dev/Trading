// BrandDropdown.js
import React from "react";

function BrandDropdown({ value, onChange }) {
  const brands = [
    { id: 1, name: "Apple" },
    { id: 2, name: "Samsung" },
    { id: 3, name: "Huawei" },
    { id: 4, name: "Xiaomi" },
    { id: 5, name: "Oppo" },
    { id: 6, name: "Google" },
    { id: 7, name: "One Plus" },
  ];

  return (
    <select value={value} onChange={onChange}>
      <option value="">Select Brand</option>
      {brands.map((brand) => (
        <option key={brand.id} value={brand.id}>
          {brand.name}
        </option>
      ))}
    </select>
  );
}

export default BrandDropdown;
