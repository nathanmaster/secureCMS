# SecureCMS Component Library

This document provides a comprehensive guide to all the custom components available in your SecureCMS application.

## Layouts

### App Layout
The main layout for authenticated users.

```php
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Page Title
        </h2>
    </x-slot>

    <!-- Your content here -->
</x-app-layout>
```

### Guest Layout
The layout for authentication pages.

```php
<x-guest-layout>
    <!-- Your login/register form here -->
</x-guest-layout>
```

## Components

### Alert Component
Display flash messages and notifications.

```php
<x-alert type="success" message="Operation completed successfully!" />
<x-alert type="error" message="An error occurred!" />
<x-alert type="warning" message="Please check your input!" />
<x-alert type="info" message="Information message!" />
```

### Badge Component
Small status indicators.

```php
<x-badge type="success">Active</x-badge>
<x-badge type="error">Inactive</x-badge>
<x-badge type="warning">Pending</x-badge>
<x-badge type="info">New</x-badge>
```

### Card Component
Container for grouped content.

```php
<x-card>
    <h3 class="text-lg font-semibold mb-4">Card Title</h3>
    <p>Card content goes here...</p>
</x-card>

<x-card padding="p-4" shadow="shadow-lg">
    <!-- Custom padding and shadow -->
</x-card>
```

### Container Component
Responsive container with max-width.

```php
<x-container>
    <!-- Content will be centered with responsive padding -->
</x-container>

<x-container max-width="4xl">
    <!-- Smaller container -->
</x-container>
```

### Grid Component
Responsive grid layout.

```php
<x-grid cols="3" gap="6">
    <div>Item 1</div>
    <div>Item 2</div>
    <div>Item 3</div>
</x-grid>
```

### Stats Card Component
Display statistics with icons.

```php
<x-stats-card 
    title="Total Users" 
    value="1,234" 
    description="+12% from last month"
    color="blue"
    :icon="'<svg>...</svg>'"
/>
```

### Table Components
Clean data tables.

```php
<x-table>
    <thead>
        <tr>
            <x-table.th sortable="true">Name</x-table.th>
            <x-table.th>Email</x-table.th>
            <x-table.th>Status</x-table.th>
        </tr>
    </thead>
    <tbody>
        <x-table.tr>
            <x-table.td>John Doe</x-table.td>
            <x-table.td>john@example.com</x-table.td>
            <x-table.td><x-badge type="success">Active</x-badge></x-table.td>
        </x-table.tr>
    </tbody>
</x-table>
```

### Tabs Components
Tabbed content interface.

```php
<x-tabs active="tab1">
    <x-tabs.nav :tabs="[
        ['id' => 'tab1', 'title' => 'Tab 1'],
        ['id' => 'tab2', 'title' => 'Tab 2']
    ]" />
    
    <div class="mt-6">
        <x-tabs.content id="tab1">
            Content for tab 1
        </x-tabs.content>
        
        <x-tabs.content id="tab2">
            Content for tab 2
        </x-tabs.content>
    </div>
</x-tabs>
```

### Breadcrumb Component
Navigation breadcrumbs.

```php
<x-breadcrumb :items="[
    ['title' => 'Dashboard', 'url' => route('dashboard')],
    ['title' => 'Products', 'url' => route('products.index')],
    ['title' => 'Create Product']
]" />
```

### Form Group Component
Form field wrapper with label and error handling.

```php
<x-form-group label="Product Name" name="name" required="true" :error="$errors->first('name')">
    <x-text-input id="name" name="name" type="text" class="form-input" required />
</x-form-group>
```

### Page Template Component
Complete page layout with header, breadcrumbs, and actions.

```php
<x-page-template 
    title="Product Management" 
    subtitle="Manage your products and inventory"
    :breadcrumbs="[
        ['title' => 'Dashboard', 'url' => route('dashboard')],
        ['title' => 'Products']
    ]"
>
    <x-slot name="actions">
        <x-primary-button>
            Add Product
        </x-primary-button>
    </x-slot>

    <!-- Your page content here -->
</x-page-template>
```

### Loading Component
Loading spinners.

```php
<x-loading size="md" />
<x-loading size="lg" />
```

## CSS Classes

### Button Classes
```css
.btn-primary     /* Blue primary button */
.btn-secondary   /* Gray secondary button */
.btn-success     /* Green success button */
.btn-danger      /* Red danger button */
.btn-warning     /* Yellow warning button */
.btn-outline     /* Outlined button */
```

### Form Classes
```css
.form-input      /* Standard input styling */
.form-textarea   /* Textarea styling */
.form-select     /* Select dropdown styling */
.form-checkbox   /* Checkbox styling */
.form-radio      /* Radio button styling */
```

### Status Classes
```css
.status-active   /* Green active status */
.status-inactive /* Red inactive status */
.status-pending  /* Yellow pending status */
```

### Utility Classes
```css
.text-gradient   /* Gradient text */
.gradient-bg     /* Gradient background */
.glass           /* Glass morphism effect */
.text-shadow     /* Text shadow */
```

## JavaScript Helpers

### Alpine.js Data Components
```javascript
// Dropdown component
x-data="dropdown"

// Modal component
x-data="modal"

// Tabs component
x-data="tabs('defaultTab')"

// Notification component
x-data="notification('message', 'type', 5000)"
```

### Global Functions
```javascript
// Show notification
showNotification('Success message!', 'success');

// Copy to clipboard
$clipboard('Text to copy');

// Format date
$formatDate('2023-12-25');
```

## Dark Mode Support

All components support dark mode out of the box. Dark mode classes are automatically applied based on the user's system preference or manual toggle.

## Responsive Design

All components are fully responsive and work seamlessly across desktop, tablet, and mobile devices.

## Customization

You can customize any component by:

1. **Overriding CSS classes**: Most components accept additional classes via attributes
2. **Modifying component files**: Edit the Blade component files in `resources/views/components/`
3. **Extending Tailwind config**: Add custom colors, spacing, or utilities in `tailwind.config.js`
4. **Adding Alpine.js functionality**: Extend the Alpine.js setup in `resources/js/app.js`

## Performance Tips

1. **Use semantic HTML**: Components are built with accessibility in mind
2. **Optimize images**: Use appropriate image formats and sizes
3. **Minimize JavaScript**: Only include necessary Alpine.js components
4. **Use Tailwind purging**: Unused CSS is automatically removed in production

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
