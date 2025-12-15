@extends('layouts.app')

@section('title', 'OtraMajo – Videos ' . $tipo)

@section('content')
<style>
    :root{
        --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#D4A8A1;
        --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
    }
    body{ background: var(--om-blanco); color: var(--om-carbon); }

    .pt-header{ padding-top:140px; }
    .om-sep{ height:1px; background:linear-gradient(90deg,transparent,rgba(74,74,74,.25),transparent); }
    .om-brand{ font-family:"Cormorant Garamond", serif; }

    .card-video{
        background: var(--om-blanco);
        border:1px solid var(--om-gris-claro);
        border-radius:1.25rem;
        overflow:hidden;
        box-shadow:0 10px 30px rgba(0,0,0,.06);
        transition:all .35s ease;
        cursor:pointer;
        user-select:none;
    }
    .card-video:hover{
        transform:translateY(-6px);
        box-shadow:0 20px 50px rgba(0,0,0,.12);
        border-color: var(--om-salvia);
    }

    .thumb-wrap{
        position:relative;
        height:220px;
        overflow:hidden;
        background:#000;
    }
    .thumb-wrap img{
        width:100%;
        height:100%;
        object-fit:cover;
        transition:transform .4s ease, opacity .4s ease;
    }
    .card-video:hover .thumb-wrap img{ transform:scale(1.06); opacity:.85; }

    .play-badge{
        position:absolute; inset:0;
        display:flex; align-items:center; justify-content:center;
        pointer-events:none;
    }
    .play-badge span{
        width:64px; height:64px;
        border-radius:999px;
        display:flex; align-items:center; justify-content:center;
        background: rgba(0,0,0,.45);
        border:1px solid rgba(255,255,255,.25);
        backdrop-filter: blur(6px);
        box-shadow:0 10px 30px rgba(0,0,0,.3);
        color:#fff;
        font-size:26px;
    }

    .card-body{ padding:1.5rem 1.5rem 1.75rem; }
    .card-title{
        font-family:"Cormorant Garamond", serif;
        font-size:1.35rem;
        font-weight:600;
        margin-bottom:.5rem;
        line-height:1.3;
    }
    .card-desc{
        font-size:.95rem;
        opacity:.85;
        line-height:1.6;
    }

    .back-btn{
        display:inline-flex;
        align-items:center;
        gap:.5rem;
        padding:.6rem 1.2rem;
        border-radius:.75rem;
        border:1px solid var(--om-gris-claro);
        background: var(--om-blanco);
        transition:all .25s ease;
        text-decoration:none;
        color: var(--om-carbon);
        font-weight:500;
    }
    .back-btn:hover{
        background: var(--om-salvia);
        border-color: var(--om-salvia);
        color:#1f2a1f;
        transform:translateY(-2px);
        box-shadow:0 6px 16px rgba(168,195,160,.35);
    }

    .pagination-container{
        background: var(--om-blanco);
        border:1px solid var(--om-gris-claro);
        border-radius:1rem;
        padding:1.5rem;
        box-shadow:0 5px 20px rgba(0,0,0,.05);
    }

    /* ===================== MODAL (fijo y más chico) ===================== */
    .om-modal-overlay{
        position:fixed;
        inset:0;
        background: rgba(0,0,0,.60);
        backdrop-filter: blur(3px);
        z-index: 9990;
        display:none;
        align-items:center;
        justify-content:center;
        padding: 14px;
    }
    .om-modal-overlay.active{ display:flex; }

    .om-modal{
        width: min(720px, 92vw);              /* más chico */
        height: min(640px, 82vh);             /* alto fijo */
        background:#fff;
        border-radius: 1.1rem;
        border: 1px solid rgba(0,0,0,.08);
        box-shadow: 0 30px 80px rgba(0,0,0,.35);
        overflow:hidden;
        display:flex;
        flex-direction: column;
    }

    .om-modal-header{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap: 12px;
        padding: 12px 14px;
        background: linear-gradient(135deg, rgba(212,168,161,.20), rgba(244,225,161,.16));
        border-bottom: 1px solid rgba(0,0,0,.08);
        flex: 0 0 auto;
    }
    .om-modal-title{
        font-family:"Cormorant Garamond", serif;
        font-size: 1.25rem;
        font-weight: 600;
        line-height: 1.2;
        margin:0;
        color: var(--om-carbon);
    }
    .om-modal-sub{
        margin-top: 2px;
        font-size: .88rem;
        opacity: .8;
    }
    .om-modal-close{
        border:1px solid rgba(0,0,0,.15);
        background:#fff;
        border-radius: 12px;
        padding: 7px 10px;
        cursor:pointer;
        transition: all .2s ease;
        line-height: 1;
        flex: 0 0 auto;
    }
    .om-modal-close:hover{
        background: rgba(168,195,160,.25);
        border-color: rgba(168,195,160,.55);
        transform: translateY(-1px);
    }

    .om-modal-body{
        padding: 12px 14px 14px;
        flex: 1 1 auto;
        overflow:hidden;                      /* no scroll general */
        display:flex;
        flex-direction: column;
        gap: 12px;
    }

    .video-shell{
        width: 100%;
        aspect-ratio: 16 / 9;                 /* el contenedor manda */
        background:#0b0b0b;
        border-radius: 1rem;
        overflow:hidden;
        border: 1px solid rgba(0,0,0,.12);
        box-shadow: 0 10px 30px rgba(0,0,0,.10);
        flex: 0 0 auto;
    }
    video{
        width: 100%;
        height: 100%;                         /* el video se adapta */
        object-fit: contain;                  /* NO corta */
        display:block;
        background:#000;
    }

    .om-tools{
        display:flex;
        flex-wrap:wrap;
        gap: 8px;
        justify-content: space-between;
        align-items:center;
        flex: 0 0 auto;
    }
    .tool-left, .tool-right{
        display:flex;
        flex-wrap:wrap;
        gap: 8px;
        align-items:center;
    }

    .tool-btn{
        border:1px solid rgba(0,0,0,.15);
        background:#fff;
        border-radius: 999px;
        padding: 8px 12px;
        cursor:pointer;
        transition: all .2s ease;
        font-size: .92rem;
        text-decoration:none;
        color: var(--om-carbon);
    }
    .tool-btn:hover{
        background: rgba(168,195,160,.25);
        border-color: rgba(168,195,160,.55);
        transform: translateY(-1px);
    }
    .tool-btn:disabled{
        opacity:.5;
        cursor:not-allowed;
        transform:none;
    }

    .desc-box{
        border: 1px solid rgba(0,0,0,.08);
        border-radius: 1rem;
        background: rgba(250,249,246,.8);
        padding: 12px 14px;
        overflow:auto;                        /* ✅ scroll solo aquí */
        flex: 1 1 auto;
        font-size: .95rem;
        line-height: 1.6;
        opacity: .92;
    }
    /* Para respetar el formato del editor (p, listas, links, etc.) */
    .desc-box p{ margin: 0 0 .6rem; }
    .desc-box ul, .desc-box ol{ margin: .4rem 0 .6rem 1.2rem; }
    .desc-box li{ margin: .15rem 0; }
    .desc-box a{ text-decoration: underline; }

    @media (max-width:768px){
        .pt-header{ padding-top:100px; }
        .thumb-wrap{ height:180px; }
        .om-modal{ width: min(92vw, 720px); height: min(78vh, 620px); }
        .om-modal-title{ font-size:1.15rem; }
        .om-tools{ justify-content:center; }
        .tool-left, .tool-right{ justify-content:center; width:100%; }
    }
