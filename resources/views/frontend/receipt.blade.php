<x-frontend-layout title="home" description="this is meta description" keywords="this is meta keywords">
    <div class="container mx-auto p-6">
        <div id="receipt-card" class="bg-white shadow-md rounded-lg px-10 py-6">
            <div>
                <h1 class="text-2xl font-bold mb-2 text-center text-[var(--primary)]">Order Receipt</h1>
                <h2 class=" text-center text-xl font-semibold mb-2 text-[var(--black-text)]">{{ $shop->name }}</h2>
            </div>
            <!-- Order Information -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2 text-[var(--text)]">Order Details</h2>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p><strong>Order ID:</strong> {{ $order->order_id }}</p>
                        <p><strong>Order Status:</strong> {{ ucfirst($order->status) }}</p>
                        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        <p><strong>Delivery Date:</strong> {{ $order->delivery_date}}</p>

                    </div>

                    <!-- QR code container -->
                    <div id="qr-container" class="w-24 h-24 p-2 bg-white border rounded shadow-sm">
                        <!-- QR will be generated here -->
                    </div>
                    <div>
                        <p><strong>Customer:</strong> {{ $order->user->name }}</p>
                        <p><strong>Contact:</strong> {{ $order->contact }}</p>
                        <p><strong>Location:</strong> {{ $order->location }}</p>
                        <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2 text-[var(--text)]">Order Items</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-[var(--light-primary)]">
                            <th class="border p-2 text-center text-[var(--text)]">Product</th>
                            <th class="border p-2 text-center text-[var(--text)]">Image</th>
                            <th class="border p-2 text-center text-[var(--text)]">Flavour</th>
                            <th class="border p-2 text-center text-[var(--text)]">Weight</th>
                            <th class="border p-2 text-center text-[var(--text)]">Quantity</th>
                            <th class="border p-2 text-center text-[var(--text)]">Price</th>
                            <th class="border p-2 text-center text-[var(--text)]">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->order_items as $item)
                            <tr>
                                <td class="border p-2 text-[var(--text)]">{{ $item->product->name }}</td>
                                <td class="border p-2 text-[var(--text)]">
                                    <img class="size-26" src="{{ asset(Storage::url($item->product->images[0])) }}"
                                        alt="">
                                </td>
                                <td class="border p-2 text-[var(--text)]">
                                    @php
                                        $flavour = \App\Models\Flavour::find($item->flavour_id);
                                    @endphp
                                    {{ $flavour->names }}
                                </td>
                                <td class="border p-2 text-[var(--text)]">{{ $item->weight }} pounds</td>
                                <td class="border p-2 text-right text-[var(--text)]">{{ $item->qty }}</td>
                                <td class="border p-2 text-right text-[var(--text)]">Rs.
                                    {{ number_format($item->amount / $item->qty, 2) }}</td>
                                <td class="border p-2 text-right text-[var(--text)]">Rs.
                                    {{ number_format($item->amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-semibold">
                            <td colspan="6" class="border p-2 text-right text-[var(--text)]">Subtotal:</td>
                            <td class="border p-2 text-right text-[var(--text)]">Rs.
                                {{ number_format($order->total_amount - $order->delivery_fee, 2) }}</td>
                        </tr>
                        <tr class="font-semibold">
                            <td colspan="6" class="border p-2 text-right text-[var(--text)]">Delivery Fee:</td>
                            <td class="border p-2 text-right text-[var(--text)]">Rs.
                                {{ number_format($order->delivery_fee, 2) }}</td>
                        </tr>
                        <tr class="font-semibold">
                            <td colspan="6" class="border p-2 text-right text-[var(--text)]">Total Amount:</td>
                            <td class="border p-2 text-right text-[var(--text)]">Rs.
                                {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Payment Information -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2 text-[var(--text)]">Payment Details</h2>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment->method) }}</p>
                        <p><strong>Payment Status:</strong> {{ ucfirst($order->payment->status) }}</p>
                    </div>
                    <div>
                        <p><strong>Transaction ID:</strong> {{ $order->payment->transaction_id ?? 'N/A' }}</p>
                        @if ($order->payment->payment_receipt)
                            <p><strong>Receipt:</strong>
                                <a href="{{ Storage::url($order->payment->payment_receipt) }}" target="_blank"
                                    class="text-[var(--secondary)] hover:underline">
                                    View Receipt
                                </a>

                                {{-- <a href="{{ asset($order->payment->payment_receipt) }}"
                                    target="_blank" class="text-[var(--secondary)] hover:underline">View Receipt</a> --}}
                            </p>
                        @else
                            <p><strong>Receipt:</strong> Not uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="text-center mt-4">
            <button onclick="printReceipt()"
                class="inline-flex items-center px-4 py-2 bg-[var(--secondary)] text-white rounded hover:bg-[var(--primary)]">
                <i class="fas fa-print mr-2"></i> Print PDF
            </button>
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 bg-[var(--primary)] text-white rounded hover:bg-[var(--secondary)] ml-2">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <!-- QR lib -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // safely inject server-side order_id into JS
            const orderId = {!! json_encode($order->order_id) !!};

            // Target element
            const qrContainer = document.getElementById('qr-container');

            // Clear any previous content (if rerendered)
            qrContainer.innerHTML = '';

            // Create QR: size 96x96 px (adjust if needed)
            const qr = new QRCode(qrContainer, {
                text: orderId,
                width: 96,
                height: 96,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });

            // Optional: add small label under QR
            const label = document.createElement('div');
            label.style.fontSize = '10px';
            label.style.marginTop = '4px';
            // label.textContent = orderId;
            // label.style.textAlign = 'center';
            qrContainer.appendChild(label);
        });

        function printReceipt() {
            const {
                jsPDF
            } = window.jspdf;
            const receiptCard = document.getElementById('receipt-card');

            html2canvas(receiptCard, {
                scale: 2
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF({
                    orientation: 'portrait',
                    unit: 'mm',
                    format: 'a4'
                });

                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save(`receipt_order.pdf`);
            });
        }
    </script>
</x-frontend-layout>
