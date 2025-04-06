<x-main-layout with-analytics>
    <script src="{{ asset('/build/messages.js') }}"></script>
    <script nonce="{{ csp_nonce() }}">
        Lang.setLocale('{{ App::getLocale() }}')
    </script>
    <div id="app"></div>
</x-main-layout>
