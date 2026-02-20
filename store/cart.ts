'use client'
import { create } from 'zustand'
import { persist } from 'zustand/middleware'
import { Product } from '../data/products'

export type CartItem = {
  product: Product
  quantity: number
}

type CartState = {
  items: CartItem[]
  add: (product: Product, quantity?: number) => void
  remove: (slug: string) => void
  updateQuantity: (slug: string, qty: number) => void
  clear: () => void
  subtotal: () => number
}

export const useCart = create<CartState>()(
  persist(
    (set, get) => ({
      items: [],
      add: (product, quantity = 1) => {
        const items = get().items.slice()
        const idx = items.findIndex((i) => i.product.slug === product.slug)
        if (idx > -1) {
          items[idx].quantity += quantity
        } else {
          items.push({ product, quantity })
        }
        set({ items })
      },
      remove: (slug) => set({ items: get().items.filter((i) => i.product.slug !== slug) }),
      updateQuantity: (slug, qty) => {
        const items = get().items.map((i) => (i.product.slug === slug ? { ...i, quantity: qty } : i))
        set({ items })
      },
      clear: () => set({ items: [] }),
      subtotal: () => get().items.reduce((s, i) => {
        const price = i.product.discountPercent ? Math.round(i.product.price * (1 - i.product.discountPercent / 100)) : i.product.price
        return s + price * i.quantity
      }, 0)
    }),
    {
      name: 'miveh-jaan-cart'
    }
  )
)
