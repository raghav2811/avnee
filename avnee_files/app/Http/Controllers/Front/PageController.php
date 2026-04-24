<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
    {
        $policyPage = $this->policyPageContent($slug);
        if ($policyPage) {
            $page = (object) $policyPage;
            return view('front.page', compact('page'));
        }

        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->first();

        if (!$page) {
            abort(404);
        }

        return view('front.page', compact('page'));
    }

    private function policyPageContent(string $slug): ?array
    {
        $pages = [
            'terms-of-service' => [
                'title' => 'Terms & Conditions',
                'content' => '
                    <h3>Introduction</h3>
                    <p><strong>Welcome to Avnee Collections.</strong></p>
                    <p>By accessing or using our website and services, you agree to be bound by the terms and conditions set forth herein. These Terms of Service constitute a legally binding agreement between you ("User") and Avnee Collections.</p>
                    <p>Please read these Terms carefully before using the website or making a purchase. By continuing to use the platform, you acknowledge that you have read, understood, and agreed to these Terms, along with our related policies including Returns, Shipping, and Privacy.</p>

                    <h3>Overview</h3>
                    <p>Avnee Collections is a lifestyle brand offering curated products including kidswear (0-12 years), jewelry for women and mothers, sarees, accessories, and playful trinkets.</p>
                    <p>All products and services provided through the platform are subject to these Terms of Service.</p>

                    <h3>Eligibility</h3>
                    <p>Use of this website is available only to persons who are legally capable of entering into binding contracts under applicable laws.</p>
                    <p>If you are under the age of 18 years, you may use this website only under the supervision of a parent or legal guardian who agrees to be bound by these Terms.</p>

                    <h3>Products & Representation</h3>
                    <p>Avnee Collections strives to ensure that all product descriptions, images, and details are presented as accurately as possible. However, slight variations may occur due to factors beyond our control.</p>
                    <p>Colors of products may differ slightly due to lighting conditions or display settings of your device. Fabric textures, prints, and handcrafted elements may exhibit natural variations. Jewelry finishes may also vary slightly due to their design and usage nature.</p>
                    <p>Such variations are inherent characteristics and shall not be considered defects.</p>

                    <h3>Pricing & Payments</h3>
                    <p>All prices listed on the website are in Indian Rupees (INR) and are subject to change without prior notice.</p>
                    <p>An order is considered confirmed only upon successful receipt of payment. In the event of pricing inaccuracies or technical errors, Avnee Collections reserves the right to cancel or modify the order at its discretion.</p>

                    <h3>Order Acceptance & Cancellation</h3>
                    <p>Placing an order on the website constitutes an offer to purchase. An order is deemed accepted only upon dispatch of the product.</p>
                    <p>Avnee Collections reserves the right to cancel any order due to reasons including but not limited to stock unavailability, incorrect pricing or product information, or concerns related to payment or fraud detection.</p>
                    <p>In case of cancellation after payment, the applicable refund will be processed to the original payment method.</p>

                    <h3>Shipping & Delivery</h3>
                    <p>Delivery timelines provided are indicative and may vary depending on location and external factors.</p>
                    <p>Avnee Collections shall not be held responsible for delays caused by logistics partners, weather conditions, or other unforeseen circumstances.</p>
                    <p>The risk of loss or damage to the product passes to the customer upon dispatch.</p>

                    <h3>Returns & Exchanges</h3>
                    <p>Returns or exchanges are accepted only if the product is unused, in its original condition, and accompanied by original tags and packaging. Requests must be raised within the specified return window.</p>
                    <p>Certain items, including jewelry (for hygiene reasons) and customized or sale products, may not be eligible for return or exchange.</p>
                    <p>Avnee Collections reserves the right to reject any return request that does not meet the stated conditions.</p>

                    <h3>Jewelry Care Disclaimer</h3>
                    <p>Our jewelry is designed for everyday elegance and comfort, including anti-tarnish styles. However, its longevity depends on proper usage and care.</p>
                    <p>Customers are advised to avoid exposure to water, perfumes, and chemicals. Natural wear and tear over time is expected and shall not be considered a manufacturing defect.</p>

                    <h3>User Responsibilities</h3>
                    <p>Users agree to provide accurate, complete, and current information while using the website. You are responsible for maintaining the confidentiality of your account credentials.</p>
                    <p>You agree to use the platform only for lawful purposes and in compliance with applicable laws.</p>
                    <p>Users must not misuse the website, attempt unauthorized access, or upload any harmful, illegal, or inappropriate content.</p>

                    <h3>Intellectual Property</h3>
                    <p>All content available on the website, including but not limited to images, product designs, branding, text, and graphics, is the property of Avnee Collections.</p>
                    <p>Unauthorized use, reproduction, or distribution of any content without prior written permission is strictly prohibited.</p>

                    <h3>Reviews & Feedback</h3>
                    <p>Any reviews, feedback, or content submitted by users may be used by Avnee Collections for marketing, promotional, or improvement purposes.</p>
                    <p>Users agree that such content shall not be unlawful, offensive, misleading, or in violation of any rights.</p>

                    <h3>Limitation of Liability</h3>
                    <p>Avnee Collections shall not be liable for any indirect, incidental, or consequential damages arising from the use of the website or purchase of products.</p>
                    <p>We are not responsible for delays beyond our control or minor variations in product appearance.</p>
                    <p>The maximum liability, if any, shall not exceed the value of the product purchased.</p>

                    <h3>Force Majeure</h3>
                    <p>Avnee Collections shall not be held responsible for any delay or failure in performance caused by events beyond reasonable control, including but not limited to natural disasters, strikes, transportation disruptions, or government restrictions.</p>

                    <h3>Privacy</h3>
                    <p>We are committed to protecting your personal information. All data provided by users is handled securely and used solely to enhance the shopping experience.</p>
                    <p>For more details, please refer to our Privacy Policy.</p>

                    <h3>Changes to Terms</h3>
                    <p>Avnee Collections reserves the right to update or modify these Terms at any time without prior notice.</p>
                    <p>Continued use of the website after such changes constitutes acceptance of the revised Terms.</p>

                    <h3>Governing Law</h3>
                    <p>These Terms shall be governed by and interpreted in accordance with the laws of India.</p>
                    <p>Any disputes arising out of or relating to these Terms shall be subject to the jurisdiction of the courts in India.</p>

                    <h3>Contact Information</h3>
                    <p>For any queries, concerns, or support, you may contact us at:</p>
                    <p><strong>Avnee Collections</strong><br>Email: studio@avneecollections.com<br>Email: avnee.collections@gmail.com</p>
                ',
            ],
            'privacy-policy' => [
                'title' => 'Privacy Policy',
                'content' => '
                    <h3>Introduction</h3>
                    <p>At Avnee Collections, we value your privacy and are committed to safeguarding your personal information.</p>
                    <p>This Privacy Policy outlines how we collect, use, store, and protect your data when you access or use our website. By using our platform, you agree to the practices described in this policy.</p>

                    <h3>Information We Collect</h3>
                    <p>When you interact with our website, we may collect personal and technical information necessary to provide our services effectively.</p>
                    <p>This includes details such as your name, email address, phone number, shipping and billing address, payment details (processed securely through authorized payment gateways), and your order history and preferences.</p>
                    <p>Additionally, we may collect technical data such as your IP address, browser type, and device information to enhance user experience and improve our platform.</p>

                    <h3>How We Use Information</h3>
                    <p>The information collected is used for legitimate business purposes, including processing and delivering your orders, communicating order updates and customer support, and informing you about offers or promotions.</p>
                    <p>We also use your data to improve our website functionality, personalize your shopping experience, ensure secure transactions, and prevent fraudulent activities.</p>

                    <h3>Sharing of Information</h3>
                    <p>Avnee Collections does not sell, trade, or rent your personal information to third parties.</p>
                    <p>Your data may be shared only with trusted service providers such as payment gateways, shipping and logistics partners, and technology or support service providers. These entities are obligated to maintain the confidentiality and security of your information.</p>

                    <h3>Cookies & Tracking Technologies</h3>
                    <p>We use cookies and similar tracking technologies to enhance your browsing experience, remember your preferences, and analyze website performance.</p>
                    <p>You may choose to disable cookies through your browser settings; however, this may affect certain functionalities of the website.</p>

                    <h3>Data Security</h3>
                    <p>We implement reasonable and appropriate security measures to protect your personal information from unauthorized access, misuse, alteration, or loss.</p>
                    <p>While we strive to ensure the highest level of security, no online platform can guarantee absolute protection. Users are encouraged to practice safe browsing habits.</p>

                    <h3>Your Rights</h3>
                    <p>As a user, you have the right to access, update, or correct your personal information. You may also request deletion of your data or opt out of marketing communications at any time.</p>
                    <p>Such requests can be made by contacting us through the details provided below.</p>

                    <h3>Children’s Privacy</h3>
                    <p>Our products are designed for children; however, purchases must be made by parents or legal guardians.</p>
                    <p>We do not knowingly collect personal information from children under the age of 13.</p>

                    <h3>Data Retention</h3>
                    <p>We retain your personal information only for as long as necessary to fulfill orders, comply with legal obligations, and improve customer experience.</p>
                    <p>Once the data is no longer required, it is securely deleted or anonymized.</p>

                    <h3>Legal Compliance</h3>
                    <p>This Privacy Policy is governed by applicable laws of India, including but not limited to:</p>
                    <ul>
                        <li>The Information Technology Act, 2000</li>
                        <li>The SPDI (Sensitive Personal Data or Information) Rules, 2011</li>
                    </ul>

                    <h3>Business Information</h3>
                    <p>Avnee Collections<br>GSTIN: 29BDKPR6215G1Z8</p>

                    <h3>Updates to Policy</h3>
                    <p>Avnee Collections reserves the right to update or modify this Privacy Policy at any time.</p>
                    <p>Any changes will be posted on this page, and continued use of the website constitutes acceptance of the updated policy.</p>

                    <h3>Contact Us</h3>
                    <p>For any questions, concerns, or requests related to this Privacy Policy, you may contact us at:</p>
                    <p><strong>Email:</strong> studio@avneecollections.com</p>
                    <p><strong>Email:</strong> avnee.collections@gmail.com</p>
                    <p><strong>Phone:</strong> +91 9008671144</p>
                ',
            ],
            'return-exchange-policy' => [
                'title' => 'Return & Exchange Policy',
                'content' => '
                    <h3>Introduction</h3>
                    <p>At Avnee Collections, every product is thoughtfully curated and carefully quality-checked prior to dispatch.</p>
                    <p>As a growing brand, we maintain a strict return and exchange policy to ensure fairness, product integrity, and a consistent customer experience. By placing an order with us, you agree to the terms outlined below.</p>

                    <h3>Return Window</h3>
                    <p>Return requests must be raised within 3 days of delivery of the product.</p>
                    <p>Requests made beyond this period may not be considered.</p>

                    <h3>Mandatory Unboxing Video</h3>
                    <p>To be eligible for any return or claim, a clear and complete 360° unboxing video is mandatory.</p>
                    <p>The video must clearly capture:</p>
                    <ul>
                        <li>The sealed package before opening</li>
                        <li>The complete unboxing process</li>
                        <li>The condition of the product upon opening</li>
                    </ul>
                    <p>Failure to provide this video will result in rejection of the return or claim request.</p>

                    <h3>Return Eligibility</h3>
                    <p>Returns are accepted only under the following conditions:</p>
                    <ul>
                        <li>The product is damaged</li>
                        <li>The product is defective</li>
                        <li>An incorrect item has been delivered</li>
                    </ul>
                    <p>No other circumstances shall qualify for return eligibility.</p>

                    <h3>Product Condition Requirements</h3>
                    <p>To qualify for a return, the product must meet the following conditions:</p>
                    <ul>
                        <li>The product must be unused</li>
                        <li>All original tags must be intact (especially in the case of jewelry)</li>
                        <li>The product must be returned in its original packaging</li>
                    </ul>
                    <p>If any tags are removed, including jewelry tags, the return request will not be accepted.</p>

                    <h3>Non-Returnable</h3>
                    <ul>
                        <li>Jewelry items without original tags</li>
                        <li>Accessories and trinkets (unless proven defective or damaged through unboxing video)</li>
                        <li>Customized or made-to-order products</li>
                        <li>Sale or discounted items</li>
                    </ul>

                    <h3>Size & Preference</h3>
                    <p>Returns are not accepted for reasons related to personal preference, including but not limited to:</p>
                    <ul>
                        <li>Size issues</li>
                        <li>Change of mind</li>
                        <li>Styling preferences</li>
                    </ul>
                    <p>Customers are advised to review size charts and product details carefully before placing an order.</p>

                    <h3>Return Process</h3>
                    <p>Currently, automated return requests are not available on the website.</p>
                    <p>To initiate a return, customers must contact us through the following channels:</p>
                    <p><strong>Email:</strong> studio@avneecollections.com</p>
                    <p><strong>Alternate Email:</strong> avnee.collections@gmail.com</p>
                    <p><strong>Phone/WhatsApp:</strong> +91 908671144</p>
                    <p>The request must include:</p>
                    <ul>
                        <li>Order ID</li>
                        <li>Description of the issue</li>
                        <li>360° unboxing video</li>
                    </ul>
                    <p>Our team will review the request and respond within 24-48 hours.</p>

                    <h3>Approval & Pickup</h3>
                    <p>All return requests are subject to approval after verification.</p>
                    <p>If approved, detailed pickup instructions will be provided. A quality inspection will be conducted once the product is received before processing any refund.</p>

                    <h3>Return Charges</h3>
                    <p>A return handling fee of ₹149 may be applicable.</p>
                    <p>Shipping charges paid at the time of purchase are non-refundable.</p>

                    <h3>Refund Policy</h3>
                    <p>Refunds will be processed only after the returned product successfully passes quality inspection.</p>
                    <p>Refunds may be issued in the following forms:</p>
                    <ul>
                        <li>Store credit (preferred)</li>
                        <li>Original payment method (on a case-by-case basis)</li>
                    </ul>
                    <p>The refund processing timeline is typically 5-7 working days from approval.</p>

                    <h3>Cancellation Policy</h3>
                    <p>Orders may be cancelled only before they are dispatched.</p>
                    <p>Once the order has been shipped, cancellation requests will not be accepted.</p>

                    <h3>Note From Us</h3>
                    <p>AVNEE is built with care, intention, and attention to detail. Every product is chosen to bring joy to little ones and confidence to women.</p>
                    <p>This policy helps us maintain quality, fairness, and sustainability as we continue to grow.</p>
                ',
            ],
            'shipping-policy' => [
                'title' => 'Shipping Policy',
                'content' => '
                    <h3>Introduction</h3>
                    <p>At Avnee Collections, we are committed to delivering your orders in a safe, timely, and seamless manner. This Shipping Policy outlines the terms and conditions governing the shipment and delivery of products purchased through our website.</p>
                    <p>By placing an order with us, you agree to the terms stated below.</p>

                    <h3>Shipping Coverage</h3>
                    <p>Avnee Collections currently offers shipping services across India.</p>
                    <p>International shipping may be available upon request. Customers interested in international delivery are encouraged to contact us prior to placing an order for further assistance.</p>

                    <h3>Shipping Charges</h3>
                    <p>Shipping charges are calculated based on order value, delivery location, and package weight.</p>
                    <p>We offer free shipping on all orders above ₹1499. For orders below ₹1499, shipping charges typically range between ₹50 and ₹150, depending on the delivery location and weight of the package.</p>

                    <h3>Cash on Delivery (COD)</h3>
                    <p>Cash on Delivery (COD) is available at selected locations.</p>
                    <p>COD orders are accepted for a maximum order value of ₹10,000. Availability of COD depends on the serviceability of the delivery location.</p>

                    <h3>Order Processing & Delivery Time</h3>
                    <p>Orders are generally processed and dispatched within 1-3 working days from the date of order confirmation.</p>
                    <p>Estimated delivery timelines are as follows:</p>
                    <ul>
                        <li>Metro cities: 2-4 working days</li>
                        <li>Other locations: 3-6 working days</li>
                    </ul>
                    <p>Delivery timelines are indicative and may vary depending on location, courier partner availability, and unforeseen circumstances.</p>

                    <h3>Order Tracking</h3>
                    <p>Once your order has been shipped, you will receive tracking details via SMS and/or email.</p>
                    <p>Customers can track their shipment using the tracking link provided by the courier partner.</p>

                    <h3>Shipping Partners</h3>
                    <p>We collaborate with reliable and trusted courier partners to ensure safe and efficient delivery of your orders.</p>

                    <h3>Delivery Responsibility</h3>
                    <p>Upon dispatch, the shipment is handled by our courier partners.</p>
                    <p>While we strive to ensure timely delivery, Avnee Collections shall not be held responsible for delays caused by logistics partners, weather conditions, or other external factors beyond our control. We request your patience in such situations.</p>

                    <h3>Damaged or Tampered Packages</h3>
                    <p>Customers are strongly advised to record a complete 360° unboxing video at the time of opening the package.</p>
                    <p>If the package appears damaged or tampered with at the time of delivery, you are advised to either refuse acceptance (where possible) or contact us immediately.</p>
                    <p>Claims related to damaged or tampered packages may not be processed without valid proof.</p>

                    <h3>Incorrect Address</h3>
                    <p>Customers are responsible for providing accurate and complete shipping details at the time of placing the order.</p>
                    <p>Avnee Collections shall not be liable for delays, failed deliveries, or additional charges arising due to incorrect or incomplete address or contact information.</p>

                    <h3>International Orders (If Applicable)</h3>
                    <p>For international orders, customers are responsible for any applicable customs duties, import taxes, or additional charges imposed by their respective country.</p>

                    <h3>Note From Us</h3>
                    <p>Every order from Avnee Collections is carefully packed with attention and care.</p>
                    <p>We sincerely appreciate your trust and patience as we deliver our products to your doorstep and strive to provide you with a delightful shopping experience.</p>
                ',
            ],
            'faqs' => [
                'title' => 'Frequently Asked Questions',
                'content' => '
                    <h3>Introduction</h3>
                    <p>Welcome to the Avnee Collections FAQ section.</p>
                    <p>Here, we have answered the most common questions to help you have a smooth and enjoyable shopping experience. If you need further assistance, feel free to contact us anytime.</p>

                    <h3>About Avnee Collections</h3>
                    <p><strong>What is Avnee Collections?</strong><br>Avnee Collections is a curated lifestyle brand offering stylish and comfortable kidswear (0-12 years), along with jewelry, accessories, sarees, and playful trinkets designed to add joy to everyday moments.</p>

                    <h3>Size & Fit</h3>
                    <p><strong>How do I choose the right size?</strong><br>We recommend referring to the size chart available on each product page. For further assistance, you may contact our support team.</p>
                    <p><strong>Do you offer customization?</strong><br>Currently, we do not offer customization services.</p>
                    <p><strong>What if the outfit does not fit?</strong><br>We advise checking the size chart carefully before placing an order. Returns are not accepted for size-related concerns.</p>

                    <h3>Orders & Delivery</h3>
                    <p><strong>How do I place an order?</strong><br>Select your desired product, choose the appropriate size (if applicable), and proceed to checkout.</p>
                    <p><strong>How can I track my order?</strong><br>Once your order is shipped, tracking details will be shared via SMS or email.</p>
                    <p><strong>How long does delivery take?</strong><br>Delivery timelines are as follows:</p>
                    <ul>
                        <li>Metro cities: 2-4 working days</li>
                        <li>Other locations: 3-6 working days</li>
                    </ul>
                    <p><strong>Do you offer Cash on Delivery (COD)?</strong><br>Yes, COD is available for orders up to ₹10,000 in selected locations.</p>
                    <p><strong>What if I miss my delivery?</strong><br>The courier partner will attempt delivery again. You may also contact the courier service or reach out to us for assistance.</p>

                    <h3>Payments</h3>
                    <p><strong>What payment methods do you accept?</strong><br>We accept UPI, Debit Cards, Credit Cards, Net Banking, and Cash on Delivery (COD).</p>

                    <h3>Returns & Cancellation</h3>
                    <p><strong>Can I return or exchange my order?</strong><br>Returns are accepted only if the product is damaged, defective, or incorrect.</p>
                    <p><strong>What is the return window?</strong><br>Return requests must be raised within 3 days of delivery.</p>
                    <p><strong>What is required for a return?</strong><br>A complete 360° unboxing video is mandatory for any return request.</p>
                    <p><strong>Are all products eligible for return?</strong><br>No. The following items are not eligible for return:</p>
                    <ul>
                        <li>Jewelry (especially if tags are removed)</li>
                        <li>Accessories and trinkets</li>
                        <li>Sarees and stitched items</li>
                        <li>Sale or discounted products</li>
                    </ul>
                    <p><strong>Can I cancel my order?</strong><br>Orders can be cancelled only before dispatch. Once shipped, cancellation is not possible.</p>

                    <h3>Shipping</h3>
                    <p><strong>What are the shipping charges?</strong></p>
                    <ul>
                        <li>Free shipping on orders above ₹1499</li>
                        <li>₹50-₹150 for orders below ₹1499 (depending on location and weight)</li>
                    </ul>

                    <h3>Product & Quality</h3>
                    <p><strong>Will I receive good quality products?</strong><br>Yes. Every product is carefully selected to ensure comfort, quality, and style.</p>
                    <p><strong>Will the product look exactly like the images?</strong><br>While we aim for accuracy, slight variations may occur due to lighting conditions or screen settings.</p>

                    <h3>Customer Support</h3>
                    <p><strong>How can I contact you?</strong><br>You can reach us through the following:</p>
                    <p><strong>Email:</strong> studio@avneecollections.com</p>
                    <p><strong>Email:</strong> avnee.collections@gmail.com</p>
                    <p><strong>Phone:</strong> 908671144</p>
                    <p>Our team typically responds within 24-48 hours.</p>

                    <h3>Additional Queries</h3>
                    <p><strong>Do you offer bulk orders?</strong><br>Yes, for bulk or special orders, please contact us directly.</p>
                    <p><strong>Do you have a physical store?</strong><br>We are currently an online-first brand based in Bangalore.</p>

                    <h3>Popular Questions</h3>
                    <p>Below are some of the most frequently asked questions for quick reference:</p>
                    <p><strong>Do you offer Cash on Delivery (COD)?</strong><br>Yes, COD is available for orders up to ₹10,000 in selected locations.</p>
                    <p><strong>What is your return policy?</strong><br>Returns are accepted only for damaged or incorrect items within 3 days, along with a mandatory unboxing video.</p>
                    <p><strong>How long does delivery take?</strong><br>2-4 days for metro cities and 3-6 days for other locations.</p>
                    <p><strong>Is shipping free?</strong><br>Yes, free shipping is available on orders above ₹1499; otherwise, charges range between ₹50-₹150.</p>
                    <p><strong>What if the size does not fit?</strong><br>Returns are not accepted for size issues. Please refer to the size chart before ordering.</p>
                    <p><strong>Will I receive the same product as shown?</strong><br>Yes, although slight variations in color may occur due to lighting.</p>
                    <p><strong>Is jewelry safe for everyday wear?</strong><br>Yes, many pieces are designed for daily use. Avoid exposure to water and perfumes for better longevity.</p>

                    <h3>Recent Queries</h3>
                    <p><strong>Can I change my order after placing it?</strong><br>Yes, modifications are possible only before dispatch. Please contact us immediately.</p>
                    <p><strong>I missed my delivery. What should I do?</strong><br>The courier will reattempt delivery. You may also contact them or reach out to us.</p>
                    <p><strong>My order shows delivered but I did not receive it. What should I do?</strong><br>Please check with neighbors or security personnel. If still unresolved, contact us immediately.</p>
                    <p><strong>Do you offer customization?</strong><br>Currently, customization services are not available.</p>
                    <p><strong>How can I contact your team?</strong><br>You may reach us via email or phone. Our response time is typically within 24-48 hours.</p>
                    <p><strong>Do you take bulk or gifting orders?</strong><br>Yes, we accept bulk and special orders. Please contact us for details.</p>
                    <p><strong>Do you have a store in Bangalore?</strong><br>We are currently an online-first brand.</p>

                    <h3>Note From Us</h3>
                    <p>Every piece at Avnee Collections is selected with care and love - for little ones and for you.</p>
                    <p>If you ever need assistance, we are always just a message away.</p>
                ',
            ],
        ];

        return $pages[$slug] ?? null;
    }
}
