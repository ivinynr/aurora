@props([
    'label' => '',
    'nome' => '',
    'tipo' => 'text',
    'obrigatorio' => false,
    'placeholder' => '',
    'dica' => '',
    'valor' => '',
])

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $nome }}" class="block text-sm font-medium text-bark-700">
            {{ $label }}
            @if($obrigatorio)<span class="text-terra-400">*</span>@endif
        </label>
    @endif

    @if($tipo === 'textarea')
        <textarea name="{{ $nome }}" id="{{ $nome }}" placeholder="{{ $placeholder }}"
            {{ $obrigatorio ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors text-sm resize-none']) }}
            rows="4">{{ old($nome, $valor) }}</textarea>
    @else
        <input type="{{ $tipo }}" name="{{ $nome }}" id="{{ $nome }}" value="{{ old($nome, $valor) }}"
            placeholder="{{ $placeholder }}" {{ $obrigatorio ? 'required' : '' }}
            {{ $attributes->merge(['class' => 'block w-full px-4 py-3 rounded-xl border border-cream-300 bg-white text-bark-800 placeholder:text-bark-300 focus:border-terra-300 focus:ring-2 focus:ring-terra-100 transition-colors text-sm']) }} />
    @endif

    @if($dica)<p class="text-xs text-bark-300">{{ $dica }}</p>@endif
    @error($nome)<p class="text-xs text-terra-500 font-medium">{{ $message }}</p>@enderror
</div>
