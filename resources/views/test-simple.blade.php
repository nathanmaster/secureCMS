<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <style>
        body {
            background: #1a1a2e;
            color: white;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h1>Test Page Working!</h1>
    <p>This is a simple test page to verify routing is working.</p>
    <p>Current time: {{ now() }}</p>
    
    <h2>Testing Links</h2>
    <ul>
        <li><a href="{{ route('menu') }}" style="color: #7c3aed;">Menu Page (Main)</a></li>
        <li><a href="{{ route('test') }}" style="color: #7c3aed;">Simple Test</a></li>
        <li><a href="{{ route('test-menu') }}" style="color: #7c3aed;">Test Menu (Mock Data)</a></li>
        <li><a href="{{ route('test-layout') }}" style="color: #7c3aed;">Test Layout</a></li>
    </ul>
    
    <h2>Quick Product Tests</h2>
    <ul>
        <li><a href="/product/1" style="color: #7c3aed;">Product 1 (if exists)</a></li>
        <li><a href="/product/2" style="color: #7c3aed;">Product 2 (if exists)</a></li>
        <li><a href="/product/3" style="color: #7c3aed;">Product 3 (if exists)</a></li>
    </ul>
    
    <h2>System Status</h2>
    <ul>
        <li><strong>Laravel:</strong> {{ app()->version() }}</li>
        <li><strong>PHP:</strong> {{ phpversion() }}</li>
        <li><strong>Environment:</strong> {{ app()->environment() }}</li>
        <li><strong>Database:</strong> {{ config('database.default') }}</li>
    </ul>
    
    <h2>Recent Changes</h2>
    <ul style="color: #22c55e;">
        <li>✅ Created PublicLayout component</li>
        <li>✅ Fixed Alpine.js integration</li>
        <li>✅ Simplified MenuController</li>
        <li>✅ Cleaned up menu.blade.php (removed complex CSS)</li>
        <li>✅ Cleaned up product/show.blade.php (removed complex CSS)</li>
        <li>✅ Modeled after working wishlist layout</li>
    </ul>
</body>
</html>
