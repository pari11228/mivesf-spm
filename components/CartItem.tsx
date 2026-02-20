'use client'
import React from 'react'
import { CartItem as CI, useCart } from '../store/cart'
import QuantitySelector from './QuantitySelector'
import { formatToman } from '../utils/format'

export default function CartItem({ item }: { item: CI }) {
  const update = useCart((s) => s.updateQuantity)
  const remove = useCart((s) => s.remove)

  const price = item.product.discountPercent ? Math.round(item.product.price * (1 - item.product.discountPercent / 100)) : item.product.price

  return (
    <div className="flex items-center gap-4 p-3 border rounded">
      <img src={item.product.imageUrl} className="w-20 h-20 object-cover rounded" alt={item.product.title} />
      <div className="flex-1">
        <div className="font-medium">{item.product.title}</div>
        <div className="text-sm text-gray-500">{formatToman(price)} • واحد: {item.product.unit}</div>
      </div>
      <div className="flex flex-col items-end gap-2">
        <QuantitySelector value={item.quantity} onChange={(v) => update(item.product.slug, v)} />
        <button className="text-red-500 text-sm" onClick={() => remove(item.product.slug)}>حذف</button>
      </div>
    </div>
  )
}
