<div wire:poll.1000ms>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            color-scheme: light dark;

            --logo-height: 40px;
            --logo-container: 80px;

            --terminal-bg: black;
            --laravel-bg: white;

            --border-radius: 3px;

            /* #E6623C */
            --main-background: url("/img/banner.png");
        }

        body {
            color: #eeeeee;
            background-color: var(--main-background);
            font-family: Inter, sans-serif;
            overflow: hidden;
        }

        * {
            box-sizing: border-box;
        }

        body,
        html {
            width: 1920px;
            height: 1080px;
            margin: 0;
            padding: 0;
        }


        .shadow {
            /* box-shadow:  */
            /*     rgba(0, 0, 0, 0.25) 0px 54px 55px, */
            /*     rgba(0, 0, 0, 0.12) 0px -12px 30px, */
            /*     rgba(0, 0, 0, 0.12) 0px 4px 6px, */
            /*     rgba(0, 0, 0, 0.17) 0px 12px 13px, */
            /*     rgba(0, 0, 0, 0.09) 0px -3px 5px; */

            /* box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px; */
            /* box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px; */
            /* border: 4px solid white; */

            /* box-shadow: 5px 5px 0px 0px #289FED, 10px 10px 0px 0px #5FB8FF, 15px 15px 0px 0px #A1D8FF, 20px 20px 0px 0px #CAE6FF, 25px 25px 0px 0px #E1EEFF, 5px 5px 15px 5px rgba(0, 0, 0, 0); */
            box-shadow: 5px 5px 0px 0px rgba(255, 137, 0, 1), 10px 10px 0px 0px rgba(255, 162, 58, 1), 15px 15px 0px 0px rgba(253, 173, 75, 1), 20px 20px 0px 0px rgba(255, 193, 122, 1), 25px 25px 0px 0px rgba(255, 224, 182, 1);

            /* box-shadow: 0px 9px 30px rgba(255, 149, 5, 0.3); */

            /* box-shadow: 0px 10px 13px -7px #000000, 5px 5px 15px 5px rgba(0, 0, 0, 0); */

            /* box-shadow: 4px -4px 15px 0px #FF1F1F, 12px -11px 7px 0px #FF9376, 20px -5px 7px 0px #FFE264, 20px 6px 7px 0px #F6FF33, 13px 12px 17px 0px #FF9527, 2px 17px 17px 0px #FF0000, -9px 21px 18px 0px #FFF212, -9px 6px 11px 0px #FF0808, -11px -9px 11px 0px #FFFA17, -11px -9px 11px 0px #FFFA17, 5px 5px 15px 5px rgba(0, 0, 0, 0); */
        }

        .blurred-background {
            background: var(--main-background);
            background-size: 39%;
            filter: blur(2px);
            /* opacity: 0.9; */
            position: absolute;
            z-index: -10000000;
            width: 100%;
            height: 100%;
        }

        .app {
            display: flex;
            flex-direction: column;
            width: 1920px;
            height: 1080px;
            gap: 2rem;
        }

        .main {
            padding: 2rem;
            display: flex;
            flex: 1 1 auto;
            gap: 2rem;
        }

        .aside {
            /* Sidebar fixed with, can change with % */
            flex: 0 0 200px;
            display: flex;
            flex-direction: column;
        }

        .cam {
            position: relative;
            background: #fff;
            aspect-ratio: 1 / 2;
            border-radius: var(--border-radius);
        }

        .cam-scott {
            background: url("/img/scott-test.jpg");
            background-size: cover;
            margin-top: 75px;
            /* background: #00FF00; */
        }

        .cam-wes {
            /* background: url("/img/wes-test.jpg"); */
            /* background-size: cover; */
            background: #00FF00;
        }

        .cam-name {
            font-weight: 600;
            background: black;
            position: relative;
            top: 85%;
            left: 50%;
            transform: translateX(-50%);
            width: 50%;
            padding: 10px 0px;
            text-align: center;
            border-radius: var(--border-radius);
        }

        .video {
            display: flex;
            justify-content: center;
            background: #00FF00;
            border-radius: 1rem;
            width: 100%;
            height: 100%;
            position: relative;
            align-items: end;
        }

        .marquee {
            height: 100px;
            padding: 2rem;
            text-align: center;
            border-top: 1px solid white;
            margin-inline: 2rem;
        }

        .score {
            /* position: relative; */
            /* bottom: -95%; */
            /* border-radius: 1rem; */
            /* width: 33%; */
            /* background: linear-gradient(90deg, #82100c 0%, #f78b2e 50%, #82100c 100%); */
            background: none;
            /* padding: 1.5rem 2.5rem; */
        }

        .logo {
            background: black;
            border-radius: var(--border-radius);
        }

        .score {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
            transform: translateY(42.0%);
        }

        .bobbing {
            position: relative;
            animation: moveUpAndDown 5s ease-in-out infinite;
        }

        @keyframes moveUpAndDown {
            0% {
                top: 40px;
            }

            50% {
                top: 60px;
            }

            100% {
                top: 40px;
            }
        }

        .team {
            /* height: 40px; */
            padding: 30px;
            height: var(--logo-container);
            display: flex;
            gap: 10px;
            align-items: center;
            background: black;
            /* padding: 10px 20px; */
            border-radius: var(--border-radius);
            /* border: 1px solid black; */
        }

        .team-name {
            font-weight: normal;
            font-size: 3em;
        }

        .team-score {
            font-weight: bold;
            font-size: 3em;
            text-align: center;
            min-width: 50px;
        }

        .team-logo-terminal,
        .team-logo-laravel {
            height: calc(2 * var(--logo-height));
            width: calc(1.5 * var(--logo-height));
            object-fit: cover;

            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: var(--border-radius);
        }

        .team-logo-terminal>img,
        .team-logo-laravel>img {
            height: var(--logo-height);
        }

        .team-logo-terminal {
            background: var(--terminal-bg);
            border: 1px solid var(--terminal-bg);
        }

        .team-logo-laravel {
            background: var(--laravel-bg);
            border: 1px solid var(--laravel-bg);
        }

        .team-logo-laravel>img {
            filter: drop-shadow(3px 3px 2px rgba(0, 0, 0, .7));
        }


        @keyframes scroll {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .ticker {
            bottom: 0;
            margin-top: 10px;
            width: 100%;
            height: 100px;
            background-color: black;
        }

        .ticker-message {
            bottom: 0;
            left: 100%;
            color: white;
            white-space: nowrap;
            padding: 10px;
            font-size: 20px;
            font-family: Arial, sans-serif;
            animation: scroll 45s linear infinite;
            will-change: transform;
            backface-visibility: hidden;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>

    <div class="blurred-background"> </div>
    <div class="app">
        <div class="main">
            <div class="aside">
                <div class="cam cam-wes shadow">
                    <div class="cam-name">@wesbos</div>
                </div>
                <div class="cam cam-scott shadow">
                    <div class="cam-name">@stolinski</div>
                </div>
            </div>
            <div class="video shadow">
                <div class="score">
                    <span class="team-logo-terminal shadow">
                        <img src="/img/terminal-logo.svg" />
                    </span>
                    <div class="team shadow">
                        <span class="team-name">TRM</span>
                        <span class="team-score">{{ $terminalScore }}</span>
                    </div>
                    <div class="logo shadow">
                        <img src="/img/nullstar-logo.svg" />
                    </div>
                    <div class="team shadow">
                        <span class="team-score">{{ $laraconScore }}</span>
                        <span class="team-name">LAR</span>
                    </div>
                    <span class="team-logo-laravel shadow">
                        <img src="/img/laravel-logo.svg" />
                    </span>
                </div>
            </div>
        </div>
        @if ($prompt !== '')
            <div class="fixed top-8 right-8 w-256 bg-white text-black border border-gray-200 shadow-lg p-4 rounded-lg">
                <div class="font-bold mb-2 text-2xl">{{ $prompt }}</div>
                <div class="font-bold mb-2 text-2xl">{{ $totalPoints }}</div>
                <ol class="list-decimal text-xl pl-8">
                    @foreach ($options as $o)
                        <li class="text-xl">
                            {{ $o['option'] }} / {{ $o['points'] }}
                        </li>
                    @endforeach
                </ol>
            </div>
        @endif

        <div class="ticker">
            <div class="ticker-message">
                <span style="color: #b0b1b0; font-family: monospace">
                    <img style="height: 20px" src="/img/terminal-logo.svg" />
                    Buy coffee at ssh terminal.shop
                </span>
                <span style="color: #b0b1b0; font-family: monospace">
                    <img style="height: 20px" src="/img/laravel-logo.svg" />
                    Brought to you by laracon.us
                </span>
                <span style="color: #b0b1b0; font-family: monospace">
                    <img style="height: 20px" src="/img/laravel-logo.svg" />
                    Thanks to Sentry, who sponsored this event.
                </span>
            </div>
        </div>
    </div>
</div>
