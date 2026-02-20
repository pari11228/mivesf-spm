'use client'
import React from 'react'
import { formatToman } from '../utils/format'
import { Product } from '../data/products'

export default function PriceDisplay({ product }: { product: Product }) {
  const discounted = product.discountPercent
  const discountedPrice = discounted ? Math.round(product.price * (1 - product.discountPercent! / 100)) : product.price

  return (
    <div className="flex items-baseline gap-2">
      <div className="text-mivehGreen font-semibold">{formatToman(discountedPrice)}</div>
      {discounted && <div className="text-xs text-gray-500 line-through">{formatToman(product.price)}</div>}
    </div>
  )
}
