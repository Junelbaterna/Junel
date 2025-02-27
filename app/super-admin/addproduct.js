"use client";
import { useState } from "react";
import axios from "axios";
import { FaCamera, FaTrash } from "react-icons/fa";

export default function AddProducts() {
  const [storeType, setStoreType] = useState("Pharmacy");
  const [productName, setProductName] = useState("");
  const [price, setPrice] = useState("");
  const [quantity, setQuantity] = useState("");
  const [pieces, setPieces] = useState("");
  const [category, setCategory] = useState("");
  const [expiration, setExpiration] = useState("");
  const [dosageID, setDosageID] = useState("");
  const [message, setMessage] = useState("");
  const [image, setImage] = useState(null);

  const handleAddProduct = async (e) => {
    e.preventDefault();
    
    const productData = {
      action: "add_product",
      store_type: storeType,
      product_name: productName,
      price,
      quantity,
      pieces,
      category,
      expiration,
      dosage_ID: dosageID,
    };
    
    console.log("Sending product data:", productData);
    
    try {
      const response = await axios.post("http://localhost/api2/index.php", productData);
      
      console.log("Server Response:", response.data);
      
      if (response.data.success) {
        setMessage("Product added successfully!");
      } else {
        setMessage(response.data.message || "Failed to add product.");
      }
    } catch (err) {
      console.error("Error:", err);
      setMessage("Error adding product.");
    }
  };

  return (
    <div className="p-8 bg-white shadow-xl rounded-xl max-w-3xl mx-auto border border-gray-300">
      <h2 className="text-3xl font-semibold mb-6 text-gray-700">Add New Product</h2>
      {message && <p className="text-green-600 text-lg mb-4">{message}</p>}

      {/* Store Type Selection */}
      <div className="mb-6 flex space-x-6">
        <label className="flex items-center space-x-2 text-gray-600">
          <input
            type="radio"
            value="Pharmacy"
            checked={storeType === "Pharmacy"}
            onChange={() => setStoreType("Pharmacy")}
          />
          <span>Pharmacy</span>
        </label>
        <label className="flex items-center space-x-2 text-gray-600">
          <input
            type="radio"
            value="Convenience Store"
            checked={storeType === "Convenience Store"}
            onChange={() => setStoreType("Convenience Store")}
          />
          <span>Convenience Store</span>
        </label>
      </div>

      <div className="grid grid-cols-2 gap-8">
        {/* Product Image Section */}
        <div className="bg-gray-50 p-6 rounded-lg border border-gray-300">
          <p className="font-medium mb-3 text-gray-700">Product Image</p>
          <div className="relative w-full h-44 bg-white rounded-lg flex items-center justify-center border border-gray-300">
            {image ? (
              <img src={URL.createObjectURL(image)} alt="Product" className="h-full object-cover rounded-md" />
            ) : (
              <FaCamera className="text-gray-400 text-4xl" />
            )}
          </div>
          <div className="flex space-x-3 mt-3">
            <label className="bg-blue-600 text-white px-5 py-2 rounded-lg cursor-pointer text-center">
              Upload
              <input type="file" className="hidden" onChange={(e) => setImage(e.target.files[0])} />
            </label>
            {image && (
              <button onClick={() => setImage(null)} className="bg-red-600 text-white px-5 py-2 rounded-lg">
                <FaTrash />
              </button>
            )}
          </div>
        </div>

        {/* General Information */}
        <div>
          <form onSubmit={handleAddProduct} className="space-y-5">
            <input type="text" placeholder="Product Name" value={productName} onChange={(e) => setProductName(e.target.value)} className="w-full p-3 border rounded-lg" required />
            <input type="number" placeholder="Price" value={price} onChange={(e) => setPrice(e.target.value)} className="w-full p-3 border rounded-lg" required />
            <input type="number" placeholder="Quantity" value={quantity} onChange={(e) => setQuantity(e.target.value)} className="w-full p-3 border rounded-lg" required />
            <input type="number" placeholder="Pieces" value={pieces} onChange={(e) => setPieces(e.target.value)} className="w-full p-3 border rounded-lg" required />
            <select value={category} onChange={(e) => setCategory(e.target.value)} className="w-full p-3 border rounded-lg" required>
              <option value="">Select Category</option>
              <option value="Medicine">Medicine</option>
              <option value="Supplements">Supplements</option>
            </select>
            <input type="date" placeholder="Expiration Date" value={expiration} onChange={(e) => setExpiration(e.target.value)} className="w-full p-3 border rounded-lg" required />
            <input type="text" placeholder="Dosage ID" value={dosageID} onChange={(e) => setDosageID(e.target.value)} className="w-full p-3 border rounded-lg" required />
            <button type="submit" className="w-full bg-blue-600 text-white p-3 rounded-lg font-medium text-lg">
              Add Product
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}
