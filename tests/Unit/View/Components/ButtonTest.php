<?php

use Illuminate\Support\Facades\Blade;
use WireUi\Support\Buttons\Colors\{ColorPack, Solid};
use WireUi\Support\Buttons\Sizes;

it('should render the button default slot')
    ->expect('<x-button><b>Label From Slot</b></x-button>')
    ->render()
    ->toContain('<b>Label From Slot</b>');

it('should render a spinner')
    ->expect('<x-button primary label="primary" spinner />')
    ->render()
    ->toContain(
        '<svg class="animate-spin',
        'wire:loading.delay="true"'
    );

it('should render a spinner with a custom delay')
    ->expect('<x-button primary label="primary" spinner.long />')
    ->render()
    ->toContain('wire:loading.delay.long="true"');

it('should render a spinner with a target')
    ->expect('<x-button primary label="primary" spinner="save" />')
    ->render()
    ->toContain('wire:target="save"');

it('should not render a spinner')
    ->expect('<x-button primary label="primary" />')
    ->render()
    ->not()
    ->toContain('<svg class="animate-spin');

it('should render all color classes from attributes', function (string $class, string $variant, string $color) {
    /** @var ColorPack $colorPack */
    $colorPack = new $class();

    expect("<x-button {$variant} {$color} />")
        ->render()
        ->toContain($colorPack->get($color)->toString())
        ->not()
        ->toContain($colorPack->default()->toString());
})->with('buttons::variant-color');

it('should render all color classes from props', function (string $class, string $variant, string $color) {
    /** @var ColorPack $colorPack */
    $colorPack = new $class();

    expect("<x-button variant=\"{$variant}\" color=\"{$color}\" />")
        ->render()
        ->toContain($colorPack->get($color)->toString())
        ->not()
        ->toContain($colorPack->default()->toString());
})->with('buttons::variant-color');

it('should render all sizes classes from attributes', function (string $size) {
    expect("<x-button {$size} />")
        ->render()
        ->toContain((new Sizes\Base())->get($size));
})->with('buttons::sizes');

it('should render all sizes classes from props', function (string $size) {
    expect("<x-button size=\"{$size}\" />")
        ->render()
        ->toContain((new Sizes\Base())->get($size));
})->with('buttons::sizes');

it('should render a squared button')
    ->expect('<x-button squared />')
    ->render()
    ->not()
    ->toContain('/(rounded)*/');

it('should render a pill button')
    ->expect('<x-button rounded />')
    ->render()
    ->toContain('rounded-full');

it('should render a block button')
    ->expect('<x-button block />')
    ->render()
    ->toContain('w-full');

it('should pass the attributes bag to the button')
    ->expect('<x-button foo="bar" disabled aria-label="test" />')
    ->render()
    ->toContain(
        'foo="bar"',
        'disabled="disabled"',
        'aria-label="test"'
    );

it('should render a button with a label')
    ->expect('<x-button label="My Label" />')
    ->render()
    ->toContain('My Label');

it('should render a button with a label and icons with default sizes', function () {
    expect('<x-button label="My Label" icon="home" right-icon="user" />')
        ->render()
        ->toContain(
            'My Label',
            Blade::render('<x-heroicons::outline.home class="w-4 h-4 shrink-0" />'),
            Blade::render('<x-heroicons::outline.user class="w-4 h-4 shrink-0" />')
        );
});

it('should render icons with different sizes', function (string $size) {
    $css = (new Sizes\Icon())->get($size);

    expect("<x-button {$size} icon=\"home\" right-icon=\"user\" />")
        ->render()
        ->toContain(
            Blade::render("<x-heroicons::outline.home class=\"{$css} shrink-0\" />"),
            Blade::render("<x-heroicons::outline.user class=\"{$css} shrink-0\" />")
        );
})->with('buttons::sizes');

it('should render icons with custom sizes', function () {
    expect('<x-button class="my-padding" icon="home" right-icon="user" icon-size="my-custom icon-size" />')
        ->render()
        ->toContain(
            'my-padding',
            Blade::render('<x-heroicons::outline.home class="my-custom icon-size shrink-0" />'),
            Blade::render('<x-heroicons::outline.user class="my-custom icon-size shrink-0" />')
        );
});

it('should render a button with two differents colors when interacting', function () {
    expect('<x-button primary hover:yellow focus:green />')
        ->render()
        ->toContain(
            (new Solid())->get('primary')->base,
            (new Solid())->get('yellow')->hover,
            (new Solid())->get('green')->focus
        );
});

it('should render a button with one different color when interacting', function () {
    expect('<x-button primary interaction:green />')
        ->render()
        ->toContain(
            (new Solid())->get('primary')->base,
            (new Solid())->get('green')->hover,
            (new Solid())->get('green')->focus
        );
});
