@extends("Layout")

@section("title", "Contact")

@section("content")
    <div class="card">
        <h1>Contact Us</h1>
        <p style="color:#555;">We would love to hear from you.</p>

        <form method="POST" action="#">
            @csrf

            <label>Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Message</label>
            <textarea name="message" rows="5" required></textarea>

            <button type="submit" class="btn" style="margin-top:15px;">
                Send Message
            </button>
        </form>
    </div>
@endsection