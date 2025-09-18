import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Routes, Route, Navigate } from "react-router-dom";

// Requested pages
import Example from "./Example";
import ListofNames from "./ListofNames";

// Keep the same functionality but with a slightly different structure
export default function Routers() {
  return (
    <Router>
      <Routes>
        {/* Default redirect to /Person */}
        <Route index element={<Navigate to="/Person" replace />} />

        {/* Required routes */}
        <Route path="/Person" element={<Example />} />
        <Route path="/List" element={<ListofNames />} />

        {/* Fallback for unknown paths */}
        <Route path="*" element={<Navigate to="/Person" replace />} />
      </Routes>
    </Router>
  );
}

// Hydrate into #root if present
const mountNode = document.getElementById("root");
if (mountNode) {
  ReactDOM.render(<Routers />, mountNode);
}
