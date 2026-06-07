<footer class="bg-bg py-8 border-t border-border mt-auto">
    <div class="container-custom flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <x-site-logo variant="auth-footer" class="items-center" />
            <p class="text-xs text-text-muted mt-2">&copy; 2026 KosCheck. Memulai babak baru mahasiswa.</p>
        </div>
        <div class="flex flex-wrap justify-center gap-6">
            <a href="#" class="text-xs text-text-muted hover:text-primary transition-colors">Kebijakan Privasi</a>
            <a href="#" class="text-xs text-text-muted hover:text-primary transition-colors">Syarat &amp; Ketentuan</a>
            <a href="{{ route('bantuan') }}" class="text-xs text-text-muted hover:text-primary transition-colors">Pusat Bantuan</a>
            <a href="#" class="text-xs text-text-muted hover:text-primary transition-colors">Karir</a>
        </div>
    </div>
</footer>
