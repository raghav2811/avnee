<?php
$filePath = 'd:/smartindia projects/avnee/avnee-laravel/resources/views/welcome.blade.php';
$content = file_get_contents($filePath);

// Fix 1: Wrap unclosed swiper and sections properly
// We find the part where the bestselling styles end and replace it with correct structure.

$part1 = "          @foreach(\$newArrivals as \$product)\r\n          <div class=\"swiper-slide\">\r\n            <a href=\"{{ route('front.product.detail', \$product->slug ?? \$product->id) }}\" class=\"block group/item\">\r\n              <div class=\"relative overflow-hidden bg-[#f7f5f2] mb-4\" style=\"aspect-ratio: 3/4;\">\r\n                <img src=\"{{ asset('storage/' . \$product->image) }}\" alt=\"{{ \$product->name }}\"\r\n                  class=\"w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover/item:scale-105\" />\r\n              </div>\r\n              <h3 class=\"font-body text-xs sm:text-[13px] text-[#3d2b1a] font-medium mb-1 truncate\">\r\n                {{ \$product->name }}\r\n              </h3>\r\n              @if(\$product->discount > 0)\r\n              <div class=\"flex items-center gap-2\">\r\n                @php\r\n                    \$discountedPrice = \$product->price - (\$product->price * (\$product->discount / 100));\r\n                @endphp\r\n                <span class=\"font-body text-sm font-semibold text-[#1c0f04]\">₹{{ number_format(\$discountedPrice, 2) }}</span>\r\n                <span class=\"font-body text-xs text-[#a8998a] line-through\">₹{{ number_format(\$product->price, 2) }}</span>\r\n                <span class=\"font-body text-[11px] font-semibold text-[#c0392b] tracking-wide uppercase\">{{ \$product->discount }}% Off</span>\r\n              </div>\r\n              @else\r\n              <p class=\"font-body text-sm font-semibold text-[#1c0f04]\">\r\n                ₹{{ number_format(\$product->price, 2) }}\r\n              </p>\r\n              @endif\r\n            </a>\r\n          </div>\r\n          @endforeach\r\n\r\n        </div>\r\n      </div>\r\n\r\n    </div>\r\n  </section>\n\n  <!-- ═══════════════════════════════════════════════ -->\n  <!-- THE SAREE EDIT SECTION                         -->\n  <!-- ═══════════════════════════════════════════════ -->\n  <section id=\"saree-edit\" class=\"py-12 sm:py-16 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto\">\n    <!-- Section Title -->\n    <h2 class=\"font-heading text-2xl sm:text-3xl text-center text-gray-800 font-normal tracking-wide mb-8 sm:mb-10\">\n      The Saree Edit\n    </h2>\r\n";

// Target is something like "@foreach... @endforeach \n\n The Saree Edit \n </h2>"
// I will just use a regex to replace everything between @foreach and "Introducing INSTANT SAREE" to ensure I cover the gap.

$content = preg_replace('/@foreach\(\$newArrivals as \$product\).*?The Saree Edit.*?<\/h2>/s', $part1, $content);

// Cleanup redundant tags
$content = preg_replace('/<\/div>\s*<\/section>\s*<\/div>\s*<\/section>/', "    </div>\n  </section>\n", $content);

file_put_contents($filePath, $content);
echo "SUCCESS: Welcome page fixed.\n";
?>
