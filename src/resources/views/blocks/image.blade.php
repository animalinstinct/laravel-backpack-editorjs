@php
$classes = '';
$styles = '';

if ($data['stretched']) {
    $classes .= ' image--stretched';
    $styles .= 'width: 100%;height: auto;';
}
if ($data['withBorder']) {
    $classes .= 'image--bordered';
    $styles .= 'border: 7px solid #393939;';
}
if ($data['withBackground']) {
    $classes .= ' image--backgrounded';
    $styles .= 'margin: 0 auto;padding: 1em 0;';
}
@endphp

<figure class="image {{ $classes }}">
    <img src="{{ $data['file']['url'] }}" alt="{{ $data['caption'] ?: '' }}" style="{{ $styles }}">
    @if (!empty($data['caption']))
    <footer class="image-caption">
        {{ $data['caption'] }}
    </footer>
    @endif
</figure>