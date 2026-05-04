<nav class="navbar">
    <div class="nav-container">
        <a href="{{ url('/home') }}" class="logo">MyWebsite</a>
        <ul class="nav-menu">
            <li><a href="{{ url('/home') }}" class="nav-link">Home</a></li>
            <li><a href="{{ url('/about') }}" class="nav-link">About</a></li>
            <li><a href="{{ url('/contact') }}" class="nav-link">Contact</a></li>
            <li><a href="{{ url('/users') }}" class="nav-link">Users</a></li>
        </ul>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<style>
    .navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 0;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 40px;
    }

    .logo {
        color: white;
        font-size: 24px;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.3s ease;
    }

    .logo:hover {
        transform: scale(1.05);
    }

    .nav-menu {
        display: flex;
        list-style: none;
        gap: 30px;
        margin: 0;
        padding: 0;
    }

    .nav-link {
        color: white;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
        padding: 8px 16px;
        border-radius: 6px;
        transition: all 0.3s ease;
        position: relative;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: white;
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 60%;
    }

    /* Mobile hamburger menu */
    .hamburger {
        display: none;
        flex-direction: column;
        cursor: pointer;
        gap: 4px;
    }

    .hamburger span {
        width: 25px;
        height: 3px;
        background: white;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    @media (max-width: 768px) {
        .nav-container {
            padding: 15px 20px;
        }

        .hamburger {
            display: flex;
        }

        .nav-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            flex-direction: column;
            gap: 0;
            padding: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .nav-menu.active {
            max-height: 300px;
        }

        .nav-link {
            padding: 12px 16px;
            display: block;
        }
    }
</style>

<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const hamburger = document.querySelector('.hamburger');
        const navMenu = document.querySelector('.nav-menu');

        if (hamburger) {
            hamburger.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                
                // Animate hamburger to X
                const spans = hamburger.querySelectorAll('span');
                if (navMenu.classList.contains('active')) {
                    spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                    spans[1].style.opacity = '0';
                    spans[2].style.transform = 'rotate(-45deg) translate(7px, -6px)';
                } else {
                    spans[0].style.transform = 'none';
                    spans[1].style.opacity = '1';
                    spans[2].style.transform = 'none';
                }
            });
        }
    });
</script>