"use client";
import { useState, useEffect } from "react";
import { useRouter } from "next/navigation";
import { FiSettings, FiLogOut } from "react-icons/fi";
import { FaBox, FaChartBar, FaUserTie } from "react-icons/fa";
import { MdSpaceDashboard } from "react-icons/md";
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, LineChart, Line, PieChart, Pie, Cell } from "recharts";

export default function Dashboard() {
  const [activeTab, setActiveTab] = useState("Dashboard");
  const [storeType, setStoreType] = useState("Pharmacy");
  const [products, setProducts] = useState([]);
  const router = useRouter();


  useEffect(() => {
   fetch("http://localhost/api2/index.php", { 

      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ action: "display_products" }),
    })
      .then((res) => res.json())
      .then((data) => {
        console.log("API Response:", data);
        if (data.success) {
          setProducts(data.products);
        } else {
          console.error("Error fetching products:", data.message);
        }
      })
      .catch((error) => console.error("Fetch error:", error));
  }, []);

  const handleLogout = () => {
    localStorage.removeItem("userToken");
    sessionStorage.removeItem("userToken");
    router.push("/");
  };

  return (
    <div className="flex min-h-screen bg-gray-200">
      {/* Sidebar */}
      <aside className="w-72 bg-white shadow-xl p-6 flex flex-col justify-between rounded-r-2xl">
        <div>
          <h1 className="text-2xl font-bold text-gray-800 mb-6">Admin Panel</h1>
          <nav>
            {[
              { name: "Dashboard", icon: <MdSpaceDashboard /> },
              { name: "Add Products", icon: <FaBox /> },
              { name: "Employee", icon: <FaUserTie /> },
              { name: "Statistics", icon: <FaChartBar /> },
            ].map(({ name, icon }) => (
              <button
                key={name}
                onClick={() => setActiveTab(name)}
                className={`flex items-center space-x-3 w-full p-3 rounded-lg mb-2 text-left font-medium text-gray-700 transition duration-200 ${
                  activeTab === name ? "bg-blue-100 text-blue-600" : "hover:bg-gray-100"
                }`}
              >
                {icon}
                <span>{name}</span>
              </button>
            ))}
          </nav>
        </div>
        <div>
          <button className="flex items-center space-x-3 w-full p-3 rounded-lg hover:bg-gray-100">
            <FiSettings />
            <span>Settings</span>
          </button>
          <button 
            onClick={handleLogout}
            className="flex items-center space-x-3 w-full p-3 rounded-lg hover:bg-gray-100 mt-2"
          >
            <FiLogOut />
            <span>Log Out</span>
          </button>
        </div>
      </aside>

      {/* Main Content */}
      <main className="flex-1 p-8">
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            <h2 className="text-3xl font-bold">Dashboard</h2>
            <div className="bg-gray-200 p-1 rounded-full flex space-x-2">
              <button 
                className={`px-4 py-2 text-sm font-medium rounded-full transition duration-200 ${storeType === "Pharmacy" ? "bg-white shadow" : "text-gray-500"}`}
                onClick={() => setStoreType("Pharmacy")}
              >
                Pharmacy
              </button>
              <button 
                className={`px-4 py-2 text-sm font-medium rounded-full transition duration-200 ${storeType === "Convenience Store" ? "bg-white shadow" : "text-gray-500"}`}
                onClick={() => setStoreType("Convenience Store")}
              >
                Convenience Store
              </button>
            </div>
          </div>
        </div>

        <div className="grid grid-cols-3 gap-6">
          {/* Daily Sales (Bar Chart Placeholder) */}
          <div className="bg-white p-6 rounded-2xl shadow-md border-2 border-dashed border-gray-300">
            <h3 className="text-lg font-bold mb-4">Daily Sales</h3>
            <ResponsiveContainer width="100%" height={150}>
              <BarChart data={[]}>
                <XAxis dataKey="name" />
                <YAxis />
                <Tooltip />
                <Bar dataKey="sales" fill="#8884d8" />
              </BarChart>
            </ResponsiveContainer>
          </div>

          {/* Weekly Sales (Line Chart Placeholder) */}
          <div className="bg-white p-6 rounded-2xl shadow-md border-2 border-dashed border-gray-300">
            <h3 className="text-lg font-bold mb-4">Weekly Sales</h3>
            <ResponsiveContainer width="100%" height={150}>
              <LineChart data={[]}>
                <XAxis dataKey="name" />
                <YAxis />
                <Tooltip />
                <Line type="monotone" dataKey="sales" stroke="#82ca9d" />
              </LineChart>
            </ResponsiveContainer>
          </div>

          {/* Monthly Sales (Pie Chart Placeholder) */}
          <div className="bg-white p-6 rounded-2xl shadow-md border-2 border-dashed border-gray-300">
            <h3 className="text-lg font-bold mb-4">Monthly Sales</h3>
            <ResponsiveContainer width="100%" height={150}>
              <PieChart>
                <Pie data={[]} dataKey="value" nameKey="name" cx="50%" cy="50%" outerRadius={50} fill="#8884d8">
                  <Cell key="1" fill="#8884d8" />
                  <Cell key="2" fill="#82ca9d" />
                </Pie>
              </PieChart>
            </ResponsiveContainer>
          </div>
        </div>

        {/* Product Table */}
        <div className="mt-6 bg-white p-6 rounded-2xl shadow-md border-2 border-dashed border-gray-300">
          <h3 className="text-xl font-bold mb-4">Product Table</h3>
          <table className="w-full border-collapse border border-gray-300">
            <thead>
              <tr className="bg-gray-200">
                <th className="border border-gray-300 p-2">Product Name</th>
                <th className="border border-gray-300 p-2">Price</th>
                <th className="border border-gray-300 p-2">Quantity</th>
              </tr>
            </thead>
            <tbody>
              {products.length > 0 ? (
                products.map((product) => (
                  <tr key={product.product_id} className="bg-white">
                    <td className="border border-gray-300 p-2">{product.product_name}</td>
                    <td className="border border-gray-300 p-2">{product.price}</td>
                    <td className="border border-gray-300 p-2">{product.quantity}</td>
                  </tr>
                ))
              ) : (
                <tr>
                  <td colSpan="3" className="text-center p-4">
                    No products available.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </main>
    </div>
  );
}
