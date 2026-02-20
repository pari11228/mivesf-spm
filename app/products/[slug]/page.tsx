'use client'
import React, { useState } from 'react'
import { products } from '../../../data/products'
import { useCart } from '../../../store/cart'
import QuantitySelector from '../../../components/QuantitySelector'
import PriceDisplay from '../../../components/PriceDisplay'
import toast from 'react-hot-toast'

export default function ProductPage({ params }: { params: { slug: string } }) {
  const slug = params.slug
  const product = products.find((p) => p.slug === slug)
  const add = useCart((s) => s.add)
  const [qty, setQty] = useState(1)

  if (!product) return <div className="p-6 bg-white rounded">محصول پیدا نشد</div>

  const handleAdd = () => {
    if (product.stock <= 0) {
      toast.error('متأسفیم، موجودی کافی نیست')
      return
    }
    add(product, qty)
    toast.success('به سبد اضافه شد')
  }

  return (
    <div className="bg-white p-4 rounded shadow">
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div className="md:col-span-2">
          <img src={product.imageUrl} alt={product.title} className="w-full h-96 object-cover rounded" />
          <h1 className="text-2xl font-semibold mt-3">{product.title}</h1>
          <p className="mt-2 text-gray-700">{product.description || 'توضیحات محصول وجود ندارد.'}</p>
        </div>

        <aside className="p-4 border rounded">
          <PriceDisplay product={product} />
          <div className="mt-3">واحد: {product.unit}</div>
          <div className="mt-3">موجودی: {product.stock}</div>
          <div className="mt-3">
            <QuantitySelector value={qty} onChange={setQty} />
          </div>
          <button disabled={product.stock <= 0} onClick={handleAdd} className="mt-4 w-full bg-mivehGreen text-white py-2 rounded disabled:opacity-60">افزودن به سبد</button>
        </aside>
      </div>
    </div>
  )
}
