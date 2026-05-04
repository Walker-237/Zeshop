@extends("Layout")

@section("title", "About")

@section("content")
    <div class="about-hero">
        <div class="stars"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        
        <div class="hero-content-wrapper">
            <h1>About Us</h1>
            <p class="hero-subtitle">
                Building the future, one line of code at a time
            </p>
        </div>
    </div>

    <section class="about-story">
        <div class="story-content">
            <div class="story-text">
                <h2>Our Story</h2>
                <p>
                    MyWebsite was founded with the goal of building clean, efficient, and scalable web applications 
                    that empower businesses to thrive in the digital age. We believe technology should be accessible, 
                    intuitive, and transformative.
                </p>
                <p>
                    From startups to established enterprises, we've helped countless organizations realize their 
                    digital potential through innovative solutions and unwavering commitment to excellence.
                </p>
            </div>
            <div class="story-image">
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&auto=format&fit=crop" alt="Team collaboration">
            </div>
        </div>
    </section>

    <section class="mission-vision">
        <div class="mv-grid">
            <div class="mv-card">
                <div class="mv-icon">🎯</div>
                <h3>Our Mission</h3>
                <p>
                    To deliver quality digital experiences that drive real business value. 
                    We craft solutions that are not just functional, but exceptional—combining 
                    cutting-edge technology with user-centered design.
                </p>
            </div>

            <div class="mv-card">
                <div class="mv-icon">🚀</div>
                <h3>Our Vision</h3>
                <p>
                    To become a trusted technology partner for businesses worldwide. 
                    We envision a future where every organization, regardless of size, 
                    has access to enterprise-grade digital solutions.
                </p>
            </div>
        </div>
    </section>

    <section class="values">
        <h2>Our Values</h2>
        <div class="values-grid">
            <div class="value-item">
                <div class="value-icon">💡</div>
                <h4>Innovation</h4>
                <p>Constantly pushing boundaries and exploring new possibilities</p>
            </div>
            <div class="value-item">
                <div class="value-icon">🤝</div>
                <h4>Collaboration</h4>
                <p>Working together to achieve extraordinary results</p>
            </div>
            <div class="value-item">
                <div class="value-icon">⚡</div>
                <h4>Excellence</h4>
                <p>Never settling for good enough—always striving for great</p>
            </div>
            <div class="value-item">
                <div class="value-icon">🎨</div>
                <h4>Creativity</h4>
                <p>Thinking outside the box to solve complex challenges</p>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="stars"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        
        <div class="team-content-wrapper">
            <h2>Meet The Team</h2>
            <div class="team-grid">
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&auto=format&fit=crop" alt="Team member">
                    <h4>Alex Johnson</h4>
                    <p class="role">Founder & CEO</p>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&auto=format&fit=crop" alt="Team member">
                    <h4>Sarah Chen</h4>
                    <p class="role">Lead Designer</p>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&auto=format&fit=crop" alt="Team member">
                    <h4>Mike Rodriguez</h4>
                    <p class="role">Tech Lead</p>
                </div>
                <div class="team-member">
                    <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&auto=format&fit=crop" alt="Team member">
                    <h4>Emma Taylor</h4>
                    <p class="role">Product Manager</p>
                </div>
            </div>
        </div>
    </section>

    <style>
        .about-hero {
            position: relative;
            text-align: center;
            padding: 0px 20px;
            background: linear-gradient(to bottom, #0b0b2b, #1b2735 70%, #090a0f);
            color: white;
            border-radius: 12px;
            margin-bottom: 80px;
            overflow: hidden;
            min-height: 400px;
        }

        .hero-content-wrapper {
            position: relative;
            height: 100%;
            width: 100%;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .about-hero h1 {
            font-size: 52px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-subtitle {
            font-size: 24px;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Starry background styles */
        .stars {
            width: 1px;
            height: 1px;
            position: absolute;
            background: white;
            box-shadow: 2vw 5vh 2px white, 10vw 8vh 2px white, 15vw 15vh 1px white,
                22vw 22vh 1px white, 28vw 12vh 2px white, 32vw 32vh 1px white,
                38vw 18vh 2px white, 42vw 35vh 1px white, 48vw 25vh 2px white,
                53vw 42vh 1px white, 58vw 15vh 2px white, 63vw 38vh 1px white,
                68vw 28vh 2px white, 73vw 45vh 1px white, 78vw 32vh 2px white,
                83vw 48vh 1px white, 88vw 20vh 2px white, 93vw 52vh 1px white,
                98vw 35vh 2px white, 5vw 60vh 1px white, 12vw 65vh 2px white,
                18vw 72vh 1px white, 25vw 78vh 2px white, 30vw 85vh 1px white,
                35vw 68vh 2px white, 40vw 82vh 1px white, 45vw 92vh 2px white,
                50vw 75vh 1px white, 55vw 88vh 2px white, 60vw 95vh 1px white,
                65vw 72vh 2px white, 70vw 85vh 1px white, 75vw 78vh 2px white,
                80vw 92vh 1px white, 85vw 82vh 2px white, 90vw 88vh 1px white,
                95vw 75vh 2px white;
            animation: twinkle 8s infinite linear;
            z-index: 1;
        }

        .stars::after {
            content: "";
            position: absolute;
            width: 1px;
            height: 1px;
            background: white;
            box-shadow: 8vw 12vh 2px white, 16vw 18vh 1px white, 24vw 25vh 2px white,
                33vw 15vh 1px white, 41vw 28vh 2px white, 49vw 35vh 1px white,
                57vw 22vh 2px white, 65vw 42vh 1px white, 73vw 28vh 2px white,
                81vw 48vh 1px white, 89vw 32vh 2px white, 97vw 45vh 1px white,
                3vw 68vh 2px white, 11vw 75vh 1px white, 19vw 82vh 2px white,
                27vw 88vh 1px white, 35vw 72vh 2px white, 43vw 85vh 1px white,
                51vw 92vh 2px white, 59vw 78vh 1px white;
            animation: twinkle 6s infinite linear reverse;
        }

        .shooting-star {
            position: absolute;
            width: 100px;
            height: 2px;
            background: linear-gradient(90deg, white, transparent);
            animation: shoot 3s infinite ease-in;
            z-index: 1;
        }

        .shooting-star:nth-child(2) {
            top: 20%;
            left: -100px;
            animation-delay: 0s;
        }

        .shooting-star:nth-child(3) {
            top: 35%;
            left: -100px;
            animation-delay: 1s;
        }

        .shooting-star:nth-child(4) {
            top: 50%;
            left: -100px;
            animation-delay: 2s;
        }

        .shooting-star:nth-child(5) {
            top: 65%;
            left: -100px;
            animation-delay: 0.5s;
        }

        .shooting-star:nth-child(6) {
            top: 80%;
            left: -100px;
            animation-delay: 1.5s;
        }

        @keyframes twinkle {
            0%, 100% {
                opacity: 0.8;
            }
            50% {
                opacity: 0.4;
            }
        }

        @keyframes shoot {
            0% {
                transform: translateX(0) translateY(0) rotate(25deg);
                opacity: 1;
            }
            100% {
                transform: translateX(120vw) translateY(50vh) rotate(25deg);
                opacity: 0;
            }
        }

        .about-story {
            margin-bottom: 100px;
            padding: 0 40px;
        }

        .story-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .story-text h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 30px;
        }

        .story-text p {
            color: #555;
            line-height: 1.8;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .story-image img {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }

        .mission-vision {
            padding: 80px 40px;
            background: linear-gradient(to bottom, #f8f9fa, #ffffff);
            margin-bottom: 80px;
        }

        .mv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .mv-card {
            background: white;
            padding: 50px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }

        .mv-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        }

        .mv-icon {
            font-size: 56px;
            margin-bottom: 24px;
        }

        .mv-card h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }

        .mv-card p {
            color: #666;
            line-height: 1.8;
            font-size: 16px;
        }

        .values {
            padding: 0 40px 80px;
            text-align: center;
        }

        .values h2 {
            font-size: 36px;
            color: #333;
            margin-bottom: 60px;
        }

        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .value-item {
            padding: 30px;
            background: #f8f9fa;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .value-item:hover {
            background: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }

        .value-icon {
            font-size: 48px;
            margin-bottom: 20px;
        }

        .value-item h4 {
            font-size: 22px;
            color: #333;
            margin-bottom: 12px;
        }

        .value-item p {
            color: #666;
            line-height: 1.6;
        }

        .team-section {
            position: relative;
            padding: 80px 40px;
            background: linear-gradient(to bottom, #0b0b2b, #1b2735 70%, #090a0f);
            color: white;
            border-radius: 12px;
            overflow: hidden;
            min-height: 600px;
        }

        .team-content-wrapper {
            position: relative;
            z-index: 2;
        }

        .team-section h2 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 60px;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .team-member {
            text-align: center;
            transition: transform 0.3s ease;
        }

        .team-member:hover {
            transform: translateY(-10px);
        }

        .team-member img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 5px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }

        .team-member:hover img {
            border-color: white;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .team-member h4 {
            font-size: 22px;
            margin-bottom: 8px;
        }

        .role {
            opacity: 0.9;
            font-size: 16px;
        }

        @media (max-width: 968px) {
            .about-hero h1 {
                font-size: 36px;
            }

            .hero-subtitle {
                font-size: 18px;
            }

            .story-content {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 0 20px;
            }

            .about-story,
            .mission-vision,
            .values,
            .team-section {
                padding: 60px 20px;
            }

            .mv-grid {
                grid-template-columns: 1fr;
            }

            .values-grid,
            .team-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 30px;
            }
        }
    </style>
@endsection