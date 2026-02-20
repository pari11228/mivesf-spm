import React from 'react'
import ProductCard from '../components/ProductCard'
import { products } from '../data/products'

export default function HomePage() {
  const featured = products.slice(0, 6)

  return (
    <div className="space-y-8">
      <section className="rounded-lg overflow-hidden shadow-lg bg-white p-6 flex flex-col md:flex-row items-center gap-6">
        <div className="flex-1">
          <h1 className="text-3xl md:text-4xl font-bold text-mivehGreen">میوه تازه، مستقیم از باغ به در خانه شما</h1>
          <p className="mt-3 text-gray-600">تحویل همان‌ روز، بسته‌بندی سالم و انتخاب بهترین میوه‌ها</p>
          <div className="mt-4">
            <a href="/shop" className="inline-block px-4 py-2 bg-mivehGreen text-white rounded">مشاهده محصولات</a>
          </div>
        </div>
        <div className="w-full md:w-1/2">
          <img src="https://placehold.co/800x500/8ee4af/064e3b?text=Fresh+Fruits" alt="hero" className="w-full rounded" />
        </div>
      </section>

      <section>
        <h2 className="text-xl font-semibold mb-4">محصولات منتخب</h2>
        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 gap-4">
          {featured.map((p) => (
            <ProductCard key={p.id} product={p} />
          ))}
        </div>
      </section>

      <section className="bg-white p-6 rounded shadow">
        <h3 className="text-lg font-semibold">چرا میوه‌جان؟</h3>
        <ul className="mt-3 space-y-2 text-gray-700">
          <li>• انتخاب تازه‌ از باغ</li>
          <li>• بسته‌بندی بهداشتی</li>
          <li>• تحویل سریع و قابل اعتماد</li>
        </ul>
      </section>
    </div>
  )
}