</style>

@include('partials.top-nav')

<main class="pt-header">
    <section class="py-14">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Encabezado --}}
            <div class="text-center mb-10">
                <h1 class="om-brand text-4xl md:text-5xl font-semibold mb-4">{{ $tipo }}</h1>
                <div class="om-sep max-w-md mx-auto"></div>

                <p class="mt-5 text-lg opacity-80 max-w-2xl mx-auto">
                    {{ $tipo === 'Ejercicios'
                        ? 'Ejercicios y recursos pensados para acompañar procesos de rehabilitación, movilidad y autonomía.'
                        : 'Viajes, experiencias personales y recomendaciones de lugares accesibles y adaptados.' }}
                </p>

                <div class="mt-6">
                    <a href="{{ route('videos') }}" class="back-btn">← Volver a Videos</a>
                </div>
            </div>

            {{-- Grilla --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($videos as $v)
                    <article
                        class="card-video"
                        role="button"
                        tabindex="0"
                        data-video-src="{{ $v->video_url }}"
                        data-title="{{ e($v->titulo) }}"
                        data-desc-b64="{{ base64_encode($v->descripcion ?? '') }}"
                    >
                        <div class="thumb-wrap">
                            <img src="{{ $v->miniatura_url }}" alt="{{ $v->titulo }}" loading="lazy" decoding="async">
                            <div class="play-badge"><span>▶</span></div>
                        </div>

                        <div class="card-body">
                            <h3 class="card-title">{{ $v->titulo }}</h3>
                            <p class="card-desc">{!! \Illuminate\Support\Str::limit($v->descripcion, 140) !!}</p>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3">
                        <div class="bg-white border border-[color:var(--om-gris-claro)] rounded-xl p-12 text-center">
                            <p class="text-lg opacity-70">Todavía no hay videos en esta categoría.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Paginación --}}
            @if($videos->hasPages())
                <div class="mt-12 pagination-container">
                    {{ $videos->links() }}
                </div>
            @endif

        </div>
    </section>
</main>

