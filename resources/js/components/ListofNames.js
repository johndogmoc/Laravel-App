import React, { useEffect, useState } from 'react';

export default function ListofNames() {
  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    let mounted = true;
    (async () => {
      try {
        const res = await fetch('/api/profiles', { headers: { Accept: 'application/json' } });
        if (!res.ok) throw new Error('Failed to load');
        const data = await res.json();
        if (mounted) setItems(Array.isArray(data) ? data : []);
      } catch (e) {
        if (mounted) setError('Could not load profiles.');
      } finally {
        if (mounted) setLoading(false);
      }
    })();
    return () => {
      mounted = false;
    };
  }, []);

  return (
    <section style={{ padding: '1.5rem' }}>
      <h2 style={{ marginBottom: '0.75rem' }}>Profiles</h2>
      {loading && <p>Loading…</p>}
      {error && <p style={{ color: 'crimson' }}>{error}</p>}
      {!loading && !error && (
        <table style={{ width: '100%', borderCollapse: 'collapse' }}>
          <thead>
            <tr>
              <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd', padding: '8px' }}>First</th>
              <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd', padding: '8px' }}>Last</th>
              <th style={{ textAlign: 'left', borderBottom: '1px solid #ddd', padding: '8px' }}>Email</th>
            </tr>
          </thead>
          <tbody>
            {items.map((p) => (
              <tr key={p.id}>
                <td style={{ borderBottom: '1px solid #eee', padding: '8px' }}>{p.first_name || ''}</td>
                <td style={{ borderBottom: '1px solid #eee', padding: '8px' }}>{p.last_name || ''}</td>
                <td style={{ borderBottom: '1px solid #eee', padding: '8px' }}>{p.email || ''}</td>
              </tr>
            ))}
            {items.length === 0 && (
              <tr>
                <td colSpan={3} style={{ padding: '12px', color: '#666' }}>No profiles found.</td>
              </tr>
            )}
          </tbody>
        </table>
      )}
    </section>
  );
}
