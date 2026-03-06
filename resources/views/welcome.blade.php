<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Gestión de Maquinaria Textil</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0a0f1c;
            color: #e2e8f0;
            line-height: 1.6;
        }

        /* Color System - Versión Azul Profesional */
        :root {
            --primary: #0ea5e9;        /* Azul eléctrico principal */
            --primary-dark: #0284c7;     /* Azul más oscuro */
            --primary-light: #38bdf8;     /* Azul claro */
            --secondary: #2563eb;         /* Azul secundario */
            --success: #10b981;           /* Verde menta - Disponible (se mantiene) */
            --warning: #f59e0b;           /* Ámbar - Advertencias/Tránsito */
            --danger: #ef4444;
            --dark-bg: #0a0f1c;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
        }

        /* Typography */
        h1, h2, h3 {
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        h1 {
            font-size: clamp(2.5rem, 5vw, 3.5rem);
            line-height: 1.2;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        h2 {
            font-size: 2.25rem;
            margin-bottom: 2rem;
            text-align: center;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        /* Header */
        .navbar {
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(14, 165, 233, 0.2);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(45deg);
        }

        .logo-icon i {
            transform: rotate(-45deg);
            color: #0a0f1c;
            font-size: 1.5rem;
        }

        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: var(--text-dim);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            font-size: 0.95rem;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-links .btn-outline {
            border: 1px solid var(--primary);
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            color: var(--primary);
        }

        .nav-links .btn-outline:hover {
            background: var(--primary);
            color: #0a0f1c;
        }

        /* Hero Section */
        .hero {
            padding: 8rem 2rem 6rem;
            background: radial-gradient(circle at 70% 50%, rgba(14, 165, 233, 0.15) 0%, transparent 50%),
                        radial-gradient(circle at 30% 30%, rgba(37, 99, 235, 0.1) 0%, transparent 50%),
                        linear-gradient(135deg, #0a0f1c 0%, #111827 100%);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><path d="M20 20 L40 20 L40 40 L20 40 Z" stroke="rgba(14,165,233,0.1)" fill="none" stroke-width="1"/><path d="M25 25 L35 25 L35 35 L25 35 Z" stroke="rgba(37,99,235,0.1)" fill="none" stroke-width="1"/></svg>');
            opacity: 0.3;
            pointer-events: none;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 100px;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 2rem;
            border: 1px solid rgba(14, 165, 233, 0.3);
        }

        .hero p {
            font-size: 1.25rem;
            color: var(--text-dim);
            margin: 2rem 0;
            max-width: 600px;
        }

        .hero-stats {
            display: flex;
            gap: 3rem;
            margin-top: 3rem;
        }

        .stat-item {
            text-align: left;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: var(--primary);
            display: block;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--text-dim);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: var(--primary);
            color: #0a0f1c;
            font-weight: 600;
            padding: 0.875rem 2rem;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
            margin-left: 1rem;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: #0a0f1c;
        }

        /* Sections */
        .section {
            padding: 5rem 2rem;
            position: relative;
        }

        .section-alt {
            background: #111827;
        }

        .section-header {
            text-align: center;
            max-width: 600px;
            margin: 0 auto 4rem;
        }

        .section-header h2 {
            margin-bottom: 1rem;
        }

        .section-header p {
            color: var(--text-dim);
            font-size: 1.125rem;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            max-width: 1280px;
            margin: 0 auto;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 2rem;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(14, 165, 233, 0.2);
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            width: 56px;
            height: 56px;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .card-icon i {
            font-size: 1.75rem;
            color: var(--primary);
        }

        .card h3 {
            font-size: 1.25rem;
            margin-bottom: 0.75rem;
            color: var(--text-light);
        }

        .card p {
            color: var(--text-dim);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .card-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
            margin-top: 1rem;
        }

        /* Estados del sistema */
        .states-container {
            max-width: 900px;
            margin: 3rem auto 0;
        }

        .state-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1rem;
            background: rgba(0,0,0,0.2);
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .state-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .state-dot.transit { background: var(--warning); box-shadow: 0 0 10px var(--warning); }
        .state-dot.available { background: var(--success); box-shadow: 0 0 10px var(--success); }
        .state-dot.reserved { background: var(--primary); box-shadow: 0 0 10px var(--primary); }
        .state-dot.sold { background: var(--text-dim); box-shadow: 0 0 10px var(--text-dim); }

        /* Timeline */
        .timeline {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin: 3rem 0;
        }

        .timeline-step {
            text-align: center;
            position: relative;
        }

        .timeline-step:not(:last-child)::after {
            content: '→';
            position: absolute;
            right: -10px;
            top: 30px;
            color: var(--primary);
            font-size: 1.5rem;
        }

        .timeline-icon {
            width: 60px;
            height: 60px;
            background: var(--card-bg);
            border: 2px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .timeline-icon i {
            font-size: 1.5rem;
            color: var(--primary);
        }

        /* Perfiles Grid */
        .profiles-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .profile-card {
            background: rgba(14, 165, 233, 0.05);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s;
        }

        .profile-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .profile-card i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .profile-card h4 {
            font-size: 1rem;
            margin-bottom: 0.5rem;
            color: var(--text-light);
        }

        .profile-card p {
            font-size: 0.85rem;
            color: var(--text-dim);
        }

        /* Footer */
        .footer {
            background: #0a0f1c;
            border-top: 1px solid #1f2937;
            padding: 3rem 2rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1280px;
            margin: 0 auto;
        }

        .footer-logo {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin: 2rem 0;
        }

        .footer-links a {
            color: var(--text-dim);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-copyright {
            color: #4b5563;
            font-size: 0.875rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .timeline {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .timeline-step:not(:last-child)::after {
                content: '↓';
                right: auto;
                bottom: -20px;
                top: auto;
                left: 50%;
                transform: translateX(-50%);
            }

            .profiles-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="logo-wrapper">
            <div class="logo-icon">
                <i class="fas fa-cog"></i>
            </div>
            <span class="logo-text">GALGA</span>
        </div>
        <div class="nav-links">
            <a href="#inicio">Inicio</a>
            <a href="#modulos">Módulos</a>
            <a href="#flujo">Flujo Comercial</a>
            <a href="#perfiles">Perfiles</a>
            <a href="#contacto" class="btn-outline">Contactar</a>
        </div>
    </div>
</nav>

<section class="hero" id="inicio">
    <div class="hero-content container">
        <span class="hero-badge">
            <i class="fas fa-industry"></i> Especializado en Maquinaria Textil
        </span>
        <h1>Control Total del Ciclo de Vida de tu Maquinaria</h1>
        <p>
            Desde la orden de compra en fábrica hasta la entrega al cliente final. 
            Centraliza importaciones, inventario y ventas en una única plataforma 
            con trazabilidad en tiempo real.
        </p>
        <div>
            <a href="/login" class="btn">
                <i class="fas fa-rocket"></i>
                Comenzar ahora
            </a>
            <a href="#" class="btn btn-outline">
                <i class="fas fa-play"></i>
                Ver demo
            </a>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number">3</span>
                <span class="stat-label">Módulos Integrados</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">5</span>
                <span class="stat-label">Perfiles Especializados</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">100%</span>
                <span class="stat-label">Trazabilidad</span>
            </div>
        </div>
    </div>
</section>

<section class="section" id="modulos">
    <div class="container">
        <div class="section-header">
            <h2>Arquitectura Modular</h2>
            <p>Tres pilares fundamentales para una gestión integral de tu operación textil</p>
        </div>

        <div class="cards-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-ship"></i>
                </div>
                <h3>Compras e Importaciones</h3>
                <p>
                    Registro de órdenes a fábrica, gestión de facturas de compra, 
                    seguimiento de máquinas en tránsito y control de pedidos pendientes.
                </p>
                <span class="card-tag">
                    <i class="fas fa-clock"></i> Tiempo real
                </span>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-warehouse"></i>
                </div>
                <h3>Inventario Inteligente</h3>
                <p>
                    Consulta automática de disponibilidad con identificación instantánea 
                    del estado: inventario, tránsito, pendiente o vendida.
                </p>
                <span class="card-tag">
                    <i class="fas fa-microchip"></i> IA integrada
                </span>
            </div>

            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3>Ventas y Facturación</h3>
                <p>
                    Gestión completa de anticipos, reservas, despacho y facturación 
                    final con trazabilidad 360° de cada máquina.
                </p>
                <span class="card-tag">
                    <i class="fas fa-check-circle"></i> Automatizado
                </span>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <h2>Estados en Tiempo Real</h2>
            <p>Visualización instantánea del ciclo de vida de cada máquina</p>
        </div>

        <div class="states-container">
            <div class="state-item">
                <div class="state-dot transit"></div>
                <div>
                    <strong>En Tránsito / Por Fabricar</strong>
                    <p style="margin:0; font-size:0.9rem;">Máquina solicitada a fábrica. Llegada estimada programada.</p>
                </div>
            </div>
            <div class="state-item">
                <div class="state-dot available"></div>
                <div>
                    <strong>En Inventario - Disponible</strong>
                    <p style="margin:0; font-size:0.9rem;">Máquina física en bodega. Lista para venta inmediata.</p>
                </div>
            </div>
            <div class="state-item">
                <div class="state-dot reserved"></div>
                <div>
                    <strong>Reservada (con Anticipo)</strong>
                    <p style="margin:0; font-size:0.9rem;">Máquina comprometida con cliente. Bloqueada en sistema.</p>
                </div>
            </div>
            <div class="state-item">
                <div class="state-dot sold"></div>
                <div>
                    <strong>Vendida / Despachada</strong>
                    <p style="margin:0; font-size:0.9rem;">Ciclo completado. Factura emitida y máquina entregada.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" id="flujo">
    <div class="container">
        <div class="section-header">
            <h2>Flujo Comercial Automatizado</h2>
            <p>Desde la consulta del vendedor hasta la entrega final</p>
        </div>

        <div class="timeline">
            <div class="timeline-step">
                <div class="timeline-icon">
                    <i class="fas fa-search"></i>
                </div>
                <h4>Consulta</h4>
                <p style="color: var(--text-dim); font-size:0.9rem;">Vendedor verifica disponibilidad</p>
            </div>
            <div class="timeline-step">
                <div class="timeline-icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <h4>Anticipo</h4>
                <p style="color: var(--text-dim); font-size:0.9rem;">Cliente confirma reserva</p>
            </div>
            <div class="timeline-step">
                <div class="timeline-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h4>Despacho</h4>
                <p style="color: var(--text-dim); font-size:0.9rem;">Gestión de envío</p>
            </div>
            <div class="timeline-step">
                <div class="timeline-icon">
                    <i class="fas fa-file-invoice"></i>
                </div>
                <h4>Facturación</h4>
                <p style="color: var(--text-dim); font-size:0.9rem;">Cierre del ciclo</p>
            </div>
        </div>
    </div>
</section>

<section class="section section-alt" id="perfiles">
    <div class="container">
        <div class="section-header">
            <h2>Perfiles Especializados</h2>
            <p>Cada rol con las herramientas que necesita</p>
        </div>

        <div class="profiles-grid">
            <div class="profile-card">
                <i class="fas fa-user-tie"></i>
                <h4>Vendedores</h4>
                <p>Consulta de inventario y estado comercial</p>
            </div>
            <div class="profile-card">
                <i class="fas fa-coins"></i>
                <h4>Cartera</h4>
                <p>Control de anticipos y pagos</p>
            </div>
            <div class="profile-card">
                <i class="fas fa-globe"></i>
                <h4>Importaciones</h4>
                <p>Gestión de órdenes y tránsito</p>
            </div>
            <div class="profile-card">
                <i class="fas fa-boxes"></i>
                <h4>Despachos</h4>
                <p>Coordinación de envíos</p>
            </div>
            <div class="profile-card">
                <i class="fas fa-calculator"></i>
                <h4>Facturación</h4>
                <p>Emisión y cierre contable</p>
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-content">
        <div class="footer-logo">GALGA</div>
        <p style="color: #6b7280; max-width: 600px; margin: 0 auto;">
            Sistema Integral de Gestión de Maquinaria Textil. 
            Trazabilidad completa desde la compra hasta la entrega final.
        </p>
        <div class="footer-links">
            <a href="#">Términos</a>
            <a href="#">Privacidad</a>
            <a href="#">Soporte</a>
            <a href="#">Contacto</a>
        </div>
        <div class="footer-copyright">
            © 2024 GALGA · Versión 2.0 · Todos los derechos reservados
        </div>
    </div>
</footer>

</body>
</html>