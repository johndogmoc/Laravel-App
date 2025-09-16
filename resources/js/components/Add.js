import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";

export default function Add() {
  const [form, setForm] = useState({ first: "", last: "", email: "" });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const onChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const onSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setLoading(true);
    try {
      const payload = { name: `${form.first} ${form.last}`.trim(), email: form.email };
      const res = await fetch('/api/submit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.message || 'Failed to create profile');
      navigate('/profiles');
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="profiles-wrap">
      <div className="profiles-top">
        <Link to="/profiles" className="btn-pill">View All Profiles</Link>
      </div>

      <div className="profiles-center">
        <div className="card">
          <h4>Add New Profile</h4>

          <form onSubmit={onSubmit}>
            <div className="form-row">
              <label>First Name</label>
              <input
                type="text"
                name="first"
                placeholder="Enter your first name"
                value={form.first}
                onChange={onChange}
                required
              />
            </div>
            <div className="form-row">
              <label>Last Name</label>
              <input
                type="text"
                name="last"
                placeholder="Enter your last name"
                value={form.last}
                onChange={onChange}
                required
              />
            </div>
            <div className="form-row">
              <label>Email</label>
              <input
                type="email"
                name="email"
                placeholder="Enter your email"
                value={form.email}
                onChange={onChange}
                required
              />
            </div>

            {error && (
              <div className="error-text">{error}</div>
            )}

            <button type="submit" disabled={loading} className="btn-main">
              {loading ? 'Adding...' : 'Add Profile'}
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}
