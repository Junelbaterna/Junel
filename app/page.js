"use client";
import { useState } from "react";
import { useRouter } from "next/navigation";
import axios from "axios";

export default function LoginForm() {
  const [emp_name, setEmpName] = useState(""); // Fix: setEmpName instead of setUsername
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");

  const router = useRouter();

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      console.log("Sending payload:", JSON.stringify({ emp_name, password, action: "login" }, null, 2));

     const response = await axios.post("http://localhost/api2/index.php", {
  emp_name,  // Make sure this matches PHP
  password,
  action: "login",
});


      console.log("API Response:", response.data);

      if (response.data.success) {
        switch (response.data.role) {
          case "admin":
            router.push("/admin");
            break;
          case "cashier":
            router.push("/cashier");
            break;
          case "pharmacist":
            router.push("/pharmacist");
            break;
          case "super admin":
            router.push("/super-admin");
            break;
          default:
            setError("Unauthorized role");
        }
      } else {
        setError(response.data.message || "Invalid username or password");
      }
    } catch (err) {
      console.error("Error during login:", err);
      setError("Login failed. Please try again.");
    }
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-[#81A57C]">
      <div className="bg-white p-8 rounded-lg shadow-2xl shadow-blue-500/50 w-96 border border-gray-300 flex flex-col items-center relative">
        <div className="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-purple-500 rounded-t-lg"></div>
        <h2 className="text-2xl font-bold mb-6 text-center text-gray-800">Login</h2>
        {error && <p className="text-red-500 text-center">{error}</p>}
        <form onSubmit={handleSubmit} className="w-full flex flex-col items-center">
          <div className="mb-4 w-full px-4">
            <label htmlFor="emp_name" className="block text-sm font-medium text-gray-700">
              Username
            </label>
            <input
              type="text"
              id="emp_name"
              value={emp_name}
              onChange={(e) => setEmpName(e.target.value)} // Fix: setEmpName
              className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100 hover:bg-gray-200 transition duration-200"
              required
            />
          </div>
          <div className="mb-6 w-full px-4">
            <label htmlFor="password" className="block text-sm font-medium text-gray-700">
              Password
            </label>
            <input
              type="password"
              id="password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 bg-gray-100 hover:bg-gray-200 transition duration-200"
              required
            />
          </div>
          <button
            type="submit"
            className="w-3/4 bg-gradient-to-r from-blue-500 to-purple-500 text-white py-2 px-4 rounded-lg hover:opacity-90 transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
          >
            Login
          </button>
        </form>
      </div>
    </div>
  );
}