{{-- ================= MODAL ================= --}}
<div class="om-modal-overlay" id="omVideoOverlay" aria-hidden="true">
    <div class="om-modal" role="dialog" aria-modal="true" aria-labelledby="omModalTitle">
        <div class="om-modal-header">
            <div>
                <h2 class="om-modal-title" id="omModalTitle">—</h2>
                <div class="om-modal-sub" id="omModalSub">—</div>
            </div>
            <button class="om-modal-close" id="omVideoClose" aria-label="Cerrar">✕</button>
        </div>

        <div class="om-modal-body">
            <div class="video-shell">
                <video id="omVideoPlayer"
                       controls
                       preload="metadata"
                       playsinline
                       webkit-playsinline>
                    <source id="omVideoSource" src="" type="video/mp4">
                    Tu navegador no soporta la reproducción de video.
                </video>
            </div>

            <div class="om-tools">
                <div class="tool-left">
                    <button class="tool-btn" id="btnPrev">← Anterior</button>
                    <button class="tool-btn" id="btnNext">Siguiente →</button>
                    <button class="tool-btn" id="btnRestart">⟲ Reiniciar</button>
                </div>
                <div class="tool-right">
                    <button class="tool-btn" id="btnFullscreen">⛶ Pantalla completa</button>
                </div>
            </div>

            <div class="desc-box" id="omModalDesc"></div>
        </div>
    </div>
</div>

@include('partials.bottom-nav')

<script>
(function () {
    const overlay   = document.getElementById('omVideoOverlay');
    const btnClose  = document.getElementById('omVideoClose');

    const titleEl   = document.getElementById('omModalTitle');
    const subEl     = document.getElementById('omModalSub');
    const descEl    = document.getElementById('omModalDesc');

    const videoEl   = document.getElementById('omVideoPlayer');
    const sourceEl  = document.getElementById('omVideoSource');

    const btnPrev   = document.getElementById('btnPrev');
    const btnNext   = document.getElementById('btnNext');
    const btnRestart= document.getElementById('btnRestart');
    const btnFs     = document.getElementById('btnFullscreen');

    const cards = Array.from(document.querySelectorAll('.card-video'));

    let currentIndex = -1;
    let lastFocused = null;

    function updateNavButtons() {
        btnPrev.disabled = (currentIndex <= 0);
        btnNext.disabled = (currentIndex >= cards.length - 1);
    }

    function b64ToUtf8(b64) {
        try {
            return decodeURIComponent(escape(atob(b64 || "")));
        } catch (e) {
            try { return atob(b64 || ""); } catch(e2) { return ""; }
        }
    }

    function openModal(index) {
        if (index < 0 || index >= cards.length) return;

        lastFocused = document.activeElement;
        currentIndex = index;

        const card = cards[index];
        const src  = card.dataset.videoSrc;
        const title= card.dataset.title || 'Video';
        const descHtml = b64ToUtf8(card.dataset.descB64 || '');

        titleEl.textContent = title;
        subEl.textContent = `Video ${index + 1} de ${cards.length} • {{ $tipo }}`;

        // ✅ HTML real con formato (CKEditor)
        descEl.innerHTML = descHtml;

        // cargar video (sin autoplay)
        sourceEl.src = src;
        videoEl.load();

        overlay.classList.add('active');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        updateNavButtons();

        try { videoEl.pause(); } catch(e){}
    }

    function closeModal() {
        overlay.classList.remove('active');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';

        // liberar recursos
        try { videoEl.pause(); } catch(e){}
        try { videoEl.currentTime = 0; } catch(e){}
        sourceEl.src = '';
        videoEl.load();

        if (lastFocused && typeof lastFocused.focus === 'function') lastFocused.focus();
        currentIndex = -1;
    }

    function go(delta) {
        const next = currentIndex + delta;
        if (next < 0 || next >= cards.length) return;
        openModal(next);
    }

    // Abrir desde card
    cards.forEach((card, i) => {
        card.addEventListener('click', () => openModal(i));
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                openModal(i);
            }
        });
    });

    // Cerrar
    btnClose.addEventListener('click', closeModal);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeModal();
    });
    document.addEventListener('keydown', (e) => {
        if (!overlay.classList.contains('active')) return;

        if (e.key === 'Escape') closeModal();
        if (e.key === 'ArrowLeft') go(-1);
        if (e.key === 'ArrowRight') go(1);
    });

    // Navegación
    btnPrev.addEventListener('click', () => go(-1));
    btnNext.addEventListener('click', () => go(1));

    // Reiniciar
    btnRestart.addEventListener('click', () => {
        try { videoEl.currentTime = 0; videoEl.play(); } catch(e){}
    });

    // Pantalla completa (video)
    btnFs.addEventListener('click', async () => {
        try {
            if (videoEl.requestFullscreen) await videoEl.requestFullscreen();
            else if (videoEl.webkitEnterFullscreen) videoEl.webkitEnterFullscreen(); // iOS
        } catch (e) {}
    });

    // ✅ Auto-siguiente al finalizar
    videoEl.addEventListener('ended', () => {
        if (currentIndex < cards.length - 1) {
            setTimeout(() => go(1), 400);
        } else {
            updateNavButtons();
        }
    });
})();
</script>
@endsection
