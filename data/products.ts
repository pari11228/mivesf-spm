export type Product = {
  id: string
  title: string
  slug: string
  category: string
  price: number // in toman
  discountPercent?: number
  imageUrl: string
  unit: 'kg' | 'عدد' | 'جعبه'
  stock: number
  description?: string
  popularity?: number
}

export const products: Product[] = [
  { id: 'p1', title: 'سیب زرد درجه یک', slug: 'sib-zard', category: 'میوه‌های فصل', price: 25000, discountPercent: 10, imageUrl: 'https://source.unsplash.com/featured/?apple', unit: 'kg', stock: 50, popularity: 90 },
  { id: 'p2', title: 'موز رسیده', slug: 'moz', category: 'میوه‌های وارداتی', price: 40000, imageUrl: 'https://source.unsplash.com/featured/?banana', unit: 'kg', stock: 60, popularity: 85 },
  { id: 'p3', title: 'گوجه فرنگی درجه یک', slug: 'gohje', category: 'صیفی‌جات', price: 12000, discountPercent: 5, imageUrl: 'https://source.unsplash.com/featured/?tomato', unit: 'kg', stock: 80, popularity: 70 },
  { id: 'p4', title: 'خیار تازه', slug: 'khiyar', category: 'صیفی‌جات', price: 8000, imageUrl: 'https://source.unsplash.com/featured/?cucumber', unit: 'kg', stock: 100, popularity: 60 },
  { id: 'p5', title: 'پرتقال محلی', slug: 'porteghal', category: 'میوه‌های فصل', price: 22000, imageUrl: 'https://source.unsplash.com/featured/?orange', unit: 'kg', stock: 40, popularity: 75 },
  { id: 'p6', title: 'کیوی تازه', slug: 'kiwi', category: 'میوه‌های وارداتی', price: 50000, discountPercent: 15, imageUrl: 'https://source.unsplash.com/featured/?kiwi', unit: 'kg', stock: 30, popularity: 65 },
  { id: 'p7', title: 'موز ارگانیک (بسته 6 عدد)', slug: 'moz-6', category: 'میوه‌های وارداتی', price: 240000, imageUrl: 'https://source.unsplash.com/featured/?banana,bunch', unit: 'جعبه', stock: 10, popularity: 78 },
  { id: 'p8', title: 'انار تازه', slug: 'anar', category: 'میوه‌های فصل', price: 30000, imageUrl: 'https://source.unsplash.com/featured/?pomegranate', unit: 'kg', stock: 20, popularity: 82 },
  { id: 'p9', title: 'بادام خام (۵۰۰ گرم)', slug: 'badam-500', category: 'خشکبار', price: 180000, discountPercent: 10, imageUrl: 'https://source.unsplash.com/featured/?almond', unit: 'جعبه', stock: 25, popularity: 55 },
  { id: 'p10', title: 'مخلوط سبزیجات (بسته)', slug: 'sabzijat-mix', category: 'صیفی‌جات', price: 60000, imageUrl: 'https://source.unsplash.com/featured/?vegetables,mix', unit: 'جعبه', stock: 15, popularity: 50 },
  { id: 'p11', title: 'خرما کبکاب (۵۰۰ گرم)', slug: 'khorma-500', category: 'خشکبار', price: 90000, imageUrl: 'https://source.unsplash.com/featured/?dates', unit: 'جعبه', stock: 40, popularity: 68 },
  { id: 'p12', title: 'گلابی شیرین', slug: 'golabi', category: 'میوه‌های فصل', price: 27000, imageUrl: 'https://source.unsplash.com/featured/?pear', unit: 'kg', stock: 35, popularity: 58 },
  { id: 'p13', title: 'کاهو تازه', slug: 'kahu', category: 'صیفی‌جات', price: 7000, imageUrl: 'https://source.unsplash.com/featured/?lettuce', unit: 'عدد', stock: 90, popularity: 45 },
  { id: 'p14', title: 'مخلوط میوه خشک (۳۰۰ گرم)', slug: 'mix-dried-300', category: 'خشکبار', price: 120000, discountPercent: 12, imageUrl: 'https://source.unsplash.com/featured/?dried-fruit', unit: 'جعبه', stock: 20, popularity: 52 },
  { id: 'p15', title: 'کیسه میوه منتخب (سبد هدیه)', slug: 'gift-basket', category: 'سبدهای هدیه', price: 450000, imageUrl: 'https://source.unsplash.com/featured/?gift,fruits', unit: 'جعبه', stock: 8, popularity: 88 },
  { id: 'p16', title: 'هویج تازه', slug: 'havij', category: 'صیفی‌جات', price: 10000, imageUrl: 'https://source.unsplash.com/featured/?carrot', unit: 'kg', stock: 70, popularity: 49 },
  { id: 'p17', title: 'آووکادو', slug: 'avocado', category: 'میوه‌های وارداتی', price: 85000, imageUrl: 'https://source.unsplash.com/featured/?avocado', unit: 'عدد', stock: 22, popularity: 77 },
  { id: 'p18', title: 'انبه فصل', slug: 'mango', category: 'میوه‌های فصل', price: 65000, imageUrl: 'https://source.unsplash.com/featured/?mango', unit: 'kg', stock: 18, popularity: 73 },
  { id: 'p19', title: 'گردو خام (۵۰۰ گرم)', slug: 'gerdoo-500', category: 'خشکبار', price: 210000, imageUrl: 'https://source.unsplash.com/featured/?walnut', unit: 'جعبه', stock: 30, popularity: 60 },
  { id: 'p20', title: 'لیمو ترش', slug: 'limoo', category: 'میوه‌های فصل', price: 15000, imageUrl: 'https://source.unsplash.com/featured/?lemon', unit: 'kg', stock: 55, popularity: 42 },
  { id: 'p21', title: 'توت فرنگی (بسته ۴۰۰ گرم)', slug: 'toot-400', category: 'میوه‌های فصل', price: 95000, discountPercent: 8, imageUrl: 'https://source.unsplash.com/featured/?strawberry', unit: 'جعبه', stock: 12, popularity: 80 },
  { id: 'p22', title: 'انگور قرمز', slug: 'angoor', category: 'میوه‌های فصل', price: 28000, imageUrl: 'https://source.unsplash.com/featured/?grapes', unit: 'kg', stock: 45, popularity: 66 },
  { id: 'p23', title: 'سیر تازه', slug: 'seer', category: 'صیفی‌جات', price: 20000, imageUrl: 'https://source.unsplash.com/featured/?garlic', unit: 'kg', stock: 60, popularity: 38 },
  { id: 'p24', title: 'پیاز محلی', slug: 'piyaz', category: 'صیفی‌جات', price: 9000, imageUrl: 'https://source.unsplash.com/featured/?onion', unit: 'kg', stock: 85, popularity: 35 },
  { id: 'p25', title: 'سبد اقتصادی فصل (۳ کیلو)', slug: 'season-box-3kg', category: 'سبدهای هدیه', price: 180000, discountPercent: 20, imageUrl: 'https://source.unsplash.com/featured/?fruit,basket', unit: 'جعبه', stock: 14, popularity: 91 },
]
