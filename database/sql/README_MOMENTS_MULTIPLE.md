# Moments Module - Multiple Selection Update

## Overview
The Moments module has been updated to support **multiple moments per product** (many-to-many relationship) instead of single moment selection.

## What Changed

### Database Changes
1. **New Pivot Table**: `product_moment` - Links products to multiple moments
2. **Old Column**: `moment_id` in products table is now deprecated (kept for backward compatibility)

### Code Changes

#### Models
- **Product.php**: Changed `moment()` from `belongsTo` to `moments()` with `belongsToMany`
- **Moment.php**: Changed `products()` from `hasMany` to `belongsToMany`

#### Controllers
- **ProductsController.php**: 
  - Updated validation from `moment_id` to `moments` array
  - Added `sync()` logic for moments relationship
  - Updated session data to use `moments` array

#### Views
- **create/step1.blade.php**: Changed from radio buttons (single) to checkboxes (multiple)
- **edit/step1.blade.php**: Changed from radio buttons (single) to checkboxes (multiple)
- **JavaScript**: Updated `momentDropdown()` to `momentsDropdown()` with array handling

#### Other Controllers
- **CollectionController.php**: Updated moment filter and search to use `whereHas('moments')`

## SQL Files for Production

### Option 1: Complete Fresh Setup
Use: `MOMENTS_COMPLETE_SETUP.sql`
- Creates moments table
- Creates product_moment pivot table
- Includes sample data
- Migrates existing moment_id data

### Option 2: Update Existing Setup
Use: `moments_multiple_selection_update.sql`
- Only creates pivot table
- Migrates existing data
- Keeps old moment_id column for safety

### Option 3: Just Pivot Table
Use: `add_moments_pivot_table.sql`
- Minimal version
- Just creates pivot table and migrates data

## How to Deploy to Production

1. **Backup your database first!**

2. **Run SQL file in phpMyAdmin**:
   ```sql
   -- Copy and paste contents of MOMENTS_COMPLETE_SETUP.sql
   -- OR moments_multiple_selection_update.sql
   ```

3. **Upload updated code files**:
   - app/Models/Product.php
   - app/Models/Moment.php
   - app/Http/Controllers/Admin/ProductsController.php
   - app/Http/Controllers/CollectionController.php
   - resources/views/admin/products/create/step1.blade.php
   - resources/views/admin/products/edit/step1.blade.php

4. **Clear cache on server**:
   ```bash
   php artisan optimize:clear
   ```

## Features

### Admin Panel
- ✅ Select multiple moments per product
- ✅ Searchable dropdown (like Highlight Notes)
- ✅ Shows count: "3 moments selected"
- ✅ Works in both Create and Edit product

### Frontend
- ✅ Collection pages work with multiple moments
- ✅ Search works with multiple moments
- ✅ Filters work with multiple moments

## Testing

1. **Create a new product**:
   - Go to Products > Add New
   - In Step 1, select multiple moments
   - Save and verify

2. **Edit existing product**:
   - Edit any product
   - Add/remove moments
   - Save and verify

3. **Frontend**:
   - Visit `/collections/{moment-slug}`
   - Products with that moment should appear
   - Search should work

## Backward Compatibility

- Old `moment_id` column is kept in products table
- Existing single moment associations are migrated to pivot table
- You can safely remove `moment_id` column later after testing

## Optional: Remove Old Column

After verifying everything works, you can remove the old column:

```sql
ALTER TABLE `products` DROP FOREIGN KEY `products_moment_id_foreign`;
ALTER TABLE `products` DROP COLUMN `moment_id`;
```

## Support

If you encounter any issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check browser console for JavaScript errors
3. Verify pivot table was created: `SHOW TABLES LIKE 'product_moment'`
4. Verify data was migrated: `SELECT COUNT(*) FROM product_moment`

---

**Last Updated**: January 8, 2026
**Version**: 2.0 (Multiple Selection)
