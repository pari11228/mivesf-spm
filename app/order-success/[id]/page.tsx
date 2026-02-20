'use client'
import React from 'react'
import { useRouter } from 'next/navigation'
import Link from 'next/link'

export default function OrderSuccess({ params }: { params: { id: string } }) {
  const id = params.id
  return (
    <div className="bg-white p-6 rounded">
      <h1 className="text-2xl font-semibold">سفارش شما ثبت شد</h1>
      <p className="mt-3">شناسه سفارش: <strong>{id}</strong></p>
      <p className="mt-2">ما شما را از طریق پیامک از وضعیت ارسال مطلع خواهیم کرد.</p>
      <div className="mt-4">
        <Link href="/" className="px-4 py-2 bg-mivehGreen text-white rounded">بازگشت به صفحه اصلی</Link>
      </div>
    </div>
  )
}
