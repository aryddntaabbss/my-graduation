<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event?->title ?? 'Wedding Invitation' }} - {{ $guest->name }}</title>
    <style>
        :root {
            --bg: #f4eee2;
            --ink: #2b231c;
            --accent: #a85c1a;
            --panel: #fffaf2;
            --line: #e5d6bf;
            --muted: #7a6754;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--ink);
            background:
                radial-gradient(circle at 20% 20%, #efdfc0 0, transparent 38%),
                radial-gradient(circle at 80% 10%, #ebd2b2 0, transparent 35%),
                var(--bg);
            line-height: 1.6;
        }

        .wrap {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .cover {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 22px;
            padding: 34px;
            box-shadow: 0 20px 50px rgba(36, 31, 26, 0.08);
            text-align: center;
        }

        .label {
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-size: 12px;
            color: var(--muted);
            margin: 0 0 10px;
        }

        h1 {
            margin: 0 0 6px;
            font-size: 40px;
            line-height: 1.1;
        }

        h2 {
            margin: 0 0 12px;
            font-size: 28px;
            line-height: 1.2;
        }

        .muted {
            color: var(--muted);
        }

        .open-button {
            margin-top: 16px;
            padding: 12px 20px;
            border-radius: 12px;
            border: 1px solid #8d4d18;
            color: #fff;
            background: var(--accent);
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .invitation-content {
            margin-top: 18px;
            opacity: 0;
            transform: translateY(22px);
            pointer-events: none;
            transition: opacity 0.45s ease, transform 0.45s ease;
            height: 0;
            overflow: hidden;
        }

        body.is-open .invitation-content {
            opacity: 1;
            transform: translateY(0);
            pointer-events: auto;
            height: auto;
            overflow: visible;
        }

        .section {
            margin-top: 18px;
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 22px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .chip,
        .alert {
            display: inline-block;
            border: 1px solid var(--line);
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 13px;
            background: #fff;
        }

        .alert {
            border-radius: 10px;
            font-size: 14px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
        }

        .gallery img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: #f5efe3;
        }

        .form-group {
            margin-bottom: 14px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 700;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 10px 12px;
            background: #fff;
            color: var(--ink);
        }

        .wish {
            border-top: 1px dashed var(--line);
            padding-top: 10px;
            margin-top: 10px;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            border: 1px solid #9e5d2a;
            color: #fff;
            background: var(--accent);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 32px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .gallery {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
    </style>
</head>
<body class="{{ request()->query('open') === '1' || session('success') || $errors->any() ? 'is-open' : '' }}">
    <div class="wrap">
        <section class="cover">
            <p class="label">Personal Invitation</p>
            <h1>{{ $event?->title ?? 'Our Special Day' }}</h1>
            <p class="muted">To: {{ $guest->name }}</p>
            <p class="muted">You are warmly invited to celebrate this special moment with us.</p>
            <button id="openInvitation" class="open-button" type="button">Buka Undangan</button>
        </section>

        <div class="invitation-content" id="invitationContent">
            <section class="section">
                <h2>Event Details</h2>
                @if ($event)
                    <div class="grid">
                        <div>
                            <p><strong>{{ $event->title }}</strong></p>
                            <p class="muted">{{ \Illuminate\Support\Carbon::parse($event->event_date)->format('l, d M Y') }}</p>
                            <p>{{ $event->location }}</p>
                        </div>
                        <div>
                            <p class="muted">{{ $event->description ?: 'We are excited to celebrate this day with you.' }}</p>
                            @if ($event->maps_url)
                                <a class="btn" href="{{ $event->maps_url }}" target="_blank" rel="noopener noreferrer">Open Maps</a>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="muted">Event details will be announced soon.</p>
                @endif
            </section>

            <section class="section">
                <h2>Gallery</h2>
                @if ($galleries->isNotEmpty())
                    <div class="gallery">
                        @foreach ($galleries as $photo)
                            <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->caption ?? 'Gallery photo' }}">
                        @endforeach
                    </div>
                @else
                    <p class="muted">No gallery photos yet.</p>
                @endif
            </section>

            <section class="section" id="rsvp-form">
                <h2>RSVP & Pesan</h2>
                @if (session('success'))
                    <p class="alert">{{ session('success') }}</p>
                @endif
                @if ($errors->any())
                    <p class="alert">Please complete the form correctly.</p>
                @endif
                <form method="POST" action="{{ route('invitation.rsvp', $guest->slug) }}">
                    @csrf
                    <div class="form-group">
                        <label for="guest-name">Nama Tamu</label>
                        <input id="guest-name" type="text" value="{{ $guest->name }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="attendance">Konfirmasi Kehadiran</label>
                        <select id="attendance" name="attendance">
                            <option value="" {{ old('attendance', $guest->attendance) === null ? 'selected' : '' }}>Belum konfirmasi</option>
                            <option value="1" {{ (string) old('attendance', $guest->attendance) === '1' ? 'selected' : '' }}>Hadir</option>
                            <option value="0" {{ (string) old('attendance', $guest->attendance) === '0' ? 'selected' : '' }}>Tidak hadir</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan</label>
                        <textarea id="message" name="message" rows="4" placeholder="Tulis ucapan terbaikmu..." required>{{ old('message') }}</textarea>
                    </div>
                    <button class="btn" type="submit">Kirim RSVP & Pesan</button>
                </form>
            </section>

            <section class="section" id="guestbook">
                <h2>Semua Pesan Tamu</h2>
                @if ($wishes->isNotEmpty())
                    @foreach ($wishes as $wish)
                        <div class="wish">
                            <p><strong>{{ $wish->guest?->name ?? 'Guest' }}</strong></p>
                            <p class="muted">{{ $wish->message }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="muted">Belum ada pesan dari tamu.</p>
                @endif
            </section>
        </div>
    </div>

    <script>
        const openButton = document.getElementById('openInvitation');

        openButton?.addEventListener('click', function () {
            document.body.classList.add('is-open');

            const content = document.getElementById('invitationContent');

            if (content) {
                content.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    </script>
</body>
</html>
