<form method="get" action="mailto:{{ $emailAddress }}?subject={{ $subject }}">
    <textarea name="message" placeholder="Tulis pesan"></textarea>
    <button type="submit">Kirim Email</button>
</form>
