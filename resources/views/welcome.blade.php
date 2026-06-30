<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CikalTas — Premium Bags for Modern Lifestyle</title>
    <meta name="description" content="Temukan koleksi tas premium CikalTas. Desain elegan, kualitas terbaik untuk gaya hidup modern Anda.">
    <link rel="icon" type="image/png" href="{{ asset('gambar/Logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('gambar/Logo.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --cream: #faf7f2;
            --sand: #f0ebe0;
            --warm: #e8dfd0;
            --brown-light: #c4956a;
            --brown: #9c6e43;
            --brown-dark: #6b4226;
            --espresso: #3d2314;
            --charcoal: #1a1a1a;
            --white: #ffffff;
            --gray-soft: #888880;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
            overflow-x: hidden;
        }

        /* ══════════════════════════════
           SCROLLBAR
        ══════════════════════════════ */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--brown-light); border-radius: 10px; }

        /* ══════════════════════════════
           NAVBAR
        ══════════════════════════════ */
        .navbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 999;
            transition: all 0.4s ease;
            padding: 0 60px;
        }

        .navbar.transparent { background: transparent; }
        .navbar.scrolled {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(196,149,106,0.15);
            box-shadow: 0 4px 30px rgba(0,0,0,0.06);
        }

        .navbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
.logo img { max-height: 48px; height: auto; width: auto; }
        .logo-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--brown-dark), var(--brown));
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            transform: rotate(45deg);
        }
        .logo-icon-inner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.8);
            border-radius: 3px;
            transform: rotate(-45deg);
        }

        .logo-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 26px;
            font-weight: 600;
            color: var(--espresso);
            letter-spacing: 1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 36px;
            list-style: none;
        }

        .nav-links a {
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--espresso);
            text-decoration: none;
            position: relative;
            transition: color 0.3s;
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -4px; left: 0;
            width: 0; height: 1px;
            background: var(--brown);
            transition: width 0.3s ease;
        }
        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: var(--brown); }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .btn-outline-nav {
            padding: 9px 22px;
            border: 1.5px solid var(--brown);
            border-radius: 100px;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            color: var(--brown-dark);
            background: transparent;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-outline-nav:hover {
            background: var(--brown);
            color: var(--white);
        }

        .btn-solid-nav {
            padding: 9px 22px;
            border: 1.5px solid var(--espresso);
            border-radius: 100px;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            color: var(--white);
            background: var(--espresso);
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-solid-nav:hover {
            background: var(--brown-dark);
            border-color: var(--brown-dark);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 4px;
        }
        .hamburger span {
            display: block;
            width: 24px; height: 2px;
            background: var(--espresso);
            border-radius: 2px;
            transition: all 0.3s;
        }

        /* ══════════════════════════════
           HERO
        ══════════════════════════════ */
        .hero {
            min-height: 100vh;
            background: var(--cream);
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: stretch;
            position: relative;
            overflow: hidden;
        }

        .hero-left {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 120px 60px 80px 100px;
            position: relative;
            z-index: 2;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--sand);
            border: 1px solid var(--warm);
            border-radius: 100px;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--brown);
            margin-bottom: 32px;
            width: fit-content;
            animation: fadeInUp 0.8s ease both;
        }

        .hero-badge::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--brown-light);
        }

        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(52px, 5vw, 80px);
            font-weight: 600;
            line-height: 1.05;
            color: var(--espresso);
            margin-bottom: 28px;
            animation: fadeInUp 0.8s 0.1s ease both;
        }

        .hero-title em {
            font-style: italic;
            color: var(--brown);
        }

        .hero-desc {
            font-size: 16px;
            color: var(--gray-soft);
            line-height: 1.8;
            max-width: 400px;
            margin-bottom: 48px;
            animation: fadeInUp 0.8s 0.2s ease both;
        }

        .hero-ctas {
            display: flex;
            gap: 16px;
            animation: fadeInUp 0.8s 0.3s ease both;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 36px;
            background: var(--espresso);
            color: var(--white);
            border-radius: 100px;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0 8px 30px rgba(61,35,20,0.25);
        }
        .btn-primary:hover {
            background: var(--brown-dark);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(61,35,20,0.3);
        }
        .btn-primary svg { width: 18px; height: 18px; transition: transform 0.3s; }
        .btn-primary:hover svg { transform: translateX(4px); }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 36px;
            background: transparent;
            color: var(--espresso);
            border: 1.5px solid rgba(61,35,20,0.2);
            border-radius: 100px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-secondary:hover {
            border-color: var(--brown);
            color: var(--brown);
            background: var(--sand);
        }

        .hero-stats {
            display: flex;
            gap: 40px;
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid var(--warm);
            animation: fadeInUp 0.8s 0.4s ease both;
        }

        .stat-item h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 36px;
            font-weight: 600;
            color: var(--espresso);
        }

        .stat-item p {
            font-size: 13px;
            color: var(--gray-soft);
            margin-top: 2px;
        }

        /* Hero Right / Image */
        .hero-right {
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(145deg, #f5ede3 0%, #ede0d0 50%, #e8d5bf 100%);
        }

        .hero-right::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(245,237,227,0.6) 0%, transparent 30%);
            z-index: 1;
            pointer-events: none;
        }

        .hero-img-clip {
            position: relative;
            width: 88%;
            max-width: 520px;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-img-main {
            width: 100%;
            height: auto;
            max-height: 78vh;
            object-fit: contain;
            object-position: center center;
            animation: scaleIn 1.2s ease both;
            display: block;
            filter: drop-shadow(0 32px 64px rgba(61,35,20,0.22));
        }

        .hero-float-card {
            position: absolute;
            bottom: 40px;
            left: 40px;
            background: var(--white);
            border-radius: 20px;
            padding: 20px 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
            width: 220px;
            animation: floatCard 3s ease-in-out infinite;
            z-index: 10;
        }

        .hero-float-card .tag {
            font-size: 11px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--brown-light);
            font-weight: 600;
            margin-bottom: 6px;
        }
        .hero-float-card .price {
            font-family: 'Cormorant Garamond', serif;
            font-size: 24px;
            font-weight: 600;
            color: var(--espresso);
        }
        .hero-float-card .label { font-size: 12px; color: var(--gray-soft); }

        .hero-scroll {
            position: absolute;
            bottom: 40px; left: 100px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gray-soft);
            animation: fadeInUp 1s 0.6s ease both;
        }
        .hero-scroll .line {
            width: 40px; height: 1px;
            background: var(--warm);
            position: relative;
            overflow: hidden;
        }
        .hero-scroll .line::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: var(--brown);
            animation: slideRight 2s ease-in-out infinite;
        }

        /* ══════════════════════════════
           FEATURES STRIP
        ══════════════════════════════ */
        .features-strip {
            background: var(--espresso);
            padding: 28px 60px;
        }
        .features-strip-inner {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 14px;
            color: rgba(255,255,255,0.85);
        }
        .feature-item svg {
            width: 28px; height: 28px;
            color: var(--brown-light);
            flex-shrink: 0;
        }
        .feature-item h4 {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.3px;
        }
        .feature-item p { font-size: 12px; color: rgba(255,255,255,0.5); margin-top: 2px; }
        .feature-divider { width: 1px; height: 40px; background: rgba(255,255,255,0.1); }

        /* ══════════════════════════════
           SECTION HEADER
        ══════════════════════════════ */
        .section-label {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--brown);
            margin-bottom: 16px;
        }
        .section-label::before {
            content: '';
            width: 30px; height: 1px;
            background: var(--brown-light);
        }

        .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(36px, 4vw, 54px);
            font-weight: 600;
            color: var(--espresso);
            line-height: 1.1;
        }

        .section-title em { font-style: italic; color: var(--brown); }

        /* ══════════════════════════════
           CATEGORIES
        ══════════════════════════════ */
        .categories-section {
            padding: 100px 60px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .categories-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 56px;
        }

        .view-all-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 500;
            color: var(--brown);
            text-decoration: none;
            border-bottom: 1px solid var(--brown-light);
            padding-bottom: 2px;
            transition: all 0.3s;
        }
        .view-all-link:hover { color: var(--brown-dark); gap: 10px; }
        .view-all-link svg { width: 14px; height: 14px; }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
        }

        .cat-card {
            text-decoration: none;
            group: true;
        }

        .cat-img-wrap {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 3/4;
            background: var(--sand);
            margin-bottom: 14px;
        }

        .cat-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        .cat-card:hover .cat-img-wrap img { transform: scale(1.08); }

        .cat-img-wrap::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(61,35,20,0.6) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s;
        }
        .cat-card:hover .cat-img-wrap::after { opacity: 1; }

        .cat-shop-btn {
            position: absolute;
            bottom: 16px; left: 50%; transform: translateX(-50%) translateY(8px);
            background: var(--white);
            color: var(--espresso);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 8px 18px;
            border-radius: 100px;
            white-space: nowrap;
            opacity: 0;
            transition: all 0.3s;
            z-index: 2;
        }
        .cat-card:hover .cat-shop-btn {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .cat-name {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.5px;
            color: var(--espresso);
            text-align: center;
            text-decoration: none;
        }
        .cat-count {
            font-size: 12px;
            color: var(--gray-soft);
            text-align: center;
            margin-top: 2px;
        }

        /* ══════════════════════════════
           FEATURED PRODUCTS
        ══════════════════════════════ */
        .products-section {
            padding: 100px 60px;
            background: var(--white);
        }
        .products-inner { max-width: 1400px; margin: 0 auto; }

        .products-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 56px;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 32px;
        }

        .product-card {
            cursor: pointer;
            text-decoration: none;
        }

        .product-img-wrap {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: var(--sand);
            aspect-ratio: 3/4;
            margin-bottom: 18px;
        }

        .product-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            mix-blend-mode: multiply;
        }
        .product-card:hover .product-img-wrap img { transform: scale(1.06); }

        .product-badge {
            position: absolute;
            top: 16px; left: 16px;
            padding: 5px 12px;
            border-radius: 100px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .badge-sale { background: var(--brown-dark); color: #fff; }
        .badge-new { background: var(--espresso); color: #fff; }

        .product-actions {
            position: absolute;
            top: 16px; right: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            opacity: 0;
            transform: translateX(10px);
            transition: all 0.3s;
        }
        .product-card:hover .product-actions { opacity: 1; transform: translateX(0); }

        .action-btn {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--white);
            display: flex; align-items: center; justify-content: center;
            color: var(--espresso);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: all 0.2s;
            text-decoration: none;
        }
        .action-btn:hover { background: var(--espresso); color: var(--white); }
        .action-btn svg { width: 16px; height: 16px; }

        .add-to-cart {
            position: absolute;
            bottom: 0; left: 0; right: 0;
            background: var(--espresso);
            color: var(--white);
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 14px;
            text-align: center;
            transform: translateY(100%);
            transition: transform 0.3s ease;
            text-decoration: none;
            display: block;
        }
        .product-card:hover .add-to-cart { transform: translateY(0); }

        .product-info { padding: 0 4px; }

        .product-cat {
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--brown-light);
            font-weight: 600;
            margin-bottom: 6px;
        }

        .product-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            font-weight: 600;
            color: var(--espresso);
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .product-rating {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 10px;
        }
        .stars { color: #d4a753; font-size: 13px; letter-spacing: 1px; }
        .rating-count { font-size: 12px; color: var(--gray-soft); }

        .product-price {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .price-current {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 600;
            color: var(--espresso);
        }
        .price-old {
            font-size: 14px;
            color: var(--gray-soft);
            text-decoration: line-through;
        }

        /* ══════════════════════════════
           ABOUT / BANNER
        ══════════════════════════════ */
        .about-section {
            padding: 120px 60px;
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 100px;
            align-items: center;
        }

        .about-img-wrap {
            position: relative;
        }

        .about-img-main {
            width: 100%;
            aspect-ratio: 4/5;
            object-fit: cover;
            border-radius: 24px;
        }

        .about-img-float {
            position: absolute;
            bottom: -30px; right: -30px;
            width: 55%;
            aspect-ratio: 1;
            object-fit: cover;
            border-radius: 20px;
            border: 6px solid var(--cream);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .about-years {
            position: absolute;
            top: 40px; left: -20px;
            background: var(--espresso);
            color: var(--white);
            border-radius: 16px;
            padding: 20px 24px;
            text-align: center;
        }
        .about-years .num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 48px;
            font-weight: 600;
            line-height: 1;
        }
        .about-years .label {
            font-size: 12px;
            color: rgba(255,255,255,0.6);
            letter-spacing: 1px;
        }

        .about-content { padding-right: 20px; }
        .about-content p {
            font-size: 15px;
            color: var(--gray-soft);
            line-height: 1.9;
            margin-bottom: 20px;
        }

        .about-points {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 36px 0;
        }
        .about-point {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 14px;
            color: var(--espresso);
            font-weight: 500;
        }
        .about-point::before {
            content: '';
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--brown-light);
            flex-shrink: 0;
        }

        /* ══════════════════════════════
           TESTIMONIALS
        ══════════════════════════════ */
        .testimonials-section {
            padding: 120px 60px;
            background: var(--espresso);
            position: relative;
            overflow: hidden;
        }

        .testimonials-section::before {
            content: '"';
            position: absolute;
            top: -40px; left: 60px;
            font-family: 'Cormorant Garamond', serif;
            font-size: 400px;
            color: rgba(255,255,255,0.03);
            line-height: 1;
            pointer-events: none;
        }

        .testimonials-inner { max-width: 1400px; margin: 0 auto; }

        .testimonials-header { margin-bottom: 56px; }
        .testimonials-header .section-label { color: var(--brown-light); }
        .testimonials-header .section-title { color: var(--white); }

        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .testi-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 24px;
            padding: 36px;
            transition: all 0.3s;
        }
        .testi-card:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-4px);
        }

        .testi-stars {
            font-size: 16px;
            color: #d4a753;
            letter-spacing: 2px;
            margin-bottom: 20px;
        }

        .testi-text {
            font-family: 'Cormorant Garamond', serif;
            font-size: 20px;
            color: rgba(255,255,255,0.85);
            line-height: 1.6;
            font-style: italic;
            margin-bottom: 28px;
        }

        .testi-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .testi-avatar {
            width: 48px; height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(196,149,106,0.4);
        }
        .testi-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--white);
        }
        .testi-role { font-size: 12px; color: rgba(255,255,255,0.4); margin-top: 2px; }

        /* ══════════════════════════════
           CTA BANNER
        ══════════════════════════════ */
        .cta-section {
            padding: 120px 60px;
            background: var(--sand);
            text-align: center;
        }

        .cta-inner { max-width: 700px; margin: 0 auto; }

        .cta-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: clamp(42px, 5vw, 68px);
            font-weight: 600;
            color: var(--espresso);
            line-height: 1.1;
            margin-bottom: 20px;
        }
        .cta-title em { font-style: italic; color: var(--brown); }

        .cta-desc {
            font-size: 16px;
            color: var(--gray-soft);
            line-height: 1.7;
            margin-bottom: 44px;
        }

        .cta-btns { display: flex; gap: 16px; justify-content: center; }

        /* ══════════════════════════════
           FOOTER
        ══════════════════════════════ */
        .footer {
            background: var(--charcoal);
            color: rgba(255,255,255,0.5);
            padding: 80px 60px 40px;
        }

        .footer-inner {
            max-width: 1400px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
            padding-bottom: 60px;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .footer-brand .logo-text { color: #fff; font-size: 28px; }
        .footer-brand p {
            font-size: 14px;
            line-height: 1.8;
            margin: 20px 0 28px;
        }

        .footer-socials { display: flex; gap: 12px; }
        .social-btn {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            transition: all 0.3s;
        }
        .social-btn:hover {
            background: var(--brown);
            border-color: var(--brown);
            color: var(--white);
        }
        .social-btn svg { width: 16px; height: 16px; }

        .footer-col h4 {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.8);
            margin-bottom: 24px;
        }

        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 12px; }
        .footer-col ul a {
            font-size: 14px;
            color: rgba(255,255,255,0.4);
            text-decoration: none;
            transition: color 0.3s;
        }
        .footer-col ul a:hover { color: var(--brown-light); }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            margin-bottom: 14px;
        }
        .footer-contact-item svg { width: 16px; height: 16px; color: var(--brown-light); flex-shrink: 0; margin-top: 2px; }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
        }

        /* ══════════════════════════════
           MOBILE MENU
        ══════════════════════════════ */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 80px; left: 0; right: 0;
            background: rgba(255,255,255,0.98);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--warm);
            padding: 24px 24px 32px;
            z-index: 998;
            flex-direction: column;
            gap: 20px;
        }
        .mobile-menu.open { display: flex; }
        .mobile-menu a {
            font-size: 16px;
            font-weight: 500;
            color: var(--espresso);
            text-decoration: none;
            padding: 6px 0;
            border-bottom: 1px solid var(--warm);
        }
        .mobile-menu-btns {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 8px;
        }

        /* ══════════════════════════════
           ANIMATIONS
        ══════════════════════════════ */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            from { opacity: 0; transform: scale(1.05); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes slideRight {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 1200px) {
            .categories-grid { grid-template-columns: repeat(3, 1fr); }
            .products-grid { grid-template-columns: repeat(2, 1fr); }
            .testimonials-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-top { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 900px) {
            .navbar { padding: 0 24px; }
            .nav-links, .nav-actions { display: none; }
            .hamburger { display: flex; }

            .hero { grid-template-columns: 1fr; min-height: auto; }
            .hero-left { padding: 120px 24px 60px; }
            .hero-right { height: 60vw; }
            .hero-scroll { left: 24px; }

            .features-strip { padding: 24px; }
            .features-strip-inner { flex-direction: column; align-items: flex-start; gap: 20px; }
            .feature-divider { display: none; }

            .categories-section, .products-inner { padding: 60px 24px; }
            .about-section { padding: 60px 24px; grid-template-columns: 1fr; gap: 60px; }
            .about-img-float { width: 45%; bottom: -20px; right: -10px; }
            .testimonials-section { padding: 60px 24px; }
            .testimonials-grid { grid-template-columns: 1fr; }
            .cta-section { padding: 80px 24px; }
            .footer { padding: 60px 24px 32px; }
            .footer-top { grid-template-columns: 1fr; gap: 36px; }
            .footer-bottom { flex-direction: column; gap: 16px; text-align: center; }
        }

        @media (max-width: 600px) {
            .categories-grid { grid-template-columns: repeat(2, 1fr); }
            .products-grid { grid-template-columns: 1fr; }
            .hero-stats { gap: 24px; }
            .hero-ctas { flex-direction: column; }
            .cta-btns { flex-direction: column; }
        }

        /* ══════════════════════════════
           CUSTOM PRODUCTS
        ══════════════════════════════ */
        .custom-section-wrap {
            background: linear-gradient(to bottom, var(--sand), var(--cream));
            padding: 120px 60px;
            position: relative;
            overflow: hidden;
        }

        .custom-section-wrap::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: radial-gradient(var(--brown-light) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.15;
            pointer-events: none;
        }

        .custom-section {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 100px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .custom-content {
            padding-right: 20px;
        }

        .custom-section-wrap .section-label {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--brown);
            font-weight: 600;
            margin-bottom: 12px;
            display: inline-block;
        }

        .custom-section-wrap .section-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 48px;
            font-weight: 500;
            color: var(--espresso);
            line-height: 1.2;
            margin-bottom: 24px;
        }

        .custom-description {
            font-size: 16px;
            color: var(--gray-soft);
            line-height: 1.8;
            margin-bottom: 36px;
        }

        .custom-features {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 40px;
        }

        .custom-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            background: rgba(255, 255, 255, 0.45);
            border: 1px solid rgba(196, 149, 106, 0.15);
            border-radius: 16px;
            padding: 24px;
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .custom-feature-item:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.85);
            border-color: var(--brown-light);
            box-shadow: 0 15px 35px rgba(61, 35, 20, 0.08);
        }

        .custom-feature-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--brown);
            line-height: 1;
            background: var(--cream);
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid rgba(196, 149, 106, 0.25);
            flex-shrink: 0;
            transition: all 0.3s;
        }

        .custom-feature-item:hover .custom-feature-num {
            background: var(--espresso);
            color: var(--white);
            border-color: var(--espresso);
        }

        .custom-feature-text h4 {
            font-size: 17px;
            font-weight: 600;
            color: var(--espresso);
            margin-bottom: 6px;
        }

        .custom-feature-text p {
            font-size: 14px;
            color: var(--gray-soft);
            line-height: 1.6;
        }

        .custom-img-wrap {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .custom-img-container {
            width: 85%;
            aspect-ratio: 3.5/5;
            border-radius: 200px 200px 24px 24px;
            overflow: hidden;
            border: 10px solid var(--white);
            box-shadow: 0 30px 70px rgba(61, 35, 20, 0.18);
            position: relative;
        }

        .custom-img-main {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .custom-img-container:hover .custom-img-main {
            transform: scale(1.05);
        }

        .custom-builder-card {
            position: absolute;
            bottom: 40px;
            left: -10px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(196, 149, 106, 0.2);
            border-radius: 20px;
            padding: 24px;
            width: 260px;
            box-shadow: 0 20px 45px rgba(0,0,0,0.12);
            z-index: 5;
            animation: floatCard 4s ease-in-out infinite;
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .builder-title {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--espresso);
            margin-bottom: 14px;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            padding-bottom: 8px;
        }

        .builder-group {
            margin-bottom: 12px;
        }

        .builder-label {
            font-size: 10px;
            text-transform: uppercase;
            color: var(--gray-soft);
            margin-bottom: 6px;
            display: block;
            font-weight: 500;
        }

        .builder-swatches {
            display: flex;
            gap: 8px;
        }

        .swatch {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid var(--white);
            box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .swatch:hover {
            transform: scale(1.2);
            box-shadow: 0 0 0 1px var(--brown);
        }

        .swatch.s-tan { background: #c4956a; }
        .swatch.s-espresso { background: #3d2314; }
        .swatch.s-cream { background: #f5ebd6; }
        .swatch.s-green { background: #5c6246; }

        .hardware-swatches {
            display: flex;
            gap: 8px;
        }

        .h-swatch {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid var(--white);
            box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .h-swatch:hover {
            transform: scale(1.2);
            box-shadow: 0 0 0 1px var(--brown);
        }

        .h-swatch.gold { background: linear-gradient(135deg, #ffe066, #d4af37, #aa8000); }
        .h-swatch.silver { background: linear-gradient(135deg, #e6e6e6, #b3b3b3, #808080); }

        .monogram-preview {
            background: var(--cream);
            border: 1px dashed var(--brown-light);
            border-radius: 8px;
            padding: 8px;
            text-align: center;
            font-family: 'Cormorant Garamond', serif;
            font-size: 16px;
            font-weight: 700;
            color: var(--brown);
            letter-spacing: 2px;
        }

        .custom-luxury-badge {
            position: absolute;
            top: -20px;
            right: -10px;
            background: var(--espresso);
            color: var(--white);
            border-radius: 50%;
            width: 90px;
            height: 90px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 5;
            box-shadow: 0 12px 30px rgba(61, 35, 20, 0.25);
            border: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            animation: rotateBadge 20s linear infinite;
        }

        .custom-luxury-badge .badge-text {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            line-height: 1.2;
        }

        @keyframes rotateBadge {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 900px) {
            .custom-section-wrap {
                padding: 80px 24px;
            }
            .custom-section {
                grid-template-columns: 1fr;
                gap: 60px;
            }
            .custom-content {
                padding-right: 0;
            }
            .custom-img-container {
                width: 100%;
                aspect-ratio: 4/5;
                border-radius: 120px 120px 24px 24px;
            }
            .custom-builder-card {
                left: 10px;
                bottom: 20px;
                width: 220px;
                padding: 16px;
            }
            .custom-luxury-badge {
                top: -10px;
                right: 10px;
                width: 80px;
                height: 80px;
            }
        }

        /* ══════════════════════════════
           CUSTOM CURSOR & SPARKLES
        ══════════════════════════════ */
        @media (pointer: fine) {
            body { cursor: none; }
            a, button { cursor: none; }
        }

        .cursor-dot {
            position: fixed;
            top: 0; left: 0;
            width: 12px; height: 12px;
            background: var(--brown-dark);
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 99999;
            transition: transform 0.08s ease, background 0.2s;
            mix-blend-mode: multiply;
        }

        .cursor-ring {
            position: fixed;
            top: 0; left: 0;
            width: 36px; height: 36px;
            border: 1.5px solid rgba(139, 90, 43, 0.5);
            border-radius: 50%;
            pointer-events: none;
            transform: translate(-50%, -50%);
            z-index: 99998;
            transition: transform 0.18s ease, width 0.2s, height 0.2s, border-color 0.2s;
        }

        .cursor-dot.hovered { transform: translate(-50%, -50%) scale(1.8); background: var(--brown); }
        .cursor-ring.hovered { width: 52px; height: 52px; border-color: var(--brown); }

        .sparkle {
            position: fixed;
            pointer-events: none;
            z-index: 99997;
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(1);
            animation: sparkleFade 0.65s ease-out forwards;
        }

        @keyframes sparkleFade {
            0%   { opacity: 1; transform: translate(-50%, -50%) scale(1); }
            100% { opacity: 0; transform: translate(calc(-50% + var(--dx)), calc(-50% + var(--dy))) scale(0); }
        }
    </style>
</head>
<body>

    <!-- ══════════ NAVBAR ══════════ -->
    <nav class="navbar transparent" id="navbar">
        <div class="navbar-inner">
            <a href="/" class="logo"><img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas Logo" class="logo-img"><span class="logo-text">CikalTas</span></a>

            <ul class="nav-links">
                <li><a href="#">Home</a></li>
                <li><a href="#shop">Shop</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#custom">Custom</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <div class="nav-actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/beranda') }}" class="btn-solid-nav">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-outline-nav">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-solid-nav">Daftar</a>
                        @endif
                    @endauth
                @endif
            </div>

            <div class="hamburger" id="hamburger" onclick="toggleMenu()">
                <span></span><span></span><span></span>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <a href="#">Home</a>
        <a href="#shop">Shop</a>
        <a href="#products">Products</a>
        <a href="#custom">Custom Order</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <div class="mobile-menu-btns">
            @auth
                <a href="{{ url('/beranda') }}" class="btn-solid-nav" style="text-align:center;">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-outline-nav" style="text-align:center;">Masuk</a>
                <a href="{{ route('register') }}" class="btn-solid-nav" style="text-align:center;">Daftar Sekarang</a>
            @endauth
        </div>
    </div>

    <!-- ══════════ HERO ══════════ -->
    <section class="hero">
        <div class="hero-left">
            <div class="hero-badge">✦ New Collection 2025</div>

            <h1 class="hero-title">
                Premium Bags<br>
                for <em>Modern</em><br>
                Lifestyle
            </h1>

            <p class="hero-desc">
                Crafted with the finest materials, each CikalTas piece is a testament to timeless elegance and sophisticated design for the contemporary woman.
            </p>

            <div class="hero-ctas">
                <a href="{{ route('login') }}" class="btn-primary">
                    Shop Now
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="#products" class="btn-secondary">
                    Explore Collection
                </a>
            </div>

            <div class="hero-stats">
                <div class="stat-item">
                    <h3>500+</h3>
                    <p>Premium Products</p>
                </div>
                <div class="stat-item">
                    <h3>10K+</h3>
                    <p>Happy Customers</p>
                </div>
                <div class="stat-item">
                    <h3>8+</h3>
                    <p>Years Crafting</p>
                </div>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-img-clip">
                @if($heroProduct && $heroProduct->image)
                    <img src="{{ asset($heroProduct->image) }}" 
                         alt="{{ $heroProduct->name }}" class="hero-img-main" style="mix-blend-mode: normal;">
                @else
                    <img src="{{ asset('gambar/hero_bag.png') }}" 
                         alt="Premium Handbag" class="hero-img-main" style="object-fit: contain; object-position: center;">
                @endif
            </div>

            <div class="hero-float-card">
                <div class="tag">Featured</div>
                @if($heroProduct)
                    <div class="price">Rp {{ number_format($heroProduct->price, 0, ',', '.') }}</div>
                    <div class="label">{{ $heroProduct->name }}</div>
                @else
                    <div class="price">Rp 890K</div>
                    <div class="label">Leather Tote Bag</div>
                @endif
            </div>
        </div>

        <div class="hero-scroll">
            <div class="line"></div>
            Scroll Down
        </div>
    </section>

    <!-- ══════════ FEATURES STRIP ══════════ -->
    <div class="features-strip">
        <div class="features-strip-inner">
            <div class="feature-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"></path></svg>
                <div>
                    <h4>Free Shipping</h4>
                    <p>All orders above Rp 500K</p>
                </div>
            </div>
            <div class="feature-divider"></div>
            <div class="feature-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"></path></svg>
                <div>
                    <h4>Money Back Guarantee</h4>
                    <p>30-day return policy</p>
                </div>
            </div>
            <div class="feature-divider"></div>
            <div class="feature-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"></path></svg>
                <div>
                    <h4>24/7 Online Support</h4>
                    <p>Always here to help you</p>
                </div>
            </div>
            <div class="feature-divider"></div>
            <div class="feature-item">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"></path></svg>
                <div>
                    <h4>Secure Payment</h4>
                    <p>100% protected transactions</p>
                </div>
            </div>
        </div>
    </div>



    <!-- ══════════ FEATURED PRODUCTS ══════════ -->
    <section id="products" class="products-section">
        <div class="products-inner">
            <div class="products-header reveal">
                <div>
                    <div class="section-label">Our Selection</div>
                    <h2 class="section-title">Featured <em>Products</em></h2>
                </div>
                <a href="{{ route('login') }}" class="view-all-link">
                    View All Products
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="products-grid">
                @forelse($featuredProducts as $product)
                <a href="{{ route('login') }}" class="product-card reveal">
                    <div class="product-img-wrap">
                        @if($loop->first)
                            <span class="product-badge badge-new">New</span>
                        @elseif($loop->index === 1)
                            <span class="product-badge badge-sale">Hot</span>
                        @endif
                        <div class="product-actions">
                            <span class="action-btn">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </span>
                            <span class="action-btn">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </span>
                        </div>
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--sand);">
                                <svg width="80" height="80" fill="none" stroke="#c4956a" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                            </div>
                        @endif
                        <span class="add-to-cart">+ Lihat Produk</span>
                    </div>
                    <div class="product-info">
                        <div class="product-cat">{{ $product->category ?? 'Tas' }}</div>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-count">Stok: {{ $product->stock }}</span>
                        </div>
                        <div class="product-price">
                            <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </a>
                @empty
                {{-- Fallback: tampilkan placeholder jika belum ada produk di DB --}}
                <a href="{{ route('login') }}" class="product-card reveal">
                    <div class="product-img-wrap">
                        <span class="product-badge badge-new">New</span>
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--sand);">
                            <svg width="80" height="80" fill="none" stroke="#c4956a" viewBox="0 0 24 24" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <span class="add-to-cart">+ Lihat Produk</span>
                    </div>
                    <div class="product-info">
                        <div class="product-cat">Handbag</div>
                        <div class="product-name">Produk Segera Hadir</div>
                        <div class="product-rating">
                            <span class="stars">★★★★★</span>
                        </div>
                        <div class="product-price">
                            <span class="price-current">—</span>
                        </div>
                    </div>
                </a>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ══════════ CUSTOM PRODUCTS ══════════ -->
    <section id="custom" class="custom-section-wrap">
        <div class="custom-section">
            <div class="custom-content reveal">
                <span class="section-label">Exclusive Service</span>
                <h2 class="section-title">Design Your <em>Own</em> Masterpiece</h2>
                <p class="custom-description">
                    We believe the finest bag is one that reflects its owner's true character. Through the <strong>CikalTas Bespoke</strong> service, we invite you to collaborate with us in crafting a completely personalized masterpiece, custom-made by our master artisans.
                </p>

                <div class="custom-features">
                    <div class="custom-feature-item">
                        <span class="custom-feature-num">01</span>
                        <div class="custom-feature-text">
                            <h4>Premium Leather Selection</h4>
                            <p>Select from our collection of premium genuine cowhide leather (Pebbled, Smooth Calfskin, or Saffiano) featuring exceptional durability and luxurious texture.</p>
                        </div>
                    </div>

                    <div class="custom-feature-item">
                        <span class="custom-feature-num">02</span>
                        <div class="custom-feature-text">
                            <h4>Color & Hardware Detailing</h4>
                            <p>Choose your bag's primary color palette and complement it with premium rust-resistant hardware in polished gold or minimalist brushed silver.</p>
                        </div>
                    </div>

                    <div class="custom-feature-item">
                        <span class="custom-feature-num">03</span>
                        <div class="custom-feature-text">
                            <h4>Custom Monogram Engraving</h4>
                            <p>Add a personal signature with your initials elegantly hot-stamped on the leather using classic gold or silver foil.</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('login') }}" class="btn-primary">
                    Start Custom Order
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="custom-img-wrap reveal">
                <div class="custom-img-container">
                    <img src="https://images.unsplash.com/photo-1590874103328-eac38a683ce7?q=80&w=900&auto=format&fit=crop" alt="Premium Custom Handbag" class="custom-img-main">
                </div>
                
                <!-- Floating Atelier Option Board -->
                <div class="custom-builder-card">
                    <div class="builder-title">Bespoke Customizer</div>
                    
                    <div class="builder-group">
                        <span class="builder-label">1. Leather Tone</span>
                        <div class="builder-swatches">
                            <span class="swatch s-tan" title="Calfskin Tan"></span>
                            <span class="swatch s-espresso" title="Espresso Brown"></span>
                            <span class="swatch s-cream" title="Saffiano Cream"></span>
                            <span class="swatch s-green" title="Forest Green"></span>
                        </div>
                    </div>
                    
                    <div class="builder-group">
                        <span class="builder-label">2. Hardware Metal</span>
                        <div class="builder-swatches">
                            <span class="h-swatch gold" title="Gold Plated"></span>
                            <span class="h-swatch silver" title="Silver Brush"></span>
                        </div>
                    </div>
                    
                    <div class="builder-group">
                        <span class="builder-label">3. Monogram Gold Emboss</span>
                        <div class="monogram-preview">C . T</div>
                    </div>
                </div>

                <div class="custom-luxury-badge">
                    <div class="badge-text">100%<br>GENUINE<br>LEATHER</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════ ABOUT ══════════ -->
    <section id="about">
        <div class="about-section">
            <div class="about-img-wrap reveal">
                <img src="https://images.unsplash.com/photo-1591561954557-26941169b49e?q=80&w=900&auto=format&fit=crop" 
                     alt="About CikalTas" class="about-img-main">
                <img src="https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?q=80&w=600&auto=format&fit=crop" 
                     alt="Craftsmanship" class="about-img-float">
                <div class="about-years">
                    <div class="num">8+</div>
                    <div class="label">Years of<br>Excellence</div>
                </div>
            </div>

            <div class="about-content reveal">
                <div class="section-label">Our Story</div>
                <h2 class="section-title">Crafting <em>Elegance</em><br>Since 2016</h2>

                <div class="about-points">
                    <div class="about-point">Premium materials sourced from trusted suppliers</div>
                    <div class="about-point">Handcrafted with precision and care</div>
                    <div class="about-point">Timeless designs that never go out of style</div>
                    <div class="about-point">Sustainable and ethical production</div>
                </div>

                <p>CikalTas was born from a passion for beautiful, functional bags. We believe every bag tells a story — of craftsmanship, quality, and the woman who carries it. Each piece in our collection is thoughtfully designed to blend timeless elegance with everyday practicality.</p>

                <br>

                <a href="{{ route('login') }}" class="btn-primary" style="width: fit-content; margin-top: 12px;">
                    Discover Our Story
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- ══════════ TESTIMONIALS ══════════ -->
    <section class="testimonials-section">
        <div class="testimonials-inner">
            <div class="testimonials-header reveal">
                <div class="section-label">What They Say</div>
                <h2 class="section-title" style="color:#fff;">Loved by <em>Thousands</em></h2>
            </div>

            <div class="testimonials-grid">
                <div class="testi-card reveal">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"The leather quality is absolutely phenomenal. I've owned many bags, but none compare to the craftsmanship of CikalTas. Worth every penny!"</p>
                    <div class="testi-user">
                        <img src="https://i.pravatar.cc/150?img=1" alt="Sarah" class="testi-avatar">
                        <div>
                            <div class="testi-name">Sarah Wijaya</div>
                            <div class="testi-role">Fashion Blogger, Jakarta</div>
                        </div>
                    </div>
                </div>

                <div class="testi-card reveal">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"I ordered the Elegant Leather Tote and it arrived beautifully packaged. The material is premium and the stitching is impeccable. 10/10!"</p>
                    <div class="testi-user">
                        <img src="https://i.pravatar.cc/150?img=5" alt="Rina" class="testi-avatar">
                        <div>
                            <div class="testi-name">Rina Kusuma</div>
                            <div class="testi-role">Business Executive, Surabaya</div>
                        </div>
                    </div>
                </div>

                <div class="testi-card reveal">
                    <div class="testi-stars">★★★★★</div>
                    <p class="testi-text">"Fast shipping, beautiful packaging, and the bag is even more stunning in person. CikalTas has earned a loyal customer for life!"</p>
                    <div class="testi-user">
                        <img src="https://i.pravatar.cc/150?img=9" alt="Dina" class="testi-avatar">
                        <div>
                            <div class="testi-name">Dina Rahmawati</div>
                            <div class="testi-role">Lifestyle Content Creator</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ══════════ CTA ══════════ -->
    <section class="cta-section">
        <div class="cta-inner reveal">
            <div class="section-label" style="justify-content:center;">Limited Time</div>
            <h2 class="cta-title">Ready to Find Your<br><em>Perfect Bag?</em></h2>
            <p class="cta-desc">
                Join over 10,000 satisfied customers and discover your next favorite bag. New arrivals every week.
            </p>
            <div class="cta-btns">
                <a href="{{ route('login') }}" class="btn-primary">
                    Shop Now
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
                <a href="{{ route('register') }}" class="btn-secondary">Create Free Account</a>
            </div>
        </div>
    </section>

    <!-- ══════════ FOOTER ══════════ -->
    <footer class="footer" id="contact">
        <div class="footer-inner">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="logo">
                        <img src="{{ asset('gambar/Logo.png') }}" alt="CikalTas Logo" style="height:44px; width:auto; object-fit:contain;" />
                        <span class="logo-text">CikalTas</span>
                    </div>
                    <p>Premium bags crafted for the modern woman. Elegance, quality, and functionality — all in one.</p>
                    <div class="footer-socials">
                        <a href="#" class="social-btn">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="social-btn">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="social-btn">
                            <svg fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#categories">Categories</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#about">About Us</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Customer Care</h4>
                    <ul>
                        <li><a href="#">Shipping Policy</a></li>
                        <li><a href="#">Return & Exchange</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Contact</h4>
                    <div class="footer-contact-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Gumelar, Banyumas
                    </div>
                    <div class="footer-contact-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        +62 812 3456 7890
                    </div>
                    <div class="footer-contact-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        cikaltas@gmail.com
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} CikalTas. All rights reserved. Crafted with ♥</p>
                <p>Premium Bags — Modern Lifestyle</p>
            </div>
        </div>
    </footer>

    <script>
        // ── Navbar scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.remove('transparent');
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.add('transparent');
                navbar.classList.remove('scrolled');
            }
        });

        // ── Mobile menu
        function toggleMenu() {
            document.getElementById('mobileMenu').classList.toggle('open');
        }

        // ── Scroll reveal
        const revealEls = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, i * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        revealEls.forEach(el => observer.observe(el));

        // ── Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', e => {
                const target = document.querySelector(a.getAttribute('href'));
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    document.getElementById('mobileMenu').classList.remove('open');
                }
            });
        });
    // -- Custom cursor + sparkle trail (desktop only)
        if (window.matchMedia("(pointer: fine)").matches) {
            const dot  = document.createElement("div");
            const ring = document.createElement("div");
            dot.className  = "cursor-dot";
            ring.className = "cursor-ring";
            document.body.appendChild(dot);
            document.body.appendChild(ring);
            let mx = 0, my = 0, rx = 0, ry = 0;
            document.addEventListener("mousemove", function(e) {
                mx = e.clientX; my = e.clientY;
                dot.style.left = mx + "px"; dot.style.top = my + "px";
                spawnSparkle(mx, my);
            });
            function loopRing() {
                rx += (mx - rx) * 0.12; ry += (my - ry) * 0.12;
                ring.style.left = rx + "px"; ring.style.top = ry + "px";
                requestAnimationFrame(loopRing);
            }
            loopRing();
            document.querySelectorAll("a, button").forEach(function(el) {
                el.addEventListener("mouseenter", function() { dot.classList.add("hovered"); ring.classList.add("hovered"); });
                el.addEventListener("mouseleave", function() { dot.classList.remove("hovered"); ring.classList.remove("hovered"); });
            });
            var sparkleColors = ["#d4a753","#c8945a","#e8c97a","#b87333","#f0d9a0","#c4956a","#a0714f","#e2b96e"];
            var sparkleShapes = ["\u2726","\u2727","\u273a","\u2729","\u2737","\u2605","\u00b7","\u2055"];
            var lastSpawn = 0;
            function spawnSparkle(x, y) {
                var now = Date.now();
                if (now - lastSpawn < 40) return;
                lastSpawn = now;
                var el    = document.createElement("div");
                var size  = 8 + Math.random() * 14;
                var dx    = ((Math.random() - 0.5) * 60) + "px";
                var dy    = ((Math.random() - 0.5) * 60) + "px";
                var color = sparkleColors[Math.floor(Math.random() * sparkleColors.length)];
                var shape = sparkleShapes[Math.floor(Math.random() * sparkleShapes.length)];
                var dur   = 0.5 + Math.random() * 0.35;
                el.className = "sparkle";
                el.textContent = shape;
                el.style.left = x + "px";
                el.style.top  = y + "px";
                el.style.fontSize = size + "px";
                el.style.color = color;
                el.style.setProperty("--dx", dx);
                el.style.setProperty("--dy", dy);
                el.style.animationDuration = dur + "s";
                el.style.lineHeight = "1";
                document.body.appendChild(el);
                el.addEventListener("animationend", function() { el.remove(); });
            }
        }
    </script>
</body>
</html>
