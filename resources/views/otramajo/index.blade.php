@extends('layouts.app')

@section('title', 'OtraMajo – Inicio')

@section('content')
<style>
    :root{
        --om-blanco:#FAF9F6; --om-salvia:#A8C3A0; --om-rosa:#E9C7C1;
        --om-gris-claro:#D3D3D3; --om-arena:#F4E1A1; --om-carbon:#4A4A4A;
    }
    body{ background: var(--om-blanco); color: var(--om-carbon); }

    /* Compensa header fijo (10px social + 80~96px barra principal) */
    .pt-header{ padding-top: 140px; }

    .om-sep{ height:1px; background:linear-gradient(90deg,transparent,rgba(74,74,74,.25),transparent); }
    .om-brand{ font-family:"Cormorant Garamond", serif; }
    .om-nav{ font-family:"Quicksand", system-ui, -apple-system, Segoe UI, Roboto, sans-serif; }

    /* ===== HERO FULL COVER + PARALLAX CON MOUSE ===== */
    .om-hero{
        position: relative;
        isolation: isolate;
        overflow: hidden;
        min-height: 75vh; /* podés subir a 80/100vh */
        width: 100%;
        background: var(--om-blanco);
    }
    .om-hero-img{
        position: absolute;
        inset: 0;
        background-image: url('{{ asset('images/birds.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

        /* Valores controlados por JS */
        transform:
            scale(var(--om-zoom, 1.08))
            translate(var(--om-mouse-x, 0px), var(--om-mouse-y, 0px));

        transition: transform .15s ease-out;
        will-change: transform;
        filter: brightness(1) contrast(1); /* base */
    }
    /* Overlay para aclarar más la imagen y resaltar el texto */
    .om-hero::before{
        content: "";
        position: absolute; inset: 0;
        /* Capa suave blanca para aclarar */
        background: rgba(255,255,255, .20);
        z-index: 0;
        pointer-events: none;
    }
    .om-hero::after{
        content:""; position:absolute; inset:0;
        /* Gradiente cálido más notorio que antes */
        background: linear-gradient(180deg,
            rgba(250,249,246,.78) 0%,
            rgba(244,225,161,.42) 100%
        );
        z-index: 0;
        pointer-events: none;
        /* Opcional: refuerza claridad sobre el fondo real */
        backdrop-filter: brightness(1.06);
    }

    .om-hero-inner{ position: relative; z-index: 2; }

    @media (prefers-reduced-motion: reduce){
        .om-hero-img{ transition:none !important; }
    }
</style>

{{-- Header fijo (top) --}}
@include('partials.top-nav')

<main class="pt-header">
    {{-- HERO / Presentación (imagen cubre todo el div + efecto por movimiento del mouse) --}}
    <section class="om-hero">
        <div class="om-hero-img"></div>

        <div class="om-hero-inner max-w-5xl mx-auto px-6 sm:px-6 lg:px-8 py-16 md:py-20">
            <div class="bg-[color:var(--om-blanco)]/70 backdrop-blur-md rounded-2xl shadow border border-[color:var(--om-gris-claro)] p-6 md:p-10">
                <h1 class="om-brand text-3xl md:text-5xl font-semibold mb-4 text-[color:var(--om-carbon)]">
                    Hola soy María José Olveira <span class="text-[color:var(--om-salvia)]">(Majo)</span>
                </h1>
                <p class="text-lg leading-relaxed mb-4">
                    Bienvenidos a mi historia: hace un tiempo mi vida cambio de una forma que nunca imaginé, me desperté con un ACV (accidente cerebrovascular).
                </p>
                <p class="leading-relaxed mb-4">
                    Esta página nace del deseo de compartir mi camino: mis miedos, mis avances, mis recaídas, mis aprendizajes, las pequeñas grandes victorias que me trajeron hasta acá. No soy médica ni especialista solo soy una persona que pasó y sigue pasando por esto y que quiere ofrecer una mirada más humana y real sobre la recuperación.
                </p>
                <blockquote class="border-l-4 pl-4 italic text-[color:var(--om-carbon)]/80 mb-4" style="border-color: var(--om-rosa)">
                    “La vida es un 10% lo que nos ocurre y un 90% cómo reaccionamos a ello.” — Charles R. Swindoll
                </blockquote>
                <p class="leading-relaxed mb-4">
                    Al contarte mi historia, no busco dar recetas ni fórmulas mágicas. Solo relatarte como fui y sigo trabajando mi vida después del ACV, en mi vida siempre pensé que hay un lado de la moneda que podemos elegir. Que incluso en medio de un golpe tan duro como un ACV, es posible encontrar nuevos caminos, nuevos afectos, nuevas formas de amar la vida. Teniendo siempre en claro que esa es mi forma de ver la vida y que cada uno lo hace con las herramientas que tiene y puede.
                </p>
                <div class="om-sep my-6"></div>
                <h2 class="om-brand text-2xl md:text-3xl mb-4">Aquí vas a encontrar:</h2>
                <ul class="space-y-2 marker:text-[color:var(--om-salvia)] list-disc pl-6">
                    <li>Un blog donde contare como fui y sigo transitando mi nueva vida</li>
                    <li>Mi relato personal sobre como fui enfrentando mi nueva historia de vida, mi proceso en el día a día.</li>
                    <li>Reflexiones desde mi mirada sobre la paciencia, fortaleza, angustia que conlleva la rehabilitación e inserción a este nuevo mundo.</li>
                    <li>Relatos y videos sobre sobre recursos que me ayudaron en mi rehabilitación y en la vida cotidiana.</li>
                    <li>Entrevistas, historias sobre gente que paso y pasa por lo mismo.</li>
                    <li>Y lo que vaya surgiendo en este nuevo camino y necesite compartirlo con ustedes.</li>
                    <li>Y sobre todo esperanza. Porque si, se puede volver a sonreír.</li>
                    <li>Historias de personas que pasaron y pasan por lo mismo.</li>
                </ul>
                <div class="om-sep my-6"></div>
                <p class="leading-relaxed">
                    Si estás atravesando algo parecido como paciente familiar o amigo o simplemente querés conocer una historia de resiliencia, te invito a acompañarme. Este espacio es para compartir, aprender y recordar que cada paso, por pequeño que sea, es importante en nuestra vida.
                </p>
                <p class="mt-4 font-medium">Gracias por estar acá — Bienvenido a mi página.</p>
            </div>
        </div>
    </section>

    {{-- Secciones placeholder --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid md:grid-cols-3 gap-6">
            <a href="#" class="block rounded-xl p-6 border shadow-sm hover:shadow-md transition"
               style="background: var(--om-rosa); border-color: #e7b5ad">
                <h3 class="om-brand text-xl mb-2">Blog personal</h3>
                <p>Notas y relatos sobre mi camino y mis descubrimientos.</p>
            </a>
            <a href="#" class="block rounded-xl p-6 border shadow-sm hover:shadow-md transition"
               style="background: var(--om-salvia); border-color: #98b691">
                <h3 class="om-brand text-xl mb-2">Mis videos</h3>
                <p>Pequeños registros y ejercicios que me acompañan.</p>
            </a>
            <a href="#" class="block rounded-xl p-6 border shadow-sm hover:shadow-md transition"
               style="background: var(--om-arena); border-color: #ead894">
                <h3 class="om-brand text-xl mb-2">Noticias destacadas</h3>
                <p>Información útil y novedades relacionadas.</p>
            </a>
        </div>

        <div class="om-sep my-10"></div>

        <div class="grid md:grid-cols-2 gap-6">
            <a href="#" class="block rounded-xl p-6 border shadow-sm hover:shadow-md transition"
               style="background: var(--om-blanco); border-color: var(--om-gris-claro)">
                <h3 class="om-brand text-xl mb-2">Preguntas frecuentes</h3>
                <p>Respuestas sencillas desde mi experiencia.</p>
            </a>
            <a href="#" class="block rounded-xl p-6 border shadow-sm hover:shadow-md transition"
               style="background: var(--om-blanco); border-color: var(--om-gris-claro)">
                <h3 class="om-brand text-xl mb-2">Encuestas</h3>
                <p>Para escucharnos y aprender entre todos.</p>
            </a>
            <a href="#" class="block rounded-xl p-6 border shadow-sm hover:shadow-md transition"
               style="background: var(--om-blanco); border-color: var(--om-gris-claro)">
                <h3 class="om-brand text-xl mb-2">Resultados</h3>
                <p>Lo que vayamos construyendo con la comunidad.</p>
            </a>
            <a href="#" class="block rounded-xl p-6 border shadow-sm hover:shadow-md transition"
               style="background: var(--om-blanco); border-color: var(--om-gris-claro)">
                <h3 class="om-brand text-xl mb-2">Enlaces donde puedes seguirme</h3>
                <p>Mis redes y espacios.</p>
            </a>
        </div>
    </section>
</main>

{{-- Footer (bottom) --}}
@include('partials.bottom-nav')
@endsection

@push('scripts')
<script>
(function(){
    const hero = document.querySelector('.om-hero');
    const img  = document.querySelector('.om-hero-img');
    if (!hero || !img) return;

    hero.addEventListener('mousemove', (e) => {
        const rect = hero.getBoundingClientRect();

        // posición del mouse dentro del hero
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        // normalizamos: 0 a 1
        const nx = x / rect.width;
        const ny = y / rect.height;

        // amplitud del movimiento
        const MAX = 18; // px hacia cada lado (suave)
        const moveX = (nx - 0.5) * MAX * -1;
        const moveY = (ny - 0.5) * MAX * -1;

        img.style.setProperty('--om-mouse-x', `${moveX.toFixed(1)}px`);
        img.style.setProperty('--om-mouse-y', `${moveY.toFixed(1)}px`);
        img.style.setProperty('--om-zoom', '1.10'); // zoom constante moderado
    });

    hero.addEventListener('mouseleave', () => {
        img.style.setProperty('--om-mouse-x', '0px');
        img.style.setProperty('--om-mouse-y', '0px');
        img.style.setProperty('--om-zoom', '1.08');
    });
})();
</script>
@endpush
