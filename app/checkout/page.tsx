'use client'
import React from 'react'
import { useForm } from 'react-hook-form'
import { zodResolver } from '@hookform/resolvers/zod'
import * as z from 'zod'
import { useCart } from '../../store/cart'
import { formatToman } from '../../utils/format'
import { useRouter } from 'next/navigation'

const CheckoutSchema = z.object({
  fullName: z.string().min(2),
  phone: z.string().min(7),
  city: z.string().min(1),
  street: z.string().min(1),
  plaque: z.string().min(1),
  unit: z.string().optional(),
  deliveryTime: z.enum(['morning', 'afternoon']),
  payment: z.enum(['online', 'cod'])
})

type CheckoutForm = z.infer<typeof CheckoutSchema>

export default function CheckoutPage() {
  const router = useRouter()
  const items = useCart((s) => s.items)
  const subtotal = useCart((s) => s.subtotal)()
  const clear = useCart((s) => s.clear)

  const { register, handleSubmit, formState: { errors } } = useForm<CheckoutForm>({ resolver: zodResolver(CheckoutSchema) })

  const onSubmit = (data: CheckoutForm) => {
    // fake order placement — in production, call backend
    const orderId = Math.random().toString(36).slice(2, 9)
    clear()
    router.push(`/order-success/${orderId}`)
  }

  const delivery = subtotal >= 200000 ? 0 : 20000
  const total = subtotal + delivery

  return (
    <div className="space-y-6">
      <h1 className="text-2xl font-semibold">تکمیل خرید</h1>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        <form className="md:col-span-2 bg-white p-4 rounded space-y-3" onSubmit={handleSubmit(onSubmit)}>
          <div>
            <label className="block text-sm">نام و نام خانوادگی</label>
            <input className="w-full border rounded px-2 py-1" {...register('fullName')} />
            {errors.fullName && <div className="text-red-500 text-xs">{String(errors.fullName.message)}</div>}
          </div>

          <div>
            <label className="block text-sm">شماره تماس</label>
            <input className="w-full border rounded px-2 py-1" {...register('phone')} />
            {errors.phone && <div className="text-red-500 text-xs">{String(errors.phone.message)}</div>}
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div>
              <label className="block text-sm">شهر</label>
              <input className="w-full border rounded px-2 py-1" {...register('city')} />
            </div>
            <div>
              <label className="block text-sm">خیابان</label>
              <input className="w-full border rounded px-2 py-1" {...register('street')} />
            </div>
          </div>

          <div className="grid grid-cols-1 sm:grid-cols-2 gap-2">
            <div>
              <label className="block text-sm">پلاک</label>
              <input className="w-full border rounded px-2 py-1" {...register('plaque')} />
            </div>
            <div>
              <label className="block text-sm">واحد</label>
              <input className="w-full border rounded px-2 py-1" {...register('unit')} />
            </div>
          </div>

          <div>
            <label className="block text-sm">زمان تحویل</label>
            <select className="w-full border rounded px-2 py-1" {...register('deliveryTime')}>
              <option value="morning">صبح</option>
              <option value="afternoon">عصر</option>
            </select>
          </div>

          <div>
            <label className="block text-sm">روش پرداخت</label>
            <select className="w-full border rounded px-2 py-1" {...register('payment')}>
              <option value="online">پرداخت آنلاین</option>
              <option value="cod">پرداخت در محل</option>
            </select>
          </div>

          <button type="submit" className="mt-3 bg-mivehGreen text-white px-4 py-2 rounded">ثبت سفارش</button>
        </form>

        <aside className="bg-white p-4 rounded shadow">
          <div className="text-sm">جمع سبد: <strong>{formatToman(subtotal)}</strong></div>
          <div className="text-sm mt-2">هزینه ارسال: <strong>{delivery === 0 ? 'رایگان' : formatToman(delivery)}</strong></div>
          <div className="mt-4 text-lg font-semibold">مجموع: {formatToman(total)}</div>
        </aside>
      </div>
    </div>
  )
}
