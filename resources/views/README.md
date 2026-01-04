# Views Structure

## Directory Organization

```
resources/views/
├── layouts/
│   └── app.blade.php          # Main layout template
├── partials/
│   ├── header.blade.php       # Header navigation component
│   ├── footer.blade.php       # Footer component
│   ├── styles.blade.php       # Global CSS styles
│   └── scripts.blade.php      # Global JavaScript
├── admin/                     # Admin panel views
├── website/                   # Website specific views
├── components/                # Reusable components
└── home.blade.php            # Homepage view

```

## Usage

### Main Layout (layouts/app.blade.php)
The main layout includes:
- Header (sticky with transparent effect)
- Content area (@yield)
- Footer
- Global styles and scripts
- Stack support for page-specific assets

### Creating New Pages
```php
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
    <!-- Your content here -->
@endsection

@push('styles')
    <!-- Page-specific styles -->
@endpush

@push('scripts')
    <!-- Page-specific scripts -->
@endpush
```

### Partials
- **header.blade.php**: Sticky navigation with transparent scroll effect
- **footer.blade.php**: Site footer with newsletter, social links, and navigation
- **styles.blade.php**: Global CSS including fonts, animations, and header effects
- **scripts.blade.php**: Global JavaScript for header scroll behavior

## Features
- Responsive design with Tailwind CSS
- Sticky header with transparent-to-solid transition on scroll
- Modular and reusable components
- Easy to maintain and extend
