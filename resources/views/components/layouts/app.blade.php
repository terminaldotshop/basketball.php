<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? 'Page Title' }}</title>
        @vite('resources/css/app.css')
        <style>
          @font-face {
            font-family: 'geist';
            src:
              url('/fonts/geist-mono-latin.woff2') format('woff2-variations'),
              url('/fonts/geist-mono-latin.woff') format('woff-variations'),
              url('/fonts/geist-mono-latin.otf') format('opentype-variations');
            font-display: swap;
            font-style: normal;
            font-weight: 100 900;
          }
          @font-face {
            font-family: 'geist-fallback';
            src: local('Courier New');
            size-adjust: 100%;
            ascent-override: 97%;
            descent-override: 25%;
            line-gap-override: 1%;
          }
        </style>
        <link
          rel="preload"
          href="/fonts/geist-mono-latin.woff2"
          as="font"
          type="font/woff2"
          crossorigin="anonymous"
        />
        <link
          rel="preload"
          href="/fonts/geist-mono-latin.woff"
          as="font"
          type="font/woff"
          crossorigin="anonymous"
        />
        <link
          rel="preload"
          href="/fonts/geist-mono-latin.otf"
          as="font"
          type="font/otf"
          crossorigin="anonymous"
        />
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
