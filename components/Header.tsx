import React from 'react'
import Link from 'next/link'
import { useCart } from '../store/cart'

export default function Header() {
  const count = useCart((s) => s.items.reduce((acc, i) => acc + i.quantity, 0))

  return (
    <header className="bg-white shadow-sm">
      <div className="container flex items-center justify-between py-4">
        <Link href="/" className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-full bg-mivehGreen flex items-center justify-center text-white font-bold">م</div>
          <div>
            <div className="font-bold">میوه‌جان</div>
            <div className="text-xs text-gray-500">تحویل همان‌ روز</div>
          </div>
        </Link>

        <nav className="hidden md:flex items-center gap-4">
          <Link href="/shop" className="text-gray-700">فروشگاه</Link>
          <Link href="/about" className="text-gray-700">درباره</Link>
          <Link href="/contact" className="text-gray-700">تماس</Link>
        </nav>

        <div className="flex items-center gap-3">
          <Link href="/cart" className="relative">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M6 6h15l-1.5 9h-12L6 6z" stroke="#111827" strokeWidth="1.2" strokeLinecap="round" strokeLinejoin="round"/></svg>
            <span className="absolute -top-2 -left-2 bg-mivehRed text-white rounded-full px-1 text-xs">{count}</span>
          </Link>
        </div>
      </div>
    </header>
  )
}
