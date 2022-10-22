@php
    $hasError = !$errorless && $name && $errors->has($name);
    $min = $formatDataSliderRange($attributes, 'min');
    $max = $formatDataSliderRange($attributes, 'max');
@endphp

<div x-ref="sliderComponent" x-data="wireui_inputs_slider_range({
    range: @boolean($range),
    disabled: @boolean($disabled),
    hideTooltip: @boolean($hideTooltip),
})" {{ $attributes->only('wire:key') }}>

    @if ($label || $cornerHint)
        <div class="flex {{ !$label && $cornerHint ? 'justify-end' : 'justify-between' }} mb-1">
            @if ($label)
                <x-dynamic-component
                    :component="WireUi::component('label')"
                    :label="$label"
                    :has-error="$hasError"
                    :for="$id"
                />
            @endif

            @if ($cornerHint)
                <x-dynamic-component
                    :component="WireUi::component('label')"
                    :label="$cornerHint"
                    :has-error="$hasError"
                    :for="$id"
                />
            @endif
        </div>
    @endif

    <input x-on:change="inputChange" x-ref="input1" {{ $min->class('')->merge($formatDataSlider($attributes)) }} />

    <input x-on:change="inputChange" x-ref="input2" {{ $max->class('')->merge($formatDataSlider($attributes)) }} />

    <div x-ref="slider" x-on:click="sliderClick" class="{{ $getSliderClasses($disabled) }}">

        <div class="{{ $getBarClasses($disabled, $hasError) }}" x-bind:style="barStyle"></div>

        <div x-ref="button1">
            <div
                tabindex="0"
                x-data="wireui_inputs_slider_button({ input: 'input1' })"
                class="{{ $getButtonGridClasses() }}"
                x-bind:style="wrapperStyle"
            >
                <x-dynamic-component
                    tabindex="0"
                    :component="WireUi::component('button.circle')"
                    x-on:mouseenter="buttonEnter"
                    x-on:mouseleave="buttonLeave"
                    x-on:mousedown="buttonDown"
                    x-on:touchstart="buttonDown"
                    x-on:mousemove.window="dragging ? onDragging : ''"
                    x-on:touchmove.window="dragging ? onDragging : ''"
                    x-on:mouseup.window="dragging ? onDragEnd : ''"
                    x-on:touchend.window="dragging ? onDragEnd : ''"
                    x-on:contextmenu.window="dragging ? onDragEnd : ''"
                    :color="$buttonError($disabled, $hasError)"
                    :class="$getButtonClasses($disabled)"
                    :size="$buttonSizes()"
                    x-bind:style="buttonStyle"
                    x-text="value"
                    outline
                />
            </div>
        </div>

        <div x-ref="button2">
            <div
                tabindex="0"
                x-data="wireui_inputs_slider_button({ input: 'input2' })"
                class="{{ $getButtonGridClasses() }}"
                x-bind:style="wrapperStyle"
            >
                <x-dynamic-component
                    tabindex="0"
                    :component="WireUi::component('button.circle')"
                    x-on:click.stop.prevent="console.log('click')"
                    x-on:mouseenter="buttonEnter"
                    x-on:mouseleave="buttonLeave"
                    x-on:mousedown="buttonDown"
                    x-on:touchstart="buttonDown"
                    x-on:mousemove.window="dragging ? onDragging : ''"
                    x-on:touchmove.window="dragging ? onDragging : ''"
                    x-on:mouseup.window="dragging ? onDragEnd : ''"
                    x-on:touchend.window="dragging ? onDragEnd : ''"
                    x-on:contextmenu.window="dragging ? onDragEnd : ''"
                    :color="$buttonError($disabled, $hasError)"
                    :class="$getButtonClasses($disabled)"
                    :size="$buttonSizes()"
                    x-bind:style="buttonStyle"
                    x-text="value"
                    outline
                />
            </div>
        </div>
    </div>

    @if (!$hasError && $hint)
        <label @if ($id) for="{{ $id }}" @endif class="mt-2 text-sm text-secondary-500 dark:text-secondary-400">
            {{ $hint }}
        </label>
    @endif

    @if ($name && !$errorless)
        <x-dynamic-component
            :component="WireUi::component('error')"
            :name="$name"
        />
    @endif
</div>
