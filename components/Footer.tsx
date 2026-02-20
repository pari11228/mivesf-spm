import React from 'react'

export default function Footer() {
  return (
    <footer className="mt-8 bg-white border-t">
      <div className="container py-6 text-sm text-gray-600">
        <div>© {new Date().getFullYear()} میوه‌جان — همه حقوق محفوظ است.</div>
      </div>
    </footer>
  )
}
