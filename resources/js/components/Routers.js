import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Add from "./Add";
import List from "./List";

export default function Routers() {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Add />} />
        <Route path="/profiles" element={<List />} />
      </Routes>
    </Router>
  );
}
