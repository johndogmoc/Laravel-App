import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";

export default function ProfilesList() {
  const [rows, setRows] = useState([]);
  const [loading, setLoading] = useState(true);
  const [msg, setMsg] = useState("");

  const load = async () => {
    setLoading(true);
    const res = await fetch('/api/profilelist');
    const json = await res.json();
    setRows(json.data || []);
    setLoading(false);
  };

  useEffect(() => { load(); }, []);

  const updateRow = async (id) => {
    const row = rows.find(r => r.id === id);
    try {
      const res = await fetch(`/api/profile/${id}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name: row.name, email: row.email, age: row.age })
      });
      const data = await res.json();
      if (!res.ok) throw new Error(data.message || 'Update failed');
      setMsg('Profile updated');
      setTimeout(() => setMsg(''), 2000);
    } catch (e) { setMsg(e.message); }
  };

  const deleteRow = async (id) => {
    if (!confirm('Delete this profile?')) return;
    try {
      const res = await fetch(`/api/profile/${id}`, { method: 'DELETE' });
      const data = await res.json();
      if (!res.ok) throw new Error(data.message || 'Delete failed');
      setRows(rows.filter(r => r.id !== id));
      setMsg('Profile deleted');
      setTimeout(() => setMsg(''), 2000);
    } catch (e) { setMsg(e.message); }
  };

  const changeCell = (id, field, value) => {
    setRows(rows.map(r => r.id === id ? { ...r, [field]: value } : r));
  };

  return (
    <div style={{ padding: 20 }}>
      <div style={{ marginBottom: 12 }}>
        <Link to="/" style={{ background: "#2563eb", color: "#fff", padding: "8px 12px", borderRadius: 999, textDecoration: "none", fontSize: 12 }}>Add New</Link>
      </div>

      {msg && <div style={{ marginBottom: 10, color: '#065f46' }}>{msg}</div>}
      {loading ? (
        <div>Loading...</div>
      ) : (
        <div style={{ overflowX: 'auto' }}>
          <table style={{ width: '100%', borderCollapse: 'collapse' }}>
            <thead>
              <tr>
                <th style={{ textAlign: 'left', borderBottom: '1px solid #e5e7eb', padding: 8 }}>ID</th>
                <th style={{ textAlign: 'left', borderBottom: '1px solid #e5e7eb', padding: 8 }}>Name</th>
                <th style={{ textAlign: 'left', borderBottom: '1px solid #e5e7eb', padding: 8 }}>Email</th>
                <th style={{ textAlign: 'left', borderBottom: '1px solid #e5e7eb', padding: 8 }}>Age</th>
                <th style={{ textAlign: 'left', borderBottom: '1px solid #e5e7eb', padding: 8 }}>Actions</th>
              </tr>
            </thead>
            <tbody>
              {rows.map(r => (
                <tr key={r.id}>
                  <td style={{ padding: 8 }}>{r.id}</td>
                  <td style={{ padding: 8 }}>
                    <input value={r.name || ''} onChange={e => changeCell(r.id, 'name', e.target.value)} style={{ width: '100%', padding: 6 }} />
                  </td>
                  <td style={{ padding: 8 }}>
                    <input value={r.email || ''} onChange={e => changeCell(r.id, 'email', e.target.value)} style={{ width: '100%', padding: 6 }} />
                  </td>
                  <td style={{ padding: 8 }}>
                    <input type="number" value={r.age ?? ''} onChange={e => changeCell(r.id, 'age', e.target.value)} style={{ width: 100, padding: 6 }} />
                  </td>
                  <td style={{ padding: 8 }}>
                    <button onClick={() => updateRow(r.id)} style={{ marginRight: 6, background: '#16a34a', color: '#fff', border: 0, padding: '6px 10px', borderRadius: 6 }}>Save</button>
                    <button onClick={() => deleteRow(r.id)} style={{ background: '#dc2626', color: '#fff', border: 0, padding: '6px 10px', borderRadius: 6 }}>Delete</button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      )}
    </div>
  );
}
