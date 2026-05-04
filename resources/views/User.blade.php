@extends("Layout")

@section("title", "Users")

@section("content")
    <div class="hero">
        <div class="stars"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        <div class="shooting-star"></div>
        
        <div class="hero-content">
            <h1>List of Users</h1>
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user["id"]}}</td>
                        <td>{{$user["name"]}}</td>
                        <td>{{$user["email"]}}</td>
                        <td>{{$user["role"]}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        .hero {
            position: relative;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            padding-left: 40%;
            background: linear-gradient(to bottom, #0b0b2b, #1b2735 70%, #090a0f);
            color: white;
            border-radius: 12px;
            margin-bottom: 80px;
            overflow: hidden;
            min-height: 600px;
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

        table{
            border: 1px solid black;
        }

        /* Hero content - needs higher z-index to appear above stars */
        .hero-content,
        .hero-image {
            position: relative;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .tagline {
            font-size: 20px;
            opacity: 0.95;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .cta-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 32px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-primary {
            background: white;
            color: #667eea;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
        }
    </style>
@endsection