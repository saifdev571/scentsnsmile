# Bundle Feature Documentation

## Overview
Bundle feature ab database mein store hota hai with session aur user data ke saath.

## Features Implemented

### 1. Database Storage
- **Table**: `bundles`
- **Fields**:
  - `user_id` - Agar user logged in hai
  - `session_id` - Guest users ke liye
  - `items` - JSON format mein products (id, name, price, quantity, image)
  - `total_price` - Total price before discount
  - `discount_amount` - Discount amount (40% off for 2+ items)
  - `final_price` - Final price after discount
  - `total_items` - Total number of items

### 2. Auto-Save Feature
- Jab bhi user bundle mein product add karta hai, automatically database mein save hota hai
- Jab product remove karta hai, tab bhi update hota hai
- Real-time save without page reload

### 3. Session Management
- **Guest Users**: Session ID se bundle track hota hai
- **Logged In Users**: User ID se bundle track hota hai
- **Login/Register**: Session bundle automatically user account se link ho jata hai

### 4. Bundle Persistence
- Page reload karne par bhi bundle items show hote hain
- Database se load hota hai on page load
- User logout karne par session bundle maintain rehta hai

### 5. Discount Calculation
- 2+ items: 40% OFF automatically apply hota hai
- Discount amount aur final price calculate hota hai
- Database mein store hota hai

## API Endpoints

### Save Bundle
```
POST /bundle/save
Body: {
  items: [
    {
      id: 1,
      name: "Product Name",
      price: 999,
      quantity: 2,
      image: "image_url"
    }
  ]
}
```

### Get Current Bundle
```
GET /bundle/get
Response: {
  success: true,
  bundle: { ... }
}
```

### Clear Bundle
```
DELETE /bundle/clear
Response: {
  success: true,
  message: "Bundle cleared successfully"
}
```

## How It Works

### For Guest Users
1. User bundle page par jata hai
2. Products add karta hai
3. Session ID se database mein save hota hai
4. Page reload par bhi items show hote hain

### For Logged In Users
1. User login karta hai
2. Bundle user_id se link hota hai
3. Session bundle (agar hai) user account se merge ho jata hai
4. User ke saath permanently store hota hai

### Login/Register Flow
1. Guest user bundle create karta hai (session_id se)
2. User login/register karta hai
3. Session bundle automatically user_id se link ho jata hai
4. Purana session bundle delete ho jata hai ya merge ho jata hai

## Database Schema

```sql
CREATE TABLE bundles (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NULL,
    session_id VARCHAR(255) NULL,
    items JSON,
    total_price DECIMAL(10,2),
    discount_amount DECIMAL(10,2),
    final_price DECIMAL(10,2),
    total_items INT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX (user_id, session_id)
);
```

## Testing

### Test as Guest
1. Bundle page par jao: `/bundle`
2. Products add karo
3. Page reload karo - items show hone chahiye
4. Browser console mein dekho: "Loaded existing bundle" message

### Test as Logged In User
1. Login karo
2. Bundle page par jao
3. Products add karo
4. Logout karo aur phir login karo
5. Bundle items wahi hone chahiye

### Test Session to User Migration
1. Guest user ke taur par bundle create karo
2. Login karo
3. Bundle automatically user account se link ho jana chahiye
4. Database mein check karo: `user_id` set hona chahiye

## Files Modified

1. **Migration**: `database/migrations/2026_01_03_000001_create_bundles_table.php`
2. **Model**: `app/Models/Bundle.php`
3. **Controller**: `app/Http/Controllers/BundleController.php`
4. **Routes**: `routes/web.php`
5. **View**: `resources/views/bundle.blade.php`
6. **Auth Controller**: `app/Http/Controllers/UserAuthController.php`

## Future Enhancements

1. Bundle history tracking
2. Share bundle with friends
3. Save multiple bundles
4. Bundle recommendations
5. Bundle analytics
