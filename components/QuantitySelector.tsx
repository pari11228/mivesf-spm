'use client'
import React from 'react'

export default function QuantitySelector({ value, onChange }: { value: number; onChange: (v: number) => void }) {
  return (
    <div className="inline-flex items-center border rounded overflow-hidden">
      <button aria-label="decrease" onClick={() => onChange(Math.max(1, value - 1))} className="px-3 py-1">-</button>
      <div className="px-3">{value}</div>
      <button aria-label="increase" onClick={() => onChange(value + 1)} className="px-3 py-1">+</button>
    </div>
  )
}
