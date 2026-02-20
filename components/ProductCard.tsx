import React from 'react'
import { Product } from '../data/products'
import { formatToman } from '../utils/format'

export default function ProductCard({ product }: { product: Product }) {
  const discountedPrice = product.discountPercent
    ? Math.round(product.price * (1 - product.discountPercent / 100))
    : product.price

  return (
    <article className="bg-white p-3 rounded shadow-sm">
      <img src={product.imageUrl} alt={product.title} className="w-full h-36 object-cover rounded" />
      <h4 className="mt-2 font-medium text-sm">{product.title}</h4>
      <div className="mt-1 text-xs text-gray-600">واحد: {product.unit}</div>
      <div className="mt-2 flex items-center gap-2">
        {product.discountPercent ? (
          <>
            <span className="text-sm font-semibold text-mivehGreen">{formatToman(discountedPrice)}</span>
            <span className="text-xs text-gray-500 line-through">{formatToman(product.price)}</span>
          </>
        ) : (
          <span className="text-sm font-semibold text-mivehGreen">{formatToman(product.price)}</span>
        )}
      </div>
      <div className="mt-3">
        <button className={`w-full px-3 py-2 rounded bg-mivehLime text-sm`}>افزودن به سبد</button>
      </div>
    </article>
  )
}
