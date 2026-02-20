'use client'
import React from 'react'
import { useCart } from '../../store/cart'
import CartItem from '../../components/CartItem'
import { formatToman } from '../../utils/format'
import Link from 'next/link'

export default function CartPage() {
  const items = useCart((s) => s.items)
  const subtotal = useCart((s) => s.subtotal)()

  const delivery = subtotal >= 200000 ? 0 : 20000
  const total = subtotal + delivery

  return (
    <div className="space-y-6">
      <h1 className="text-2xl font-semibold">سبد خرید</h1>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div className="md:col-span-2 space-y-3">
          {items.length === 0 ? (
            <div className="p-6 bg-white rounded text-center">سبد خرید خالی است. <Link href="/shop">برگشت به فروشگاه</Link></div>
          ) : (
            items.map((it) => <CartItem key={it.product.id} item={it} />)
          )}
        </div>

        <aside className="bg-white p-4 rounded shadow">
          <div className="text-sm">جمع سبد: <strong>{formatToman(subtotal)}</strong></div>
          <div className="text-sm mt-2">هزینه ارسال: <strong>{delivery === 0 ? 'رایگان' : formatToman(delivery)}</strong></div>
          {subtotal < 200000 && <div className="text-yellow-600 text-sm mt-2">حداقل سفارش برای ارسال رایگان ۲۰۰,۰۰۰ تومان است</div>}
          <div className="mt-4 text-lg font-semibold">مجموع: {formatToman(total)}</div>
          <Link href="/checkout"><button className="mt-4 w-full bg-mivehGreen text-white py-2 rounded">ادامه و پرداخت</button></Link>
        </aside>
      </div>
    </div>
  )
}
