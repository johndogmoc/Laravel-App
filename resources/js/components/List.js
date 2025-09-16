import React, { useEffect, useState } from "react";
import { Link } from "react-router-dom";

export default function List() {
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
    <div className="list-wrap">
      <div className="list-top">
        <Link to="/" className="btn-pill">Add New</Link>
      </div>

      {msg && <div style={{ marginBottom: 10, color: '#065f46' }}>{msg}</div>}
      {loading ? (
        <div>Loading...</div>
      ) : (
        <div style={{ overflowX: 'auto' }}>
          <table className="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Age</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              {rows.map(r => (
                <tr key={r.id}>
                  <td>{r.id}</td>
                  <td>
                    <input className="input-sm" value={r.name || ''} onChange={e => changeCell(r.id, 'name', e.target.value)} />
                  </td>
                  <td>
                    <input className="input-sm" value={r.email || ''} onChange={e => changeCell(r.id, 'email', e.target.value)} />
                  </td>
                  <td>
                    <input className="input-num" type="number" value={r.age ?? ''} onChange={e => changeCell(r.id, 'age', e.target.value)} />
                  </td>
                  <td>
                    <button className="btn-green" onClick={() => updateRow(r.id)} style={{ marginRight: 6 }}>Save</button>
                    <button className="btn-red" onClick={() => deleteRow(r.id)}>Delete</button>
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
