import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";

export default function AddProfile() {
  const [form, setForm] = useState({ firstName: "", lastName: "", email: "" });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState("");
  const navigate = useNavigate();

  const onChange = (e) => setForm({ ...form, [e.target.name]: e.target.value });

  const onSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setLoading(true);
    try {
      // Map to backend fields (name, email)
      const payload = { name: `${form.firstName} ${form.lastName}`.trim(), email: form.email };
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
    <div style={{ minHeight: "100vh", display: "flex", flexDirection: "column" }}>
      <div style={{ padding: "12px" }}>
        <Link to="/profiles" style={{
          display: "inline-block", background: "#2563eb", color: "#fff", padding: "8px 12px",
          borderRadius: "999px", textDecoration: "none", fontSize: 12
        }}>View All Profiles</Link>
      </div>

      <div style={{ flex: 1, display: "flex", alignItems: "center", justifyContent: "center" }}>
        <div style={{ width: 380, border: "1px solid #e5e7eb", borderRadius: 10, padding: 20, boxShadow: "0 1px 2px rgba(0,0,0,.05)" }}>
          <h4 style={{ textAlign: "center", marginBottom: 16 }}>Add New Profile</h4>

          <form onSubmit={onSubmit}>
            <div style={{ marginBottom: 10 }}>
              <label style={{ display: "block", fontSize: 12, fontWeight: 600 }}>First Name</label>
              <input
                type="text"
                name="firstName"
                placeholder="Enter your first name"
                value={form.firstName}
                onChange={onChange}
                required
                style={{ width: "100%", padding: 8, borderRadius: 6, border: "1px solid #d1d5db" }}
              />
            </div>
            <div style={{ marginBottom: 10 }}>
              <label style={{ display: "block", fontSize: 12, fontWeight: 600 }}>Last Name</label>
              <input
                type="text"
                name="lastName"
                placeholder="Enter your last name"
                value={form.lastName}
                onChange={onChange}
                required
                style={{ width: "100%", padding: 8, borderRadius: 6, border: "1px solid #d1d5db" }}
              />
            </div>
            <div style={{ marginBottom: 14 }}>
              <label style={{ display: "block", fontSize: 12, fontWeight: 600 }}>Email</label>
              <input
                type="email"
                name="email"
                placeholder="Enter your email"
                value={form.email}
                onChange={onChange}
                required
                style={{ width: "100%", padding: 8, borderRadius: 6, border: "1px solid #d1d5db" }}
              />
            </div>

            {error && (
              <div style={{ color: "#b91c1c", fontSize: 12, marginBottom: 8 }}>{error}</div>
            )}

            <button
              type="submit"
              disabled={loading}
              style={{ width: "100%", background: "#2563eb", color: "#fff", border: 0, padding: 8, borderRadius: 6 }}
            >
              {loading ? 'Adding...' : 'Add Profile'}
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}
