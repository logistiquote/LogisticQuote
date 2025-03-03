<section class="mb-5">
    <div class="container">
        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <h3 class="faq-question">How does the quotation request process work?</h3>
                    <div class="faq-answer">
                        Submit your request, and we’ll gather the necessary details to provide a <strong>customized quote</strong>.
                        You’ll receive a confirmation email, and our team may contact you for further details.
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">How long does it take to receive a quotation?</h3>
                    <div class="faq-answer">
                        Most requests are processed within <strong>24 to 48 hours</strong>, depending on the service complexity. Urgent requests may be expedited.
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">Is the quotation free?</h3>
                    <div class="faq-answer">
                        Yes, our quotations are <strong>100% free and non-binding</strong>. You can request multiple quotes to compare options.
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">What information do I need to provide?</h3>
                    <div class="faq-answer">
                        To get the most accurate quote, include:
                        <ul>
                            <li><strong>Type of service</strong> required</li>
                            <li><strong>Delivery location</strong> and timeframe</li>
                            <li><strong>Quantity and specifications</strong> of items</li>
                            <li>Any <strong>special requirements</strong></li>
                        </ul>
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">How do I accept a quotation?</h3>
                    <div class="faq-answer">
                        If satisfied, follow the email instructions or contact us to proceed with <strong>payment and confirmation</strong>.
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">Do you provide international quotations?</h3>
                    <div class="faq-answer">
                        Yes, we offer <strong>both domestic and international</strong> quotations. Processing times vary depending on logistics and regulations.
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">Can I modify my request?</h3>
                    <div class="faq-answer">
                        Yes, contact our support team as soon as possible. Changes may affect <strong>pricing and delivery time</strong>.
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">How can I track my quotation status?</h3>
                    <div class="faq-answer">
                        You can track your request via your <strong>account dashboard</strong> or contact our support team for updates.
                    </div>
                </div>
                <div class="faq-item">
                    <h3 class="faq-question">What payment methods do you accept?</h3>
                    <div class="faq-answer">
                        We accept <strong>credit/debit cards, PayPal, bank transfers</strong>, and invoices for approved accounts.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEO: FAQ Schema Markup -->
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "How does the quotation request process work?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Submit your request, and we’ll gather the necessary details to provide a customized quote. You’ll receive a confirmation email, and our team may contact you for further details."
          }
        },
        {
          "@type": "Question",
          "name": "How long does it take to receive a quotation?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Most requests are processed within 24 to 48 hours, depending on the service complexity. Urgent requests may be expedited."
          }
        },
        {
          "@type": "Question",
          "name": "Is the quotation free?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, our quotations are 100% free and non-binding. You can request multiple quotes to compare options."
          }
        },
        {
          "@type": "Question",
          "name": "What information do I need to provide?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "To get the most accurate quote, include: Type of service required, Delivery location and timeframe, Quantity and specifications of items, and any special requirements."
          }
        },
        {
          "@type": "Question",
          "name": "How do I accept a quotation?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "If satisfied, follow the email instructions or contact us to proceed with payment and confirmation."
          }
        },
        {
          "@type": "Question",
          "name": "Do you provide international quotations?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, we offer both domestic and international quotations. Processing times vary depending on logistics and regulations."
          }
        },
        {
          "@type": "Question",
          "name": "Can I modify my request?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "Yes, contact our support team as soon as possible. Changes may affect pricing and delivery time."
          }
        },
        {
          "@type": "Question",
          "name": "How can I track my quotation status?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "You can track your request via your account dashboard or contact our support team for updates."
          }
        },
        {
          "@type": "Question",
          "name": "What payment methods do you accept?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "We accept credit/debit cards, PayPal, bank transfers, and invoices for approved accounts."
          }
        }
      ]
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const faqItems = document.querySelectorAll(".faq-item");

        faqItems.forEach(item => {
            item.addEventListener("click", function () {
                const answer = this.querySelector(".faq-answer");
                const isOpen = this.classList.contains("active");

                // Close all answers
                document.querySelectorAll(".faq-item").forEach(i => {
                    i.classList.remove("active");
                    i.querySelector(".faq-answer").style.display = "none";
                });

                // Toggle the clicked one
                if (!isOpen) {
                    this.classList.add("active");
                    answer.style.display = "block";
                }
            });
        });
    });
</script>
