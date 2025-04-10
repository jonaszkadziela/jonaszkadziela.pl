<x-main-layout with-analytics>
    <script src="{{ asset('/build/messages.js?v=' . Vite::manifestHash()) }}"></script>
    <script nonce="{{ csp_nonce() }}">
        Lang.setLocale('{{ App::getLocale() }}')
    </script>
    <div id="app"></div>
</x-main-layout>
