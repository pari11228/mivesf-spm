import './globals.css'
import React from 'react'
import Header from '../components/Header'
import Footer from '../components/Footer'
import { Toaster } from 'react-hot-toast'

export const metadata = {
  title: 'میوه‌جان — میوه تازه، مستقیم از باغ',
  description: 'فروشگاه میوه و سبزیجات با تحویل همان‌ روز در شهر شما',
}

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html lang="fa" dir="rtl">
      <head />
      <body>
        <Header />
        <main className="container">{children}</main>
        <Footer />
        <Toaster position="top-right" />
      </body>
    </html>
  )
}
