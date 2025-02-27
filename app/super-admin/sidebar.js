"use client";

import { MdSpaceDashboard } from "react-icons/md";
import { FaBox, FaChartBar, FaUserTie } from "react-icons/fa";
import { FiSettings, FiLogOut } from "react-icons/fi";

const Sidebar = ({ onSelectFeature }) => {
  return (
    <aside className="w-72 h-screen bg-white shadow-xl p-6 flex flex-col justify-between fixed top-0 left-0">
      {/* Title */}
      <div>
        <h1 className="text-2xl font-bold text-gray-800 mb-6">Super Admin</h1>
        
        {/* Navigation */}
        <nav>
          {[
            { name: "Dashboard", icon: <MdSpaceDashboard /> },
            { name: "Add Product", icon: <FaBox /> },
            { name: "Activity Log", icon: <FaChartBar /> },
            { name: "Employee Info", icon: <FaUserTie /> },
          ].map(({ name, icon }) => (
            <button
              key={name}
              onClick={() => onSelectFeature(name)}
              className="flex items-center space-x-3 w-full p-3 rounded-lg mb-2 text-left font-medium text-gray-700 hover:bg-gray-100 transition duration-200"
            >
              {icon}
              <span>{name}</span>
            </button>
          ))}
        </nav>
      </div>

      {/* Bottom Buttons */}
      <div>
        <button className="flex items-center space-x-3 w-full p-3 rounded-lg hover:bg-gray-100">
          <FiSettings />
          <span>Settings</span>
        </button>
        <button className="flex items-center space-x-3 w-full p-3 rounded-lg hover:bg-gray-100 mt-2">
          <FiLogOut />
          <span>Log Out</span>
        </button>
      </div>
    </aside>
  );
};

export default Sidebar;
