<div x-data="mobileReview()" x-cloak>
    <!-- Floating button (visible on mobile only) -->
    <button @click="open = true" class="fixed bottom-20 right-4 z-[9999] md:hidden w-14 h-14 rounded-full bg-primary text-white flex items-center justify-center shadow-xl" aria-label="Beri Review">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
    </button>

    <!-- Modal -->
    <div x-show="open" x-transition class="fixed inset-0 bg-black/60 z-[9998] flex items-end md:items-center justify-center p-4 md:p-8" @click="open = false">
        <div @click.stop x-transition class="w-full max-w-md bg-white rounded-t-3xl md:rounded-3xl p-5 shadow-2xl">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-bold">Beri Review (Mobile)</h3>
                <button @click="open = false" class="text-gray-500">&times;</button>
            </div>

            <div class="space-y-3 text-sm">
                <div>
                    <label class="block text-xs font-semibold mb-1">Pilih Kos / Partner</label>
                    <input type="text" x-model="form.subject" placeholder="Nama kos atau partner" class="w-full px-3 py-2 border border-border-light rounded" />
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Rating</label>
                    <select x-model="form.rating" class="w-full px-3 py-2 border border-border-light rounded">
                        <option value="5">5 — Sangat Baik</option>
                        <option value="4">4 — Baik</option>
                        <option value="3">3 — Cukup</option>
                        <option value="2">2 — Kurang</option>
                        <option value="1">1 — Buruk</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold mb-1">Ulasan</label>
                    <textarea x-model="form.message" rows="4" class="w-full px-3 py-2 border border-border-light rounded" placeholder="Tulis pengalamanmu..."></textarea>
                </div>

                <div class="flex gap-2">
                    <button @click="submit()" class="flex-1 py-2 bg-primary text-white rounded">Kirim Review</button>
                    <button @click="open=false" class="flex-1 py-2 border rounded">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function mobileReview() {
    return {
        open: false,
        form: {
            subject: '',
            rating: '5',
            message: ''
        },
        submit() {
            if (!this.form.subject || !this.form.message) {
                alert('Mohon isi nama kos/partner dan ulasan.');
                return;
            }
            // Save to localStorage as demo (or send to server if available)
            const reviews = JSON.parse(localStorage.getItem('kc_mobile_reviews') || '[]');
            reviews.unshift({ subject: this.form.subject, rating: this.form.rating, message: this.form.message, created_at: new Date().toISOString() });
            localStorage.setItem('kc_mobile_reviews', JSON.stringify(reviews));

            this.open = false;
            this.form = { subject: '', rating: '5', message: '' };

            const t = document.createElement('div');
            t.className = 'fixed bottom-6 right-6 bg-gray-900 text-white px-5 py-3 rounded-2xl shadow-xl text-sm z-[9999]';
            t.textContent = 'Terima kasih! Review dikirim (simulasi).';
            document.body.appendChild(t);
            setTimeout(() => t.remove(), 2600);
        }
    }
}
</script>
