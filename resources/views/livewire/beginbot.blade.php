<div>
    <style>
        body {
            background: black;
            color: white;
        }
    </style>

    <h1>Terminal Score: {{ $terminalScore }}</h1>
    <h1>Laracon Score: {{ $laraconScore }}</h1>

    <div>
        <button wire:click="incrementTerminal(1)">+1</button>
        <button wire:click="incrementTerminal(2)">+2</button>
        <button wire:click="incrementTerminal(3)">+3</button>
        <button wire:click="decrementTerminal">-</button>
        <button wire:click="resetTerminal">reset</button>
    </div>

    <div>
        <button wire:click="incrementLaracon(1)">+1</button>
        <button wire:click="incrementLaracon(2)">+2</button>
        <button wire:click="incrementLaracon(3)">+3</button>
        <button wire:click="decrementLaracon">-</button>
        <button wire:click="resetLaracon">reset</button>
    </div>

    <button wire:click="reset_count">-</button>
</div>
