# Product Card Design Specification

## Reference Image Analysis

Based on the provided reference image, here is the exact design specification for the product card.

---

## Card Structure

### 1. Container
- Background: Light cream/beige (`#f5f5f0` or similar)
- Border radius: Large rounded corners (`rounded-2xl`)
- No border, clean look
- Padding: None on image, content below image

### 2. Badges (Top of Image)
**Position:** Absolute, top-left and top-right corners

**Left Badge (Category):**
- Text: "Women" (or "Men", "Unisex")
- Style: Outlined/bordered pill shape
- Border: Red/coral color (`border-red-400`)
- Background: Transparent or very light
- Text color: Red/coral
- Font: Small, regular weight
- Padding: `px-3 py-1`
- Border radius: Full rounded (`rounded-full`)

**Right Badge (Bestseller):**
- Text: "Bestseller"
- Style: Solid background
- Background: Beige/tan color (`bg-[#d4c4b0]` or similar)
- Text color: Dark gray/black
- Font: Small, regular weight
- Padding: `px-3 py-1`
- Border radius: Rounded (`rounded-lg`)

### 3. Product Image
- Aspect ratio: Square or slightly taller (`aspect-square`)
- Object fit: Cover
- Border radius: Large (`rounded-2xl`)
- Full width of card

### 4. Rating Row
**Position:** Below image, left-aligned

**Stars:**
- 5 stars total
- Filled stars: Black (`★`)
- Empty/half stars: Outlined or gray
- Size: Medium (`text-base` or `text-lg`)

**Review Count:**
- Format: Just number (e.g., "5623")
- Color: Gray (`text-gray-500`)
- Font size: Small (`text-sm`)
- Position: Right after stars with small gap

### 5. Product Name & Price Row
**Layout:** Flex, space-between

**Left Side - Product Name:**
- Two lines
- Line 1: Bold, uppercase (e.g., "FLORAL")
- Line 2: Bold, uppercase (e.g., "MARSHMALLOW")
- Font size: Large (`text-xl` or `text-2xl`)
- Color: Black
- Font weight: Bold (`font-bold`)

**Right Side - Price Section:**
- Stacked vertically, right-aligned

**Discount Badge:**
- Text: "-50%"
- Background: Coral/salmon color (`bg-[#e8a598]`)
- Text color: White
- Shape: Tag/ribbon shape or rounded
- Position: Above sale price

**Sale Price:**
- Format: "€19,50" (or ₹ symbol)
- Color: Coral/red (`text-[#e8a598]`)
- Font size: Large (`text-2xl`)
- Font weight: Bold
- Font style: Italic

**Original Price:**
- Format: "€39" (strikethrough)
- Color: Gray (`text-gray-400`)
- Font size: Small (`text-sm`)
- Text decoration: Line-through
- Position: Below sale price

### 6. Info Icon (Optional)
- Small "i" icon in circle
- Position: Left of price section
- Color: Light gray
- Size: Small

---

## Color Palette

| Element | Color Code | Tailwind Class |
|---------|------------|----------------|
| Card Background | #f5f5f0 | bg-[#f5f5f0] |
| Women Badge Border | #e57373 | border-red-400 |
| Women Badge Text | #e57373 | text-red-400 |
| Bestseller Badge BG | #d4c4b0 | bg-[#d4c4b0] |
| Bestseller Badge Text | #333333 | text-gray-800 |
| Discount Badge BG | #e8a598 | bg-[#e8a598] |
| Sale Price | #e8a598 | text-[#e8a598] |
| Stars (filled) | #000000 | text-black |
| Review Count | #6b7280 | text-gray-500 |
| Original Price | #9ca3af | text-gray-400 |

---

## Responsive Behavior

### Mobile (< 640px)
- Card width: ~160px
- 2 cards visible in slider
- Smaller text sizes

### Tablet (640px - 1024px)
- Card width: ~200px
- 3-4 cards visible

### Desktop (> 1024px)
- Card width: ~220px
- 5-6 cards visible

---

## HTML/Tailwind Structure

```html
<div class="flex-shrink-0 w-[180px] sm:w-[200px] lg:w-[220px]">
    <!-- Image Container with Badges -->
    <div class="relative mb-4">
        <!-- Left Badge - Category -->
        <span class="absolute top-3 left-3 z-10 border border-red-400 text-red-400 text-xs px-3 py-1 rounded-full bg-white/80">
            Women
        </span>
        <!-- Right Badge - Bestseller -->
        <span class="absolute top-3 right-3 z-10 bg-[#d4c4b0] text-gray-800 text-xs px-3 py-1 rounded-lg">
            Bestseller
        </span>
        <!-- Product Image -->
        <div class="aspect-square rounded-2xl overflow-hidden bg-[#f5f5f0]">
            <img src="..." alt="..." class="w-full h-full object-cover">
        </div>
    </div>
    
    <!-- Rating -->
    <div class="flex items-center gap-2 mb-2">
        <div class="flex text-black text-lg">★★★★☆</div>
        <span class="text-sm text-gray-500">5623</span>
    </div>
    
    <!-- Name & Price Row -->
    <div class="flex items-end justify-between">
        <!-- Product Name -->
        <div>
            <h3 class="font-bold text-xl text-gray-900 leading-tight">FLORAL</h3>
            <p class="font-bold text-xl text-gray-900 leading-tight">MARSHMALLOW</p>
        </div>
        
        <!-- Price Section -->
        <div class="text-right">
            <!-- Discount Badge -->
            <span class="inline-block bg-[#e8a598] text-white text-xs px-2 py-0.5 rounded mb-1">
                -50%
            </span>
            <!-- Sale Price -->
            <p class="text-[#e8a598] text-xl font-bold italic">€19,50</p>
            <!-- Original Price -->
            <p class="text-gray-400 text-sm line-through">€39</p>
        </div>
    </div>
</div>
```

---

## Notes

1. No "Add to Cart" or "Choose Size" button visible in this design
2. Clean, minimal aesthetic
3. Price tag has a subtle ribbon/tag shape effect
4. Stars are solid black, not yellow
5. Product name is split into two lines for visual impact
