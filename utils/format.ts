export function persianNumber(input: number | string) {
  const str = String(input)
  return str.replace(/[0-9]/g, (d) => '۰۱۲۳۴۵۶۷۸۹'[Number(d)])
}

export function formatToman(value: number) {
  // value is in toman (integer). Format with thousand separators and Persian digits
  const formatted = value.toLocaleString('fa-IR')
  return `${formatted} تومان`
}
