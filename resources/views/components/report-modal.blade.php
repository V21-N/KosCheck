<div
    x-data="reportModal()"
    x-show="isOpen"
    x-cloak
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
>
    {{-- Overlay --}}
    <div
        class="absolute inset-0 bg-black/50 backdrop-blur-sm"
        @click="closeModal()"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    {{-- Modal Content --}}
    <div
        class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-4"
        @click.stop
    >
        {{-- Header --}}
        <div class="sticky top-0 bg-white rounded-t-2xl border-b border-border-light px-6 py-4 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-text">Laporkan Masalah</h2>
                    <p class="text-xs text-text-muted">Bantu kami menjaga kualitas platform</p>
                </div>
            </div>
            <button
                type="button"
                @click="closeModal()"
                class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-text-muted hover:text-text transition-colors"
                aria-label="Tutup modal"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Success State --}}
        <div x-show="submitted" x-cloak class="p-8 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-text mb-2">Laporan Terkirim!</h3>
            <p class="text-text-muted text-sm mb-6">Terima kasih atas laporan Anda. Tim kami akan memproses laporan ini dalam 1x24 jam.</p>
            <button
                type="button"
                @click="closeModal()"
                class="btn btn-primary"
            >
                Tutup
            </button>
        </div>

        {{-- Form State --}}
        <form x-show="!submitted" @submit.prevent="submitReport()" class="p-6 space-y-5">
            {{-- Info Banner --}}
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-xs text-amber-800 leading-relaxed">
                    Laporan palsu atau tidak berdasar dapat mengakibatkan akun Anda dibatasi. Pastikan laporan Anda valid dan dapat dibuktikan.
                </p>
            </div>

            {{-- Target Info --}}
            <div class="bg-gray-50 rounded-xl p-4">
                <p class="text-xs text-text-muted mb-2">Melaporkan:</p>
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                        <img :src="targetImage || '{{ asset('images/kos-placeholder.png') }}'" class="w-full h-full object-cover" alt="Target">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="font-bold text-sm text-text truncate" x-text="targetName || 'Loading...'"></h4>
                        <p class="text-xs text-text-muted truncate" x-text="targetLocation || 'Lokasi tidak tersedia'"></p>
                    </div>
                </div>
            </div>

            {{-- Report Type --}}
            <div>
                <label class="block text-sm font-semibold text-text mb-3">Jenis Laporan</label>
                <div class="grid grid-cols-1 gap-3">
                    @foreach([
                        ['value' => 'fraud', 'label' => 'Penipuan / Scam', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Pemilik kos meminta transfer di luar platform'],
                        ['value' => 'fake_photo', 'label' => 'Foto Palsu / Tidak Sesuai', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z', 'desc' => 'Foto tidak sesuai dengan kondisi sebenarnya'],
                        ['value' => 'spam', 'label' => 'Spam / Iklan tidak relevan', 'icon' => 'M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'desc' => 'Kontenpromosi tidak sesuai atau berulang'],
                        ['value' => 'inappropriate', 'label' => 'Konten Tidak Pantas', 'icon' => 'M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636', 'desc' => 'Konten SARA, vulgar, atau tidak pantas'],
                        ['value' => 'fake_review', 'label' => 'Review Palsu', 'icon' => 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', 'desc' => 'Review tidak berdasarkan pengalaman nyata'],
                        ['value' => 'other', 'label' => 'Lainnya', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Masalah lain yang tidak termasuk di atas']
                    ] as $type)
                        <button
                            type="button"
                            @click="reportType = '{{ $type['value'] }}'"
                            :class="reportType === '{{ $type['value'] }}' ? 'border-primary bg-primary/5 ring-2 ring-primary/30' : 'border-border-light hover:border-primary/50'"
                            class="w-full flex items-start gap-3 p-4 rounded-xl border bg-white transition-all text-left"
                        >
                            <div :class="reportType === '{{ $type['value'] }}' ? 'bg-primary text-white' : 'bg-gray-100 text-text-muted'" class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-semibold text-text">{{ $type['label'] }}</h4>
                                <p class="text-xs text-text-muted mt-0.5">{{ $type['desc'] }}</p>
                            </div>
                            <div x-show="reportType === '{{ $type['value'] }}'" class="flex-shrink-0">
                                <svg class="w-5 h-5 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-semibold text-text mb-2">
                    Deskripsi Masalah
                    <span class="text-text-muted font-normal" x-text="' (' + description.length + '/500)'"></span>
                </label>
                <textarea
                    x-model="description"
                    rows="4"
                    maxlength="500"
                    class="input-field bg-gray-50 focus:bg-white resize-none"
                    placeholder="Jelaskan secara detail masalah yang Anda temukan. Semakin spesifik, semakin membantu kami memproses laporan Anda."
                    required
                ></textarea>
                <p class="mt-1 text-xs" :class="description.length < 20 ? 'text-red-500' : 'text-green-600'">
                    <span x-show="description.length < 20" x-cloak>Minimal 20 karakter diperlukan.</span>
                    <span x-show="description.length >= 20" x-cloak>Deskripsi sudah cukup detail.</span>
                </p>
            </div>

            {{-- Evidence Upload --}}
            <div>
                <label class="block text-sm font-semibold text-text mb-2">Bukti (Opsional)</label>
                <div
                    class="border-2 border-dashed border-border-light rounded-xl p-6 text-center hover:border-primary/50 transition-colors cursor-pointer"
                    :class="isDragging ? 'border-primary bg-primary/5' : ''"
                    @dragover.prevent="isDragging = true"
                    @dragleave="isDragging = false"
                    @drop.prevent="handleFileDrop($event)"
                    @click="$refs.fileInput.click()"
                >
                    <input type="file" x-ref="fileInput" @change="handleFileSelect($event)" accept="image/*,.pdf" class="hidden" multiple>
                    <div x-show="!files.length" class="space-y-2">
                        <div class="w-12 h-12 mx-auto rounded-full bg-gray-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                        </div>
                        <p class="text-sm text-text-muted">Seret file ke sini atau <span class="text-primary font-semibold">klik untuk upload</span></p>
                        <p class="text-xs text-text-light">Maks 3 file (gambar/PDF, masing-masing maks 5MB)</p>
                    </div>
                    <div x-show="files.length" class="space-y-2">
                        <template x-for="(file, index) in files" :key="index">
                            <div class="flex items-center gap-3 bg-gray-50 rounded-lg p-3">
                                <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                                    <img x-show="file.preview" :src="file.preview" class="w-full h-full object-cover">
                                    <div x-show="!file.preview" class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-text truncate" x-text="file.name"></p>
                                    <p class="text-xs text-text-muted" x-text="formatFileSize(file.size)"></p>
                                </div>
                                <button type="button" @click.stop="removeFile(index)" class="text-text-muted hover:text-red-500 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click.stop="$refs.fileInput.click()" class="text-sm text-primary font-semibold hover:text-primary-dark">
                            + Tambah file lagi
                        </button>
                    </div>
                </div>
            </div>

            {{-- Contact Info --}}
            <div>
                <label class="block text-sm font-semibold text-text mb-2">Nomor WhatsApp untuk Follow-up</label>
                <div class="flex">
                    <span class="inline-flex items-center rounded-l-lg border border-r-0 border-border bg-gray-50 px-3 text-sm text-text-muted">+62</span>
                    <input
                        type="tel"
                        x-model="contactPhone"
                        class="input-field rounded-l-none bg-gray-50 focus:bg-white flex-1"
                        placeholder="81234567890"
                        pattern="[0-9]{8,12}"
                    >
                </div>
                <p class="mt-1 text-xs text-text-muted">Opsional. Kami akan menghubungi Anda jika butuh informasi tambahan.</p>
            </div>

            {{-- Terms --}}
            <div class="bg-gray-50 rounded-xl p-4">
                <label class="flex items-start gap-3 cursor-pointer">
                    <input type="checkbox" x-model="agreeTerms" class="mt-0.5 h-4 w-4 rounded border-border text-primary accent-primary" required>
                    <span class="text-xs text-text-muted leading-relaxed">
                        Saya menyatakan laporan ini benar dan dapat dipertanggungjawabkan. Saya memahami bahwa laporan palsu dapat mengakibatkan pembatasan akun saya.
                    </span>
                </label>
            </div>

            {{-- Submit Button --}}
            <div class="flex gap-3 pt-2">
                <button
                    type="button"
                    @click="closeModal()"
                    class="btn btn-white flex-1"
                >
                    Batal
                </button>
                <button
                    type="submit"
                    class="btn btn-primary flex-1"
                    :disabled="!canSubmit || isSubmitting"
                    :class="!canSubmit || isSubmitting ? 'opacity-50 cursor-not-allowed' : ''"
                >
                    <span x-show="!isSubmitting">Kirim Laporan</span>
                    <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengirim...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function reportModal() {
    return {
        isOpen: false,
        reportType: '',
        description: '',
        files: [],
        contactPhone: '',
        agreeTerms: false,
        isDragging: false,
        isSubmitting: false,
        submitted: false,
        targetId: null,
        targetType: null,
        targetName: '',
        targetLocation: '',
        targetImage: '',

        openModal(options = {}) {
            this.isOpen = true;
            this.resetForm();
            this.targetId = options.id || null;
            this.targetType = options.type || 'kos';
            this.targetName = options.name || 'Kos Tidak Dikenal';
            this.targetLocation = options.location || '';
            this.targetImage = options.image || '';
            document.body.classList.add('overflow-hidden');
        },

        closeModal() {
            this.isOpen = false;
            document.body.classList.remove('overflow-hidden');
        },

        resetForm() {
            this.reportType = '';
            this.description = '';
            this.files = [];
            this.contactPhone = '';
            this.agreeTerms = false;
            this.submitted = false;
            this.isSubmitting = false;
        },

        get canSubmit() {
            return (
                this.reportType &&
                this.description.length >= 20 &&
                this.agreeTerms
            );
        },

        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            this.addFiles(files);
        },

        handleFileDrop(event) {
            this.isDragging = false;
            const files = Array.from(event.dataTransfer.files);
            this.addFiles(files);
        },

        addFiles(files) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf'];
            const maxSize = 5 * 1024 * 1024; // 5MB
            const maxFiles = 3;

            if (this.files.length >= maxFiles) {
                alert('Maksimal 3 file dapat diupload.');
                return;
            }

            files.forEach(file => {
                if (this.files.length >= maxFiles) return;

                if (!validTypes.includes(file.type)) {
                    alert('Hanya file gambar (JPG, PNG, GIF, WEBP) dan PDF yang diizinkan.');
                    return;
                }

                if (file.size > maxSize) {
                    alert('Ukuran file maksimal 5MB.');
                    return;
                }

                const fileObj = {
                    file: file,
                    name: file.name,
                    size: file.size,
                    preview: null
                };

                // Generate preview for images
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        fileObj.preview = e.target.result;
                        this.files.push(fileObj);
                    };
                    reader.readAsDataURL(file);
                } else {
                    this.files.push(fileObj);
                }
            });
        },

        removeFile(index) {
            this.files.splice(index, 1);
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        async submitReport() {
            if (!this.canSubmit) return;

            this.isSubmitting = true;

            try {
                // Simulate API call
                await new Promise(resolve => setTimeout(resolve, 1500));

                // In production, this would be:
                // const formData = new FormData();
                // formData.append('target_id', this.targetId);
                // formData.append('target_type', this.targetType);
                // formData.append('report_type', this.reportType);
                // formData.append('description', this.description);
                // formData.append('contact_phone', this.contactPhone);
                // this.files.forEach((file, index) => {
                //     formData.append('evidence[]', file.file);
                // });
                // const response = await fetch('/report', {
                //     method: 'POST',
                //     headers: {
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                //     },
                //     body: formData
                // });

                this.submitted = true;
            } catch (error) {
                console.error('Error submitting report:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                this.isSubmitting = false;
            }
        }
    };
}
</script>
@endpush