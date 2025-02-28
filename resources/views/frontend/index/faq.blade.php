<section class="mb-5">
    <div class="container">
        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            <div class="faq-list">
                <div class="faq-item">
                    <div class="faq-question">How does the quotation request process work?</div>
                    <div class="faq-answer">
                        Once you submit a request, we gather the necessary details and provide you with a customized quote.
                        You'll receive a confirmation email, and our team will contact you if any additional information is required.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">How long does it take to receive a quotation?</div>
                    <div class="faq-answer">
                        Typically, it takes <strong>24 to 48 hours</strong> to process a request, depending on the complexity and availability of the requested services.
                        Urgent requests may be accommodated upon request.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Is the quotation free of charge?</div>
                    <div class="faq-answer">
                        Yes, requesting a quotation is completely <strong>free and non-binding</strong>.
                        You are not obligated to proceed with the service after receiving the quote.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Can I request multiple quotations?</div>
                    <div class="faq-answer">
                        Absolutely! You can request <strong>multiple quotes</strong> for different services or options, helping you compare and choose the best solution for your needs.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What information do I need to provide for a quotation?</div>
                    <div class="faq-answer">
                        To ensure an accurate quote, please provide:
                        - <strong>Type of service</strong> needed
                        - <strong>Delivery location</strong> and timeframe
                        - <strong>Quantity and specifications</strong> of the items
                        - Any <strong>special requirements</strong>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">How do I accept a quotation?</div>
                    <div class="faq-answer">
                        If you're satisfied with the quote, simply follow the instructions in the email or contact our team to proceed with <strong>payment and confirmation</strong>.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Do you offer international delivery quotations?</div>
                    <div class="faq-answer">
                        Yes, we provide <strong>both domestic and international</strong> quotations.
                        International requests may take longer due to additional regulations and logistics considerations.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">Can I modify my request after submitting it?</div>
                    <div class="faq-answer">
                        If you need to make changes, contact our support team as soon as possible.
                        Modifications may affect the <strong>final price and delivery time</strong>.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">How can I track my quotation status?</div>
                    <div class="faq-answer">
                        Once submitted, you can track your request via your <strong>account dashboard</strong> or by contacting our support team.
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">What payment methods do you accept?</div>
                    <div class="faq-answer">
                        We accept payments via <strong>credit/debit cards, PayPal, bank transfers, and company invoices</strong> (for approved accounts).
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
