#!/bin/bash

# Test script to verify the wishlist and weight functionality updates
echo "Testing wishlist and weight functionality updates..."
echo "================================================="

# Check if product show page has the updated weight selector
echo "1. Checking product show page weight selector..."
grep -n "weight-selector" resources/views/product/show.blade.php
if [ $? -eq 0 ]; then
    echo "   ✓ Weight selector found in product show page"
else
    echo "   ✗ Weight selector not found in product show page"
fi

# Check if wishlist button is functional in product show page
echo "2. Checking wishlist button functionality..."
grep -n "addToWishlist" resources/views/product/show.blade.php
if [ $? -eq 0 ]; then
    echo "   ✓ Wishlist button functionality found"
else
    echo "   ✗ Wishlist button functionality not found"
fi

# Check if percentage display is updated
echo "3. Checking percentage display..."
grep -n "text-purple-600" resources/views/product/show.blade.php
if [ $? -eq 0 ]; then
    echo "   ✓ Percentage display updated with purple color"
else
    echo "   ✗ Percentage display not updated"
fi

# Check if wishlist icon is removed from navigation
echo "4. Checking wishlist icon removal..."
grep -n "svg.*heart" resources/views/menu.blade.php
if [ $? -eq 0 ]; then
    echo "   ✗ Wishlist icon still present in menu"
else
    echo "   ✓ Wishlist icon removed from menu"
fi

grep -n "svg.*heart" resources/views/wishlist/index.blade.php
if [ $? -eq 0 ]; then
    echo "   ✗ Wishlist icon still present in wishlist index"
else
    echo "   ✓ Wishlist icon removed from wishlist index"
fi

# Check if weight dropdown has stopPropagation
echo "5. Checking weight dropdown stopPropagation..."
grep -n "event.stopPropagation" resources/views/menu.blade.php
if [ $? -eq 0 ]; then
    echo "   ✓ Weight dropdown has stopPropagation"
else
    echo "   ✗ Weight dropdown missing stopPropagation"
fi

echo ""
echo "Test complete!"
echo "=============="
echo ""
echo "Manual testing recommended:"
echo "1. Navigate to the menu page"
echo "2. Test weight dropdown on product cards (should not redirect)"
echo "3. Test wishlist button on product cards"
echo "4. Navigate to product show page"
echo "5. Test weight dropdown on product show page"
echo "6. Test wishlist button on product show page"
echo "7. Check percentage display formatting"
echo "8. Verify wishlist icon is removed from navigation"
