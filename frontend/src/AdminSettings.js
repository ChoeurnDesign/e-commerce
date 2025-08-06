import React, { useEffect, useState } from 'react';

const API_URL = 'http://localhost:4000/api/settings';

export default function AdminSettings() {
  const [settings, setSettings] = useState({
    siteName: '',
    logoUrl: '',
    themeColor: '#0070f3',
    currency: 'USD',
    language: 'en',
    emailSender: ''
  });
  const [loading, setLoading] = useState(true);
  const [message, setMessage] = useState('');

  useEffect(() => {
    fetch(API_URL)
      .then(res => res.json())
      .then(data => {
        setSettings(data);
        setLoading(false);
      });
  }, []);

  function handleChange(e) {
    const { name, value } = e.target;
    setSettings(prev => ({ ...prev, [name]: value }));
  }

  function handleSubmit(e) {
    e.preventDefault();
    fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(settings)
    })
      .then(res => res.json())
      .then(data => {
        setMessage('Settings saved!');
        setTimeout(() => setMessage(''), 2000);
      });
  }

  if (loading) return <div>Loading...</div>;

  return (
    <form onSubmit={handleSubmit} style={{maxWidth: 500, margin: '2rem auto', padding: '2rem', border: '1px solid #eee', borderRadius: 8}}>
      <h2>Global Site Settings</h2>
      <label>
        Site Name:
        <input name="siteName" value={settings.siteName} onChange={handleChange} />
      </label>
      <br />
      <label>
        Logo URL:
        <input name="logoUrl" value={settings.logoUrl} onChange={handleChange} />
      </label>
      <br />
      <label>
        Theme Color:
        <input type="color" name="themeColor" value={settings.themeColor} onChange={handleChange} />
      </label>
      <br />
      <label>
        Currency:
        <select name="currency" value={settings.currency} onChange={handleChange}>
          <option value="USD">USD</option>
          <option value="EUR">EUR</option>
          <option value="KHR">KHR</option>
          {/* Add more currencies as needed */}
        </select>
      </label>
      <br />
      <label>
        Language:
        <select name="language" value={settings.language} onChange={handleChange}>
          <option value="en">English</option>
          <option value="km">Khmer</option>
          {/* Add more languages as needed */}
        </select>
      </label>
      <br />
      <label>
        Email Sender:
        <input name="emailSender" value={settings.emailSender} onChange={handleChange} />
      </label>
      <br />
      <button type="submit" style={{marginTop: 16}}>Save Settings</button>
      {message && <div style={{color:'green',marginTop:8}}>{message}</div>}
    </form>
  );
}
