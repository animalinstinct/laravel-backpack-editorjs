@php
/**
 * Embed Block for the Editor.js parser
 * 
 * @var string $caption
 * @var string $embed The embed URL
 * @var int|string $width
 * @var int|string $height
 */
@endphp

<iframe
src="{{ $data['embed'] }}"
width={{ $data['width'] }}
height={{ $data['height'] }}
frameborder="0"
allow="autoplay; encrypted-media"
allowfullscreen></iframe>
