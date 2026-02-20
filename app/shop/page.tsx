import React from 'react'
import ProductCard from '../../components/ProductCard'
import { products } from '../../data/products'

export default function ShopPage() {
  return (
    <div className="space-y-6">
      <header className="flex items-center justify-between">
        <h1 className="text-2xl font-semibold">فروشگاه</h1>
        <div className="w-64">
          <input placeholder="جستجو..." className="w-full border rounded px-3 py-2" />
        </div>
      </header>

      <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        {products.map((p) => (
          <ProductCard key={p.id} product={p} />
        ))}
      </div>
    </div>
  )
}
