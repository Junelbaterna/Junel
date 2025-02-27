"use client";
import { useState, useEffect } from "react";
import Sidebar from "./sidebar";
import AddProducts from "./addproduct";
import ActivityLog from "./actiivityLog";
import EmployeeInfo from "./emplooye";
import { ToastContainer, toast } from "react-toastify";
import axios from "axios";
import "react-toastify/dist/ReactToastify.css";

export default function SuperAdminDashboard() {
  const [activeTab, setActiveTab] = useState("Dashboard");
  const [storeType, setStoreType] = useState("Pharmacy");
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (activeTab === "Dashboard") {
      fetchProducts();
    }
  }, [activeTab, storeType]);

  const fetchProducts = async () => {
    setLoading(true);
    try {
      const response = await axios.post("http://localhost/api2/index.php", {
        action: "display_products",
        store_type: storeType,
      });
      if (response.data.success) {
        setProducts(response.data.products);
        setError(null);
      } else {
        setError("Failed to fetch products.");
      }
    } catch (err) {
      setError("An error occurred while fetching products.");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="flex min-h-screen bg-gray-200">
      {/* Sidebar (Fixed sa gilid) */}
      <Sidebar onSelectFeature={setActiveTab} />

      {/* Main Content */}
      <main className="flex-1 p-8 ml-72"> 
        {/* DITO KO INADJUST ANG MARGIN PARA DI MATABUNAN NG SIDEBAR */}
        
        {/* Dashboard */}
        {activeTab === "Dashboard" && (
          <>
            <div className="flex justify-between items-center mb-6">
              <h2 className="text-3xl font-bold">Dashboard</h2>
              <div className="bg-gray-200 p-1 rounded-full flex space-x-2">
                <button
                  className={`px-4 py-2 text-sm font-medium rounded-full transition duration-200 ${
                    storeType === "Pharmacy" ? "bg-white shadow" : "text-gray-500"
                  }`}
                  onClick={() => setStoreType("Pharmacy")}
                >
                  Pharmacy
                </button>
                <button
                  className={`px-4 py-2 text-sm font-medium rounded-full transition duration-200 ${
                    storeType === "Convenience Store" ? "bg-white shadow" : "text-gray-500"
                  }`}
                  onClick={() => setStoreType("Convenience Store")}
                >
                  Convenience Store
                </button>
              </div>
            </div>

            <div className="grid grid-cols-3 gap-6">
              <div className="bg-white p-6 rounded-lg shadow-md border font-bold">Daily Sales</div>
              <div className="bg-white p-6 rounded-lg shadow-md border font-bold">Weekly Sales</div>
              <div className="bg-white p-6 rounded-lg shadow-md border font-bold">Monthly Sales</div>
            </div>

            {/* Product Table inside Dashboard */}
            <div className="mt-6 bg-white p-6 rounded-lg shadow-md border">
              <h3 className="text-xl font-bold mb-4">{storeType} Product Table</h3>
              {loading ? (
                <p>Loading...</p>
              ) : error ? (
                <p className="text-red-500">{error}</p>
              ) : products.length === 0 ? (
                <p>No products available.</p>
              ) : (
                <table className="w-full border-collapse border border-gray-300">
                  <thead>
                    <tr className="bg-gray-200">
                      <th className="border border-gray-300 p-2">Product Name</th>
                      <th className="border border-gray-300 p-2">Price</th>
                      <th className="border border-gray-300 p-2">Quantity</th>
                    </tr>
                  </thead>
                  <tbody>
                  {products.map((product) => (
              <tr key={`${product.product_ID}-${product.product_name}`} className="text-center">
  

                        <td className="border border-gray-300 p-2">{product.product_name}</td>
                        <td className="border border-gray-300 p-2">₱{product.price}</td>
                        <td className="border border-gray-300 p-2">{product.quantity}</td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              )}
            </div>
          </>
        )}

        {/* Add Product */}
        {activeTab === "Add Product" && <AddProducts />}

        {/* Activity Log */}
        {activeTab === "Activity Log" && <ActivityLog />}

        {/* Employee Info */}
        {activeTab === "Employee Info" && <EmployeeInfo />}
      </main>
      <ToastContainer />
    </div>
  );
}
